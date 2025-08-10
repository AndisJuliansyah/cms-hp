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
        Schema::table('hpqs', function (Blueprint $table) {
            $table->string('fragrance_aroma_notes')->nullable()->after('status');
            $table->string('flavor_aftertaste_notes')->nullable()->after('fragrance_aroma_notes');
            $table->string('acidity_mouthfeel_other_notes')->nullable()->after('flavor_aftertaste_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hpqs', function (Blueprint $table) {
            $table->dropColumn([
                'fragrance_aroma_notes',
                'flavor_aftertaste_notes',
                'Acidity_Mouthfeel_other_notes'
            ]);
        });
    }
};
