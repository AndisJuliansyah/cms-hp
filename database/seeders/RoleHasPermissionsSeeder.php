<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleHasPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        for ($i = 1; $i <= 45; $i++) {
            $data[] = [
                'permission_id' => $i,
                'role_id' => 1,
            ];
        }

        DB::table('role_has_permissions')->insert($data);
    }
}
