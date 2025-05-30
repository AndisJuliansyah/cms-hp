<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PartnersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('partners')->insert([
            [
                'name' => 'Partner A',
                'logo' => 'partner_a_logo.png',
                'url' => 'https://partnera.com',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Partner B',
                'logo' => 'partner_b_logo.png',
                'url' => 'https://partnerb.com',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Partner C',
                'logo' => 'partner_c_logo.png',
                'url' => 'https://partnerc.com',
                'is_active' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Partner D',
                'logo' => 'partner_d_logo.png',
                'url' => 'https://partnerd.com',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Partner E',
                'logo' => 'partner_e_logo.png',
                'url' => 'https://partnere.com',
                'is_active' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
