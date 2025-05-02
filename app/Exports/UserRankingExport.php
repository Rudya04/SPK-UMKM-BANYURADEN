<?php

namespace App\Exports;

use App\Models\UserRanking;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserRankingExport implements FromArray, WithHeadings, WithStyles
{
    protected $table1;
    protected $table2;
    protected $table3;
    protected $lastRow = 1;

    public function __construct($table1, $table2, $table3)
    {
        $this->table1 = $table1;
        $this->table2 = $table2;
        $this->table3 = $table3;
    }

    public function headings(): array
    {
        return []; // heading per tabel ditaruh langsung di array
    }

    public function array(): array
    {
        $data = [];

        // Tabel 1
        $data[] = ['TABEL 1: USERS'];
        $data[] = ['ID', 'Name', 'Email'];
        foreach ($this->table1 as $user) {
            $data[] = [$user->id, $user->created_at, $user->updated_at];
        }

        $data[] = ['']; // baris kosong pemisah

        // Tabel 2
        $data[] = ['TABEL 2: PRODUCTS'];
        $data[] = ['ID', 'Name', 'Price'];
        foreach ($this->table2 as $product) {
            $data[] = [$product->id, $product->created_at, $product->updated_at];
        }

        $data[] = ['']; // baris kosong pemisah

        // Tabel 3
        $data[] = ['TABEL 3: ORDERS'];
        $data[] = ['ID', 'User ID', 'Total'];
        foreach ($this->table3 as $order) {
            $data[] = [$order->id, $order->created_at, $order->updated_at];
        }

        $this->lastRow = count($data);

        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        // Tentukan area range yang ingin diberi border
        $range = 'A1:C' . $this->lastRow;

        // Terapkan border pada semua cell yang digunakan
        $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Bold untuk judul tabel
        for ($row = 1; $row <= $this->lastRow; $row++) {
            $cellValue = $sheet->getCell('A' . $row)->getValue();
            if (str_contains($cellValue, 'TABEL')) {
                $sheet->getStyle('A' . $row)->getFont()->setBold(true);
            }
        }

        return [];
    }
}
