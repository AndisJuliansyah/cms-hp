<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class HpqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('hpqs')->insert([
            'code_hpq' => '0000001-GB',
            'email' => 'user@example.com',
            'full_name' => 'John Doe',
            'brand_name' => 'Coffee Brand',
            'contact_number' => '+628123456789',
            'address' => 'Jl. Kopi No. 123, Jakarta',
            'customer_type' => 'Retail',
            'coffee_type' => 'Arabica',
            'coffee_sample_name' => 'Sample A',
            'lot_number' => 'LOT12345',
            'total_lot_quantity' => 100,
            'origin' => 'Indonesia',
            'variety' => 'Typica',
            'altitude' => '1200m',
            'post_harvest_process' => 'Washed',
            'harvest_date' => '2025-05-01',
            'green_bean_condition' => 'Good',
            'sort_before_sending' => 'Yes',
            'specific_goal' => 'Achieve high cup score',
            'notes' => 'Sample notes about this HPQ',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
