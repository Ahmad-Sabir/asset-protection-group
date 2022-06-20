<?php

namespace App\Listeners;

use Mail;
use App\Events\Imported;
use App\Events\Registered;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendImportEmail implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Imported $event
     * @return void
     */
    public function handle(Imported $event)
    {
        $body = view('email-template.admin-email-report', [
            'failures' => $event->data['failures'] ?? [],
            'success_rows' => $event->data['success_rows'] ?? 0
        ])->render();

        send_mail(config('app.email'), $event->data['subject'], $body);
    }
}
