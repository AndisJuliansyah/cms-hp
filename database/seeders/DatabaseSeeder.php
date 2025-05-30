<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            MenuSeeder::class,
            PermissionsSeeder::class,
            MenuPermissionSeeder::class,
            RoleSeeder::class,
            RoleHasPermissionsSeeder::class,
            ApiClientSeeder::class,
            EventSeeder::class,
            PartnersSeeder::class,
            ArticleCategoriesSeeder::class,
            UsersSeeder::class,
            ArticlesSeeder::class,
            ArticleImagesSeeder::class,
            HpqSeeder::class,
            HpqScoreSeeder::class,
        ]);
    }
}
