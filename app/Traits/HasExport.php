<?php

namespace App\Traits;

use App\Services\Admin\WorkOrder\WorkOrderService;

trait HasExport
{
    /**
     * Send attachments via email.
     *
     * @param string $id
     * @return mixed
     */
    public function exportWorkOrderPdf($id = '')
    {
        $workOrder =  $this->workOrderService->exportWorkOrderPdf($id);
        $view['fileName'] = (!empty($workOrder)) ? $workOrder[0]['title'] : '';
        $view['emailView'] = 'email-template.exports.master-workorder-single';
        return $this->getExport($workOrder, config('apg.export_format.pdf'), $view);
    }

    /**
     * Send attachments via email.
     *
     * @param mixed $workOrder
     * @param mixed $type
     * @param mixed $view
     * @return mixed
     */
    public function getExport($workOrder, $type, $view = [])
    {
        $pdfTemplate = config('apg.pdf_options.template.work-order-print');
        $orientation = config('apg.pdf_options.orientation.portrait');
        $filter = [];
        $field = [];
        $module = [
            'module' => config('apg.export_module.asset_workorder_single'),
            'fileName' => __('messages.export_filename.work_order', ['name' => $view['fileName']]),
            'isLocation' => true,
            'emailView'  => $view['emailView']
        ];

        return $this->exportService->export($workOrder, $pdfTemplate, $orientation, $filter, $field, $type, $module);
    }

    /**
     * Send attachments via email.
     *
     * @param string $id
     * @return mixed
     */
    public function exportWorkOrderCsv($id = '')
    {
        $workOrder =  $this->workOrderService->getMasterExport($id);
        $view['fileName'] = (!empty($workOrder)) ? $workOrder[0]['title'] : '';
        $view['emailView'] = 'email-template.exports.master-workorder-single';
        return $this->getExport($workOrder, config('apg.export_format.csv'), $view);
    }
}
