<?php

namespace App\Http\Controllers\Admin\WorkOrder;

use App\Exports\WorkOrderSampleExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\ImportRequest;
use App\Http\Requests\Admin\WorkOrder\WorkOrderRequest;
use App\Http\Responses\BaseResponse;
use App\Models\Admin\Asset\Asset;
use App\Models\Admin\Asset\AssetType;
use App\Models\User;
use App\Services\Admin\User\ImportService;
use App\Services\Admin\WorkOrder\WorkOrderService;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Admin\ExportService;
use App\Services\Admin\Company\ExpenseService;
use App\Traits\HasExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\Admin\NotificationService;

class WorkOrderController extends Controller implements ShouldQueue
{
    use HasExport;

    protected const CREATE_MESSAGE = 'messages.create';
    protected const UPDATE_MESSAGE = 'messages.update';
    protected const TITLE = 'Work Order';
    protected const INDEX_ROUTE = 'admin.work-orders.index';
    public function __construct(
        protected WorkOrderService $workOrderService,
        protected ExportService $exportService,
        protected AssetType $assetType,
        protected Asset $asset,
        protected User $user,
        protected ExpenseService $expenseService,
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
        return view('admin.workorder.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.workorder.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  WorkOrderRequest $request
     * @return BaseResponse
     */
    public function store(WorkOrderRequest $request)
    {
        $this->workOrderService->store($request);

        return new BaseResponse(
            STATUS_CODE_CREATE,
            __(self::CREATE_MESSAGE, ['title' => self::TITLE]),
            [
                'redirect_url' => $request->get('is_compliance')
                ? route('admin.assets.show', [
                    $request->input('asset_id'),
                    'action_type' => 'compliance-plan'
                ]) : route(self::INDEX_ROUTE)
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return BaseResponse
     */
    public function cloneWorkOrder($id)
    {
        $clonedOrder = $this->workOrderService->cloneWorkOrder($id);
        return new BaseResponse(
            STATUS_CODE_CREATE,
            __(self::CREATE_MESSAGE, ['title' => self::TITLE]),
            ['redirect_url' => route('admin.work-orders.edit', $clonedOrder->id)]
        );
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
        $sum = $this->expenseService->totalExpense($workOrder->id);
        $expense = $this->expenseService->find($workOrder->id);

        return view('admin.workorder.show', compact('workOrder', 'sum', 'expense'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $workOrder = $this->workOrderService->find($id);
        $sum = $this->expenseService->totalExpense($workOrder->id);
        $expense = $this->expenseService->find($workOrder->id);

        return view('admin.workorder.edit', compact('workOrder', 'sum', 'expense'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  WorkOrderRequest $request
     * @param  int  $id
     * @return BaseResponse
     */
    public function update(WorkOrderRequest $request, $id)
    {
        $this->workOrderService->update($request, $id);
        return new BaseResponse(
            STATUS_CODE_UPDATE,
            __(self::UPDATE_MESSAGE, ['title' => self::TITLE]),
            [
                'redirect_url' => $request->get('is_compliance')
                ? route('admin.assets.show', [
                    $request->input('asset_id'),
                    'action_type' => 'compliance-plan'
                ]) : route(self::INDEX_ROUTE)
            ]
        );
    }

    /**
     * Fetch the specified resource in storage.
     *
     * @param  int  $id
     * @return BaseResponse
     */

    public function fetchAssets($id)
    {
        $assets = $this->asset->where('asset_type_id', $id)->get();

        return new BaseResponse(
            STATUS_CODE_CREATE,
            __(self::CREATE_MESSAGE, ['title' => 'Asset fetched']),
            $assets
        );
    }
    /**
     * Fetch the specified resource in storage.
     *
     * @param  int  $id
     * @return BaseResponse
     */

    public function fetchLocation($id)
    {
        /** @phpstan-ignore-next-line */
        $location =  $this->asset->with(['location'
            => function ($query) {
                $query->select('*');
            }])->findOrFail($id);
        $warranty = $location->warranty_expiry_date;
        $location = $location->location;
        $locationName = $location->name;
        $locationID = $location->id;

        $locationsDetail['warranty'] = $warranty;
        $locationsDetail['name'] = $locationName;
        $locationsDetail['id'] = $locationID;

        return new BaseResponse(
            STATUS_CODE_CREATE,
            __(self::CREATE_MESSAGE, ['title' => 'Location fetched']),
            $locationsDetail
        );
    }

    /**
     * get export template
     *
     * @param  ImportRequest $request
     * @return mixed
     */
    public function importCsv(ImportRequest $request)
    {
        return (new ImportService())->importWorkOrders($request);
    }

    /**
     * get export template
     *
     * @return mixed
     */
    public function exportTemplate()
    {
        return Excel::download(new WorkOrderSampleExport(), 'work-orders-template.csv');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function assetWorkOrderCreate(Asset $asset)
    {
        $assetType = $this->assetType->get();
        $users = $this->user->get();
        $isCompliance = true;

        return view('admin.workorder.create', compact('assetType', 'users', 'asset', 'isCompliance'));
    }
}
