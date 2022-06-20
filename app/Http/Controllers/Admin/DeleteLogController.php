<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DeleteLogController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.delete-logs.index');
    }
}
