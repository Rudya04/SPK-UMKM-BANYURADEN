<?php

namespace Database\Seeders;

use App\Models\CurrentAlternative;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddPengusahIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentAlternatives = CurrentAlternative::with(['alternative'])->get();

        foreach ($currentAlternatives as $alternative) {
            $alternative->update([
                'pengusaha_id' => $alternative->alternative->pengusaha_id
            ]);
        }
    }
}
