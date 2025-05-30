<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $articles = [
            [
                'article_category_id' => 1,
                'author_id' => 1,
                'title' => 'Sejarah Kopi',
                'slug' => Str::slug('Sejarah Kopi: Dari Penemuan Hingga Popularitas Global'),
                'excerpt' => 'Mengulas perjalanan kopi dari penemuan hingga menjadi minuman favorit dunia.',
                'body' => 'Kopi pertama kali ditemukan di Ethiopia pada abad ke-9 dan sejak itu menyebar ke berbagai belahan dunia...',
                'seo_title' => 'Sejarah Kopi - Dari Penemuan Sampai Global',
                'seo_description' => 'Pelajari sejarah kopi dan bagaimana kopi menjadi minuman populer di seluruh dunia.',
                'is_published' => true,
                'published_at' => $now->subDays(10),
                'created_at' => $now->subDays(15),
                'updated_at' => $now->subDays(10),
            ],
            [
                'article_category_id' => 1,
                'author_id' => 1,
                'title' => 'Penyeduhan-Kopi',
                'slug' => Str::slug('5 Metode Penyeduhan Kopi yang Wajib Kamu Coba'),
                'excerpt' => 'Berbagai metode seduh kopi yang menghasilkan cita rasa berbeda dan unik.',
                'body' => 'Dari French Press, Pour Over, hingga Espresso, setiap metode penyeduhan memiliki karakteristik khas...',
                'seo_title' => '5 Metode Penyeduhan Kopi Terbaik',
                'seo_description' => 'Temukan metode penyeduhan kopi yang akan meningkatkan pengalaman ngopi kamu.',
                'is_published' => true,
                'published_at' => $now->subDays(8),
                'created_at' => $now->subDays(12),
                'updated_at' => $now->subDays(8),
            ],
            [
                'article_category_id' => 1,
                'author_id' => 1,
                'title' => 'Manfaat-Kesehatan',
                'slug' => Str::slug('Manfaat Kesehatan dari Minum Kopi Setiap Hari'),
                'excerpt' => 'Kopi tidak hanya nikmat, tapi juga memiliki berbagai manfaat kesehatan yang menarik.',
                'body' => 'Kopi mengandung antioksidan dan nutrisi penting yang dapat membantu meningkatkan fungsi otak dan metabolisme...',
                'seo_title' => 'Manfaat Kesehatan Kopi',
                'seo_description' => 'Ketahui berbagai manfaat kopi bagi kesehatan jika dikonsumsi secara rutin.',
                'is_published' => true,
                'published_at' => $now->subDays(5),
                'created_at' => $now->subDays(7),
                'updated_at' => $now->subDays(5),
            ],
            [
                'article_category_id' => 1,
                'author_id' => 1,
                'title' => 'Cara-Memilih-Biji-Kopi-yang-Berkualitas',
                'slug' => Str::slug('Cara Memilih Biji Kopi yang Berkualitas'),
                'excerpt' => 'Tips memilih biji kopi terbaik untuk hasil seduhan maksimal di rumah.',
                'body' => 'Perhatikan asal biji, tingkat roasting, dan aroma biji kopi untuk mendapatkan kualitas terbaik...',
                'seo_title' => 'Tips Memilih Biji Kopi Berkualitas',
                'seo_description' => 'Panduan lengkap memilih biji kopi terbaik untuk hasil seduhan yang nikmat.',
                'is_published' => true,
                'published_at' => $now->subDays(3),
                'created_at' => $now->subDays(4),
                'updated_at' => $now->subDays(3),
            ],
            [
                'article_category_id' => 1,
                'author_id' => 1,
                'title' => 'Tren-Kopi-Kekinian-yang-Populer-di-Tahun-2025',
                'slug' => Str::slug('Tren Kopi Kekinian yang Populer di Tahun 2025'),
                'excerpt' => 'Beragam tren kopi yang sedang digandrungi di tahun 2025, dari cold brew sampai kopi susu gula aren.',
                'body' => 'Di tahun 2025, kopi kekinian seperti cold brew, kopi susu gula aren, dan kopi oat milk menjadi favorit banyak orang...',
                'seo_title' => 'Tren Kopi Kekinian 2025',
                'seo_description' => 'Update tren kopi kekinian terbaru yang wajib kamu coba di tahun 2025.',
                'is_published' => true,
                'published_at' => $now->subDays(1),
                'created_at' => $now->subDays(2),
                'updated_at' => $now->subDays(1),
            ],
        ];

        foreach ($articles as $article) {
            DB::table('articles')->insert($article);
        }
    }
}
