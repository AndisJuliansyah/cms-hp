<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hpqs', function (Blueprint $table) {
            $table->id();
            $table->string('code_hpq')->unique();
            $table->string('email');
            $table->string('full_name');
            $table->string('brand_name');
            $table->string('contact_number');
            $table->text('address');
            $table->string('customer_type');
            $table->string('coffee_type');
            $table->string('coffee_sample_name');
            $table->string('lot_number');
            $table->integer('total_lot_quantity');
            $table->string('origin');
            $table->string('variety');
            $table->string('altitude');
            $table->string('post_harvest_process');
            $table->date('harvest_date');
            $table->string('green_bean_condition');
            $table->string('sort_before_sending');
            $table->text('specific_goal')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['waiting', 'scoring', 'completed'])->default('waiting');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hpqs');
    }
};
