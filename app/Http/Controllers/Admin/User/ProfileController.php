<?php

namespace App\Http\Controllers\Admin\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResponse;
use App\Services\Admin\User\UserService;
use App\Http\Requests\Admin\User\UserRequest;

class ProfileController extends Controller
{
    public function __construct(
        protected UserService $userService,
    ) {
    }

      /**
     * Write code on Method
     *
     * @return mixed
     */
    public function getProfile()
    {
        $user = auth()->user();

        return view('admin.user.profile', compact('user'));
    }

    /**
     * Write code on Method
     *
     * @return mixed
     */
    public function updateProfile(UserRequest $request)
    {
        return $this->userService->updateProfile($request);
    }
}
