<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WorkOrder
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

     /**
     * The authenticated user.
     *
     * @var mixed
     */
    public $data;
    /** @var mixed $emailData */
    public $emailData;
    /** @var mixed $preference */
    public $preference;

     /**
     * Create a new event instance.
     *
     * @param mixed $data
     * @param mixed $emailData
     * @param mixed $preference
     * @return void
     */
    public function __construct($data, $emailData, $preference)
    {
        $this->data = $data;
        $this->emailData = $emailData;
        $this->preference = $preference;
    }
}
