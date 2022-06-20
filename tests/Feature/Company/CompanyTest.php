<?php

namespace Tests\Feature\Company;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use App\Models\User;
use Tests\TestCase;
use App\Models\Admin\Asset\AssetType;
use App\Models\Admin\WorkOrder\WorkOrder;
use App\Models\Admin\Asset\Asset;
use App\Models\Expense;

class CompanyTest extends TestCase
{
    protected const COMPANY_ROUTE = 'admin.companies';
    protected const EMPLOYEE_ROUTE = 'admin.companies.';
    /**
     * @return void
     */
    public function test_manage_company()
    {
        Company::factory()->create();
        $this->actingAs($this->user)->get(route(self::COMPANY_ROUTE . '.index'))->assertOk();
        $data = [
            'manager_first_name' =>'abc',
            'manager_last_name' => 'abc',
            'name' => 'xyz',
            "profile_media_id" => null,
            'designation' => 'manager',
            'manager_email' => 'test12@gmail.com',
            'manager_phone' => "03131149754",
        ];
        $this->actingAs($this->user)->post(route(self::COMPANY_ROUTE . '.store'), $data)->assertStatus(STATUS_CODE_CREATE);
        $companyData = Company::orderBy('id', 'desc')->first();
        $this->actingAs($this->user)->put(route(self::COMPANY_ROUTE . '.update', $companyData->id), $data)->assertStatus(STATUS_CODE_UPDATE);
        $this->actingAs($this->user)->get(route(self::COMPANY_ROUTE . '.show', $companyData->id), $data)->assertStatus(STATUS_CODE_UPDATE);
    }

    public function test_manage_employee()
    {
        $company = Company::factory()->create();
        $user = User::factory()->create();
        $this->actingAs($this->user)->get(route('admin.companies.users.index', $company->id))->assertOk();
        $data = [
            'first_name' =>'abc',
            'last_name' => 'abc',
            'name' => 'xyz',
            "profile_media_id" => null,
            'designation' => 'employee',
            'email' => 'test20@gmail.com',
            'phone' => "03131149754",
            'per_hour_rate' => "120"
        ];
        $this->actingAs($this->user)->post(route('admin.companies.users.store', $company->id), $data)->assertStatus(STATUS_CODE_CREATE);
        $userData = User::orderBy('id', 'desc')->first();
        $userData->update(['email' => 'test123@gmail.com']);
        $this->actingAs($this->user)->put(route('admin.companies.users.update', [$company->id , $userData->id]), $data)->assertStatus(STATUS_CODE_UPDATE);

        Livewire::actingAs($this->user)->test('company.employee-table', [
            'model' => User::class,
            'viewFile' => 'admin.company.employee.table',
            'companyId' => $company->id,
            'filter'   => [
                'global_search' => $this->user->first_name,
                'role'             =>  $this->user->role,
                'range_created_at' => now()->format('m-d-Y'),
            ]
        ])->set('filter', [
            'payrate' => [
                'min' => 1,
                'max' => 1,
            ],
            'global_search' => 'this is test',
        ])->call('filter')
        ->call('clear')
        ->call('edit', $data)
        ->Call('delete', $this->user->id)
        ->Call('delete', $user->id)
        ->Call('csvExport', config('apg.export_format.csv'))
        ->call('sortBy')
        ->assertOk();

        Livewire::actingAs($this->user)->test('sweet-alert')->call('alert')->assertOk();

    }

    public function test_manage_company_asset_types()
    {
        $company = Company::factory()->create();
        User::factory()->create();
        $this->actingAs($this->user)->get(route('admin.companies.asset-types.index', $company->id))->assertOk();
        $data = [
            'name' => 'test',
            'work_order_titles' =>[['title' => 'oil change']]
        ];

        $this->actingAs($this->user)->post(route('admin.companies.asset-types.store', $company->id), $data)->assertStatus(STATUS_CODE_CREATE);
        $asset_type = AssetType::orderBy('id', 'desc')->first();
        $this->actingAs($this->user)->put(route('admin.companies.asset-types.update', [$company->id , $asset_type->id]), $data)->assertStatus(STATUS_CODE_UPDATE);
        Livewire::actingAs($this->user)->test('table', [
            'model' => AssetType::class,
            'viewFile' => 'admin.company.asset-type.table',
            'companyId' => $company->id,
            'filter'   => [
                'id_and_name' => $this->user->full_name,
                'range_created_at' => now()->format('m-d-Y'),
            ]
        ])->call('filter')
        ->call('clear')
        ->call('edit', $this->user)
        ->Call('delete', $this->user->id)
        ->Call('delete', 0)
        ->call('sortBy')
        ->assertOk();
    }

    public function test_manage_company_expense()
    {
        $company = Company::factory()->create();
        $workOrder = WorkOrder::factory()->create();
        $employee = User::factory([
            'user_status' => config('apg.user_status.employee')
        ])->create();
        $this->actingAs($this->user)->get(route('admin.companies.expenses.index', $company->id))->assertOk();
        $data = [
            'expense_date' => '	04-06-2022',
            'type'         => 'employee-payment',
            'description'  => 'abcd',
            'amount'       => '212',
            'work_order_id'=> $workOrder->number,
            'asset_id'     => $workOrder->asset_id,
            'location'     => $workOrder->asset?->location?->name,
        ];
        $this->actingAs($this->user)->post(route('admin.companies.expenses.store', $company->id), $data)->assertStatus(STATUS_CODE_CREATE);
        $this->actingAs($this->user)->post(route('admin.master.expenses.store', $company->id), $data)->assertStatus(STATUS_CODE_CREATE);
        $this->actingAs($employee)->post(route('employee.expenses.store', $company->id), $data)->assertStatus(STATUS_CODE_CREATE);
        $workOrder = WorkOrder::orderBy('id', 'desc')->first();
        $this->actingAs($this->user)->put(route('admin.companies.expenses.update', [$company->id , $workOrder->id]), $data)->assertStatus(STATUS_CODE_UPDATE);
        Livewire::actingAs($this->user)->test('expense-table', [
            'model' => Expense::class,
            'viewFile' => 'admin.company.expense.table',
            'filter'   => [
                'id' => $this->user->id,
                'work_order_id' => $this->user->work_order_id,
                'type' => $this->user->type,
                'description' => $this->user->description,
                'amount' =>  [
                    'min' =>  $this->user->amount,
                    'max' =>  $this->user->amount
                ],
                'range_created_at' => now()->format('m-d-Y'),
                'asset_id'  => $workOrder->asset?->number,
            ]
        ])->call('filter')
        ->set('filter', [
            'amount' => '1',
            'global_search' => 'this is test',
            'location'     => 'uk',
            'assigned'    =>  'user test',
        ])
        ->call('clear')
        ->call('manualFilter', 'expense', 1)
        ->call('pdfExport', config('apg.export_format.pdf'))
        ->call('csvExport', config('apg.export_format.csv'), config('apg.type.company'))
        ->call('edit', $this->user)
        ->Call('delete', $this->user->id)
        ->Call('delete', 0)
        ->call('sortBy')
        ->assertOk();
    }

    public function test_manage_company_dashboard()
    {
        $company = Company::factory()->create();
        User::factory()->create();
        $this->actingAs($this->user)->get(route('admin.companies.show', $company->id))->assertOk();
        Livewire::actingAs($this->user)->test('asset-table', [
            'viewFile' => 'admin.company.dashboard.table',
            'filter'   => [
                'range_created_at' => now()->format('m-d-Y'),
                'asset_type_id'  =>  $this->user->asset_type_id,
                'location_id'   =>    $this->user->location_id,
            ]
        ])->call('filter')
        ->call('clear')
        ->call('sortBy')
        ->assertOk();
    }

    public function test_delete_company()
    {
        $company = Company::factory()->create();
        $this->actingAs($this->user)->get(route('admin.companies.show', $company->id))->assertOk();
        Livewire::actingAs($this->user)->test('table', [
            'model' => Company::class,
            'viewFile' => 'admin.company.table'
        ])->call('delete', $company->id)
        ->assertOk();
    }
}
