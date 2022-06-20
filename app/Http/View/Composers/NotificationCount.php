<?php

namespace App\Http\View\Composers;

use App\Models\Notification;
use Illuminate\View\View;

class NotificationCount
{
    /**
     * compose
     *
     * @param \Illuminate\View\View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('noti_counts', Notification::where([
                'user_id' => auth()->id(),
                'read_at' => null
            ])
            ->count());
    }
}
