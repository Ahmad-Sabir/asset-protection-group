<?php

namespace Tests\Feature\Asset;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Company;
use Illuminate\Support\Str;
use App\Models\Admin\Asset\Asset;
use Illuminate\Http\UploadedFile;
use App\Models\Admin\Asset\Location;
use App\Models\Admin\Asset\AssetType;
use App\Models\Admin\WorkOrder\WorkOrder;
use App\Models\Admin\WorkOrder\AdditionalTask;

class AssetTest extends TestCase
{
    protected const ASSET_ROUTE = 'admin.assets';
    protected const COMPANY_ASSET_ROUTE = 'admin.companies.assets';
    protected const TYPE_MASTER = 'apg.type.master';
    protected const ASSET_TABLE_VIEW = 'admin.asset.table';

    public function test_manage_admin_assets()
    {
        $update = '.update';
        $user = User::factory()->create();
        $assetType = AssetType::factory()->create();
        $assetType2 = AssetType::factory()->create();
        $asset = Asset::factory()->create();
        $company = Company::factory()->create();
        $workOrder = WorkOrder::factory([
            'due_date' => now()->addDays(4),
            'asset_id' => $asset->id,
            'asset_type_id' => $assetType->id,
        ])->create();
        AdditionalTask::factory([
            'work_order_id' =>  $workOrder->id
        ])->create();
        $this->actingAs($user)->get(route(self::ASSET_ROUTE . '.index'))->assertOk();
        $this->actingAs($user)->get(route('admin.company-assets'))->assertOk();
        $this->actingAs($user)->get(route(self::ASSET_ROUTE . '.create'))->assertOk();
        $data = [
            'company_number'        => '2',
            'name'                  => 'test name',
            'model'                 => 'test model',
            'asset_type_id'         => $assetType->id,
            'purchase_date'         => customDateFormat(now()),
            'installation_date'     => customDateFormat(now()),
            'warranty_expiry_date'  => customDateFormat(now()),
            'total_useful_life'     => [
                'year' => 1,
                'month' => 2,
                'day' => 10,
            ],
            'location' => [
                'latitude' => -36.8582564456761,
                'longitude' => 174.854498997714,
                'name' => "new zealand",
            ]
        ];
        $this->actingAs($user)->post(route(self::ASSET_ROUTE . '.store'), $data)->assertStatus(STATUS_CODE_CREATE);
        $assetData = Asset::orderBy('id', 'desc')->first();
        Livewire::actingAs($user)->test('asset-table', [
            'viewFile' => self::ASSET_TABLE_VIEW,
            'filter'   => [
                'global_search' => $assetData->name,
                'location' => 'uk',
                'range_created_at' => now()->subDays(30)->format('m-d-Y') . 'to' . now()->addDays(30)->format('m-d-Y')
            ]
        ])->set('filter', [
            'global_search' => 'this is test',
        ])->call('filter')
        ->call('clear')
        ->call('sortBy')
        ->call('manualFilter', 'asset_type', 1)
        ->call('export', config('apg.export_format.pdf'))
        ->call('csvExport', config('apg.export_format.csv'), config(self::TYPE_MASTER))
        ->assertOk();
        Livewire::actingAs($user)->test('asset-table', [
            'viewFile' => self::ASSET_TABLE_VIEW
        ])->call('csvExport', config('apg.export_format.csv'), config(self::TYPE_MASTER))
        ->assertOk();

        $this->actingAs($user)->get(route(self::ASSET_ROUTE . '.show', $assetData->id))->assertOk();
        $this->actingAs($user)->get(route(self::ASSET_ROUTE . '.edit', $assetData->id))->assertOk();
        unset($data['location']);
        $this->actingAs($user)->put(route(self::ASSET_ROUTE . $update, $assetData->id), $data)->assertStatus(STATUS_CODE_UPDATE);
        $data['name'] = $asset->name;
        $data['asset_type_id'] = $assetType2->id;
        $this->actingAs($user)->put(route(self::ASSET_ROUTE . $update, $assetData->id), $data)->assertRedirect();
        $media = UploadedFile::fake()->image('slide_image.jpg');
        $this->actingAs($user)->post(route(self::ASSET_ROUTE . '.upload.media', $assetData->id), [
            'file' => [$media]
        ])->assertRedirect();

        // company assets
        $this->actingAs($user)->get(route(self::COMPANY_ASSET_ROUTE . '.index', $company->id))->assertOk();
        $this->actingAs($user)->get(route(self::COMPANY_ASSET_ROUTE . '.create', [
            'company' => $company->id,
            'master_asset_id' => $assetData->id
        ]))->assertOk();
        $data['master_asset_id'] = $asset->id;
        $data['company_number'] = 'test';
        $this->actingAs($user)->post(route(self::COMPANY_ASSET_ROUTE . '.store', $company->id), $data)
        ->assertStatus(STATUS_CODE_CREATE);
        $this->actingAs($user)->get(route(self::COMPANY_ASSET_ROUTE . '.show', [
            $company->id,
            $assetData->id
        ]))->assertOk();
        $this->actingAs($user)->get(route(self::COMPANY_ASSET_ROUTE . '.edit', [
            $company->id,
            $assetData->id
        ]))->assertOk();
        $this->actingAs($this->user)->get(route('admin.companies.asset.work_order.create', [
            $company->id,
            $assetData->id
        ]))->assertOk();
        $data['name'] = "laptop";
        $data['company_number'] = 'testing';
        $this->actingAs($user)->put(route(self::COMPANY_ASSET_ROUTE . $update, [
            $company->id,
            $assetData->id
        ]), $data)->assertStatus(STATUS_CODE_UPDATE);

        Livewire::actingAs($user)->test('asset-table', ['viewFile' => self::ASSET_TABLE_VIEW])->call('delete', $assetData->id);
    }

    /**
     * @return void
     */
    public function test_import_assets()
    {
        $csv = '.import.csv';
        $company = Company::factory()->create();
        $assetType = AssetType::factory()->create();
        $companyAssetType = AssetType::factory([
            'company_id' => $company->id
        ])->create();
        $header = (string) Str::of("Name,Asset Type,Asset Model Name,Asset Manufacturer,Asset Installation Date,")
            ->append("Asset Replacement Cost,Location Name,Latitude,Longitude,")
            ->append("Purchase Date,Purchase Price,Warranty Expiration,Total Useful Life");
        $row1 = (string) Str::of("mobile,{$assetType->name},Model 4D400,Force Flow,03-18-2022,100,Facility A,1.033456666,1.033456666,")
            ->append("03-20-2022,100,03-30-2022,1-1-1");
        $content = implode("\n", [$header, $row1]);
        $file = UploadedFile::fake()
        ->createWithContent(
            'test.csv',
            $content
        );
        $this->actingAs($this->user)->post(route(self::ASSET_ROUTE . $csv), ['file' => $file])->assertRedirect();
        $this->actingAs($this->user)->get(route(self::ASSET_ROUTE . '.export.template'))->assertDownload();

        $row2 = (string) Str::of("mobile,,Model 4D400,Force Flow,03-18-2022,100,Facility A,1.033456666,1.033456666,")
        ->append("03-20-2022,100,03-30-2022,1-1-1");
        $content = implode("\n", [$header, $row2]);
        $file = UploadedFile::fake()
        ->createWithContent(
            'test.csv',
            $content
        );
        $this->actingAs($this->user)->post(route(self::ASSET_ROUTE . $csv), ['file' => $file])->assertRedirect();

        $row3 = (string) Str::of("mobile,{$companyAssetType->name},Model4D400,Force Flow,03-18-2022,100,Facility A,1.033456666,1.033456666,")
        ->append("03-23-2022,100,03-12-2021,2-2-2");
        $content = implode("\n", [$header, $row3]);
        $file = UploadedFile::fake()
        ->createWithContent(
            'company.csv',
            $content
        );

        $this->actingAs($this->user)->post(route(self::COMPANY_ASSET_ROUTE . $csv, $company->id), [
            'file' => $file
        ])->assertRedirect();
    }

    /**
     * @return void
     */
    public function test_dynamic_dropdown()
    {
        Livewire::actingAs($this->user)->test('dynamic-dropdown', [
            'entity' => User::class,
            'whereHas' => 'profile',
            'whereNull' => 'deactivate_at',
            'entitySearchFields' => ['id'],
            'searchQuery' => '1',
            'name' => 'asset_name',
            'parentModel' => 'asset_name',
        ])->call('reactOnSearch', 'test')
        ->call('childModelUpdate', 'parentModel', 'test');
    }

    /**
     * @return void
     */
    public function test_asset_export_pdf()
    {
        $assetType = AssetType::factory()->create();
        $location = Location::factory()->create();
        $asset = Asset::create([
            "company_id" => null,
            "location_id" => $location->id,
            "asset_type_id" => $assetType->id,
            "name" => "Fletcher Krajcik Jr.",
            "model" => null,
            "manufacturer" => null,
            "description" => null,
            "type" => "master",
            "purchase_price" => null,
            "replacement_cost" => null,
            "custom_values" => null,
            "total_useful_life" => ["month" => 5, "year" => 2020],
            "status" => "0",
            "deleted_at" => null,
            "created_at" => now(),
            "updated_at" => now(),
        ]);
        $this->actingAs($this->user)
            ->get(route('admin.master-asset.export.pdf', $asset->id))
            ->assertRedirect();
    }

    /**
     * @return void
     */
    public function test_asset_compliance_export_pdf()
    {
        $assetType = AssetType::factory()->create();
        $location = Location::factory()->create();
        $asset = Asset::factory([
            "company_id" => null,
            "location_id" => $location->id,
            "asset_type_id" => $assetType->id,
            "name" => "Fletcher Krajcik Jr.",
            "model" => null,
            "manufacturer" => null,
            "description" => null,
            "purchase_price" => null,
            "replacement_cost" => null,
            "custom_values" => null,
            "total_useful_life" => ["month" => 5, "year" => 2020],
            "status" => "0",
            "deleted_at" => null,
            "created_at" => now(),
            "updated_at" => now(),
        ])->create();
        $workOrder_frequency =
        [
            'Daily',
            'Weekly',
            'Bi-weekly',
            'Monthly',
            'Bi-Monthly',
            'Quarterly',
            'Semi-Annually',
            'Annually'
        ];
        foreach ($workOrder_frequency as $frequency) {
            WorkOrder::factory([
                'asset_id' => $asset->id,
                'asset_type_id' => $asset->asset_type_id,
                'title' => 'work order daily test',
                'work_order_type' => 'Recurring',
                'work_order_frequency' => $frequency,
                'type' => config(self::TYPE_MASTER)
            ])->create();
        }
        $this->actingAs($this->user)
            ->get(route('admin.asset.compliance.pdf', [$asset->id, $assetType->id]))
            ->assertRedirect();
    }

    /**
     * @return void
     */
    public function test_asset_grid_compliance_export_pdf()
    {
        $asset = Asset::factory()->create();
        $this->actingAs($this->user)
            ->get(route('admin.asset.grid.compliance.pdf', [$asset->id, $asset->asset_type_id]))
            ->assertRedirect();

    }

    /**
     * @return void
     */
    public function test_asset_detail_compliance_export_pdf()
    {
        $asset = Asset::factory()->create();
        $this->actingAs($this->user)
            ->get(route('admin.asset.detail.compliance.pdf', [$asset->id, $asset->asset_type_id]))
            ->assertRedirect();
    }

    /**
     * @return void
     */
    public function test_company_asset_export_pdf()
    {
        $asset = Asset::factory()->create();
        $company = Company::factory()->create();
        $this->actingAs($this->user)
            ->get(route('admin.companies.company-asset.export.pdf', [$company->id, $asset->id]))
            ->assertRedirect();
    }

    /**
     * @return void
     */
    public function test_company_asset_compliance_export_pdf()
    {
        $asset = Asset::factory()->create();
        $company = Company::factory()->create();
        $this->actingAs($this->user)
            ->get(route('admin.companies.company-compliance.asset.pdf', [$company->id, $asset->id]))
            ->assertRedirect();

        $this->actingAs($this->user)
            ->get(route('admin.companies.grid.compliance.pdf', [$company->id, $asset->id]))
            ->assertRedirect();

        $this->actingAs($this->user)
            ->get(route('admin.companies.detail.compliance.pdf', [$company->id, $asset->id]))
            ->assertRedirect();
    }
}
