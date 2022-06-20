<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Arr;

class UserRequest extends FormRequest
{
    /**
     * Where to redirect users after registration.
     *
     * @var int
     */
    protected $max = 255;

    /**
     * get regex for aplha.
     *
     * @var string
     */
    protected $alphaRegex = "regex:/^[a-zA-Z ]*$/";

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  [
            'first_name'    => "bail|required|max:{$this->max}",
            'last_name'     => "bail|required|max:{$this->max}",
            'email'         => [
                'bail',
                ($this->isMethod('post')) ? 'required' : '',
                'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
                'string',
                'email',
                'max:' . $this->max,
                ($this->isMethod('post')) ? "unique:users,email,{$this->user}" : '',
                "unique:companies,manager_email,{$this->company}",
            ],
            'password'              => "nullable",
            'profile_media_id'      => "nullable",
            'deactivate_at'         => "nullable",
            'user_status'           => "nullable",
            'per_hour_rate'         => "nullable|numeric",
            'company_id'            => "nullable",
            'phone'                 => "nullable|max:16",
            'email_setting'         => "nullable",
            'notification_setting'  => "nullable",
        ];

        if (
            Route::currentRouteName() == 'admin.update-profile' ||
            Route::currentRouteName() == 'employee.update-profile'
        ) {
            $rules['email'] = '';
            $rules['current_password'] = ['nullable','required_with:password', 'current_password'];
            $rules['password'] = ['nullable', 'min:8', 'different:current_password'];
            $rules['confirm_password'] = ['nullable', 'required_with:password', 'same:password'];
        }

        return $rules;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if ($this->isMethod('post')) {
            $this->merge([
                'user_status'   =>  $this->company ? config('apg.user_status.employee')
                                            : config('apg.user_status.admin'),
                'company_id'    => $this->company ? $this->company : null,
            ]);
        }
        if ($this->isMethod('put')) {
            $this->merge(['deactivate_at' => !is_null($this->status) && $this->status == 0 ? now() : null]);
        }
        $this->emailPreferenceSetting();
    }
    /** @return void */
    public function emailPreferenceSetting()
    {
        $emailSetting = Arr::get($this->toArray(), 'email_setting', []);
        foreach (config('apg.email_setting_keys') as $key) {
            $emailSetting[$key] = Arr::has($emailSetting, $key) ? 1 : 0;
        }
        $this->merge(['email_setting' => $emailSetting]);

        $notificationSetting = Arr::get($this->toArray(), 'notification_setting', []);
        foreach (config('apg.notification_setting_keys') as $key) {
            $notificationSetting[$key] = Arr::has($notificationSetting, $key) ? 1 : 0;
        }
        $this->merge(['notification_setting' => $notificationSetting]);
    }
}
