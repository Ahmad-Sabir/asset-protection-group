<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Crud Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during Crud for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'email' => [
        'work_order_assigned_subject'    => 'WORK ORDER ASSIGNED TO EMPLOYEE',
        'work_order_reminder_subject'    => 'WORK ORDER REMINDER TO EMPLOYEE',
        'work_order_overdue_subject'     => 'WORK ORDER OVERDUE TO EMPLOYEE',
    ],
    'notification'  => [
        'work_order_assigned'      => 'Work Order has been assigned to you.',
        'work_order_reminder'      => 'Your coming work order :title due for tomorrow i.e. :date. So please be aligned to perform it and not to miss it.',
        'work_order_duedate'       => 'You are being notified that the due date of the following work orders is passed but these are still pending to be completed.',
    ]
];
