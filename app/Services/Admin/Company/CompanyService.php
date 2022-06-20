<?php

namespace App\Services\Admin\Company;

use App\Http\Requests\Company\CompanyRequest;
use App\Models\Company;
use App\Models\Admin\Asset\AssetType;
use App\Events\CompanyCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CompanyService
{
    public function __construct(
        protected Company $company,
        protected User $user
    ) {
    }

    /**
     * store user
     *
     * @param CompanyRequest $request
     * @return mixed
     */
    public function store(CompanyRequest $request)
    {
        $storeCompany = $this->company->create($request->validated());
        app(\App\Services\Admin\User\UserService::class)->storeUserEmployee($storeCompany);
        AssetType::where('type', config('apg.type.master'))
        ->whereNull('company_id')->get()->each(function ($assetType) use ($storeCompany) {
            $newType = $assetType->replicate()->fill([
                'company_id' => $storeCompany->id,
                'type' => config('apg.type.company'),
            ]);
            $newType->save();
        });
        event(new CompanyCreated($storeCompany));

        return $storeCompany;
    }

    /**
     * update user
     *
     * @param CompanyRequest $request
     * @param int $id
     * @return mixed
     */
    public function update(CompanyRequest $request, $id)
    {
        /** @var \App\Models\Company $updateCompany */
        $updateCompany = $this->company->find($id);

        return $updateCompany->update($request->validated());
    }

     /**
     * get single records
     *
     * @param int $id
     * @return mixed
     */
    public function find($id)
    {
         /** @phpstan-ignore-next-line */
        return $this->company->with(['profile'])->findOrFail($id);
    }
}
