<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use App\Models\Company;
use App\Models\Admin\Asset\Asset;
use App\Models\Admin\Asset\AssetType;
use App\Models\Admin\Asset\Location;
use App\Models\Admin\WorkOrder\WorkOrder;
use App\Models\User;

class ReportTest extends TestCase
{
    public function test_asset_report()
    {
        $filter = [
            'id' => true,
            'company_id' => true,
            'installation_date' => true,
            'name' => true,
            'asset_type' => true,
            'status' => true,
            'location_id' => true,
            'created_at' => true,
            'manufacturer' => true,
            'model' => true,
            'replacement_cost' => true,
            'purchase_price' => true,
            'remaining_useful_life' => true,
            'total_useful_life' => true,
            'warranty_expiry_date' => true,
        ];
        $assetType = AssetType::factory()->create();
        $company = Company::factory()->create();
        Asset::factory([
            'name' => 'test',
            'asset_type_id' => $assetType->id,
            'company_id' => $company->id,
            'purchase_price' => 1500,
            'replacement_cost' => 1600,
            'type' => config('apg.type.company'),
            'manufacturer' => 'Hp',
            'model' => 'ES123',
            'total_useful_life_date' => now(),
            'total_useful_life' => now(),
            'warranty_expiry_date' => now(),
        ])->create();
        $this->actingAs($this->user)->get(route('admin.reports.assets'))->assertOk();
        Livewire::actingAs($this->user)
        ->test('reports.assets', [
            'filterName' => 'test',
            'filter' => [
                'global_search' => 'test asset',
                'status' => 1,
                'asset_type' => 'oil change',
                'location'   => 'uk',
                'range_created_at' => customdateFormat(now()) . 'to' . customdateFormat(now()),
                'range_installation_date' => customdateFormat(now()) . 'to' . customdateFormat(now()),
            ]
        ])
        ->call('filter')
        ->call('customizeFilter', [
            'filter' => json_encode([
                'global_search' => 'test',
                'purchase_price' => [
                    'min' => 500,
                    'max' => 2500
                ],
                'replacement_cost' => [
                    'min' => 500,
                    'max' => 2500
                ],
            ])
        ])->call('saveFilter')
        ->call('exportPdfReportAsset', $filter, config('apg.export_format.pdf'))
        ->call('exportCsvReportAsset', $filter, config('apg.export_format.csv'))
        ->call('sortBy')
        ->call('clear')
        ->assertOk();
    }

    public function test_workorder_report()
    {
        $filter = [
            'id' => true,
            'title' => true,
            'asset_id' => true,
            'asset_type_id' => true,
            'assignee_user_id' => true,
            'work_order_status' => true,
            'created_at' => true,
            'due_date' => true,
            'work_order_type' => true,
        ];
        $this->actingAs($this->user)->get(route('admin.reports.work-orders'))->assertOk();
        $assetType = AssetType::factory()->create();
        $user = User::factory()->create();
        $location = Location::factory()->create();
        $company = Company::factory()->create();
        $asset = Asset::factory()->create();
        WorkOrder::factory([
            'company_id' => $company->id,
            'assignee_user_id' => $user->id,
            'location_id' => $location->id,
            'asset_id' => $asset->id,
            'asset_type_id' => $assetType->id,
            'title' => 'work order test',
            'type' => 'company',
        ])->create();
        Livewire::actingAs($this->user)
        ->test('reports.work-orders', [
            'filterName' => 'save filter'
        ])->set('filter', [
            'global_search' => 'test',
            'assigned' => $user->id,
            'current_month' => true,
            'current_year' => true,
            'work_order_status' => 'open',
            'asset_type' => 'computer',
            'work_order_type' => config('apg.work_order_type_check.recurring'),
            'location' => 'USA',
            'due_date' => customdateFormat(now()) . 'to' . customdateFormat(now()),
            'updated_at' => customdateFormat(now()) . 'to' . customdateFormat(now()),
        ])->call('filter')
        ->call('manualFilter', 'asset_type', 'laptop')
        ->call('customizeFilter', [
            'filter' => json_encode([
                'global_search' => 'test work order',
            ])
        ])->call('saveFilter')
        ->call('clear')
        ->call('exportPdfReportWorkOrder', $filter, config('apg.export_format.pdf'))
        ->call('exportCsvReportWorkOrder', $filter, config('apg.export_format.csv'))
        ->call('sortBy')
        ->assertOk();
        Livewire::actingAs($this->user)
        ->test('reports.work-orders')->assertOk();
    }

    public function test_company_report()
    {
        Livewire::actingAs($this->user)
        ->test('table', [
            'model' => \App\Models\Company::class,
            'viewFile' => 'livewire.reports.company',
            'autoSaveFilter' => true
        ])->set('filter', [
            'id_and_name' => 'test work order'
        ])
        ->call('filter', config('apg.company_report_fields'))
        ->call('clear')
        ->assertOk();
        $this->actingAs($this->user)->get(route('admin.reports.comapnies'))->assertOk();
    }
}
