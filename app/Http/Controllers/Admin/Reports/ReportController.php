<?php

namespace App\Http\Controllers\Admin\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    /**
     * Display a listing of the asset reports.
     * @return \Illuminate\View\View
     */
    public function manageAssets()
    {
        return view('admin.reports.assets');
    }

    /**
     * Display a listing of the asset reports.
     * @return \Illuminate\View\View
     */
    public function manageWorkOrders()
    {
        return view('admin.reports.work-orders');
    }

    /**
     * Display a listing of the asset reports.
     * @return \Illuminate\View\View
     */
    public function manageCompany()
    {
        return view('admin.reports.companies');
    }
}
