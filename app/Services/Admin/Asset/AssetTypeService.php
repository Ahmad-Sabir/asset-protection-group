<?php

namespace App\Services\Admin\Asset;

use App\Models\Admin\Asset\AssetType;
use App\Http\Requests\Admin\Asset\AssetTypeRequest;
use App\Models\Admin\WorkOrder\WorkOrder;
use App\Models\Company;

class AssetTypeService
{
    public function __construct(
        protected AssetType $assetType,
        protected WorkOrder $workOrder
    ) {
    }

    /**
     * store assetType.
     *
     * @param AssetTypeRequest $request
     * @return mixed
     */
    public function store(AssetTypeRequest $request)
    {
        $storeAssetType = $this->assetType->create($request->validated());
        foreach ($request->work_order_titles as $value) {
            $storeAssetType->workOrderTitles()->create([
                'title' => $value['title']
            ]);
        }

        if ($storeAssetType->type == config('apg.type.master')) {
            Company::select('id')->get()->each(function ($company) use ($storeAssetType, $request) {
                $cloneAssetType = $storeAssetType->replicate()->fill([
                    'company_id' => $company->id,
                    'type' => config('apg.type.company'),
                ]);
                $cloneAssetType->save();
                foreach ($request->work_order_titles as $value) {
                    $cloneAssetType->workOrderTitles()->create([
                        'title' => $value['title']
                    ]);
                }
            });
        }

        return $storeAssetType;
    }

    /**
     * update assettype
     *
     * @param AssetTypeRequest $request
     * @param int $id
     * @return mixed
     */
    public function update(AssetTypeRequest $request, $id)
    {
        /** @var \App\Models\Admin\Asset\AssetType $updateAssetType */
        $updateAssetType = $this->assetType->find($id);
        $updateAssetType->update($request->validated());
        $updateAssetType->workOrderTitles()->delete();
        foreach ($request->work_order_titles as $value) {
            $updateAssetType->workOrderTitles()->create([
                'title' => $value['title']
            ]);
        }

        return $updateAssetType;
    }
}
