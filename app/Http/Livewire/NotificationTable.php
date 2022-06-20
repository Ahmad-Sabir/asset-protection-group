<?php

namespace App\Http\Livewire;

use App\Models\Notification;
use Livewire\Component;
use Livewire\WithPagination;

class NotificationTable extends Component
{
    use WithPagination;

    /**
     * The attributes that are mass assignable.
     *
     * @var int
     */
    public $perPage = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('admin.notification.notification-table', [
            'push' => Notification::where('user_id', auth()->id())
            ->orderBy('id', 'DESC')
            ->paginate($this->perPage)
        ]);
    }
}
