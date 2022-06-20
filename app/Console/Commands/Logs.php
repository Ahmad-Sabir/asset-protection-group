<?php

namespace App\Console\Commands;

use App\Models\DeleteLog;
use Illuminate\Console\Command;
use Carbon\Carbon;

class Logs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apg:logs {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete entity 15 days old';

    /**
     * Execute the console command.
     *
     * @return void
     */

    public function handle()
    {
        call_user_func([$this, "delete"]);
    }

     /**
     * Delete user for 30 days old
     *
     * @return void
     */

    public function delete()
    {
        $logs = DeleteLog::where('created_at', '<=', Carbon::now()->subDays(15))->get();
            $logs->each(function ($log) {
                $log->entity()->withTrashed()->first()?->forcedelete();
                $log->delete();
            });
        $this->info('Deleted logs successfully');
    }
}
