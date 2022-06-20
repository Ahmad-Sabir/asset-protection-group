<?php

namespace App\Http\Controllers\Admin\Company;

use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResponse;
use App\Models\Admin\Asset\Asset;
use App\Models\Admin\Asset\AssetType;
use App\Services\Admin\User\ImportService;
use App\Services\Admin\Company\CompanyService;
use App\Services\Admin\WorkOrder\WorkOrderService;
use App\Http\Requests\Admin\User\ImportRequest;
use App\Http\Requests\Admin\WorkOrder\WorkOrderRequest;
use App\Services\Admin\ExportService;
use App\Services\Admin\Company\ExpenseService;
use App\Services\Admin\NotificationService;

class WorkOrderController extends Controller
{
    protected const CREATE_MESSAGE = 'messages.create';
    protected const UPDATE_MESSAGE = 'messages.update';
    protected const TITLE = 'Work Order';
    protected const INDEX_ROUTE = 'admin.companies.work-orders.index';
    public function __construct(
        protected WorkOrderService $workOrderService,
        protected Asset $asset,
        protected CompanyService $companyService,
        protected ExpenseService $expenseService,
        protected ExportService $exportService,
        protected NotificationService $notificationService,
    ) {
    }

    /**
     * Display a listing of the resource.
     * @param int $companyId
     * @return \Illuminate\View\View
     */
    public function index($companyId)
    {
        $company = $this->companyService->find($companyId);

        return view('admin.company.workorder.index', compact('company'));
    }

    /**
     * Display a listing of the resource.
     * @param int $companyId
     * @return \Illuminate\View\View
     */
    public function create($companyId)
    {
        $company = $this->companyService->find($companyId);
        $companyUser = $company->users()->where('is_admin_employee', 1)->first();

        return view('admin.company.workorder.create', compact('company', 'companyUser'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  WorkOrderRequest $request
     * @param  int $companyId
     * @return BaseResponse
     */
    public function store(WorkOrderRequest $request, $companyId)
    {
        $this->workOrderService->store($request);

        return new BaseResponse(
            STATUS_CODE_CREATE,
            __(self::CREATE_MESSAGE, ['title' => self::TITLE]),
            [
                'redirect_url' => $request->get('is_compliance')
                ? route('admin.companies.assets.show', [
                    $companyId,
                    $request->input('asset_id'),
                    'action_type' => 'compliance-plan'
                ]) : route(self::INDEX_ROUTE, $companyId)
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  int  $companyId
     * @return BaseResponse
     */
    public function cloneWorkOrder($companyId, $id)
    {
        $clonedOrder = $this->workOrderService->cloneWorkOrder($id);
        return new BaseResponse(
            STATUS_CODE_CREATE,
            __(self::CREATE_MESSAGE, ['title' => self::TITLE]),
            ['redirect_url' => route('admin.companies.work-orders.edit', [$companyId, $clonedOrder->id])]
        );
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  int $companyId
     * @param  int $workOrderId
     * @return \Illuminate\View\View
     */

    public function show($companyId, $workOrderId)
    {
        $workOrder = $this->workOrderService->find($workOrderId);
        $company = $this->companyService->find($companyId);
        $sum = $this->expenseService->totalExpense($workOrder->id);
        $expense = $this->expenseService->find($workOrder->id);

        return view('admin.company.workorder.show', compact('workOrder', 'company', 'expense', 'sum'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int $companyId
     * @param  int $workOrderId
     * @return \Illuminate\View\View
     */
    public function edit($companyId, $workOrderId)
    {
        $company = $this->companyService->find($companyId);
        $workOrder = $this->workOrderService->find($workOrderId);
        $sum = $this->expenseService->totalExpense($workOrder->id);
        $expense = $this->expenseService->find($workOrder->id);

        return view('admin.company.workorder.edit', compact('workOrder', 'company', 'expense', 'sum'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  WorkOrderRequest $request
     * @param  int  $companyId
     * @param  int  $workOrderId
     * @return BaseResponse
     */
    public function update(WorkOrderRequest $request, $companyId, $workOrderId)
    {
        $this->workOrderService->update($request, $workOrderId);
        return new BaseResponse(
            STATUS_CODE_UPDATE,
            __(self::UPDATE_MESSAGE, ['title' => self::TITLE]),
            [
                'redirect_url' => $request->get('is_compliance')
                ? route('admin.companies.assets.show', [
                    $companyId,
                    $request->input('asset_id'),
                    'action_type' => 'compliance-plan'
                ]) : route(self::INDEX_ROUTE, $companyId)
            ]
        );
    }

    /**
    * import workorder
    *
    * @param  ImportRequest $request
    * @param  int $companyId
    * @return mixed
    */
    public function importCsv(ImportRequest $request, $companyId)
    {
        return (new ImportService())->importWorkOrders($request, $companyId);
    }

    /**
     * Display a listing of the resource.
     * @param int $companyId
     * @param Asset $asset
     * @return \Illuminate\View\View
     */
    public function assetWorkOrderCreate($companyId, Asset $asset)
    {
        $company = $this->companyService->find($companyId);
        $isCompliance = true;

        return view('admin.company.workorder.create', compact('company', 'asset', 'isCompliance'));
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
        $workOrder = $this->workOrderService->exportCompanyWorkOrderPdf($companyId, $id);
        $view['fileName'] = (!empty($workOrder)) ? $workOrder[0]->title : '';
        $view['emailView'] = 'email-template.exports.master-workorder-single';
        return $this->getExport($workOrder, config('apg.export_format.pdf'), $view);
    }

    /**
     * Send attachments via email.
     *
     * @param string $id
     * @param string $companyId
     * @return mixed
     */
    public function exportCompanyWorkOrderCsv($companyId, $id = '')
    {
        $workOrder = $this->workOrderService->getCompanyExport($companyId, $id);
        $view['fileName'] = (!empty($workOrder)) ? $workOrder[0]->title : '';
        $view['emailView'] = 'email-template.exports.master-workorder-single';
        return $this->getExport($workOrder, config('apg.export_format.csv'), $view);
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
            'module' => config('apg.export_module.master_workorder'),
            'fileName' => __('messages.export_filename.work_order', ['name' => $view['fileName']]),
            'isLocation' => true,
            'emailView' => $view['emailView']
        ];

        return $this->exportService->export($workOrder, $pdfTemplate, $orientation, $filter, $field, $type, $module);
    }
}
