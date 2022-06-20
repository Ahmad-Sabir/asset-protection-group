<?php

namespace App\Services\Admin;

use App\Events\WorkOrderAssignedEvent;
use App\Models\Notification;

class NotificationService
{
    /**
     * Create a new event instance.
     *
     * @param mixed $data
     * @param mixed $message
     * @param mixed $user
     * @return mixed
     */
    public function notify($data, $message = '', $user = '')
    {
        $memberType = ($user->user_status == config('apg.user_status.employee')) ? 'employee'  : 'admin';
        $count = $this->getCount($data);
        $notificationData = [
            'workorder_id' => $data['id'],
            'path' => "/$memberType/work-orders/{$data['id']}",
            'message' => $message,
            'count' => $count,
        ];
        Notification::create([
            'user_id' => $data['assignee_user_id'],
            'read_at' => null,
            'data' => $notificationData,
        ]);
        broadcast(new WorkOrderAssignedEvent($data));
    }

    /**
     * Create a new event instance.
     *
     * @param mixed $workOrder
     * @return mixed
     */
    public function getCount($workOrder)
    {
        return Notification::where([
            'user_id' => $workOrder['assignee_user_id'],
            'read_at' => null
        ])->count();
    }

    /**
     * Get Notification by ID
     * @param mixed $workOrderId
     * @return mixed
     */
    public function getNotification($workOrderId)
    {
        return Notification::where('data->workorder_id', '=', $workOrderId)->first();
    }

    /**
     * Update Notification By ID
     * @param mixed $id
     * @return mixed
     */
    public function readAs($id)
    {
        return Notification::where('id', $id)
            ->update(['read_at' => now()]);
    }
}
