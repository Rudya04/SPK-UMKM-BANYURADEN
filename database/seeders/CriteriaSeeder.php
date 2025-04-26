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
            ['user_id' => 1, 'name' => 'Disiplin', 'value' => 40, 'slug' => 'disiplin'],
            ['user_id' => 1, 'name' => 'Produktivitas', 'value' => 30, 'slug' => 'produktivitas'],
            ['user_id' => 1, 'name' => 'Kreativitas', 'value' => 30, 'slug' => 'kreativitas'],
        ];

        foreach ($criterias as $criteria) {
            Criteria::query()->create($criteria);
        }
    }
}
