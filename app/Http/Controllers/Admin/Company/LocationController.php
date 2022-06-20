<?php

namespace App\Http\Controllers\Admin\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResponse;
use App\Services\Admin\Asset\LocationService;
use App\Http\Requests\Admin\Asset\LocationRequest;

class LocationController extends Controller
{
    public function __construct(
        protected LocationService $locationService,
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $companyId
     * @return \Illuminate\View\View
     */
    public function index($companyId)
    {
        $company = app(\App\Services\Admin\Company\CompanyService::class)->find($companyId);

        return view('admin.company.location.index', compact('company'));
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  LocationRequest $request
     * @param mixed $companyId
     * @return BaseResponse
     */
    public function store(LocationRequest $request, $companyId)
    {
        $this->locationService->store($request);

        return new BaseResponse(
            STATUS_CODE_CREATE,
            __('messages.create', ['title' => 'Location']),
            []
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  LocationRequest $request
     * @param mixed $companyId
     * @param mixed $locationId
     * @return BaseResponse
     */
    public function update(LocationRequest $request, $companyId, $locationId)
    {
        $this->locationService->update($request, $locationId);

        return new BaseResponse(
            STATUS_CODE_UPDATE,
            __('messages.update', ['title' => 'Location']),
            []
        );
    }
}
