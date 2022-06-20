<?php

namespace App\Http\Controllers\Admin\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Asset\AssetTypeRequest;
use App\Models\Admin\WorkOrder\WorkOrder;
use App\Http\Responses\BaseResponse;
use App\Services\Admin\Asset\AssetTypeService;
use App\Services\Admin\Company\CompanyService;

class CompanyAssetTypeController extends Controller
{
    public function __construct(
        protected AssetTypeService $assetTypeService,
        protected WorkOrder $workOrder,
    ) {
    }

     /**
     * Display a listing of the resource.
     * @param mixed $companyId
     * @return \Illuminate\View\View
     */
    public function index($companyId)
    {
        $company = app(CompanyService::class)->find($companyId);

        return view('admin.company.asset-type.index', compact('company'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AssetTypeRequest $request
     * @param mixed $companyId
     * @return BaseResponse
     */
    public function store(AssetTypeRequest $request, $companyId)
    {
        $this->assetTypeService->store($request);

        return new BaseResponse(
            STATUS_CODE_CREATE,
            __('messages.create', ['title' => 'Asset Type']),
            []
        );
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  AssetTypeRequest  $request
     * @param mixed $assettypeid
     * @param mixed $companyId
     * @return BaseResponse
     */

    public function update(AssetTypeRequest $request, $companyId, $assettypeid)
    {
        $this->assetTypeService->update($request, $assettypeid);

        return new BaseResponse(
            STATUS_CODE_UPDATE,
            __('messages.update', ['title' => 'Asset Type']),
            []
        );
    }
}
