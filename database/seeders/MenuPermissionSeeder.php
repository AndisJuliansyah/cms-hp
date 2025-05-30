<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MenuPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('menu_permission')->insert([
            ['menu_id' => 9, 'permission_id' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['menu_id' => 10, 'permission_id' => 18, 'created_at' => $now, 'updated_at' => $now],
            ['menu_id' => 11, 'permission_id' => 30, 'created_at' => $now, 'updated_at' => $now],
            ['menu_id' => 12, 'permission_id' => 34, 'created_at' => $now, 'updated_at' => $now],
            ['menu_id' => 13, 'permission_id' => 38, 'created_at' => $now, 'updated_at' => $now],
            ['menu_id' => 14, 'permission_id' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['menu_id' => 15, 'permission_id' => 22, 'created_at' => $now, 'updated_at' => $now],
            ['menu_id' => 16, 'permission_id' => 6, 'created_at' => $now, 'updated_at' => $now],
            ['menu_id' => 17, 'permission_id' => 10, 'created_at' => $now, 'updated_at' => $now],
            ['menu_id' => 18, 'permission_id' => 14, 'created_at' => $now, 'updated_at' => $now],
            ['menu_id' => 19, 'permission_id' => 42, 'created_at' => $now, 'updated_at' => $now],
            ['menu_id' => 20, 'permission_id' => 29, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
