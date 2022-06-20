<?php

namespace Tests\Feature\WorkOrder;

use App\Models\User;
use App\Models\Admin\Asset\AssetType;
use App\Models\Admin\Asset\Asset;
use App\Models\Admin\WorkOrder\WorkOrder;
use App\Models\Admin\WorkOrder\AdditionalTask;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;
use App\Models\Company;
use App\Models\Notification;

class WorkOrderTest extends TestCase
{
    protected const WORKORDER_ROUTE = 'admin.work-orders';
    protected const EMPLOYEE_WORKORDER_ROUTE = 'employee.work-orders';
    protected const COMPANY_WORKORDER_ROUTE = 'admin.companies.work-orders';
    protected const WORKORDER_COMPLETED_STATUS = 'apg.work_order_status.completed';
    protected const FREQUENCY_STATUS = 'apg.frequency_status.semi-annually';
    protected const PENDING_TASK = 'apg.task_status.pending';
    protected const INDEX = '.index';
    protected const SHOW = '.show';
    protected const STORE = '.store';
    protected const EDIT = '.edit';
    protected const UPDATE = '.update';

    public function test_manage_work_orders()
    {
        $user = User::factory()->create();
        $assetType = AssetType::factory()->create();
        $asset = Asset::factory()->create();
        $company = Company::factory()->create();
        $this->actingAs($user)->get(route(self::WORKORDER_ROUTE . '.fetch.asset', $asset->id))->assertStatus(STATUS_CODE_CREATE);
        $this->actingAs($user)->get(route(self::WORKORDER_ROUTE . '.fetch.location', $asset->location_id))->assertStatus(STATUS_CODE_CREATE);
        $this->actingAs($this->user)->get(route(self::COMPANY_WORKORDER_ROUTE . self::INDEX, $company->id))->assertOk();
        $this->actingAs($this->user)->get(route(self::COMPANY_WORKORDER_ROUTE . '.create', $company->id))->assertOk();
        $this->actingAs($user)->get(route(self::WORKORDER_ROUTE . self::INDEX))->assertOk();
        $this->actingAs($user)->get(route(self::WORKORDER_ROUTE . '.create'))->assertOk();
        $this->actingAs($user)->get(route('admin.asset.work_order.create', $asset->id))->assertOk();
        $data = [
            'title'             => 'test',
            'description'       => 'description be here test',
            'priority'          => 'High',
            'asset_type_id'     => $assetType->id,
            'asset_id'          => $asset->id,
            'work_order_profile_id' => $this->media->id,
            'assignee_user_id'  => '1',
            'work_order_type'   => 'Recurring',
            'work_order_status'   => 'Open',
            'work_order_frequency' => config(self::FREQUENCY_STATUS),
            'task_data'            => [
                0 => [
                    "name"        => "Test task",
                    "task_detail" => "description",
                    "due_date"    => customDateFormat(now())
                  ]
            ],
            'due_date'          => customDateFormat(now()),
        ];
        $this->actingAs($user)->post(route(self::WORKORDER_ROUTE . self::STORE), $data)->assertStatus(STATUS_CODE_CREATE);
        $this->actingAs($user)->post(route(self::WORKORDER_ROUTE . self::STORE, ['is_compliance' => true]), $data)->assertStatus(STATUS_CODE_CREATE);
        $this->actingAs($this->user)->post(route(self::COMPANY_WORKORDER_ROUTE . self::STORE, $company->id), $data)->assertStatus(STATUS_CODE_CREATE);
        $this->actingAs($this->user)->post(route(self::COMPANY_WORKORDER_ROUTE . self::STORE, [
            $company->id,
            'is_compliance' => true
        ]), $data)->assertStatus(STATUS_CODE_CREATE);
        $asset->update(['warranty_expiry_date' => now()->addYear(1)]);
        $this->actingAs($user)->post(route(self::WORKORDER_ROUTE . self::STORE), $data)->assertStatus(STATUS_CODE_CREATE);
        $this->actingAs($this->user)->post(route(self::COMPANY_WORKORDER_ROUTE . self::STORE, $company->id), $data)->assertStatus(STATUS_CODE_CREATE);

        $workOrderData = WorkOrder::orderBy('id', 'desc')->first();
        $statusData['id'] = $workOrderData->id;
        $statusData['status'] = config('apg.work_order_status.on_hold');
        $statusData['reason'] = 'Reason';
        $statusData['priority'] = 'Low';
        $this->actingAs($user)->post(route(self::WORKORDER_ROUTE . '.update.bulkStatus'), $statusData)->assertStatus(STATUS_CODE_UPDATE);
        $statusData['status'] = config('apg.work_order_status.completed');
        $this->actingAs($user)->post(route(self::WORKORDER_ROUTE . '.update.bulkStatus'), $statusData)->assertStatus(STATUS_CODE_UPDATE);
        $logData = [];
        $logData['id'] = $workOrderData->id;
        $logData['log'] = '00:00:02';
        $logData = json_encode($logData, true);
        $this->actingAs($user)->patch('/admin/work-orders/update-log/' . $logData)->assertStatus(STATUS_CODE_UPDATE);
        $this->actingAs($user)->get(route(self::WORKORDER_ROUTE . self::SHOW, $workOrderData->id))->assertOk();
        $notification = Notification::create([
            'data' => [
                'message' => 'test',
                'workorder_id' => $workOrderData->id
            ],
            'user_id' => $this->user->id
        ]);
        $this->actingAs($user)->get(route(self::WORKORDER_ROUTE . self::SHOW, [$workOrderData->id, 'notification_id' => $notification->id]))->assertOk();
        $this->actingAs($user)->post(route(self::WORKORDER_ROUTE . '.clone', $workOrderData->id))->assertStatus(STATUS_CODE_CREATE);
        $this->actingAs($user)->post(route(self::COMPANY_WORKORDER_ROUTE . '.clone', [$company->id, $workOrderData->id]))->assertStatus(STATUS_CODE_CREATE);
        $this->actingAs($this->user)->get(route(self::COMPANY_WORKORDER_ROUTE . self::SHOW, [$company->id, $workOrderData->id]))->assertOk();
        $this->actingAs($user)->get(route(self::WORKORDER_ROUTE . self::EDIT, $workOrderData->id))->assertOk();
        $this->actingAs($this->user)->get(route(self::COMPANY_WORKORDER_ROUTE . self::EDIT, [$company->id, $workOrderData->id]))->assertOk();
        $this->actingAs($user)->put(route(self::WORKORDER_ROUTE . self::UPDATE, [$workOrderData->id]), $data)->assertStatus(STATUS_CODE_UPDATE);
        $this->actingAs($user)->put(route(self::WORKORDER_ROUTE . self::UPDATE, [$workOrderData->id, 'is_compliance' => true]), $data)->assertStatus(STATUS_CODE_UPDATE);
        $bulkIds = [];
        $bulkIds['id'] = [$workOrderData->id];
        $bulkIds = json_encode($bulkIds, true);
        $this->actingAs($user)->get('/admin/work-orders/check-OrderStatus/'. $bulkIds)->assertStatus(STATUS_CODE_UPDATE);

        $logTime['work_order_id'] = $workOrderData->id;
        $logTime['type'] = config('apg.log_status.start');
        $this->actingAs($user)->post(route(self::WORKORDER_ROUTE . self::UPDATE . '.log', $logTime))->assertStatus(STATUS_CODE_UPDATE);
        $this->actingAs($user)->post(route(self::WORKORDER_ROUTE . self::UPDATE . '.log', $logTime))->assertStatus(STATUS_CODE_UPDATE);
        $logTime['type'] = config('apg.log_status.breakin');
        $this->actingAs($user)->post(route(self::WORKORDER_ROUTE . self::UPDATE . '.log', $logTime))->assertStatus(STATUS_CODE_UPDATE);
        $logTime['type'] = config('apg.log_status.end');
        $logTime['updated_time'] =  '00:00:02';
        $this->actingAs($user)->post(route(self::WORKORDER_ROUTE . self::UPDATE . '.log', $logTime))->assertStatus(STATUS_CODE_UPDATE);
        $this->actingAs($user)->patch('/admin/work-orders/custom-log/' . $logData)->assertStatus(STATUS_CODE_UPDATE);
        $changeStatusData = [
            'title'             => 'test',
            'description'       => 'description will be',
            'priority'          => 'High',
            'description'       => 'description be here',
            'asset_type_id'     => $assetType->id,
            'asset_id'          => $asset->id,
            'work_order_profile_id' => $this->media->id,
            'assignee_user_id'  => '1',
            'work_order_type'   => 'Recurring',
            'work_order_status' => config('apg.work_order_status.on_hold'),
            'on_hold_reason' => 'reason',
            'work_order_frequency' => config(self::FREQUENCY_STATUS),
            'due_date'          => customDateFormat(now()),
        ];
        $this->actingAs($user)->put(route(self::WORKORDER_ROUTE . self::UPDATE, $workOrderData->id), $changeStatusData)->assertStatus(STATUS_CODE_UPDATE);
        $changeStatusData = [
            'title'             => 'test',
            'flag'              => 'on',
            'description'       => 'description will be here',
            'priority'          => 'High',
            'asset_type_id'     => $assetType->id,
            'asset_id'          => $asset->id,
            'work_order_profile_id' => $this->media->id,
            'assignee_user_id'  => '1',
            'work_order_type'   => 'Recurring',
            'work_order_status' => config(self::WORKORDER_COMPLETED_STATUS),
            'task_status' => [
                config('apg.task_status.completed'),
            ],
            'work_order_frequency' => config(self::FREQUENCY_STATUS),
            'due_date'          => customDateFormat(now()),
        ];
        $this->actingAs($user)->put(route(self::WORKORDER_ROUTE . self::UPDATE, $workOrderData->id), $changeStatusData)->assertStatus(STATUS_CODE_UPDATE);
        $changeStatusTaskPending = [
            'title'             => 'test',
            'flag'              => 'on',
            'description'       => 'description will be here',
            'priority'          => 'High',
            'asset_type_id'     => $assetType->id,
            'asset_id'          => $asset->id,
            'work_order_profile_id' => $this->media->id,
            'assignee_user_id'  => '1',
            'work_order_type'   => 'Recurring',
            'work_order_status' => config(self::WORKORDER_COMPLETED_STATUS),
            'task_status' => [
                config(self::PENDING_TASK),
            ],
            'work_order_frequency' => config(self::FREQUENCY_STATUS),
            'due_date'          => customDateFormat(now()),
        ];
        $this->actingAs($user)->put(route(self::WORKORDER_ROUTE . self::UPDATE, $workOrderData->id), $changeStatusTaskPending)->assertStatus(302);
        $this->actingAs($this->user)->put(route(self::COMPANY_WORKORDER_ROUTE . self::UPDATE, [$company->id, $workOrderData->id]), $data)->assertStatus(STATUS_CODE_UPDATE);
        $this->actingAs($this->user)->put(route(self::COMPANY_WORKORDER_ROUTE . self::UPDATE, [$company->id, $workOrderData->id, 'is_compliance' => true]), $data)->assertStatus(STATUS_CODE_UPDATE);
        $this->actingAs($this->user)->put(route(self::COMPANY_WORKORDER_ROUTE . self::UPDATE, [$company->id, $workOrderData->id]), $changeStatusData)->assertStatus(STATUS_CODE_UPDATE);
    }

    /**
     * @return void
    */
    public function test_additional_task_work_orders()
    {
        $taskData = [
            'name'              => 'test',
            'task_detail'       => 'Task detail will here',
            'due_date'          => customDateFormat(now()),
            'status'            => config(self::PENDING_TASK)
        ];
        $taskDataStatusComplete = [
            'name'              => 'test',
            'task_detail'       => 'Task detail will be here',
            'due_date'          => customDateFormat(now()),
            'status'            => config('apg.task_status.completed')
        ];
        $this->actingAs($this->user)->post(route(self::WORKORDER_ROUTE . '.additional-task.store'), $taskData)->assertStatus(STATUS_CODE_CREATE);
        $this->actingAs($this->user)->post(route(self::WORKORDER_ROUTE . '.additional-task.store'), $taskDataStatusComplete)->assertStatus(STATUS_CODE_CREATE);
        $additionalTask = AdditionalTask::orderBy('id', 'desc')->first();
        $this->actingAs($this->user)->get(route(self::WORKORDER_ROUTE . '.additional-task.edit', $additionalTask->id))->assertOk();

        $taskUpdateData = [
            'id'                => 1,
            'name'              => 'test',
            'task_detail'       => 'Task detail will be here',
            'due_date'          => customDateFormat(now()),
            'status'            => config(self::PENDING_TASK)
        ];
        $this->actingAs($this->user)->patch(route(self::WORKORDER_ROUTE . '.additional-task.update', $additionalTask->id), $taskUpdateData)->assertStatus(STATUS_CODE_UPDATE);
        $type = config('apg.task_type.comment');
        $this->actingAs($this->user)->delete(route(self::WORKORDER_ROUTE . '.additional-task.delete.comment', [$additionalTask->id, $type]))->assertStatus(STATUS_CODE_DELETE);
        $type = config('apg.task_type.image');
        $this->actingAs($this->user)->delete(route(self::WORKORDER_ROUTE . '.additional-task.delete.comment', [$additionalTask->id, $type]))->assertStatus(STATUS_CODE_DELETE);
        $this->actingAs($this->user)->delete(route(self::WORKORDER_ROUTE . '.additional-task.delete', $additionalTask->id))->assertStatus(STATUS_CODE_DELETE);

    }

    /**
     * @return void
     */
    public function test_import_work_orders()
    {
        $csv = '.import.csv';
        $company = Company::factory()->create();
        $assetType = AssetType::factory()->create();
        $asset = Asset::factory()->create();
        $asset2 = Asset::factory(['warranty_expiry_date' => now()->addYear(1)])->create();

        $header = (string) Str::of("Work Order Title,Work Order Description, Work Order Additional Information, Work Order Priority, Asset Type, Asset, Assigned Employee Email, Work Order Type, Work Order Frequency, Due Date,work_order_status");
        $row1 = (string) Str::of("Work Order Test,Description will be here, Notes will be here,Low,{$assetType->name},{$asset->name},{$this->user->email},Recurring,Daily,03-18-2022,Open");
        $row2 = (string) Str::of("Work Order Test,Description will be here, Notes will be here,Low,{$assetType->name},{$asset2->name},{$this->user->email},Recurring,Daily,03-18-2022,Open");
        $content = implode("\n", [$header, $row1, $row2]);

        $file = UploadedFile::fake()
            ->createWithContent(
                'test.csv',
                $content
        );

        $this->actingAs($this->user)->get(route(self::WORKORDER_ROUTE . '.export.template'))->assertDownload();
        $this->actingAs($this->user)->post(route(self::WORKORDER_ROUTE . $csv), ['file' => $file])->assertRedirect();
        $this->actingAs($this->user)->post(route(self::COMPANY_WORKORDER_ROUTE . $csv, $company->id), ['file' => $file])->assertRedirect();

        $row2 = (string) Str::of("Work Order Test,Description will be here, Notes will be here,Low,,{$asset->name},{$this->user->email},Recurring,Daily,03-18-2022,Open");
        $content = implode("\n", [$header, $row2]);
        $file = UploadedFile::fake()
        ->createWithContent(
            'test.csv',
            $content
        );
        $this->actingAs($this->user)->post(route(self::WORKORDER_ROUTE . $csv), ['file' => $file])->assertRedirect();
        $this->actingAs($this->user)->post(route(self::COMPANY_WORKORDER_ROUTE . $csv, $company->id), ['file' => $file])->assertRedirect();

    }

    /**
     * @return void
     */
    public function test_work_order_export_pdf()
    {
        $workOrder = WorkOrder::factory()->create();
        $this->actingAs($this->user)
            ->get(route('admin.work-orders.export.pdf', [$workOrder->id, $workOrder->id]))
            ->assertRedirect();
    }

    /**
     * @return void
     */
    public function test_work_order_export_csv()
    {
        $workOrder = WorkOrder::factory()->create();
        $this->actingAs($this->user)
            ->get(route('admin.work-orders.export.csv', [$workOrder->id]))
            ->assertRedirect();
    }

    /**
     * @return void
     */
    public function test_company_work_order_export_pdf()
    {
        $workOrder = WorkOrder::factory()->create();
        $this->actingAs($this->user)
            ->get(route('admin.companies.company-work-orders.export.pdf', [$workOrder->id, $workOrder->id]))
            ->assertRedirect();
    }

    /**
     * @return void
     */
    public function test_company_work_order_export_csv()
    {
        $workOrder = WorkOrder::factory()->create();
        $this->actingAs($this->user)
            ->get(route('admin.companies.company-work-orders.export.csv', [$workOrder->id, $workOrder->id]))
            ->assertRedirect();
    }

    /**
     * @return void
     */
    public function test_work_order_assigned_notification()
    {
        $workOrder = WorkOrder::factory()->create();
        $this->actingAs($this->user)
            ->get(route('admin.notification', $workOrder->id))
            ->assertOk();
    }


    /**
     * @return void
     */
    public function test_workorder_frequency()
    {
        $workOrder = WorkOrder::factory()->create();
        $asset = Asset::factory()->create();
        $data = [
            'title'             => 'test',
            'description'       => 'description be here',
            'priority'          => 'High',
            'description'       => 'description will here',
            'asset_type_id'     => $workOrder->asset_type_id,
            'asset_id'          => $workOrder->asset_id,
            'work_order_profile_id' => $this->media->id,
            'assignee_user_id'  => '1',
            'work_order_type'   => config('apg.recurring_status.recurring'),
            'work_order_status'   => 'Open',
            'work_order_frequency' => config(self::FREQUENCY_STATUS),
            'task_data'            => [
                0 => [
                    "name"        => "oil change",
                    "task_detail" => "description",
                    "due_date"    => customDateFormat(now())
                  ]
            ],
            'due_date'          => customDateFormat(now()),
        ];
        $data['update_frequency_type'] = config('apg.update_frequency_cases.future.key');
        $this->actingAs($this->user)
        ->put(route(self::WORKORDER_ROUTE . self::UPDATE, $workOrder->id), $data)
        ->assertStatus(STATUS_CODE_UPDATE);

        $data['update_frequency_type'] = config('apg.update_frequency_cases.last_thirty.key');
        $data['work_order_frequency'] = config('apg.frequency_status.bi-weekly');
        $this->actingAs($this->user)
        ->put(route(self::WORKORDER_ROUTE . self::UPDATE, $workOrder->id), $data)
        ->assertStatus(STATUS_CODE_UPDATE);

        $data['update_frequency_type'] = config('apg.update_frequency_cases.all.key');
        $data['work_order_frequency'] = config('apg.frequency_status.weekly');
        $this->actingAs($this->user)
        ->put(route(self::WORKORDER_ROUTE . self::UPDATE, $workOrder->id), $data)
        ->assertStatus(STATUS_CODE_UPDATE);

        $data['update_frequency_type'] = 'test';
        $data['work_order_frequency'] = config('apg.frequency_status.weekly');
        $this->actingAs($this->user)
        ->put(route(self::WORKORDER_ROUTE . self::UPDATE, $workOrder->id), $data)
        ->assertStatus(STATUS_CODE_UPDATE);

        $data['asset_id'] = $asset->id;
        $this->actingAs($this->user)
        ->put(route(self::WORKORDER_ROUTE . self::UPDATE, $workOrder->id), $data)
        ->assertStatus(STATUS_CODE_UPDATE);

    }
    /**
     * @return void
     */
    public function test_workorder_emails()
    {
        WorkOrder::factory()->create();
        WorkOrder::factory([
            'due_date' => now()->subDay()->format('Y-m-d')
        ])->create();
        $this->artisan('apg:workorder reminder')->assertSuccessful();
        $this->artisan('apg:workorder overdue')->assertSuccessful();
    }

    /**
     * @return void
     */
    public function test_employee_workorder()
    {
        $company = Company::factory()->create();
        $employee = User::factory([
                'user_status' => config('apg.user_status.employee'),
                "company_id" => $company->id,
                'is_admin_employee' => 1,
        ])->create();
        $this->actingAs($employee)->get(route(self::EMPLOYEE_WORKORDER_ROUTE . self::INDEX))->assertOk();
        $workOrderData = WorkOrder::factory([
            "assignee_user_id" => $employee->id,
            "company_id" => $company->id,
            "type" => config('apg.type.company'),
        ])->create();
        $this->actingAs($employee)->get(route('employee.get-profile'))->assertOk();
        $data = [
            'first_name' => 'test',
            'last_name'  => 'employee',
            'email'      => 'test@gmail.com'
        ];
        $employeeData = User::orderBy('id', 'desc')->first();
        $this->actingAs($employee)->put(route('employee.update-profile', $employeeData->id) , $data)->assertStatus(STATUS_CODE_UPDATE);
        $this->actingAs($employee)->get(route(self::EMPLOYEE_WORKORDER_ROUTE . self::SHOW, [$workOrderData->id, 'notification_id' => 1]))->assertOk();
        $this->actingAs($employee)->get(route(self::WORKORDER_ROUTE . self::EDIT, $workOrderData->id))->assertStatus(STATUS_CODE_FORBIDDEN);
    }
    /**
     * @return void
     */
    public function test_workorder_request()
    {
        $newUser = User::factory()->create();
        $assetType = AssetType::factory()->create();
        $asset = Asset::factory()->create();
        $workOrderData = WorkOrder::factory([
            'work_order_type' => config('apg.recurring_status.recurring'),
            'work_order_frequency' => config('apg.frequency_status.daily'),
            'assignee_user_id' => $newUser->id,
            'work_order_status' => config('apg.work_order_status.in_progress')
        ])->create();
        AdditionalTask::factory([
            'work_order_id' =>  $workOrderData->id
        ])->count(2)->create();
        $data = [
            'title'             => 'test',
            'description'       => 'change',
            'priority'          => 'High',
            'asset_type_id'     => $assetType->id,
            'asset_id'          => $asset->id,
            'work_order_profile_id' => $this->media->id,
            'assignee_user_id'  => $this->user->id,
            'work_order_type'   => config('apg.recurring_status.non-recurring'),
            'work_order_status'   => 'Open',
            'work_order_frequency' => config(self::FREQUENCY_STATUS),
            'due_date'          => customDateFormat(now()),
        ];
        $this->actingAs($this->user)->put(route(self::WORKORDER_ROUTE . self::UPDATE, $workOrderData->id), $data)
        ->assertStatus(STATUS_CODE_REDIRECTED);
        Livewire::actingAs($this->user)->test('work-order-table', [
            'model' => WorkOrder::class,
            'viewFile' => 'admin.workorder.table',
            'relation' => '["assets","location"]',
        ])->set('filter', [
            'id' => $workOrderData->id,
            'global_search' => $workOrderData->name,
            'work_order_status' => $workOrderData->work_order_status,
            'flag' => $workOrderData->flag,
            'location' => 'uk',
            'asset_type' => 'asset type',
            'range_due_date' => now()->format('m-d-Y'),
            'range_created_at' => now()->format('m-d-Y'),
            'current_year' => true,
            'current_month' => true,
        ])->call('filter')
        ->call('sortBy')
        ->call('export', config('apg.export_format.pdf'))
        ->call('exportComprehensive', config('apg.export_format.pdf'))
        ->call('csvExport', config('apg.export_format.csv'))
        ->call('dateFilter', 'current_month')
        ->call('dateFilter', 'current_year')
        ->call('clear')
        ->call('manualFilter', 'flag', 1)
        ->call('delete', $workOrderData->id)
        ->assertOk();
    }

    /**
     * @return void
     */
    public function test_compliance_pdf_request()
    {
        $newUser = User::factory()->create();
        $assetType = AssetType::factory()->create();
        $asset = Asset::factory([
            'asset_type_id' => $assetType->id
        ])->create();
        $workOrderData = WorkOrder::factory([
            'asset_type_id' => $assetType->id,
            'asset_id' => $asset->id,
            'assignee_user_id' => $newUser->id,
            'work_order_status' => config('apg.work_order_status.in_progress'),
            'work_order_type' => config('apg.recurring_status.non-recurring'),
        ])->create();
        AdditionalTask::factory([
            'work_order_id' =>  $workOrderData->id
        ])->count(2)->create();

        $this->actingAs($this->user)->get(route('admin.asset.compliance.pdf', [$asset->id, $asset->asset_type_id]))
        ->assertRedirect();
    }
}
