<?php

namespace Database\Seeders;

use App\Models\Criteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $criterias = [
            ['user_id' => 1, 'name' => 'Kualitas Produk (skor)', 'value' => 2, 'slug' => 'kualitas'],
            ['user_id' => 1, 'name' => 'Omset (juta)', 'value' => 5, 'slug' => 'omset'],
            ['user_id' => 1, 'name' => 'Pengalaman (tahun)', 'value' => 3, 'slug' => 'pengalaman'],
        ];

        foreach ($criterias as $criteria) {
            Criteria::query()->create($criteria);
        }
    }
}
