<?php

namespace App\Http\Requests\Admin\Asset;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Models\Admin\Asset\Asset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
{
    /**
     * Where to redirect users after registration.
     *
     * @var int
     */
    protected $max = 250;

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
            'name'          => "bail|required|max:{$this->max}",
            'latitude'      => "bail|required|numeric",
            'longitude'     => "bail|required|numeric",
            'location'      => "nullable",
            'company_id'    => "nullable",
            'is_crud'       => "nullable",
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $lat_lng = sprintf("%s %s", $this->latitude, $this->longitude);
        $this->merge([
            'is_crud' => 1,
            'company_id' => $this->route('company') ? $this->route('company') : null,
            'location' => !app()->environment('testing') ?
            DB::raw("ST_GeomFromText('POINT($lat_lng)')") : "174.854498997714",
        ]);
    }
}
