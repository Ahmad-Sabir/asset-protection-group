<?php

namespace Tests\Feature\User;

use App\Models\DeleteLog;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class UserTest extends TestCase
{
    protected const USER_ROUTE = 'admin.users';
    /**
     * @return void
     */
    public function test_manage_admin_users()
    {
        $fields = [
            'id' => true,
            'name' => true,
            'manager_email' => true,
            'company_manager_name' => true,
            'deactivate_at' => true,
            'created_at' => true,
        ];
        $user = User::factory()->create();
        $this->actingAs($user)->get(route(self::USER_ROUTE . '.index'))->assertOk();
        $data = [
            'first_name' => 'test',
            'last_name'  => 'user',
            'email'      => 'test@gmail.com'
        ];

        $this->actingAs($user)->post(route(self::USER_ROUTE . '.store'), $data)->assertStatus(STATUS_CODE_CREATE);
        $userData = User::orderBy('id', 'desc')->first();
        $this->actingAs($user)->put(route(self::USER_ROUTE . '.update', $userData->id), $data)->assertStatus(STATUS_CODE_UPDATE);
        $this->actingAs($user)->get(route('admin.dashboard'))->assertOk();
        $this->actingAs($user)->get(route('admin.get-profile'))->assertOk();
        $this->actingAs($user)->put(route('admin.update-profile', $userData->id) , $data)->assertStatus(STATUS_CODE_UPDATE);

        Livewire::actingAs($user)->test('table', [
            'filterName' => 'save filter',
            'model' => User::class,
            'viewFile' => 'admin.user.table',
            'filter'   => [
                'deactivate_at' => true,
                'id' => $user->id,
                'full_name_search' => $user->full_name,
                'range_created_at' => now()->format('m-d-Y')
            ]
        ])->call('filter')
        ->call('clear')
        ->call('edit', $user)
        ->call('saveFilter')
        ->call('customizeFilter', [
            'filter' => json_encode([
                'id' => 1,
            ])
        ])->Call('delete', $user->id)
        ->Call('delete', 0)
        ->call('exportPdfReportCompany', $fields, config('apg.export_format.pdf'))
        ->call('exportCsvReportCompany', $fields, config('apg.export_format.csv'))
        ->assertOk();

        Livewire::actingAs($user)->test('sweet-alert')->call('alert')->assertOk();
        User::latest()->update(['deleted_at' => now()->subDays(30)]);
        DeleteLog::insert([
            'user_id' => $this->user->id,
            'entity_type' => user::class,
            'entity_id' => $this->user->id,
            'created_at' => now()->subDays(30)
        ]);

        $this->artisan('apg:logs delete')->assertSuccessful();
        $this->artisan('schedule:run');
    }

    /**
     * @return void
     */
    public function test_import_admin_users()
    {
        $header = (string) Str::of("First Name,Last Name,Email,");
        $row1 = (string) Str::of("Test,User,test@test.com,");
        $row2 = (string) Str::of("Test 2,User 2,{$this->user->email}");

        $content = implode("\n", [$header, $row1, $row2]);

        $file = UploadedFile::fake()
            ->createWithContent(
                'test.csv',
                $content
            );
        $this->actingAs($this->user)->get(route('admin.users.export'))->assertDownload();
        $this->actingAs($this->user)->post(route('admin.users.import'), ['file' => $file])->assertRedirect();

        $row = (string) Str::of(",User,test@test.com,");
        $content = implode("\n", [$header, $row]);

        $file = UploadedFile::fake()
            ->createWithContent(
                'test.csv',
                $content
            );

            $this->actingAs($this->user)->post(route('admin.users.import'), ['file' => $file])->assertRedirect();
    }
}
