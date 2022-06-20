<?php

namespace App\Http\Controllers\Admin\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\User\UserRequest;
use App\Http\Responses\BaseResponse;
use App\Services\Admin\User\UserService;

class EmployeeController extends Controller
{
    public function __construct(
        protected UserService $userService,
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

        return view('admin.company.employee.index', compact('company'));
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  UserRequest $request
     * @param mixed $companyId
     * @return BaseResponse
     */
    public function store(UserRequest $request, $companyId)
    {
        $this->userService->store($request);
        return new BaseResponse(
            STATUS_CODE_CREATE,
            __('messages.create', ['title' => 'Employee']),
            []
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserRequest $request
     * @param mixed $companyId
     * @param mixed $employeeId
     * @return BaseResponse
     */
    public function update(UserRequest $request, $companyId, $employeeId)
    {
        $this->userService->update($request, $employeeId);
        return new BaseResponse(
            STATUS_CODE_UPDATE,
            __('messages.update', ['title' => 'Employee']),
            []
        );
    }
}
