<?php

namespace App\Listeners;

use PDF;
use App\Events\Export;
use Illuminate\Support\Arr;
use Illuminate\Bus\Queueable;
use App\Models\Admin\Asset\Asset;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Admin\WorkOrder\WorkOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Admin\WorkOrder\AdditionalTask;

class ExportPdfSendListener implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * status
     *
     * @var string
     */
    protected $recurringStatus = '';

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->recurringStatus =  config('apg.recurring_status.recurring');
    }

    /**
     * Handle the event.
     *
     * @param  Export $data
     * @return void
     */
    public function handle(Export $data)
    {
        if (property_exists($data, 'module') && Arr::has($data->module, 'isLocation')) {
            $data->data->loadMissing(['location' => fn ($q) => $q->select('*')]);
        }
        $module = $data->module['module'] ?? '';
        if ($data->type == config('apg.export_format.pdf')) {
            if ($module === 'comprehensive') {
                $workOrders['data']  = $this->comprehensive(
                    $data->filter,
                    $data->module['where'],
                    '',
                    $data->module['company']
                );
                $options = [
                    'data' => $workOrders,
                    'searchTerm' => $data->filter,
                    'fields' => [],
                    'view' => $data->pdfTemplate,
                    'orientation' => $data->orientation,
                    'type' => $data->type,
                    'fileName' => $data->module['fileName'],
                    'toEmail' => $data->module['toEmail'],
                    'emailView' => $data->module['emailView'],
                ];
            } elseif ($module === 'asset_compliance') {
                $assetCompliances['data']  = $this->comprehensive(
                    [],
                    [],
                    $data->module['params']['id']
                );
                $assetCompliances['compliance'] = 'compliance';
                $options = [
                    'data' => $assetCompliances,
                    'searchTerm' => $data->filter,
                    'fields' => [],
                    'view' => $data->pdfTemplate,
                    'orientation' => $data->orientation,
                    'type' => $data->type,
                    'fileName' => $data->module['fileName'],
                    'toEmail' => $data->module['toEmail'],
                    'emailView' => $data->module['emailView'],
                ];
            } elseif ($module === 'asset_company_compliance') {
                $companyAssetCompliances['data'] = $this->comprehensive(
                    [],
                    [],
                    $data->module['params']['id']
                );
                $companyAssetCompliances['compliance'] = 'compliance';
                $options = [
                    'data' => $companyAssetCompliances,
                    'searchTerm' => $data->filter,
                    'fields' => [],
                    'view' => $data->pdfTemplate,
                    'orientation' => $data->orientation,
                    'type' => $data->type,
                    'fileName' => $data->module['fileName'],
                    'toEmail' => $data->module['toEmail'],
                    'emailView' => $data->module['emailView'],
                ];
            } elseif ($module == 'asset_grid_compliance') {
                $assetGridCompliance['data'] = $this->gridCompliance(
                    $data->module['params']['id'],
                    $data->module['params']['companyId'] ?? ''
                );
                $assetGridCompliance['type'] = 'company';
                $options = [
                    'data' => $assetGridCompliance,
                    'searchTerm' => $data->filter,
                    'fields' => $data->fields,
                    'view' => $data->pdfTemplate,
                    'orientation' => $data->orientation,
                    'type' => $data->type,
                    'fileName' => $data->module['fileName'],
                    'toEmail' => $data->module['toEmail'],
                ];
            } elseif ($module == 'asset_detail_compliance') {
                $assetDetailCompliance = $this->detailCompliance(
                    $data->module['params']['id'],
                    $data->module['params']['companyId'] ?? ''
                );
                $options = [
                    'data' => $assetDetailCompliance,
                    'searchTerm' => $data->filter,
                    'fields' => $data->fields,
                    'view' => $data->pdfTemplate,
                    'orientation' => $data->orientation,
                    'type' => $data->type,
                    'fileName' => $data->module['fileName'],
                    'toEmail' => $data->module['toEmail'],
                ];
            } else {
                if ($module == 'expense') {
                    $data->data->loadMissing(['workOrder.asset.location' => fn ($q) => $q->select('*')]);
                }
                $options = [
                    'data' => $data->data,
                    'searchTerm' => $data->filter,
                    'fields' => $data->fields,
                    'view' => $data->pdfTemplate,
                    'orientation' => $data->orientation,
                    'type' => $data->type,
                    'fileName' => $data->module['fileName'],
                    'toEmail' => $data->module['toEmail'],
                    'emailView' => $data->module['emailView'] ?? ''
                ];
            }

            $this->render($options);
        }
    }

    public function render(array $options): void
    {
        $pdf = Pdf::loadView("admin.pdf.{$options['view']}", $options)
        ->setOrientation(($options['orientation']) ? $options['orientation'] : 'portrait');
        $emailView = (!empty($options['emailView'])) ? $options['emailView'] : 'email-template.attached-pdf-email';
        $body = view($emailView, ['data' => $options])->render();
        send_mail(
            $options['toEmail'],
            "Welcome to " . config('app.name') . " ",
            $body,
            '',
            $pdf->output(),
            $options['type'] ?? '',
            $options['fileName'] ?? ''
        );
    }

    /**
     * Send attachments via email.
     *
     * @param string $assetId
     * @param string $companyId
     * @return mixed
     */
    public function gridCompliance($assetId, $companyId = '')
    {
        /** @phpstan-ignore-next-line */
        return WorkOrder::with(['user:id,first_name,last_name', 'asset:id,name', 'company:id,name,profile_media_id'])
            ->when($companyId, function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
            ->where('asset_id', $assetId)
            ->get();
    }

    /**
     * Send attachments via email.
     *
     * @param string $assetId
     * @param string $companyId
     * @return mixed
     */
    public function detailCompliance($assetId, $companyId = '')
    {
        return $this->gridCompliance($assetId, $companyId);
    }

    /**
     * @param array $filter
     * @param array $where
     * @param string $assetId
     * @param mixed $company
     * @return mixed
     */
    public function comprehensive(array $filter, $where = [], $assetId = '', $company = '')
    {
        $assets = Asset::when($assetId, function ($query) use ($assetId) {
            $query->where('id', $assetId);
        })->whereHas('workOrders')
        ->orderBy('id', 'asc')
        ->get();
        $comprehensives = [];
        foreach ($assets as $asset) {
            /** @phpstan-ignore-next-line */
            $workOrderTasksCount = AdditionalTask::whereHas('workOrder', fn ($q) => $q->where('asset_id', $asset->id))
            ->count();
            $workOrderTasksIds = [];
            for ($i = 1; $i <= $workOrderTasksCount; $i++) {
                $once = $this->getComprehensive(
                    $workOrderTasksIds,
                    $asset->id,
                    config('apg.recurring_status.non-recurring'),
                    '',
                    $where,
                    $filter
                );
                $daily = $this->getComprehensive(
                    $workOrderTasksIds,
                    $asset->id,
                    $this->recurringStatus,
                    config('apg.frequency_status.daily'),
                    $where,
                    $filter
                );
                $weekly = $this->getComprehensive(
                    $workOrderTasksIds,
                    $asset->id,
                    $this->recurringStatus,
                    config('apg.frequency_status.weekly'),
                    $where,
                    $filter
                );
                $biWeekly = $this->getComprehensive(
                    $workOrderTasksIds,
                    $asset->id,
                    $this->recurringStatus,
                    config('apg.frequency_status.bi-weekly'),
                    $where,
                    $filter
                );
                $monthly = $this->getComprehensive(
                    $workOrderTasksIds,
                    $asset->id,
                    $this->recurringStatus,
                    config('apg.frequency_status.monthly'),
                    $where,
                    $filter
                );
                $biMonthly = $this->getComprehensive(
                    $workOrderTasksIds,
                    $asset->id,
                    $this->recurringStatus,
                    config('apg.frequency_status.bi-monthly'),
                    $where,
                    $filter
                );
                $quarterly = $this->getComprehensive(
                    $workOrderTasksIds,
                    $asset->id,
                    $this->recurringStatus,
                    config('apg.frequency_status.quarterly'),
                    $where,
                    $filter
                );
                $semiAnnually = $this->getComprehensive(
                    $workOrderTasksIds,
                    $asset->id,
                    $this->recurringStatus,
                    config('apg.frequency_status.semi-annually'),
                    $where,
                    $filter
                );
                $annually = $this->getComprehensive(
                    $workOrderTasksIds,
                    $asset->id,
                    $this->recurringStatus,
                    config('apg.frequency_status.annually'),
                    $where,
                    $filter
                );

                if (
                    empty($once) &&
                    empty($daily) &&
                    empty($weekly) &&
                    empty($biWeekly) &&
                    empty($monthly) &&
                    empty($biMonthly) &&
                    empty($quarterly) &&
                    empty($semiAnnually) &&
                    empty($annually)
                ) {
                    break;
                }
                $comprehensives[$asset->id . '_' . $i]['asset_id'] = $asset->id;
                $comprehensives[$asset->id . '_' . $i]['once'] = $once->name ?? null;
                $comprehensives[$asset->id . '_' . $i]['daily'] = $daily->name ?? null;
                $comprehensives[$asset->id . '_' . $i]['weekly'] = $weekly->name ?? null;
                $comprehensives[$asset->id . '_' . $i]['bi_weekly'] = $biWeekly->name ?? null;
                $comprehensives[$asset->id . '_' . $i]['monthly'] = $monthly->name ?? null;
                $comprehensives[$asset->id . '_' . $i]['bi_monthly'] = $biMonthly->name ?? null;
                $comprehensives[$asset->id . '_' . $i]['quarterly'] = $quarterly->name ?? null;
                $comprehensives[$asset->id . '_' . $i]['semi_annually'] = $semiAnnually->name ?? null;
                $comprehensives[$asset->id . '_' . $i]['annually'] = $annually->name ?? null;
                foreach (
                    [
                        'once',
                        'daily',
                        'weekly',
                        'biWeekly',
                        'monthly',
                        'biMonthly',
                        'quarterly',
                        'semiAnnually',
                        'annually',
                    ] as $var
                ) {
                    if (!empty(${$var}->id)) {
                        array_push($workOrderTasksIds, ${$var}->id ?? 0);
                    }
                }
            }
        }
        $comprehensives['company'] = $company ?? null;

        return $comprehensives;
    }

     /**
     * get comprehensive collection.
     *
     * @param array $workOrderTasksIds
     * @param int $assetId
     * @param string $recurringStatus
     * @param string $workOrderFrequency
     * @param array $where
     * @param array $filter
     * @return mixed
     */
    public function getComprehensive(
        $workOrderTasksIds,
        $assetId,
        $recurringStatus,
        $workOrderFrequency = '',
        $where = [],
        $filter = []
    ) {
        $workOrder = WorkOrder::select('id', 'title')->where('asset_id', $assetId)
        ->when(!empty($where), fn ($q) => $q->where($where))
        ->where('work_order_type', $recurringStatus)
        ->when(
            $recurringStatus == config('apg.recurring_status.recurring'),
            fn ($query) => $query->where('work_order_frequency', $workOrderFrequency)
        )->whereHas('additionaltasks', fn ($q) => $q->whereNotIn('id', $workOrderTasksIds))
        ->with(['additionaltasks' => function ($q) use ($workOrderTasksIds) {
            $q->whereNotIn('id', $workOrderTasksIds)->limit(1);
        }])->when(!empty($filter), function ($query) use ($filter) {
            $query->filter($filter);
        })
        ->orderBy('id', 'asc')->first();

        return $workOrder?->additionaltasks->first();
    }
}
