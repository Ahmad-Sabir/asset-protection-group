<?php

namespace App\Http\Requests\Admin\Asset;

use App\Models\Admin\Asset\Asset;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class AssetRequest extends FormRequest
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
        $rules = [
            'name'     => [
                "bail",
                "required",
                "max:{$this->max}",
                function ($attribute, $value, $fail) {
                    if ($this->checkAssetDetail($attribute, $value)) {
                        $fail('The name has already been taken.');
                    }
                }
            ],
            'model'                     => "bail|max:{$this->max}",
            'type'                      => "nullable",
            'company_id'                => "nullable",
            'location_id'               => "nullable",
            'asset_type_id'             => "bail|required|exists:asset_types,id",
            'description'               => "nullable",
            'manufacturer'              => "nullable",
            'purchase_price'            => "nullable|numeric",
            'replacement_cost'          => "nullable|numeric",
            'purchase_date'             => "bail|nullable|date_format:m-d-Y",
            'installation_date'         => "bail|nullable|date_format:m-d-Y",
            'warranty_expiry_date'      => "bail|nullable|date_format:m-d-Y|after_or_equal:installation_date",
            'total_useful_life'         => "nullable",
            'total_useful_life_date'    => "nullable",
            'custom_values'             => "nullable",
            'status'                    => "nullable",
            'media_ids'                 => "nullable",
            'location'                  => "nullable",
            'company_number'            => "nullable",
        ];
        if ($this->route('company')) {
            $rules['company_number'] = ["required", function ($attribute, $value, $fail) {
                if ($this->checkAssetDetail($attribute, $value)) {
                    $fail('The company id has already been taken.');
                }
            }
            ];
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'description'           => 'Additional Information',
            'warranty_expiry_date'  => 'Warranty Expiration',
            'asset_type_id'         => 'Asset Type',
            'company_number'         => 'company id'
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function passedValidation()
    {
        $useFulLifeDate = null;
        $installation_date = $this->installation_date ?
         /** @phpstan-ignore-next-line */
        Carbon::createFromFormat('m-d-Y', $this->installation_date)->format('Y-m-d') : null;
        if (! empty($installation_date)) {
            $useFulLifeDate = calculateTotalUseFulLife($installation_date, $this->total_useful_life);
        }

        $this->merge([
            'total_useful_life_date' => $useFulLifeDate,
        ]);
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
                'company_id' => $this->company ? $this->company : null,
                'type' => $this->company ? config('apg.type.company') : config('apg.type.master'),
            ]);
        }
    }

    /**
     * @param string $value
     * @param string $attribute
     * @return bool
     */
    public function checkAssetDetail($attribute, $value)
    {
        return Asset::query()->where('id', '!=', $this->route('asset'))
            ->where($attribute, trim($value))
            ->when($this->route('company'), fn ($query) => $query->where('company_id', $this->route('company')))
            ->when(!$this->route('company'), fn ($query) => $query->whereNull('company_id'))
            ->exists();
    }
}
