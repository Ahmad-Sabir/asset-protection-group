<?php

namespace App\Http\Requests\Admin\WorkOrder;

use App\Models\Admin\WorkOrder\AdditionalTask;
use App\Models\Admin\WorkOrder\WorkOrder;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class WorkOrderRequest extends FormRequest
{
    /**
     * Where to redirect users after registration.
     *
     * @var int
     */
    protected $max = 225;

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
            'title'                     => "bail|required|max:{$this->max}",
            'company_id'                => "nullable",
            'assignee_user_id'          => [
                "bail",
                "required",
                function ($attribute, $value, $fail) {
                    if ($this->workOrderCustomRules($attribute, $value)) {
                        $fail('Assignee can only be changed on work order status as Open/On-hold');
                    }
                }
            ],
            'location_id'               => "nullable",
            'asset_id'                  => "bail|required|exists:assets,id",
            'asset_type_id'             => "bail|required|exists:asset_types,id",
            'work_order_profile_id'     => 'nullable',
            'asset_warranty'            => "nullable",
            'description'               => "nullable",
            'additional_info'           => "nullable",
            'flag'                      => "nullable",
            'priority'                  => "nullable",
            'type'                      => "nullable",
            'work_order_status'         => "nullable",
            'qualification'             => "nullable",
            'on_hold_reason'            => "nullable",
            'task_data'                 => "nullable",
            'work_order_type'           => [
                "bail",
                "required",
                function ($attribute, $value, $fail) {
                    if ($this->workOrderCustomRules($attribute, $value)) {
                        $fail('Work order type can only be changed on work order status as Open/On-hold');
                    }
                }
            ],
            'work_order_frequency'      => [
                "bail",
                "required_if:work_order_type," . config('apg.recurring_status.recurring'),
                function ($attribute, $value, $fail) {
                    if ($this->workOrderCustomRules($attribute, $value)) {
                        $fail('Work order frequency can only be changed on work order status as Open/On-hold');
                    }
                }
            ],
            'work_order_log_timer'      => "nullable|date_format:H:i:s",
            'is_pause'                  => "nullable",
            'media_ids'                 => "nullable",
            'due_date'                  => "bail|required|date_format:m-d-Y",
            'update_frequency_type'     => "bail|required_if:is_update_frequency,true",
        ];

        if ($this->work_order_status == config('apg.work_order_status.completed')) {
            $rules['task_status'] = [
                function ($attribute, $value, $fail) {
                    if ($this->checkWorkOrderStatus($value) && $attribute) {
                        $fail('Please complete all the tasks in order to mark this work order completed.');
                    }
                }
            ];
        }
        if ($this->work_order_status == config('apg.work_order_status.on_hold')) {
            $rules['on_hold_reason'] = [
            'required'
            ];
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
        $this->merge([
            'company_id' => $this->company ? $this->company : null,
            'type' => $this->company ? config('apg.type.company') : config('apg.type.master'),
        ]);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */

    protected function passedValidation()
    {
        $due_date = $this->due_date ?
            /** @phpstan-ignore-next-line */
            Carbon::createFromFormat('m-d-Y', $this->due_date)->format('Y-m-d') : null;

            $this->merge([
            'due_date' => $due_date,
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
            'additional_info'           => 'Additional Information',
        ];
    }

    /**
     * @param array $value
     * @return mixed
     */
    public function checkWorkOrderStatus($value)
    {
        if (in_array(config('apg.task_status.pending'), $value)) {
            return true;
        }
    }

    /**
     * @param string $key
     * @param array $value
     * @return mixed
     */
    public function workOrderCustomRules($key, $value)
    {
        return WorkOrder::query()->whereIn('work_order_status', [
            config('apg.work_order_status.in_progress'),
            config('apg.work_order_status.completed'),
            config('apg.work_order_status.closed')
        ])->where('id', $this->route('work_order'))
        ->where($key, '!=', $value)
        ->exists();
    }
}
