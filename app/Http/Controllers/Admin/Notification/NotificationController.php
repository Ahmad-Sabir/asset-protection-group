<?php

namespace App\Http\Controllers\Admin\Notification;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function __construct()
    {
        # code...
    }

    /**
     * Display a listing of notifications.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.notification.index');
    }
}
