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
        Schema::create('hpq_scores', function (Blueprint $table) {
            $table->id();
            $table->string('code_hpq', 20);
            $table->foreignId('jury_id')->constrained('users')->onDelete('cascade');
            $table->string('judge_name');
            $table->decimal('fragrance_aroma', 4, 2);
            $table->decimal('flavor', 4, 2);
            $table->decimal('aftertaste', 4, 2);
            $table->decimal('acidity', 4, 2);
            $table->decimal('body', 4, 2);
            $table->decimal('balance', 4, 2);
            $table->decimal('uniformity', 4, 2);
            $table->decimal('sweetness', 4, 2);
            $table->decimal('clean_cup', 4, 2);
            $table->decimal('overall', 4, 2);
            $table->text('notes')->nullable();
            $table->foreign('code_hpq')->references('code_hpq')->on('hpqs')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['code_hpq', 'jury_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hpq_scores');
    }
};
