<?php

namespace App\Http\View\Composers;

use App\Models\Notification;
use Illuminate\View\View;

class NotificationComposer
{
    /**
     * compose
     *
     * @param \Illuminate\View\View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('notifications', Notification::where('user_id', auth()->id())
            ->limit(10)
            ->orderBy('id', 'desc')
            ->get());
    }
}
