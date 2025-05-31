<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NilaiBobotSheetExport implements FromCollection, WithTitle,WithHeadings, WithColumnWidths, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected array $normalizations;

    /**
     * @param array $normalizations
     */
    public function __construct(array $normalizations)
    {
        $this->normalizations = $normalizations;
    }


    public function collection()
    {
        return collect($this->normalizations);
    }

    public function title(): string
    {
        return 'Nilai Bobot';
    }

    public function headings(): array
    {
        return ['Nama', 'Nilai', 'Nilai Bobot'];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 50,
            'B' => 10,
            'C' => 10,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                ]
            ],
        ];
    }
}
