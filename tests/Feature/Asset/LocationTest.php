<?php

namespace Tests\Feature\Asset;

use Tests\TestCase;
use Livewire\Livewire;
use App\Models\Admin\Asset\Location;
use App\Models\Company;
use Illuminate\Support\Facades\Route;

class LocationTest extends TestCase
{
    protected const COMPANY_LOCATION_ROUTE = 'admin.companies.locations';

    public function test_manage_company_locations()
    {
        $company = Company::factory()->create();
        $this->actingAs($this->user)->get(route(self::COMPANY_LOCATION_ROUTE . '.index', $company->id))->assertOk();
        $data = [
            'latitude' => -36.8582564456761,
            'longitude' => 174.854498997714,
            'name' => "new zealand",
        ];
        $this->actingAs($this->user)->post(route(self::COMPANY_LOCATION_ROUTE . '.store', $company->id), $data)
        ->assertStatus(STATUS_CODE_CREATE);
        $location = Location::select('id')->orderBy('id', 'desc')->first();

        $this->actingAs($this->user)->put(route(self::COMPANY_LOCATION_ROUTE . '.update', [
            $company->id,
            $location->id
        ]), $data)
        ->assertStatus(STATUS_CODE_UPDATE);
    }
}
