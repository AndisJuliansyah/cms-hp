<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ApiClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('api_clients')->insert([
            [
                'name' => 'Website',
                'public_key' => '9d8846c1-5514-4551-a262-c584be303c9c',
                'secret_key' => 'c3c8WUTT3lVhbz4OQYTshkk5bAF2VQ0cLM0jCd96s23XG3yqrdn9tV23pvp1QTSn',
                'allowed_domains' => 'heavenlypour.com',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
