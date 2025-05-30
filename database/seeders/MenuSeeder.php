<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menus')->insert([
            [
                'id' => 9,
                'name' => 'Dashboard',
                'route' => 'filament.admin.pages.dashboard',
                'icon' => 'heroicon-o-home',
                'parent_id' => null,
                'order' => 1,
                'group' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'name' => 'Users',
                'route' => 'filament.admin.resources.users.index',
                'icon' => 'heroicon-o-users',
                'parent_id' => null,
                'order' => 2,
                'group' => 'Master Data',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 11,
                'name' => 'Roles',
                'route' => 'filament.admin.resources.roles.index',
                'icon' => 'heroicon-o-shield-check',
                'parent_id' => null,
                'order' => 3,
                'group' => 'Management Sistem',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 12,
                'name' => 'Permisions',
                'route' => 'filament.admin.resources.permissions.index',
                'icon' => 'heroicon-o-question-mark-circle',
                'parent_id' => null,
                'order' => 4,
                'group' => 'Management Sistem',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 13,
                'name' => 'Menus',
                'route' => 'filament.admin.resources.menus.index',
                'icon' => 'heroicon-o-clipboard-document-list',
                'parent_id' => null,
                'order' => 5,
                'group' => 'Management Sistem',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 14,
                'name' => 'Articles',
                'route' => 'filament.admin.resources.articles.index',
                'icon' => 'heroicon-o-document-text',
                'parent_id' => null,
                'order' => 6,
                'group' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 15,
                'name' => 'Categories Articles',
                'route' => 'filament.admin.resources.article-categories.index',
                'icon' => 'heroicon-o-folder',
                'parent_id' => null,
                'order' => 7,
                'group' => 'Master Data',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 16,
                'name' => 'Events',
                'route' => 'filament.admin.resources.events.index',
                'icon' => 'heroicon-o-calendar-days',
                'parent_id' => null,
                'order' => 8,
                'group' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 17,
                'name' => 'Hpqs',
                'route' => 'filament.admin.resources.hpqs.index',
                'icon' => 'heroicon-o-document-text',
                'parent_id' => null,
                'order' => 9,
                'group' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 18,
                'name' => 'Hpq Scores',
                'route' => 'filament.admin.resources.hpq-scores.index',
                'icon' => 'heroicon-o-chart-bar',
                'parent_id' => null,
                'order' => 10,
                'group' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 19,
                'name' => 'Api Services',
                'route' => 'filament.admin.resources.api-clients.index',
                'icon' => 'heroicon-o-key',
                'parent_id' => null,
                'order' => 11,
                'group' => 'Management Sistem',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 20,
                'name' => 'Partners',
                'route' => 'filament.admin.resources.partners.index',
                'icon' => 'heroicon-o-link',
                'parent_id' => null,
                'order' => 12,
                'group' => 'Master Data',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
