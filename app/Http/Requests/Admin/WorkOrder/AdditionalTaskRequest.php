<?php

namespace App\Http\Requests\Admin\WorkOrder;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AdditionalTaskRequest extends FormRequest
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
        return [
            'work_order_id'   => "nullable",
            'media_id'        => "nullable",
            'name'            => "bail|required|max:{$this->max}",
            'task_detail'     => "nullable",
            'due_date'        => "nullable|date_format:m-d-Y",
            'status'          => "nullable",
            'comment'         => "nullable"
        ];
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
            'Task detail'           => 'Task Detail',
        ];
    }
}
