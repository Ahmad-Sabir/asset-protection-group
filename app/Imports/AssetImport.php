<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Admin\Asset\Asset;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Asset\Location;
use App\Models\Admin\Asset\AssetType;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Services\Admin\WorkOrder\WorkOrderService;

class AssetImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable;

    protected array $rows = [];
    protected int|null $companyId = null;

    /**
     *
     * @return array
     */
    public function rules(): array
    {
        $dateFormat = "nullable|date_format:m-d-Y";
        $numeric = "nullable|numeric";
        $companyRule = $this->companyId ? ",company_id,{$this->companyId}" : '';

        return [
            'name'     => [
                "required",
                "max:255",
                function ($attribute, $value, $fail) {
                    if ($this->checkAssetName($value) && $attribute) {
                        $fail('The name has already been taken.');
                    }
                }
            ],
            'asset_type'                    => "required|max:255|exists:asset_types,name" . $companyRule,
            'total_useful_life'             => 'regex:/^\d*(-\d+)*$/',
            'latitude'                      => $numeric,
            'longitude'                     => $numeric,
            'asset_replacement_cost'        => $numeric,
            'purchase_price'                => $numeric,
            'purchase_date'                 => $dateFormat,
            'asset_installation_date'       => $dateFormat,
            'warranty_expiration'           => $dateFormat,
        ];
    }

    /**
     * @param string $value
     * @return bool
     */
    public function checkAssetName($value)
    {
        return Asset::query()->where('name', trim($value))
            ->when($this->companyId, fn ($query) => $query->where('company_id', $this->companyId))
            ->when(!$this->companyId, fn ($query) => $query->whereNull('company_id'))
            ->exists();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function customValidationAttributes()
    {
        return [
            'asset_type'                    => 'Asset Type',
            'asset_replacement_cost'        => 'Asset Replacement Cost',
            'purchase_price'                => 'Purchase Price',
            'purchase_date'                 => 'Purchase Date',
            'asset_installation_date'       => 'Asset Installation Date',
            'warranty_expiration'           => 'Warranty Expiration',
            'total_useful_life'             => 'Total UseFul Life',
        ];
    }

    /**
     *
     * @param mixed $rows
     * @return mixed
     */
    public function collection($rows)
    {
        $count = 0;
        foreach ($rows as $row) {
             /** @var \App\Models\Admin\Asset\AssetType $assetType */
            $assetType = AssetType::where('name', $row['asset_type'])
            ->when($this->companyId, fn ($q) => $q->where('company_id', $this->companyId))->first();
            $location = $this->prepareLocation($row);
            $row = $this->prepareLogics($row);

            $assetStore = Asset::create([
                'name' => $row['name'],
                'company_id' => $this->companyId,
                'type' => $this->companyId ? config('apg.type.company') : config('apg.type.master'),
                'asset_type_id' => $assetType->id,
                'location_id' => !empty($location) ? $location->id : null,
                'model' => $row['asset_model_name'] ?? null,
                'manufacturer' => $row['asset_manufacturer'] ?? null,
                'installation_date' => $row['asset_installation_date'] ?? null,
                'replacement_cost' => $row['asset_replacement_cost'] ?? null,
                'purchase_date' => $row['purchase_date'] ?? null,
                'purchase_price' => $row['purchase_price'] ?? null,
                'warranty_expiry_date' => $row['warranty_expiration'] ?? null,
                'total_useful_life' => $row['total_useful_life'] ?? null,
                'total_useful_life_date' => $row['total_useful_life_date'] ?? null,
                'status' => 1,
            ]);
            app(WorkOrderService::class)->storeAssetTypeWorkOrders($assetStore);
            $count++;
        }
        $this->rows['success_rows'] = $count;
    }

    /**
     * @param Failure $failures
     */
    public function onFailure(Failure ...$failures): void
    {
        $this->rows['failures'] = $failures;
    }

    public function prepareLocation(mixed $row): mixed
    {
        $location = [];
        if (!empty($row['latitude']) && !empty($row['longitude'])) {
            $lat_lng = sprintf("%s %s", $row['latitude'], $row['longitude']);
            $setLocation = !app()->environment('testing') ? DB::raw("ST_GeomFromText('POINT($lat_lng)')") : null;
            $check = !app()->environment('testing') ? Location::whereRaw('ST_X(location) = ?', $row['latitude'])
            ->whereRaw('ST_Y(location) = ?', $row['longitude'])->doesntExist() : true;
            if ($this->companyId && !empty($row['location_name']) && $check) {
                Location::withoutGlobalScope('lat_lng')->create([
                    'company_id' => $this->companyId,
                    'name' => $row['location_name'] ?? '',
                    'location' => $setLocation,
                    'is_crud' => 1,
                ]);
            }
            $location = Location::withoutGlobalScope('lat_lng')->create([
                'company_id' => $this->companyId,
                'name' => $row['location_name'] ?? '',
                'location' => $setLocation,
            ]);
        }

        return $location;
    }

    public function prepareLogics(mixed $row): mixed
    {
        $total_useful_life_arr = [];
        $total_useful_life = explode('-', $row['total_useful_life'] ?? '');

        $row['asset_installation_date'] = isset($row['asset_installation_date']) && $row['asset_installation_date'] ?
         /** @phpstan-ignore-next-line */
        Carbon::createFromFormat('m-d-Y', $row['asset_installation_date'])->format('Y-m-d') : null;

        $row['purchase_date'] = isset($row['purchase_date']) && $row['purchase_date'] ?
         /** @phpstan-ignore-next-line */
        Carbon::createFromFormat('m-d-Y', $row['purchase_date'])->format('Y-m-d') : null;

        $row['warranty_expiration'] = isset($row['warranty_expiration']) && $row['warranty_expiration'] ?
         /** @phpstan-ignore-next-line */
        Carbon::createFromFormat('m-d-Y', $row['warranty_expiration'])->format('Y-m-d') : null;

        $total_useful_life_arr['year'] = isset($total_useful_life[0]) ? $total_useful_life[0] : null;
        $total_useful_life_arr['month'] = isset($total_useful_life[1]) ? $total_useful_life[1] : null;
        $total_useful_life_arr['day'] = isset($total_useful_life[2]) ? $total_useful_life[2] : null;
        $row['total_useful_life'] = $total_useful_life_arr;
        if ($row['asset_installation_date']) {
            $row['total_useful_life_date'] = calculateTotalUseFulLife(
                $row['asset_installation_date'],
                $row['total_useful_life']
            );
        }

        return $row;
    }

    public function getRows(): array
    {
        return $this->rows;
    }

    public function setCompany(int|null $companyId): void
    {
        $this->companyId = $companyId;
    }
}
