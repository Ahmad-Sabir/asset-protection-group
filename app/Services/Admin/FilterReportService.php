<?php

namespace App\Services\Admin;

use App\Models\FilterReport;

class FilterReportService
{
    public function __construct(
        protected FilterReport $filterReport,
    ) {
    }

    /**
     * save filters
     *
     * @param array $data
     * @return mixed
     */
    public function store($data)
    {
        FilterReport::create($data);
    }
}
