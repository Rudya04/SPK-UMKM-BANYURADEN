<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissons = [
          'dashboard.lihat', 'dashboard.tambah', 'dashboard.ubah', 'dashboard.hapus',
          'setting.lihat', 'setting.tambah', 'setting.ubah', 'setting.hapus',
        ];

        foreach ($permissons as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
