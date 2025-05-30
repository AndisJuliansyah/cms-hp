<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class HpqScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('users')->insert([
            [
                'id' => 2,
                'name' => 'Judge Two',
                'email' => 'judge2@example.com',
                'password' => Hash::make('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'name' => 'Judge Three',
                'email' => 'judge3@example.com',
                'password' => Hash::make('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        DB::table('hpq_scores')->insert([
            [
                'code_hpq' => '0000001-GB',
                'jury_id' => 1,
                'judge_name' => 'Judge One',
                'fragrance_aroma' => 7.5,
                'flavor' => 8.0,
                'aftertaste' => 7.8,
                'acidity' => 7.2,
                'body' => 7.6,
                'balance' => 7.9,
                'uniformity' => 10.0,
                'sweetness' => 10.0,
                'clean_cup' => 10.0,
                'overall' => 8.0,
                'notes' => 'Fruity and balanced',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code_hpq' => '0000001-GB',
                'jury_id' => 2,
                'judge_name' => 'Judge Two',
                'fragrance_aroma' => 7.0,
                'flavor' => 7.8,
                'aftertaste' => 7.5,
                'acidity' => 7.0,
                'body' => 7.3,
                'balance' => 7.5,
                'uniformity' => 10.0,
                'sweetness' => 9.5,
                'clean_cup' => 9.8,
                'overall' => 7.9,
                'notes' => 'Mild acidity with floral aroma',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code_hpq' => '0000001-GB',
                'jury_id' => 3,
                'judge_name' => 'Judge Three',
                'fragrance_aroma' => 8.0,
                'flavor' => 8.3,
                'aftertaste' => 8.1,
                'acidity' => 7.9,
                'body' => 8.0,
                'balance' => 8.2,
                'uniformity' => 10.0,
                'sweetness' => 10.0,
                'clean_cup' => 10.0,
                'overall' => 8.5,
                'notes' => 'Sweet and smooth with chocolate notes',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
