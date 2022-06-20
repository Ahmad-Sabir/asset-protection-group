<?php

namespace App\Console\Commands;

use App\Models\Admin\WorkOrder\WorkOrder as WorkOrderModel;
use App\Events\WorkOrder as  WorkOrderEvent;
use Illuminate\Console\Command;
use Illuminate\Queue\Worker;

class WorkOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apg:workorder {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The work order assigned date - before 1 day at 6:am';

     /**
     * Execute the console command.
     *
     * @return void
     */

    public function handle()
    {
        $this->arguments()['type'] == 'reminder' ? $this->workOrderReminder() : $this->workOrderOverdue();
    }
    /**
     * The work order assigned date - before 1 day at 6:am
     *
     * @return void
     */
    public function workOrderReminder()
    {
        $workOrders = WorkOrderModel::where('due_date', now()->addDay()->format('Y-m-d'))
        ->whereIn('work_order_status', [
            config('apg.employee_work_order_status.open'),
            config('apg.work_order_status.on_hold'),
            config('apg.work_order_status.in_progress'),
            ])
        ->get();
        $workOrders->each(function ($workOrder) {
            $emailData = [
                'subject'   => __('workorder.email.work_order_reminder_subject'),
                'view'      => 'email-template.work-order.reminder',
                'message'   => __(
                    'workorder.notification.work_order_reminder',
                    ['title' => $workOrder->title, 'date' => customdateFormat($workOrder->due_date)]
                )
            ];
            $preference['email'] = config('apg.email_setting_keys.reminder_workorder');
            $preference['notification'] = config('apg.notification_setting_keys.reminder_workorder');
            event(new WorkOrderEvent($workOrder, $emailData, $preference));
        });

        $this->info('Work Order Reminder successfully');
    }
     /**
     * The work order assigned date - every monday at 6:am
     * @return void
     */
    public function workOrderOverdue()
    {
        $workOrders = WorkOrderModel::where('due_date', '<', now()->format('Y-m-d'))
        ->whereIn('work_order_status', [
            config('apg.employee_work_order_status.open'),
            config('apg.work_order_status.on_hold'),
            config('apg.work_order_status.in_progress')
            ])
        ->get();
        $workOrders->each(function ($workOrder) {
            $emailData = [
                'subject'   => __('workorder.email.work_order_overdue_subject'),
                'view'      => 'email-template.work-order.over-due',
                'message'   => __('workorder.notification.work_order_duedate')
            ];
            $preference['email'] = config('apg.email_setting_keys.overdue_workorder');
            $preference['notification'] = config('apg.notification_setting_keys.overdue_workorder');
            event(new WorkOrderEvent($workOrder, $emailData, $preference));
        });

        $this->info('Work Order Overdue successfully');
    }
}
