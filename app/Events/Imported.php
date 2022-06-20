<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Imported
{
    use SerializesModels;

    /**
     * The authenticated user.
     *
     * @var array
     */
    public $data;

    /**
     * Create a new event instance.
     *
     * @param array $data
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
}
