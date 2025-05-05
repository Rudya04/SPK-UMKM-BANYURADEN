<?php

namespace Database\Seeders;

use App\Models\Criteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subCriterias = [
            [
                [
                    'name' => 'Kualitas Produk 1',
                    'value' => 80,
                ],
                [
                    'name' => 'Kualitas Produk 2',
                    'value' => 90,
                ],
                [
                    'name' => 'Kualitas Produk 3',
                    'value' => 70,
                ]
            ],
            [
                [
                    'name' => 'Omset 1',
                    'value' => 50,
                ],
                [
                    'name' => 'Omset 2',
                    'value' => 60,
                ],
                [
                    'name' => 'Omset 3',
                    'value' => 40,
                ]
            ],
            [
                [
                    'name' => 'Pengalaman 1',
                    'value' => 4,
                ],
                [
                    'name' => 'Pengalaman 2',
                    'value' => 3,
                ],
                [
                    'name' => 'Pengalaman 3',
                    'value' => 5,
                ]
            ]
        ];
        $i = 0;
        foreach (Criteria::query()->orderBy('id')->get() as $criteria) {
            $criteria->subCriterias()->createMany($subCriterias[$i]);
            $i++;
        }
    }
}
