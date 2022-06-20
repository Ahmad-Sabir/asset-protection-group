<?php

use App\Http\Controllers\Admin\Notification\NotificationController;
use App\Http\Controllers\Employee\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\WorkOrder\WorkOrderController;
use App\Http\Controllers\Admin\Company\ExpenseController;

Route::group(['middleware' => ['role:' . config('apg.user_status.employee')]], function () {
    Route::get('/', function () {
        return view('employee.workorder.index');
    })->name('work-orders');

    Route::get('/work-orders', [WorkOrderController::class, 'index'])->name('work-orders.index');
    Route::get('/work-orders/{id}', [WorkOrderController::class, 'show'])->name('work-orders.show');
    Route::get('/update-profile', [ProfileController::class, 'getProfile'])->name('get-profile');
    Route::put('/update-profile/{id}', [ProfileController::class, 'updateProfile'])->name('update-profile');
    Route::get('work-orders/export/pdf/{id}', [WorkOrderController::class, 'exportWorkOrderPdf'])
        ->name('work-orders.export.pdf');
    Route::get('work-orders/export/csv/{id}', [WorkOrderController::class, 'exportWorkOrderCsv'])
        ->name('work-orders.export.csv');
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::post('expenses/employee-expense/{company}', [ExpenseController:: class, 'employeeExpense'])
    ->name('expenses.store');
});
