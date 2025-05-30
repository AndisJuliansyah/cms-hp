<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ArticleCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('article_categories')->insert([
            [
                'name' => 'Edukasi',
                'slug' => Str::slug('Edukasi'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Berita',
                'slug' => Str::slug('Berita'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Resep',
                'slug' => Str::slug('Resep'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
