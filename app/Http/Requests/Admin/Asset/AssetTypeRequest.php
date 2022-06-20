<?php

namespace App\Http\Requests\Admin\Asset;

use App\Models\Admin\Asset\AssetType;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class AssetTypeRequest extends FormRequest
{
    /**
     * Where to redirect users after registration.
     *
     * @var int
     */
    protected $max = 110;

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
            'name'  => [
                'bail',
                'required',
                "max:{$this->max}",
                function ($attribute, $value, $fail) {
                    if ($this->checkAssetTypeName($value) && $attribute) {
                        $fail('The name has already been taken.');
                    }
                }
            ],
            'work_order_titles.*.title' => 'required',
            'company_id'      => "nullable",
            'type'            => "nullable",
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'work_order_titles.*.title.required' => 'The all work order title fields is required.'
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
                'company_id'    => $this->company ? $this->company : null,
                'type'    => $this->company ? config('apg.type.company') : config('apg.type.master'),
            ]);
        }
    }
     /**
     * @param string $value
     * @return bool
     */
    public function checkAssetTypeName($value)
    {
        return AssetType::query()->when(
            $this->route('asset_type'),
            fn ($query) => $query->where('id', '!=', $this->route('asset_type'))
        )
            ->where('name', trim($value))
            ->when($this->route('company'), fn ($query) => $query->where('company_id', $this->route('company')))
            ->when(!$this->route('company'), fn ($query) => $query->whereNull('company_id'))
            ->exists();
    }
}
