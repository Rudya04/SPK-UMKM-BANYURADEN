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
          'criteria.lihat', 'criteria.tambah', 'criteria.ubah', 'criteria.hapus',
          'subcriteria.lihat', 'subcriteria.tambah', 'subcriteria.ubah', 'subcriteria.hapus',
          'alternative.lihat', 'alternative.tambah', 'alternative.ubah', 'alternative.hapus',
          'ranking.lihat', 'ranking.tambah', 'ranking.ubah', 'ranking.hapus',
          'guide.lihat', 'guide.tambah', 'guide.ubah', 'guide.hapus',
          'flow.lihat', 'flow.tambah', 'flow.ubah', 'flow.hapus',
          'user.lihat', 'user.tambah', 'user.ubah', 'user.hapus',
          'setting.lihat', 'setting.tambah', 'setting.ubah', 'setting.hapus',
        ];

        foreach ($permissons as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
