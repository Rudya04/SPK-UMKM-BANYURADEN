<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NilaiRankingSheetExport implements FromCollection, WithTitle, WithHeadings, WithColumnWidths, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $bobots;
    protected $response;

    /**
     * @param $bobots
     * @param $response
     */
    public function __construct($bobots, $response)
    {
        $this->bobots = $bobots;
        $this->response = $response;
    }


    public function collection()
    {
        $res = collect();
        foreach ($this->response as $respon) {
            $data = collect();
            $data->push($respon['alternative_name']);
            foreach ($respon['current_criterias'] as $criteria) {
                $data->push($criteria['score']);
            }
            $data->push($respon['score']);
            $data->push($respon['status']);

            $res->push($data);
        }

        return $res;
    }

    public function title(): string
    {
        return 'Nilai Ranking';
    }

    public function headings(): array
    {
        $haeds = collect();
        $haeds->push('Alternative');
        foreach ($this->bobots as $bobot) {
            $haeds->push($bobot->criteria_name);
        }
        $haeds->push('Score');
        $haeds->push('Status');
        return $haeds->toArray();
    }

    public function columnWidths(): array
    {
        return [
            'A' => 50,
        ];
    }

    public function styles(Worksheet $sheet) : array
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
