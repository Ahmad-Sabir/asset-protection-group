<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class ImportRequest extends FormRequest
{
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
        return [
            'file'  => 'required|mimes:csv,txt,xlx,xls',
        ];
    }
}
