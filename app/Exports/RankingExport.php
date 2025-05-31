<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RankingExport implements WithMultipleSheets
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected array $normalization;
    protected $bobots;
    protected $response;

    /**
     * @param array $normalization
     * @param $bobots
     * @param $response
     */
    public function __construct(array $normalization, $bobots, $response)
    {
        $this->normalization = $normalization;
        $this->bobots = $bobots;
        $this->response = $response;
    }


    public function sheets(): array
    {
        return [
            new NilaiBobotSheetExport($this->normalization),
            new NilaiDasarSheetExport($this->bobots, $this->response),
            new NilaiRankingSheetExport($this->bobots, $this->response),
        ];
    }
}
