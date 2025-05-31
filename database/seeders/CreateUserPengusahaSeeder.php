<?php

namespace Database\Seeders;

use App\Enum\RoleEnum;
use App\Models\Alternative;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateUserPengusahaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $alternatives = Alternative::all();
        foreach ($alternatives as $alternative) {
            $password = Str::random(12);

            $umkm = User::query()->create([
                "name" => $alternative->name,
                "email" => $faker->unique()->safeEmail,
                "password" => Hash::make($password),
                "is_admin" => false,
                "created_at" => now(),
                "updated_at" => now(),
                "password_text" => $password,
            ]);

            $umkm->assignRole(RoleEnum::PENGUSAHA->value);

            $alternative->update(['pengusaha_id' => $umkm->id]);
        }
    }
}
