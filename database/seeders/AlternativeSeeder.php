<?php

namespace Database\Seeders;

use App\Models\Alternative;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlternativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('ID_id');

        for ($i = 0; $i < 3; $i++) {
            Alternative::query()->create([
                'user_id' => 1,
                'name' => $faker->name
            ]);
        }
    }
}
