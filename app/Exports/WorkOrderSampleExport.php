<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WorkOrderSampleExport implements FromArray, WithHeadings
{
    /**
     * @return array
     */
    public function array(): array
    {
        return [];
    }

    public function headings(): array
    {
        return [
            [
                'Work Order Title',
                'Work Order Description',
                'Work Order Additional Information',
                'Work Order Priority',
                'Asset Type',
                'Asset',
                'Assigned Employee Email',
                'Work Order Type',
                'Work Order Frequency',
                'Due Date',
            ],
            [
                'Work Order Test',
                'Description will be here',
                'Notes will be here',
                'Low',
                'Electronics',
                'Laptop',
                'tesat@user.com',
                implode(' & ', config('apg.work_order_type')),
                implode(' & ', config('apg.frequency')),
                '03-20-2022',
            ],
        ];
    }
}
