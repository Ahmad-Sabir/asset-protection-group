<?php

namespace App\Http\Controllers\Admin\Asset;

use App\Http\Controllers\Controller;
use App\Models\Admin\WorkOrder\WorkOrder;
use Illuminate\Http\Request;
use App\Http\Responses\BaseResponse;
use App\Services\Admin\Asset\AssetTypeService;
use App\Http\Requests\Admin\Asset\AssetTypeRequest;

class AssetTypeController extends Controller
{
    public function __construct(
        protected AssetTypeService $assetTypeService,
        protected WorkOrder $workOrder,
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.assettype.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AssetTypeRequest $request
     * @return BaseResponse
     */
    public function store(AssetTypeRequest $request)
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
     * @param  int  $id
     * @return BaseResponse
     */

    public function update(AssetTypeRequest $request, $id)
    {
        $this->assetTypeService->update($request, $id);

        return new BaseResponse(
            STATUS_CODE_UPDATE,
            __('messages.update', ['title' => 'Asset Type']),
            []
        );
    }
}
