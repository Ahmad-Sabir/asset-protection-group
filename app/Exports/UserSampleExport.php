<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserSampleExport implements FromArray, WithHeadings
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
            'First Name',
            'Last Name',
            'Email'
        ];
    }
}
