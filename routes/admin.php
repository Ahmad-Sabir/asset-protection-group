<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\Asset\AssetController;
use App\Http\Controllers\Admin\Asset\AssetTypeController;
use App\Http\Controllers\Admin\Company\CompanyController;
use App\Http\Controllers\Admin\Company\EmployeeController;
use App\Http\Controllers\Admin\Company\CompanyAssetTypeController;
use App\Http\Controllers\Admin\Company\LocationController;
use App\Http\Controllers\Admin\WorkOrder\WorkOrderController;
use App\Http\Controllers\Admin\Company\AssetController as CompanyAssetController;
use App\Http\Controllers\Admin\Company\WorkOrderController as CompanyWorkOrderController;
use App\Http\Controllers\Employee\WorkOrder\WorkOrderController as EmployeeWorkOrderController;
use App\Http\Controllers\Admin\Company\ExpenseController;
use App\Http\Controllers\Admin\DeleteLogController;
use App\Http\Controllers\Admin\Notification\NotificationController;
use App\Http\Controllers\Admin\Reports\ReportController;
use App\Http\Controllers\Admin\User\ProfileController;
use App\Services\Admin\NotificationService;

Route::group(['middleware' =>
    [
        sprintf("role:%s,%s", config('apg.user_status.super-admin'), config('apg.user_status.admin'))
    ]
], function () {
    Route::get('/', function () {
        return view('admin.dashboard.index');
    })->name('dashboard');
    Route::resources([
        'users'       => UserController::class,
        'assets'      => AssetController::class,
        'asset-types' => AssetTypeController::class,
        'work-orders' => WorkOrderController::class,
    ]);
    Route::post('clone-work-order/{id}', [WorkOrderController:: class, 'cloneWorkOrder'])
    ->name('work-orders.clone');
    Route::post('clone-work-order/{id}/{companyId}', [CompanyWorkOrderController:: class, 'cloneWorkOrder'])
    ->name('companies.work-orders.clone');
    Route::get('fetch-assets/{id}', [WorkOrderController:: class, 'fetchAssets'])
        ->name('work-orders.fetch.asset');
    Route::get('fetch-location/{id}', [WorkOrderController:: class, 'fetchLocation'])
        ->name('work-orders.fetch.location');
    Route::get('export', [UserController::class, 'export'])->name('users.export');
    Route::post('import', [UserController::class, 'import'])->name('users.import');
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/update-profile', [ProfileController::class, 'getProfile'])->name('get-profile');
    Route::put('/update-profile/{id}', [ProfileController::class, 'updateProfile'])->name('update-profile');
    Route::post('work-orders/import/csv', [WorkOrderController::class, 'importCsv'])->name('work-orders.import.csv');
    Route::get('work-orders/export/template', [WorkOrderController::class, 'exportTemplate'])
        ->name('work-orders.export.template');
    Route::get('work-orders/export/pdf/{id?}', [WorkOrderController::class, 'exportWorkOrderPdf'])
        ->name('work-orders.export.pdf');
    Route::get('work-orders/export/csv/{id?}', [WorkOrderController::class, 'exportWorkOrderCsv'])
        ->name('work-orders.export.csv');
    Route::controller(AssetController::class)->group(function () {
        Route::get('assets/export/pdf/{id?}', 'exportAssetPdf')->name('master-asset.export.pdf');
        Route::get('work-orders/export/compliance', 'exportWorkOrderCompliancePdf')
            ->name('work-orders.compliance.pdf');
        Route::get('assets/compliance/pdf/{id?}/{assetTypeId?}', 'exportAssetCompliancePdf')
            ->name('asset.compliance.pdf');
        Route::get('assets/grid/compliance/pdf/{id?}/{assetTypeId?}', 'exportAssetGridCompliancePdf')
            ->name('asset.grid.compliance.pdf');
        Route::get('assets/detail/compliance/pdf/{id?}/{assetTypeId?}', 'exportAssetDetailCompliancePdf')
            ->name('asset.detail.compliance.pdf');
        Route::post('assets/upload/media/{asset_id}', 'uploadMedia')->name('assets.upload.media');
        Route::get('assets/export/template', 'exportTemplate')->name('assets.export.template');
        Route::post('assets/import/csv', 'importCsv')->name('assets.import.csv');
    });

    Route::prefix('companies')->as('companies.')->group(function () {
        Route::resource('{company}/users', EmployeeController::class);
        Route::resource('{company}/locations', LocationController::class);
        Route::resource('{company}/assets', CompanyAssetController::class);
        Route::controller(CompanyAssetController::class)->group(function () {
            Route::get('{company}/assets/export/pdf/{id?}', 'exportCompanyAssetPdf')
            ->name('company-asset.export.pdf');
            Route::get('{company}/assets/compliance/{id?}', 'companyAssetCompliancePdf')
                ->name('company-compliance.asset.pdf');
            Route::get('{company}/assets/grid/compliance/{id?}', 'companyGridCompliancePdf')
                ->name('grid.compliance.pdf');
            Route::get('{company}/assets/detail/compliance/{id?}', 'companyDetailCompliancePdf')
                ->name('detail.compliance.pdf');
            Route::post('{company}/assets/import/csv', 'importCsv')
                ->name('assets.import.csv');
        });
        Route::resource('{company}/asset-types', CompanyAssetTypeController::class);
        Route::resource('{company}/expenses', ExpenseController::class);
        Route::resource('{company}/work-orders', CompanyWorkOrderController::class);
        Route::post('{company}/work-orders/import/csv', [CompanyWorkOrderController::class, 'importCsv'])
            ->name('work-orders.import.csv');
        Route::get('{company}/work-orders/pdf/{id?}', [CompanyWorkOrderController::class, 'exportCompanyWorkOrderPdf'])
            ->name('company-work-orders.export.pdf');
        Route::get('{company}/work-orders/csv/{id?}', [CompanyWorkOrderController::class, 'exportCompanyWorkOrderCsv'])
            ->name('company-work-orders.export.csv');
        Route::get('{company}/work-orders/{asset:id}/create', [
            CompanyWorkOrderController::class, 'assetWorkOrderCreate'
        ])->name('asset.work_order.create');
    });
    Route::resource('companies', CompanyController::class);
    Route::get('work-orders/{asset:id}/create', [
        WorkOrderController::class, 'assetWorkOrderCreate'
    ])->name('asset.work_order.create');
    Route::prefix('reports')->as('reports.')->group(function () {
        Route::get('manage-assets', [ReportController::class, 'manageAssets'])->name('assets');
        Route::get('manage-work-orders', [ReportController::class, 'manageWorkOrders'])->name('work-orders');
        Route::get('manage-companies', [ReportController::class, 'manageCompany'])->name('comapnies');
    });
    Route::post('master/expenses', [ExpenseController:: class, 'masterExpense'])
    ->name('master.expenses.store');
});
Route::post('work-orders/update-bulk-status', [EmployeeWorkOrderController:: class,
'updateBulkStatus'])->name('work-orders.update.bulkStatus');
Route::get('work-orders/check-OrderStatus/{bulkIds}', [EmployeeWorkOrderController:: class,
'checkOrderStatus'])->name('work-orders.check.OrderStatus');
Route::post('work-orders/save-log-time', [EmployeeWorkOrderController:: class, 'saveLogTime'])
    ->name('work-orders.update.log');
Route::patch('work-orders/update-log/{logData}', [EmployeeWorkOrderController:: class, 'updateLogTime'])
    ->name('work-orders.update.log.time');
Route::patch('work-orders/custom-log/{logData}', [EmployeeWorkOrderController:: class, 'customLogTime'])
    ->name('work-orders.custom.log.time');
Route::post('work-orders/additional-task/store', [EmployeeWorkOrderController:: class, 'storeAdditionalTask'])
    ->name('work-orders.additional-task.store');
Route::get('work-orders/additional-task/edit/{id}', [EmployeeWorkOrderController:: class, 'editAdditionalTask'])
    ->name('work-orders.additional-task.edit');
Route::patch('work-orders/additional-task/update/{id}', [EmployeeWorkOrderController:: class, 'updateAdditionalTask'])
    ->name('work-orders.additional-task.update');
Route::delete('work-orders/additional-task/delete/{id}', [EmployeeWorkOrderController:: class, 'deleteAdditionalTask'])
    ->name('work-orders.additional-task.delete');
Route::delete('work-orders/additional-task/delete-comment/{id}/{type}', [EmployeeWorkOrderController:: class,
'deleteCommentAdditionalTask'])
->name('work-orders.additional-task.delete.comment');
Route::get('delete-logs', [DeleteLogController::class, 'index'])->name('delete-logs');
Route::get('company-assets', [AssetController:: class, 'companyAssets'])->name('company-assets');
Route::resource('media', MediaController::class);
Route::get('notification/{id}', [NotificationService::class, 'getNotification'])->name('notification');
Route::get('notifications', [NotificationController::class, 'index'])->name('notifications');
