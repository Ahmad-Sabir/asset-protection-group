<?php

namespace App\Listeners;

use App\Events\CompanyCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CompanyNotification implements ShouldQueue
{
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
     * @param  CompanyCreated $event
     * @return void
     */
    public function handle(CompanyCreated $event)
    {
        $body = view('email-template.company-welcome-email', ['company' => $event->company])->render();
        send_mail(optional($event->company)->manager_email, "Welcome to " . config('app.name') . " ", $body);
    }
}
