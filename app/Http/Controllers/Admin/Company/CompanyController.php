<?php

namespace App\Http\Controllers\Admin\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResponse;
use App\Services\Admin\Company\CompanyService;
use App\Http\Requests\Company\CompanyRequest;

class CompanyController extends Controller
{
    public function __construct(
        protected CompanyService $companyService,
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.company.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CompanyRequest $request
     * @return BaseResponse
     */
    public function store(CompanyRequest $request)
    {
        $this->companyService->store($request);

        return new BaseResponse(
            STATUS_CODE_CREATE,
            __('messages.create', ['title' => 'Company']),
            []
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CompanyRequest $request
     * @param  int  $id
     * @return BaseResponse
     */
    public function update(CompanyRequest $request, $id)
    {
        $this->companyService->update($request, $id);

        return new BaseResponse(
            STATUS_CODE_UPDATE,
            __('messages.update', ['title' => 'Company']),
            []
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
        $company = $this->companyService->find($id);

        return view('admin.company.dashboard.index', compact('company'));
    }
}
