<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class ExpenseRequest extends FormRequest
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
            'type'          => "required",
            'description'   => "nullable",
            'amount'        =>  "required|numeric",
            'work_order_id' => "bail|required|exists:work_orders,id",
            'company_id'    => "nullable",
            'expense_date'  => "bail|nullable|date_format:m-d-Y",
        ];
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
                'company_id'    => $this->route('company') ? $this->route('company') : null,
            ]);
        }
    }
}
