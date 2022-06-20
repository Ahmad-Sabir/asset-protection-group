<?php

namespace App\Listeners;

use App\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Password;
use Mail;

class SendEmailWelcomeNotification implements ShouldQueue
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
     * @param  Registered $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $token = Password::createToken(
        /** @phpstan-ignore-next-line */
            $event->user
        );
        $url = url(route('password.reset', [
            'token' => $token,
            'email' => $event->user->getEmailForPasswordReset(),
        ], false));
        $body = view('email-template.welcome', ['user' => $event, 'url' => $url])->render();
        send_mail(optional($event->user)->email, "Welcome to " . config('app.name') . " ", $body);
    }
}
