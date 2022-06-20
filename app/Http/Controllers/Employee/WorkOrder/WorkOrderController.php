<?php

namespace App\Http\Controllers\Employee\WorkOrder;

use App\Http\Controllers\Controller;
use App\Services\Admin\WorkOrder\WorkOrderService;
use App\Http\Requests\Admin\WorkOrder\WorkOrderRequest;
use App\Http\Responses\BaseResponse;
use App\Services\Admin\Company\ExpenseService;
use App\Services\Admin\WorkOrder\AdditionalTaskService;
use App\Http\Requests\Admin\WorkOrder\TimerLogRequest;
use App\Http\Requests\Admin\WorkOrder\AdditionalTaskRequest;
use App\Services\Admin\ExportService;
use App\Services\Admin\NotificationService;
use App\Traits\HasExport;

class WorkOrderController extends Controller
{
    use HasExport;

    protected const CREATE_MESSAGE = 'messages.create';
    protected const UPDATE_MESSAGE = 'messages.update';
    protected const ADDITIONAL_TASK = 'Additional Task';

    public function __construct(
        protected WorkOrderService $workOrderService,
        protected ExportService $exportService,
        protected ExpenseService $expenseService,
        protected AdditionalTaskService $additionalTaskService,
        protected NotificationService $notificationService,
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('employee.workorder.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        if (request()->notification_id) {
            $this->notificationService->readAs(request()->notification_id);
        }
        $workOrder = $this->workOrderService->find($id);
        $expense = $this->expenseService->find($workOrder->id);
        $sum = $this->expenseService->totalExpense($workOrder->id);

        return view('employee.workorder.show', compact('workOrder', 'expense', 'sum'));
    }

    /**
     * Fetch the specified resource in storage.
     *
     * @return BaseResponse
     */

    public function updateBulkStatus()
    {
        $this->workOrderService->updateBulkStatus();
        return new BaseResponse(
            STATUS_CODE_UPDATE,
            __(self::UPDATE_MESSAGE, ['title' => 'Work Order']),
            []
        );
    }

    /**
     * Fetch the specified resource in storage.
     *
     * @param string $bulkIds
     * @return BaseResponse
     */

    public function checkOrderStatus($bulkIds)
    {
        $result = $this->workOrderService->checkOrderStatus($bulkIds);
        return new BaseResponse(
            STATUS_CODE_UPDATE,
            __(self::UPDATE_MESSAGE, ['title' => 'Work Order']),
            $result
        );
    }

    /**
     * Fetch the specified resource in storage.
     *
     * @param  TimerLogRequest $request
     * @return BaseResponse
     */

    public function saveLogTime(TimerLogRequest $request)
    {
        $data = $this->workOrderService->updateLog($request);
        return new BaseResponse(
            STATUS_CODE_UPDATE,
            __(self::UPDATE_MESSAGE, ['title' => 'Log Time']),
            $data
        );
    }

    /**
     * Fetch the specified resource in storage.
     *
     * @param  string $logData
     * @return BaseResponse
     */

    public function updateLogTime($logData)
    {
        $this->workOrderService->updateTimerLog($logData);
        return new BaseResponse(
            STATUS_CODE_UPDATE,
            __(self::UPDATE_MESSAGE, ['title' => 'Log']),
            []
        );
    }

    /**
     * Fetch the specified resource in storage.
     *
     * @param  string $logData
     * @return BaseResponse
     */

    public function customLogTime($logData)
    {
        $this->workOrderService->customTimerLog($logData);
        return new BaseResponse(
            STATUS_CODE_UPDATE,
            __(self::UPDATE_MESSAGE, ['title' => 'Log Time']),
            []
        );
    }
/**
     * Store a newly created resource in storage.
     *
     * @param  AdditionalTaskRequest $request
     * @return BaseResponse
     */

    public function storeAdditionalTask(AdditionalTaskRequest $request)
    {
        $task = $this->additionalTaskService->store($request);
        return new BaseResponse(
            STATUS_CODE_CREATE,
            __(self::CREATE_MESSAGE, ['title' => 'Task']),
            $task
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int $id
     * @return mixed
     */

    public function editAdditionalTask($id)
    {
        return $this->additionalTaskService->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param  AdditionalTaskRequest $request
     * @return BaseResponse
     */

    public function updateAdditionalTask(AdditionalTaskRequest $request, $id)
    {
        $updateTask = $this->additionalTaskService->update($request, $id);
        return new BaseResponse(
            STATUS_CODE_UPDATE,
            __(self::UPDATE_MESSAGE, ['title' => self::ADDITIONAL_TASK]),
            $updateTask
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return BaseResponse
     */

    public function deleteAdditionalTask($id)
    {
        $this->additionalTaskService->delete($id);
        return new BaseResponse(
            STATUS_CODE_DELETE,
            __('messages.delete', ['title' => self::ADDITIONAL_TASK]),
            []
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param  string $type
     * @return BaseResponse
     */

    public function deleteCommentAdditionalTask($id, $type)
    {
        $this->additionalTaskService->deleteComment($id, $type);
        return new BaseResponse(
            STATUS_CODE_DELETE,
            __('messages.delete', ['title' => self::ADDITIONAL_TASK . ' ' . $type]),
            []
        );
    }
}
