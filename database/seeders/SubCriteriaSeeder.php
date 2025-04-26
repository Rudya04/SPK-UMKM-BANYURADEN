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
                    'name' => 'Displin 1',
                    'value' => 80,
                ],
                [
                    'name' => 'Displin 2',
                    'value' => 90,
                ],
                [
                    'name' => 'Displin 3',
                    'value' => 85,
                ]
            ],
            [
                [
                    'name' => 'Produktivitas 1',
                    'value' => 75,
                ],
                [
                    'name' => 'Produktivitas 2',
                    'value' => 65,
                ],
                [
                    'name' => 'Produktivitas 3',
                    'value' => 80,
                ]
            ],
            [
                [
                    'name' => 'Kreativitas 1',
                    'value' => 70,
                ],
                [
                    'name' => 'Kreativitas 2',
                    'value' => 80,
                ],
                [
                    'name' => 'Kreativitas 3',
                    'value' => 60,
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
