<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssetSampleExport implements FromArray, WithHeadings
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
                'Name',
                'Asset Type',
                'Asset Model Name',
                'Asset Manufacturer',
                'Asset Installation Date',
                'Asset Replacement Cost',
                'Location Name',
                'Latitude',
                'Longitude',
                'Purchase Date',
                'Purchase Price',
                'Warranty Expiration',
                'Total Useful Life',
            ],
            [
                'Laptop',
                'Chlor-Scale 150, Serial No FF55225',
                'Model 4D400',
                'Force Flow',
                '03-18-2022',
                '100',
                'Facility A',
                '1.033456666',
                '1.033456666',
                '03-20-2022',
                '100',
                '03-30-2022',
                'Y-M-D',
            ],
        ];
    }
}
