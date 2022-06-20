<?php

namespace App\Listeners\WorkOrder;

use App\Events\WorkOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Services\Admin\NotificationService;
use Illuminate\Support\Arr;

class SendNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        protected NotificationService $notificationService
    ) {
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
        /** @phpstan-ignore-next-line */
        if (Arr::get($user['notification_setting'], $event->preference['notification']) == 1) {
            $this->notificationService->notify(
                $event->data,
                $event->emailData['message'],
                $user
            );
        }
    }
}
