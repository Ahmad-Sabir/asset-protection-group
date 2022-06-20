<?php

namespace App\Services\Admin\WorkOrder;

use App\Events\WorkOrder as  WorkOrderEvent;
use App\Models\Admin\Asset\Asset;
use App\Models\Admin\Asset\AssetType;
use App\Models\Admin\WorkOrder\WorkOrder;
use App\Models\Admin\WorkOrder\AdditionalTask;
use App\Models\Admin\WorkOrder\WorkOrderLogs;
use App\Http\Requests\Admin\WorkOrder\WorkOrderRequest;
use App\Http\Requests\Admin\WorkOrder\TimerLogRequest;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;

class WorkOrderService
{
    /**
     * workOrderAssigned
     *
     * @var mixed
     */
    protected $workOrderAssigned;
    protected const RECURRING_STATUS = 'apg.recurring_status.recurring';
    protected const LOG_START_STATUS = 'apg.log_status.start';
    protected const LOG_END_STATUS = 'apg.log_status.end';
    protected const WORK_ORDER_STATUS_COMPLETED = 'apg.work_order_status.completed';
    protected const STATUS_OPEN = 'apg.work_order_status.open';
    protected const STATUS_ONHOLD = 'apg.work_order_status.on_hold';
    public function __construct(
        protected WorkOrder $workOrder,
        protected Asset $asset,
        protected AssetType $assetType,
        protected AdditionalTask $additioanlTask,
        protected WorkOrderLogs $orderLogs
    ) {
        $this->workOrderAssigned = config("apg.notification_setting_keys.assigned_workorder");
    }

    /**
     * get single records
     *
     * @param int $id
     * @return mixed
     */
    public function find($id)
    {
        /** @var User $user */
        $user = auth()->user();
        /** @phpstan-ignore-next-line */
        return $this->workOrder->with([
            'location' => function ($query) {
                $query->select('*');
            },
            'asset' => function ($query) {
                $query->with(['location' => function ($query) {
                    $query->select('*');
                }]);
            }
        ])->when($user->user_status == config('apg.user_status.employee'), function ($query) {
            $query->where('assignee_user_id', auth()->id());
        })->findOrFail($id);
    }

    /**
     * store WorkOrder.
     *
     * @param WorkOrderRequest $request
     * @return mixed
     */
    public function store(WorkOrderRequest $request)
    {
        $data = $request->validated();
        $data['due_date'] = $request->due_date;
        $orderStore = $this->workOrder->create($data);
        $orderStore->medias()->attach($request->media_ids ?? []);
        $orderId = $orderStore->id;
        if ($request->has('task_data')) {
            $this->bulkTaskStore($request, $orderId);
        }
        if ($request->input('work_order_type') == config(self::RECURRING_STATUS)) {
            $this->bulkStore($request, $orderStore);
        }
        $emailData = [
            'subject'   => __('workorder.email.work_order_assigned_subject'),
            'view'      => 'email-template.work-order.assigned',
            'type'      => config('apg.notification_setting_keys'),
            'message'   => __('workorder.notification.work_order_assigned')
        ];
        $preference['email'] =   $this->workOrderAssigned;
        $preference['notification'] =   $this->workOrderAssigned;
        event(new WorkOrderEvent($orderStore, $emailData, $preference));

        return $orderStore;
    }
    /**
     * store WorkOrder.
     *
     * @param int $id
     * @return mixed
     */
    public function cloneWorkOrder($id)
    {
        /** @var \App\Models\Admin\WorkOrder\WorkOrder $WorkOrder */
        $WorkOrder = $this->workOrder->find($id);
        $cloneWorkOrder = $WorkOrder->replicate()->fill([
            'work_order_status' => config(self::STATUS_OPEN),
            'work_order_log_timer' => null,
            'is_pause' => 1,
            'on_hold_reason' => null,
            'timer_status' => 1
        ]);
        $cloneWorkOrder->save();
        $oldMediaIds = $WorkOrder->medias()->pluck('id')->toArray();
        $newMediaIds = app(\App\Services\Admin\MediaService::class)->clone($oldMediaIds);
        $cloneWorkOrder->medias()->attach($newMediaIds);
        $WorkOrder->additionaltasks()->get()->each(function ($task) use ($cloneWorkOrder) {
            $additionalTasks = $task->replicate()->fill([
                'work_order_id' => $cloneWorkOrder->id,
                'status' => config('apg.task_status.pending')
            ]);
            $additionalTasks->save();
        });
        return $cloneWorkOrder;
    }

    /**
     * prepare data
     *
     * @param WorkOrderRequest $request
     * @param int $id
     * @return mixed
     */
    public function update(WorkOrderRequest $request, $id)
    {
        /** @var \App\Models\Admin\WorkOrder\WorkOrder $updateWorkOrder */
        $updateWorkOrder = $this->workOrder->find($id);
        $updateWorkOrder->medias()->sync($request->media_ids ?? []);
        $data = $request->validated();
        $data['due_date'] = $request->due_date;
        $data['flag'] = 'off';
        if ($request->has('flag')) {
            $data['flag'] = 'on';
        }
        if ($request->work_order_status == config(self::WORK_ORDER_STATUS_COMPLETED)) {
            AdditionalTask::where('work_order_id', $id)->update([
                'status' => config('apg.task_status.completed')
            ]);
            $data['work_order_log_timer'] = null;
            $data['is_pause'] = 1;
            $data['timer_status'] = 1;
        }
        $updateWorkOrder->update($data);
        if ($data['work_order_type'] == config(self::RECURRING_STATUS)) {
            if (
                !$updateWorkOrder->wasChanged('asset_id') &&
                (
                    $updateWorkOrder->wasChanged('work_order_frequency') ||
                    $updateWorkOrder->wasChanged('qualification') ||
                    $updateWorkOrder->wasChanged('assignee_user_id')
                )
            ) {
                $this->updateFrequency($request, $updateWorkOrder);
            }
            if ($updateWorkOrder->wasChanged('asset_id')) {
                $this->bulkStore($request, $updateWorkOrder);
            }
        }
    }

    /**
     * store WorkOrder.
     *
     * @param WorkOrderRequest $request
     * @param int $orderId
     * @return mixed
     */
    public function bulkTaskStore(WorkOrderRequest $request, $orderId)
    {
        $data = $request->validated();
        $task_data = $data['task_data'] ?? [];
        foreach ($task_data as $task) {
            $task['due_date'] = $task['due_date']
            /** @phpstan-ignore-next-line */
            ? Carbon::createFromFormat('m-d-Y', $task['due_date'])->format('Y-m-d') : null;
            $task['work_order_id'] = $orderId;
            $this->additioanlTask->create($task);
        }
        return $request;
    }

    /**
     * store WorkOrder.
     *
     * @param WorkOrderRequest $request
     * @param mixed $workOrder
     * @return mixed
     */
    public function bulkStore(WorkOrderRequest $request, $workOrder)
    {
        $assetData = $this->asset->find($request->asset_id);
        $replicate = getWorkOrderFrequencyDays(
            $request->due_date,
            optional($assetData)?->warranty_expiry_date,
            $request->work_order_frequency
        );
        if ($replicate < 1) {
            return $request;
        }
        $data = $request->validated();
        for ($i = 0; $i < $replicate; $i++) {
            $data['due_date'] = getWorkOrderFrequencyDate(
                $dueDate ?? $request->due_date,
                $request->work_order_frequency
            );
            $profile = app(\App\Services\Admin\MediaService::class)->clone([$request->work_order_profile_id]);
            $data['work_order_profile_id'] = current($profile) ? current($profile) : null;
            $orderStore = $this->workOrder->create($data);
            $workOrder->additionaltasks()->get()->each(function ($task) use ($orderStore) {
                $additionalTasks = $task->replicate()->fill([
                    'work_order_id' => $orderStore->id
                ]);
                $additionalTasks->save();
            });
            $attachments = app(\App\Services\Admin\MediaService::class)->clone($request->media_ids ?? []);
            $orderStore->medias()->attach($attachments);
            $dueDate = $data['due_date'];
        }

        return $request;
    }

    /**
     * update frequency.
     *
     * @param WorkOrderRequest $request
     * @param mixed $workOrder
     * @return mixed
     */
    public function updateFrequency(WorkOrderRequest $request, $workOrder)
    {
        $status =  [
            config(self::STATUS_OPEN),
            config(self::STATUS_ONHOLD)
        ];
        switch ($request->update_frequency_type) {
            case config('apg.update_frequency_cases.future.key'):
                $this->workOrder->where('asset_id', $request->asset_id)
                    ->where('id', '!=', $workOrder->id)
                    ->where('due_date', '>', now()->format('Y-m-d'))
                    ->whereIn('work_order_status', $status)
                    ->forcedelete();
                break;
            case config('apg.update_frequency_cases.last_thirty.key'):
                $this->workOrder->where('asset_id', $request->asset_id)
                    ->where('id', '!=', $workOrder->id)
                    ->whereBetween('due_date', [
                        now()->subDays(30)->format('Y-m-d'),
                        now()->format('Y-m-d')
                    ])->whereIn('work_order_status', $status)
                    ->forcedelete();
                break;
            case config('apg.update_frequency_cases.all.key'):
                $this->workOrder->where('asset_id', $request->asset_id)
                    ->where('id', '!=', $workOrder->id)
                    ->whereIn('work_order_status', $status)
                    ->forcedelete();
                break;
            default:
                break;
        }

        $this->bulkStore($request, $workOrder);
    }

    /**
     * update log
     *
     * @param string $logData
     * @return mixed
     */

    public function updateTimerLog($logData)
    {
        $logData = json_decode($logData, true);
        $id = $logData['id'];
        $timer = $logData['log'];
        $updateWorkOrderLog = $this->workOrder->find($id);
        $data['work_order_log_timer'] = $timer;
        $data['work_order_status'] = config('apg.work_order_status.in_progress');

        /** @var \App\Models\Admin\WorkOrder\WorkOrder $updateWorkOrderLog */
        return $updateWorkOrderLog->update($data);
    }

    /**
     * update log
     *
     * @param string $logData
     * @return mixed
     */

    public function customTimerLog($logData)
    {
        $logData = json_decode($logData, true);
        $id = $logData['id'];
        $timer = $logData['log'];
        $data['work_order_id'] = $id;
        $data['total_log'] = $timer;
        $data['time'] = now();
        $data['type'] = config('apg.log_status.custom');
        $this->orderLogs->create($data);
        $workOrder = $this->workOrder->find($id);
        /** @var mixed $workOrder */
        app(\App\Services\Admin\Company\ExpenseService::class)->createAutoExpense([
            'work_order_id' => $id,
            'time'          => $data['total_log'],
            'per_hour_rate' => $workOrder->user->per_hour_rate,
            'company_id'    => $workOrder->type == config('apg.type.company') ? $workOrder->company_id : null,
        ]);
        return $workOrder;
    }
    /**
     * update log
     *
     * @param TimerLogRequest $request
     * @return mixed
     */

    public function updateLog(TimerLogRequest $request)
    {
        $orderId = $request->work_order_id;
        $type = $request->type;
        $time = $request->time;
        $data = [];
        /** @var \App\Models\Admin\WorkOrder\WorkOrderLogs $parentLog */
        $parentLog = $this->orderLogs->where('work_order_id', $orderId)->orderBy('id', 'DESC')->first();
        /** @var \App\Models\Admin\WorkOrder\WorkOrderLogs $parentId */
        $parentId = $this->orderLogs->where('work_order_id', $orderId)
            ->where('type', config(self::LOG_START_STATUS))->orderBy('id', 'DESC')->first();
        if ($parentId != null) {
            $parentId = $parentId->id;
        } else {
            $parentId = null;
        }
        if ($type == config(self::LOG_START_STATUS)) {
            $data['is_pause'] = 0;
            $data['timer_status'] = 1;
            if ($parentLog == null || $parentLog->type == config(self::LOG_END_STATUS)) {
                $log['time'] = $time;
                $log['type'] = config(self::LOG_START_STATUS);
            } else {
                $log['parent_id'] = $parentId;
                $log['time'] = $time;
                $log['type'] = config('apg.log_status.breakout');
            }
        }
        if ($type == config('apg.log_status.breakin')) {
            $log['parent_id'] = $parentId;
            $log['time'] = $time;
            $log['type'] = config('apg.log_status.breakin');
            $data['is_pause'] = 1;
            $data['timer_status'] = 0;
            $data['work_order_log_timer'] = $request->updated_time;
        }
        if ($type == config(self::LOG_END_STATUS)) {
            $log['type'] = config(self::LOG_END_STATUS);
            $log['parent_id'] = $parentId;
            $log['time'] = $time;
            $data['is_pause'] = 1;
            $data['timer_status'] = 1;
            $data['work_order_log_timer'] = null;
        }
        $log['work_order_id'] = $orderId;
        $createLog = $this->orderLogs->create($log);
        $logId = $createLog->id;
        if ($type == config(self::LOG_END_STATUS)) {
            $this->logStore($logId, $orderId);
        }
        $updateWorkOrderLog = $this->workOrder->find($orderId);
        /** @var \App\Models\Admin\WorkOrder\WorkOrder $updateWorkOrderLog */
        $updateWorkOrderLog->update($data);
        if ($type == config(self::LOG_END_STATUS) && !empty($request->updated_time)) {
            $workOrder = $this->workOrder->find($orderId);
            /** @var mixed $workOrder */
            app(\App\Services\Admin\Company\ExpenseService::class)->createAutoExpense([
                'work_order_id' => $workOrder->id,
                'time'          => $request->updated_time,
                'per_hour_rate' => $workOrder->user->per_hour_rate,
                'company_id'    => $workOrder->type == config('apg.type.company') ? $workOrder->company_id : null,
            ]);
        }
        return $this->orderLogs->find($logId);
    }

    /**
     * store WorkOrder.
     *
     * @param int $orderId
     * @param int $logId
     * @return mixed
     */

    public function logStore($logId, $orderId)
    {
        /** @var \App\Models\Admin\WorkOrder\WorkOrderLogs $start_time */
        $start_time = $this->orderLogs->where('work_order_id', $orderId)
        ->where('type', 'start')->orderBy('id', 'DESC')->first();
        $start_time = $start_time->time;
        /** @var \App\Models\Admin\WorkOrder\WorkOrderLogs $end_time */
        $end_time = $this->orderLogs->where('work_order_id', $orderId)
        ->where('type', 'end')->orderBy('id', 'DESC')->first();
        $end_time = $end_time->time;
        $start_time = Carbon::parse($start_time);
        $end_time = Carbon::parse($end_time);
        $totalDuration = $end_time->diffInSeconds($start_time);
        $Log = gmdate('H:i:s', $totalDuration);
        $log['total_log'] = $Log;
        $findLog = $this->orderLogs->find($logId);
        /** @var \App\Models\Admin\WorkOrder\WorkOrderLogs $findLog */
        return $findLog->update($log);
    }

    /**
     * update BULKSTATUS
     *
     * @param string $bulkIds
     * @return mixed
     */

    public function checkOrderStatus($bulkIds)
    {
        $bulkIds = json_decode($bulkIds, true);
        $ids = $bulkIds['id'];
        $completed_status = workOrder::whereIn('id', $ids)
        ->where('work_order_status', config(self::WORK_ORDER_STATUS_COMPLETED))->get();
        $completed_status = $completed_status->pluck('number')->toArray();
        $open_status = workOrder::whereIn('id', $ids)
        ->where('work_order_status', config(self::STATUS_OPEN))->get();
        $open_status = $open_status->pluck('number')->toArray();
        $onhold_status = workOrder::whereIn('id', $ids)
        ->where('work_order_status', config(self::STATUS_ONHOLD))->get();
        $onhold_status = $onhold_status->pluck('number')->toArray();
        return [
            'open' => $open_status,
            'onhold' => $onhold_status,
            'completed' => $completed_status,
            ];
    }

    /**
     * update BULKSTATUS
     *
     * @return mixed
     */

    public function updateBulkStatus()
    {
        $idsForUpdate = request()->input('id');
        $orderStatus = request()->input('status');

        if (array_key_exists('priority', request()->all())) {
            $priority = request()->input('priority');
            $data['priority'] = $priority;
        }
        if (array_key_exists('reason', request()->all())) {
            $reason = request()->input('reason');
            $data['on_hold_reason'] = $reason;
        }
        $data['work_order_status'] = $orderStatus;
        if (!is_array($idsForUpdate)) {
            $idsForUpdate = explode(',', $idsForUpdate);
        }
        if ($data['work_order_status'] == config(self::WORK_ORDER_STATUS_COMPLETED)) {
            foreach ($idsForUpdate as $id) {
                $workOrder = $this->workOrder->find($id);
                /** @var mixed $workOrder */
                app(\App\Services\Admin\Company\ExpenseService::class)->createAutoExpense([
                    'work_order_id' => $workOrder->id,
                    'time'          => $workOrder->work_order_log_timer ?? null,
                    'per_hour_rate' => $workOrder->user->per_hour_rate,
                    'company_id'    => $workOrder->type == config('apg.type.company') ? $workOrder->company_id : null,
                ]);
            }
            AdditionalTask::whereIn('work_order_id', $idsForUpdate)->update([
                'status' => config('apg.task_status.completed')
            ]);
            $data['work_order_log_timer'] = null;
            $data['is_pause'] = 1;
            $data['timer_status'] = 1;
        }
        return workOrder::whereIn('id', $idsForUpdate)->update($data);
    }

    /**
     * update clone
     *
     * @param mixed $companyAsset
     * @param mixed $masterAssetId
     * @return void
     */

    public function clone($companyAsset, $masterAssetId)
    {
        $workOrder = WorkOrder::where('asset_id', $masterAssetId);
        $workOrder->chunkById(300, function ($workOrders) use ($companyAsset) {
            foreach ($workOrders as $workOrder) {
                $workOrderProfile = app(\App\Services\Admin\MediaService::class)
                ->clone([$workOrder->work_order_profile_id]);
                $cloneWorkOrder = $workOrder->replicate()->fill([
                    'work_order_profile_id' => current($workOrderProfile) ? current($workOrderProfile) : null,
                    'company_id' => $companyAsset->company_id,
                    'type' => config('apg.type.company'),
                    'asset_id' => $companyAsset->id,
                    'asset_type_id' => $companyAsset->asset_type_id,
                ]);
                $cloneWorkOrder->save();
                $oldMediaIds = $workOrder->medias()->pluck('id')->toArray();
                $newMediaIds = app(\App\Services\Admin\MediaService::class)->clone($oldMediaIds);
                $cloneWorkOrder->medias()->attach($newMediaIds);
                $workOrder->additionaltasks()->get()->each(function ($task) use ($cloneWorkOrder) {
                    $additionalTasks = $task->replicate()->fill([
                        'work_order_id' => $cloneWorkOrder->id
                    ]);
                    $additionalTasks->save();
                });
            }
        });
    }

    /**
     * store asset type work orders
     * @param mixed $asset
     * @param array $oldAsset
     * @param bool $delete
     * @return void
     */
    public function storeAssetTypeWorkOrders($asset, $oldAsset = [], $delete = false)
    {
        if ($delete) {
            $oldAssetType = AssetType::find($oldAsset['asset_type_id']);
            /** @phpstan-ignore-next-line */
            $workOrderIds = $oldAssetType->workOrders()
            ->where('work_orders.asset_id', $oldAsset['id'])
            ->whereIn('work_orders.work_order_status', [
                config(self::STATUS_OPEN),
                config(self::STATUS_ONHOLD)
            ])->pluck('work_order_id')
            ->toArray();
            $this->workOrder->whereIn('id', $workOrderIds)->forcedelete();
        }
        $assetType = $asset->assetType()->first();
        $assetType->workOrderTitles()->get()->each(function ($title) use ($asset, $assetType) {
            $storeWorkOrder = $this->workOrder->create([
                'title' => $title->title,
                'asset_type_id' => $asset->asset_type_id,
                'asset_id' => $asset->id,
                'work_order_type' => config('apg.work_order_type_check.non_recurring'),
                'due_date' => now()->addDay(),
                'type' => $asset->type,
                'company_id' => $asset->company_id,
                'assignee_user_id' => auth()->Id()
            ]);
            $assetType->workOrders()->attach([$storeWorkOrder->id], ['asset_id' => $asset->id]);
        });
    }

    /**
     * Send attachments via email.
     *
     * @param string $id
     * @return mixed
     */
    public function exportWorkOrderPdf($id = '')
    {
        return $this->getMasterExport($id);
    }

    /**
     * get master export.
     *
     * @param string $id
     * @return mixed
     */
    public function getMasterExport($id = '')
    {
        /** @phpstan-ignore-next-line */
        return WorkOrder::with([
            'user',
            'asset',
            'assetType',
            'company',
            'location' => fn($query) => $query->select("*")
            ])
            ->when($id, fn ($query) => $query->where('id', $id))
            ->get();
    }

    /**
     * Send attachments via email.
     *
     * @param string $id
     * @param string $companyId
     * @return mixed
     */
    public function exportCompanyWorkOrderPdf($companyId, $id = '')
    {
        return $this->getCompanyExport($companyId, $id);
    }

    /**
     * Send attachments via email.
     *
     * @param string $id
     * @param string $companyId
     * @return mixed
     */
    public function getCompanyExport($companyId, $id = '')
    {
        /** @phpstan-ignore-next-line */
        return WorkOrder::with(['user', 'asset', 'assetType'])
            ->when($id, fn ($query) => $query->where(['id' => $id, 'company_id' => $companyId]))
            ->where('company_id', $companyId)
            ->get();
    }
}
