<?php

namespace App\Http\Controllers\Admin\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResponse;
use App\Services\Admin\User\UserService;
use App\Services\Admin\User\ImportService;
use App\Http\Requests\Admin\User\UserRequest;
use App\Http\Requests\Admin\User\ImportRequest;
use App\Exports\UserSampleExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService,
        protected ImportService $importService,
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.user.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserRequest $request
     * @return BaseResponse
     */
    public function store(UserRequest $request)
    {
        $this->userService->store($request);

        return new BaseResponse(
            STATUS_CODE_CREATE,
            __('messages.create', ['title' => 'User']),
            []
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserRequest $request
     * @param  int  $id
     * @return BaseResponse
     */
    public function update(UserRequest $request, $id)
    {
        $this->userService->update($request, $id);

        return new BaseResponse(
            STATUS_CODE_UPDATE,
            __('messages.update', ['title' => 'User']),
            []
        );
    }

    /**
     * Write code on Method
     * @param  ImportRequest $request
     * @return mixed
     */

    public function import(ImportRequest $request)
    {
        return $this->importService->importUser($request);
    }

    /**
     * Write code on Method
     *
     * @return mixed
     */
    public function export()
    {
        return Excel::download(new UserSampleExport(), 'user-template.csv');
    }

    /**
     * Write code on Method
     *
     * @return mixed
     */
    public function dashboard()
    {
        return view('admin.dashboard.index');
    }
}
