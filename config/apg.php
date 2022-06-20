<?php

$notificationSettings = [
    'assigned_workorder' => 1,
    'reminder_workorder' => 1,
    'overdue_workorder' => 1,
];
$notificationKeys = [
    'assigned_workorder' => 'assigned_workorder',
    'reminder_workorder' =>  'reminder_workorder',
    'overdue_workorder'  =>   'overdue_workorder',
];
$workOrderStatus = [
    'open' => 'Open',
    'on_hold' => 'On Hold',
    'in_progress' => 'In Progress',
    'completed' => 'Completed',
    'closed' => 'Closed'
];
$workOrderEmployeeStatus = $workOrderStatus;
unset($workOrderEmployeeStatus['closed']);
$nonRecurring = 'Non Recurring';
$recurring = 'Recurring';
return [
    'frequency'    => [
        'Daily',
        'Weekly',
        'Bi-weekly',
        'Monthly',
        'Bi-Monthly',
        'Quarterly',
        'Semi-Annually',
        'Annually'
    ],
    'work_order_type'         => [$nonRecurring, $recurring],
    'work_order_type_check'   => [
        'non_recurring' => $nonRecurring,
        'recurring' =>  $recurring
    ],
    'employee_work_order_status' => $workOrderEmployeeStatus,
    'task_status' => [
        'pending'   => 'Pending',
        'completed' => 'Completed'
    ],
    'work_order_status' => $workOrderStatus,
    'work_order_status_color'       => [
        $workOrderStatus['open'] => 'blue',
        $workOrderStatus['on_hold'] => 'primary',
        $workOrderStatus['in_progress'] => 'secondary',
        $workOrderStatus['completed'] => 'green',
        $workOrderStatus['closed'] => 'gray7'
    ],
    'priority'                => ['Low','Medium', 'High'],
    'flag'                    => ['off', 'on'],
    'qualification'     =>
    [
        'manufacturers-representative'  => "Manufacturer's Representative",
        'professional-engineer'         => "Professional Engineer",
        'equipment-operator'            => "Equipment Operator",
        'owner-representative'          => "Owner's Representative",
    ],
    'user_status'             => [
            'super-admin'  => 'super-admin',
            'admin'      =>  'admin',
            'employee'  =>  'employee',
        ],
    'recurring_status'       => [
        'recurring'      => $recurring,
        'non-recurring'  => $nonRecurring,
    ],
    'frequency_status'      =>
    [
        'daily'             => 'Daily',
        'weekly'            => 'Weekly',
        'bi-weekly'         => 'Bi-weekly',
        'monthly'           => 'Monthly',
        'bi-monthly'        => 'Bi-Monthly',
        'quarterly'         => 'Quarterly',
        'semi-annually'     => 'Semi-Annually',
        'annually'          => 'Annually',
    ],
    'frequency_interval'    =>
    [
        'daily'             => 1,
        'weekly'            => 7,
        'bi-weekly'         => 4,
        'monthly'           => 30,
        'bi-monthly'        => 15,
        'quarterly'         => 90,
        'semi-annually'     => 182,
        'annually'          => 365,
    ],
    'type'    =>
    [
        'master'            => 'master',
        'company'           => 'company'
    ],
    'task_type'    =>
    [
        'comment'            => 'Comment',
        'image'           => 'Image'
    ],
    'log_status'    =>
    [
        'start'        => 'start',
        'breakin'      => 'breakin',
        'breakout'     => 'breakout',
        'end'          => 'end',
        'custom'       => 'custom',
    ],
    'report_types' => [
        'assets' => 'assets',
        'work_orders' => 'work-orders',
        'users' => 'users',
    ],
    'pdf_options' => [
        'template' =>
        [
            'asset-print'               => 'asset-print',
            'asset-compliance-print'    => 'asset-compliance-print',
            'work-order-print'          => 'work-order-print',
            'report-asset-print'        => 'report-asset-print',
            'report-work-order-print'   => 'report-work-order-print',
            'report-company-print'      => 'report-company-print',
            'expense-print'             => 'expense-print',
        ],
        'orientation' => [
            'portrait' => 'portrait',
            'landscape' => 'landscape'
        ]
    ],
    'pdf_email' => [
        'to_email' => env('MAIL_FROM_ADDRESS')
    ],
    'update_frequency_cases' => [
        'current' => [
            'text' => 'This work order',
            'key' => 'current'
        ],
        'future' => [
            'text' => 'This and following work order',
            'key' => 'future'
        ],
        'last_thirty' => [
            'text' => 'Last 30 days work order',
            'key' => 'last_thirty'
        ],
        'all' => [
            'text' => 'All work orders',
            'key' => 'all'
        ],
    ],
    'export_module' =>
    [
        'master_asset'           => 'master_asset',
        'master_workorder'       => 'master_workorder',
        'asset_workorder_single' => 'asset_workorder_single',
        'company_employees'      => 'company_employees',
        'report_asset'           => 'report_asset',
        'report_workorder'       => 'report_workorder',
        'report_company'         => 'report_company',
        'expense'                => 'expense',
    ],
    'export_format' => [
        'csv' => 'csv',
        'pdf' => 'pdf'
    ],
    'notifications' => [
        'AssignedToEmployeeEmail' => 'AssignedToEmployeeEmail',
        'ReminderToEmployeeEmail' => 'ReminderToEmployeeEmail',
        'OverdueToEmployeeEmail' => 'OverdueToEmployeeEmail',
        'AssignedToEmployeeNoti' => 'AssignedToEmployeeNoti',
        'ReminderToEmployeeNoti' => 'ReminderToEmployeeNoti',
        'OverdueToEmployeeNoti' => 'OverdueToEmployeeNoti',
    ],
    'email_settings' => $notificationSettings,
    'notification_settings' => $notificationSettings,
    'email_setting_keys' => $notificationKeys,
    'notification_setting_keys' => $notificationKeys,
    'notification_type' => [
        'employee' => [
            'work_order_assigned' => 'work_order_assigned',
            'work_order_due_date' => 'work_order_due_date',
            'work_order_due_over_date' => 'work_order_due_over_date',
        ],
        'admin' => [
            'welcome' => 'welcome'
        ]
    ],
    'asset_report_fields' => [
        'id' => true,
        'company_id' => true,
        'installation_date' => true,
        'name' => true,
        'asset_type' => true,
        'status' => true,
        'location_id' => true,
        'created_at' => true,
        'manufacturer' => false,
        'model' => false,
        'replacement_cost' => false,
        'purchase_price' => false,
        'remaining_useful_life' => false,
        'total_useful_life' => false,
        'warranty_expiry_date' => false,
    ],
    'work_order_report_fields' => [
        'id' => true,
        'title' => true,
        'asset_id' => true,
        'asset_type_id' => true,
        'assignee_user_id' => true,
        'work_order_status' => true,
        'created_at' => true,
        'due_date' => true,
        'work_order_type' => true,
    ],
    'company_report_fields' => [
        'id' => true,
        'name' => true,
        'manager_email' => true,
        'company_manager_name' => true,
        'deactivate_at' => true,
        'created_at' => true,
    ],
    'member_type' => [
        'employee' => 'employee',
        'admin' => 'admin'
    ]
];
