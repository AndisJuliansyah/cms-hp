<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ArticleImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('article_images')->insert([
            [
                'article_id' => 1,
                'image_path' => 'articles/article1_img1.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'article_id' => 1,
                'image_path' => 'articles/article1_img2.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'article_id' => 2,
                'image_path' => 'articles/article2_img1.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'article_id' => 3,
                'image_path' => 'articles/article3_img1.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'article_id' => 3,
                'image_path' => 'articles/article3_img2.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
