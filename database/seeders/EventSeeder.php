<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [];

        for ($i = 1; $i <= 10; $i++) {
            $title = "Event Title $i";
            $slug = Str::slug($title);
            $location = "Location $i";
            $description = "This is the description for event $i.";
            $seo_title = "SEO Title for event $i";
            $seo_description = "SEO description for event $i";
            $poster_path = "posters/event_$i.jpg";
            $event_date = Carbon::now()->addDays($i); // Event date bertambah 1 hari per event
            $is_published = ($i % 2 == 0); // Publish genap true, ganjil false
            $created_at = Carbon::now()->subDays(30 - $i); // Created_at beda-beda
            $updated_at = Carbon::now()->subDays(15 - $i);

            $events[] = [
                'title' => $title,
                'slug' => $slug,
                'location' => $location,
                'description' => $description,
                'seo_title' => $seo_title,
                'seo_description' => $seo_description,
                'poster_path' => $poster_path,
                'event_date' => $event_date,
                'is_published' => $is_published,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ];
        }

        DB::table('events')->insert($events);
    }
}
