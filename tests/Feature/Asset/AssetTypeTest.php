<?php

namespace Tests\Feature\Asset;

use App\Models\User;
use App\Models\Admin\Asset\AssetType;
use App\Models\Company;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Tests\TestCase;

class AssetTypeTest extends TestCase
{
    protected const ASSETTYPE_ROUTE = 'admin.asset-types';

    public function test_manage_asset_types()
    {
        $this->actingAs($this->user)->get(route(self::ASSETTYPE_ROUTE . '.index'))->assertOk();

        $data = [
            'name' => 'test',
            'work_order_titles' =>[['title' => 'oil change']]
        ];
        Company::factory()->create();
        $this->actingAs($this->user)->post(route(self::ASSETTYPE_ROUTE . '.store'), $data)->assertStatus(STATUS_CODE_CREATE);
        $this->actingAs($this->user)->post(route(self::ASSETTYPE_ROUTE . '.store'), $data)->assertStatus(STATUS_CODE_REDIRECTED);
        $assettypeData = AssetType::orderBy('id', 'desc')->first();
        $data['name'] = 'update type';
        $this->actingAs($this->user)->put(route(self::ASSETTYPE_ROUTE . '.update', $assettypeData->id), $data)->assertStatus(STATUS_CODE_UPDATE);
        $assettypeData = $assettypeData->toArray();
        $assettypeData['view_file'] = 'admin.assettype.edit';
        Livewire::actingAs($this->user)->test('table', [
            'model' => AssetType::class,
            'viewFile' => 'admin.assettype.table',
        ])->call('edit', $assettypeData)
        ->assertOk();
    }
}
