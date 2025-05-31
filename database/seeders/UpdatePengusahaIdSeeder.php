<?php

namespace Database\Seeders;

use App\Enum\RoleEnum;
use App\Models\Alternative;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UpdatePengusahaIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alternatives = Alternative::all();
        $pengId = 4;
        foreach ($alternatives as $alternative) {

            $pengId = $pengId + 1;

            $alternative->update(['user_id' => 1, 'pengusaha_id' => $pengId]);
        }
    }
}
