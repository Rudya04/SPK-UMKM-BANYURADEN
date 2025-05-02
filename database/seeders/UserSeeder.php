<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::query()->create([
            "name" => "Admin",
            "email" => "admin@gmail.com",
            "password" => Hash::make("admin"),
            "is_admin" => true,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        $admin->assignRole('admin');
    }
}
