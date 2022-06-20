<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Company;
use App\Models\DeleteLog;

class DeleteLogTest extends TestCase
{
    public function test_manage_logs()
    {
        $this->actingAs($this->user)->get(route('admin.delete-logs'))->assertOk();
        Livewire::actingAs($this->user)->test('delete-log-table', [
            'filter'   => [
                'user_name' => 'elton',
                'company' => 'APG',
                'description' => 'test',
                'range_created_at' => now()->format('m-d-Y') . 'to' .  now()->format('m-d-Y')
            ]
        ])->set('filter', [
            'global_search' => 'logs',
        ])->call('clear')
        ->call('reStore', $this->logs()->id)
        ->call('delete', $this->logs()->id)
        ->set('logIds', $this->logs()->pluck('id')->toArray())
        ->call('bulkRestore', true)
        ->assertOk();
    }

    public function logs()
    {
        $createUser = User::factory()->create([
            'deleted_at' => now()
        ]);
        return DeleteLog::create([
            'user_id' => $this->user->id,
            'entity_type' => user::class,
            'entity_id' => $createUser->id,
        ]);
    }
}
