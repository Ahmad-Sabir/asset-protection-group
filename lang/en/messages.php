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

    'create'                    => ':title has been created successfully.',
    'update'                    => ':title has been updated successfully.',
    'delete'                    => ':title has been deleted successfully.',
    'confirm'                   => 'Are you sure?',
    'confirm_delete'            => 'you want to delete this :title',
    'confirm_restore_log'       => 'you want to restore this :title',
    'restore_success'           => 'Log has been restore successfully.',
    'import_error'              => 'There is some missing filed in file. Check your email for detail.',
    'import_success'            => ':count :title successfully imported.',
    'import_email_subject'      => ":title Import in " . config('app.name'),
    'media_upload'              => 'Successfully media uploaded.',
    'livewire_message'          => [
        'color'     => ':color',
        'message'   => 'Attachment send to your email successfully.',
    ],
    'export_filename'           => [
        'asset'                         => 'Asset :name',
        'assets'                        => 'Assets',
        'asset_compliance'              => 'Asset Compliance Plan',
        'company_asset_compliance'      => 'Company Asset Compliance Plan',
        'work_order'                    => 'Work Order :name',
        'work_orders'                   => 'Work Orders',
        'company_reports'               => 'Company Reports',
        'work_order_comprehensive'      => 'Work Order Comprehensive',
        'employees'                     => 'Employees',
        'asset_reports'                 => 'Asset Reports',
        'work_order_reports'            => 'Work Order Reports',
        'asset_grid_compliance'         => 'Asset Grid Compliance',
        'asset_detail_compliance'       => 'Asset Detail Compliance',
        'expense'                       => 'Expense',
    ]
];
