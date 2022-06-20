<?php

namespace App\Events;

use App\Models\Admin\WorkOrder\WorkOrder;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WorkOrderAssignedEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * workOrder
     *
     * @var mixed
     */
    public $workOrder;


    /**
     * Create a new event instance.
     *
     * @param \App\Models\Admin\WorkOrder\WorkOrder $workOrder
     * @return void
     */
    public function __construct(WorkOrder $workOrder)
    {
        $this->workOrder = $workOrder;
    }

    /**
     * broadcastAs
     *
     * @return mixed
     */
    public function broadcastAs()
    {
        return "work-order-assigned-event";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('workorders.' . $this->workOrder->assignee_user_id);
    }
}
