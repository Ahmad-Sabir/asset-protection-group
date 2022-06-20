<?php

namespace App\Listeners\WorkOrder;

use App\Events\WorkOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use Illuminate\Support\Arr;

class SendEmail implements ShouldQueue
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
     * @param  \App\Events\WorkOrder  $event
     * @return void
     */
    public function handle(WorkOrder $event)
    {
        $assignedUser = $event->data['assignee_user_id'];
        $user = User::where('id', $assignedUser)->first();
        /** @var mixed $user */
        if (Arr::get($user['email_setting'], $event->preference['email']) == 1) {
            $body = view($event->emailData['view'], ['data' => $event->data , 'user' => $user])->render();
            send_mail($user->email, $event->emailData['subject'], $body);
        }
    }
}
