<?php

namespace App\Http\Requests\Company;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
        $rules = [
            'manager_first_name'    => "bail|required|max:{$this->max}",
            'manager_last_name'     => "bail|required|max:{$this->max}",
            'manager_email'         => [
                'bail',
                'required',
                'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
                'string',
                'email',
                'max:' . $this->max,
                "unique:companies,manager_email,{$this->company}",
            ],
            'profile_media_id'      => "nullable",
            'designation'           => "required",
            'name'                  => "required",
            "deactivate_at"         => "nullable",
            'manager_phone'         => 'required|numeric'
        ];

        if ($this->isMethod('post')) {
            $rules['manager_email'][] =  "unique:users,email,{$this->manager_email}";
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
        if ($this->isMethod('put')) {
            $this->merge(['deactivate_at' => !is_null($this->status) && $this->status == 0 ? now() : null]);
        }
    }
}
