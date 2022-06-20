<?php

namespace App\Services\Admin\User;

use App\Http\Requests\Admin\User\UserRequest;
use App\Http\Requests\Company\CompanyRequest;
use App\Models\User;
use App\Events\Registered;
use App\Http\Responses\BaseResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Company;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function __construct(
        protected User $user,
        protected Company $company,
    ) {
    }

    /**
     * store user
     *
     * @param UserRequest $request
     * @return mixed
     */
    public function store(UserRequest $request)
    {
        $storeUser = $this->user->create($request->validated());
        event(new Registered($storeUser));

        return $storeUser;
    }

    /**
     * update user
     *
     * @param UserRequest $request
     * @param int $id
     * @return mixed
     */
    public function update(UserRequest $request, $id)
    {
        /** @var \App\Models\User $updateUser */
        $updateUser = $this->user->find($id);

        return $updateUser->update($request->validated());
    }

    /*
    @param mixed $company
    @var mixed $storeUserEmployee
    */
     /** @phpstan-ignore-next-line */
    public function storeUserEmployee($company)
    {
        $storeUserEmployee = $this->user->create(
            [
                'first_name' =>     $company->manager_first_name,
                'last_name'  =>     $company->manager_last_name,
                'email'      =>     $company->manager_email,
                'company_id' =>     $company->id,
                'user_status' =>     config('apg.user_status.employee'),
                'phone'      =>     $company->manager_phone,
                'is_admin_employee' => 1,
            ]
        );
        event(new Registered($storeUserEmployee));

        return $storeUserEmployee;
    }

    /**
    * @param mixed $request
    * @return \App\Http\Responses\BaseResponse
    */
    public function updateProfile($request)
    {
        /** @var \App\Models\User $users */
        $users = auth()->user();
        $users->profile_media_id = $request->profile_media_id;
        $users->first_name = $request->first_name;
        $users->last_name = $request->last_name;
        $users->password = $request->password == null ?  $users->password  : Hash::make($request->password);
        $users->email_setting = $request->email_setting;
        $users->notification_setting = $request->notification_setting;
        $users->save();

        return new BaseResponse(
            STATUS_CODE_UPDATE,
            __('messages.update', ['title' => 'User']),
            []
        );
    }
}
