<?php

namespace App\Services\Admin\Asset;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Admin\Asset\Asset;
use Illuminate\Support\Facades\DB;
use App\Services\Admin\MediaService;
use App\Models\Admin\Asset\AssetType;
use App\Models\Admin\Asset\AssetMedia;
use App\Models\Admin\WorkOrder\WorkOrder;
use App\Http\Requests\Admin\Asset\AssetRequest;
use App\Services\Admin\WorkOrder\WorkOrderService;

class AssetService
{
    public function __construct(
        protected Asset $asset,
        protected LocationService $locationService,
        protected AssetType $assetType
    ) {
    }

    /**
     * get single records
     *
     * @param int $id
     * @param bool $onlyWebp
     * @return mixed
     */
    public function find($id, $onlyWebp = false)
    {
         /** @phpstan-ignore-next-line */
        return $this->asset->with([
        'medias' => function ($query) use ($onlyWebp) {
            $query->when($onlyWebp)->where('ext', 'webp')->limit(10);
        },
        'location' => function ($query) {
            $query->select('*');
        },
        'assetType:id,name'
        ])->findOrFail($id);
    }

    /**
     * store asset.
     *
     * @param AssetRequest $request
     * @param bool $isCompany
     * @return mixed
     */
    public function store(AssetRequest $request, $isCompany = false)
    {
        $location = $this->locationService->create($request);
        $data = $this->prepareData($request);
        if (!empty($location)) {
            $data['location_id'] = $location->id;
        }
        $assetStore = $this->asset->create($data);
        $mediaIds = $request->media_ids ?? [];
        if ($isCompany) {
            $oldMediaIds = AssetMedia::whereIn('media_id', $request->media_ids ?? [])->pluck('media_id')->toArray();
            $cloneMediaIds = app(MediaService::class)->clone($oldMediaIds);
            $mediaIds = array_merge(array_diff($mediaIds, $oldMediaIds), $cloneMediaIds);
            app(WorkOrderService::class)->clone($assetStore, $request->master_asset_id);
        }
        app(WorkOrderService::class)->storeAssetTypeWorkOrders($assetStore);
        $assetStore->medias()->attach($mediaIds ?? []);

        return $assetStore;
    }

    /**
     * update asset
     *
     * @param AssetRequest $request
     * @param int $id
     * @return mixed
     */
    public function update(AssetRequest $request, $id)
    {
        /** @var \App\Models\Admin\Asset\Asset $updateAsset */
        $updateAsset = $this->asset->find($id);
        $updateAsset->medias()->sync($request->media_ids ?? []);
        $data = $this->prepareData($request);
        $location = $this->locationService->create($request, $updateAsset->location_id);
        $data['location_id'] = $location->id ?? null;
        $oldAsset = $updateAsset->only('id', 'asset_type_id');
        $updateAsset->update($data);
        if ($oldAsset['asset_type_id'] != $data['asset_type_id']) {
            app(WorkOrderService::class)->storeAssetTypeWorkOrders($updateAsset, $oldAsset, true);
        }

        return $updateAsset;
    }

    /**
     * prepare data
     *
     * @param AssetRequest $request
     * @return array
     */
    public function prepareData(AssetRequest $request)
    {
        $data = $request->validated();
        $data['purchase_date'] = $data['purchase_date']
         /** @phpstan-ignore-next-line */
        ? Carbon::createFromFormat('m-d-Y', $data['purchase_date'])->format('Y-m-d') : null;
        $data['installation_date'] = $data['installation_date']
         /** @phpstan-ignore-next-line */
        ? Carbon::createFromFormat('m-d-Y', $data['installation_date'])->format('Y-m-d') : null;
        $data['warranty_expiry_date'] = $data['warranty_expiry_date']
         /** @phpstan-ignore-next-line */
        ? Carbon::createFromFormat('m-d-Y', $data['warranty_expiry_date'])->format('Y-m-d') : null;
        $data['total_useful_life_date'] = $request->input('total_useful_life_date');

        return $data;
    }

    /**
     * upload media
     *
     * @param Request $request
     * @param int $assetId
     * @return array
     */
    public function uploadMedia($request, $assetId)
    {
        $media = app(MediaService::class)->store($request);
        /** @phpstan-ignore-next-line */
        $mediaIds = $media ? collect($media)->pluck('id')->toArray() : [];
         /** @var \App\Models\Admin\Asset\Asset $assetDetail */
        $assetDetail = $this->asset->find($assetId);
        $assetDetail->medias()->attach($mediaIds);

        return $media;
    }

    /**
     * Send attachments via email.
     *
     * @param string $id
     * @return mixed
     */
    public function exportAssetPdf($id = '')
    {
        /** @phpstan-ignore-next-line */
        return Asset::with(['location' => function ($query) {
            $query->select('*');
        }, 'assetType'])
         ->when($id, fn($query) => $query->where('id', $id))
         ->get();
    }

    /**
     * Send attachments via email.
     *
     * @param string $id
     * @param string $companyId
     * @return mixed
     */
    public function exportCompanyAssetPdf($companyId, $id = '')
    {
        /** @phpstan-ignore-next-line */
        return Asset::with(['location' => function ($query) {
                $query->select('*');
        }, 'assetType', 'company'])
            ->when($id, fn($query) => $query->where(['id' => $id, 'company_id' => $companyId]))
            ->where('company_id', $companyId)
            ->get();
    }

     /**
     * get assets
     *
     * @return mixed
     */
    public function getAssets(array $filter)
    {
        $date = now()->format('Y-m-d');
        $useful_life_year = !app()->environment('testing') ? "timestampdiff(YEAR, '{$date}', total_useful_life_date)
        as useful_life_year" : 'total_useful_life_date as useful_life_year';

        $useful_life_month = !app()->environment('testing') ? "timestampdiff(MONTH, '{$date}', total_useful_life_date)
        as useful_life_month" : 'total_useful_life_date as useful_life_month';

        $useful_life_day = !app()->environment('testing') ? "timestampdiff(DAY, '{$date}', total_useful_life_date) - 1
        as useful_life_day" : 'total_useful_life_date as useful_life_day';

        $warranty_expiry_year = !app()->environment('testing') ?
        "timestampdiff(YEAR, installation_date, warranty_expiry_date)
        as warranty_expiry_year" : 'total_useful_life_date as warranty_expiry_year';

        $warranty_expiry_month = !app()->environment('testing') ?
        "timestampdiff(MONTH, installation_date, warranty_expiry_date)
        as warranty_expiry_month" : 'total_useful_life_date as warranty_expiry_month';

        $warranty_expiry_day = !app()->environment('testing') ?
        "timestampdiff(DAY, installation_date, warranty_expiry_date)
        as warranty_expiry_day" : 'total_useful_life_date as warranty_expiry_day';
        return Asset::select('*')
        ->selectRaw($useful_life_year)
        ->selectRaw($useful_life_month)
        ->selectRaw($useful_life_day)
        ->selectRaw($warranty_expiry_year)
        ->selectRaw($warranty_expiry_month)
        ->selectRaw($warranty_expiry_day)
        ->when(!empty($filter), function ($query) use ($filter) {
            foreach ($filter as $field => $value) {
                $value = !is_array($value) ? trim($value) : $value;
                $this->prepareFilter($query, $field, $value);
            }
        });
    }

    /** @phpstan-ignore-next-line */
    public function prepareFilter($query, $field, $value): void
    {
        $query->when($field == 'global_search', function ($query) use ($value) {
            $query->where(function ($query) use ($value) {
                $query->where('number', $value)
                ->orWhere('company_number', $value)
                ->orWhere('name', 'like', "%$value%")
                ->orWhere('manufacturer', 'like', "%$value%")
                ->orWhere('model', 'like', "%$value%");
            });
        })->when($field == 'status' && $value != '', fn ($query) => $query->whereStatus($value))
        ->when($field == 'company_id' && $value != '', fn ($query) => $query->whereCompanyId($value))
        ->when($field == 'asset_type', function ($query) use ($value) {
            $query->whereHas('assetType', function ($query) use ($value) {
                $query->Where('name', 'like', "%$value%");
            });
        })->when($field == 'location' && !empty($value), function ($query) use ($value) {
            $query->whereHas('location', function ($query) use ($value) {
                $query->where('name', 'like', "%$value%");
            });
        })->when($field == 'range_created_at', function ($query) use ($value) {
            $range = parseRangeDate($value);
            $query->whereBetween(DB::raw('DATE(created_at)'), [$range['start_date'], $range['end_date']]);
        })->when($field == 'range_installation_date', function ($query) use ($value) {
            $range = parseRangeDate($value);
            $query->whereBetween('installation_date', [$range['start_date'], $range['end_date']]);
        })->when($field == 'purchase_price', function ($query) use ($value) {
            $query->where(function ($query) use ($value) {
                $query->when(isset($value['min']), fn ($query) => $query->where('purchase_price', '>=', $value['min']));
                $query->when(isset($value['max']), fn ($query) => $query->where('purchase_price', '<=', $value['max']));
                $query->orWhereNull('purchase_price');
            });
        })->when($field == 'cost', function ($query) use ($value) {
            $query->where(function ($query) use ($value) {
                $query->when(isset($value['min']), fn ($query) =>
                $query->where('replacement_cost', '>=', $value['min']));
                $query->when(isset($value['max']), fn ($query) =>
                $query->where('replacement_cost', '<=', $value['max']));
                $query->orWhereNull('replacement_cost');
            });
        })->when($field == 'remaining_useful_life', function ($query) use ($value) {
            /** @phpstan-ignore-next-line */
            $useful = collect($value)->filter(fn ($item) => !empty($item))->count();
            $query->when($useful, function ($query) use ($value) {
                $query->having(function ($query) use ($value) {
                    $query->when(isset($value['year']) && !empty($value['year']), function ($query) use ($value) {
                        $query->orHaving("useful_life_year", $value['year']);
                    })->when(isset($value['month']) && !empty($value['month']), function ($query) use ($value) {
                        $query->orHaving("useful_life_month", $value['month']);
                    })->when(isset($value['day']) && !empty($value['day']), function ($query) use ($value) {
                        $query->orHaving("useful_life_day", $value['day']);
                    });
                });
            });
        })->when($field == 'warranty', function ($query) use ($value) {
            /** @phpstan-ignore-next-line */
            $warranty = collect($value)->filter(fn ($item) => !empty($item))->count();
            $query->when($warranty, function ($query) use ($value) {
                $query->having(function ($query) use ($value) {
                    $query->when(isset($value['year']) && !empty($value['year']), function ($query) use ($value) {
                        $query->orHaving("warranty_expiry_year", $value['year']);
                    })->when(isset($value['month']) && !empty($value['month']), function ($query) use ($value) {
                        $query->orHaving("warranty_expiry_month", $value['month']);
                    })->when(isset($value['day']) && !empty($value['day']), function ($query) use ($value) {
                        $query->orHaving("warranty_expiry_day", $value['day']);
                    });
                });
            });
        })->when($field == 'total_useful_life', function ($query) use ($value) {
            $query->where(function ($query) use ($value) {
                $query->when(isset($value['year']) && !empty($value['year']), function ($query) use ($value) {
                    $query->orWhere("total_useful_life->year", $value['year']);
                })->when(isset($value['month']) && !empty($value['month']), function ($query) use ($value) {
                    $query->orWhere("total_useful_life->month", $value['month']);
                })->when(isset($value['day']) && !empty($value['day']), function ($query) use ($value) {
                    $query->orWhere("total_useful_life->day", $value['day']);
                });
            });
        });
    }
}
