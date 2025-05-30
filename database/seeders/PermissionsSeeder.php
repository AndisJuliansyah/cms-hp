<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timestamp = Carbon::now();
        $permissions = [];

        // Hanya satu permission untuk dashboard
        $permissions[] = [
            'name' => 'manage dashboard',
            'guard_name' => 'web',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ];

        // Menu lain
        $menus = [
            'articles', 'events', 'hpqs', 'hpqscores', 'users',
            'articles category', 'partners', 'roles', 'permissions',
            'menus', 'apiclients'
        ];

        $actions = ['manage', 'create', 'edit', 'delete'];

        foreach ($menus as $menu) {
            foreach ($actions as $action) {
                $permissions[] = [
                    'name' => "$action $menu",
                    'guard_name' => 'web',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
            }
        }

        DB::table('permissions')->insert($permissions);
    }
}
