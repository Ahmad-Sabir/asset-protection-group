<?php

namespace App\Http\Requests\Admin\WorkOrder;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TimerLogRequest extends FormRequest
{
     /**
     *
     * @var string $null
     */
    protected $null = 'nullable';

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
            'work_order_id'   => "bail|required",
            'parent_id'       => $this->null,
            'time'            => $this->null . "|date_format:H:i:s'",
            'type'            => 'required',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */

    protected function passedValidation()
    {
        $time = now()->format('Y-m-d H:i:s');
            $this->merge([
            'time' => $time,
            ]);
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'time'           => 'Time',
            'type'           => 'Type',
        ];
    }
}
