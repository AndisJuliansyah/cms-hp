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
        Schema::table('hpq_scores', function (Blueprint $table) {
                $table->decimal('defect', 4, 2)->after('overall');
                $table->enum('assesment_fragrance', ['Low', 'Medium', 'High', 'None', '1', '2', '3', '4', '5'])
                    ->nullable()
                    ->after('defect');
                $table->enum('assesment_aroma', ['Low', 'Medium', 'High', 'None', '1', '2', '3', '4', '5'])
                    ->nullable()
                    ->after('assesment_fragrance');

                $table->enum('assesment_flavor', ['Low', 'Medium', 'High', 'None', '1', '2', '3', '4', '5'])
                    ->nullable()
                    ->after('assesment_aroma');

                $table->enum('assesment_Aftertaste', ['Low', 'Medium', 'High', 'None', '1', '2', '3', '4', '5'])
                    ->nullable()
                    ->after('assesment_flavor');

                $table->enum('assesment_Acidity', ['Low', 'Medium', 'High', 'None', '1', '2', '3', '4', '5'])
                    ->nullable()
                    ->after('assesment_aftertaste');

                $table->enum('assesment_sweetness', ['Low', 'Medium', 'High', 'None', '1', '2', '3', '4', '5'])
                    ->nullable()
                    ->after('assesment_acidity');

                $table->enum('assesment_uniformity', ['Low', 'Medium', 'High', 'None', '1', '2', '3', '4', '5'])
                    ->nullable()
                    ->after('assesment_sweetness');
                $table->enum('assesment_body', ['Low', 'Medium', 'High', 'None', '1', '2', '3', '4', '5'])
                    ->nullable()
                    ->after('assesment_uniformity');
                $table->enum('assesment_defect', ['None', 'Moldy', 'Phenolic', 'Potato'])
                    ->nullable()
                    ->after('assesment_body');
                $table->string('fragrance_aroma_notes')->nullable()->after('defect');
                $table->string('flavor_aftertaste_notes')->nullable()->after('fragrance_aroma_notes');
                $table->string('acidity_mouthfeel_other_notes')->nullable()->after('flavor_aftertaste_notes');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hpq_scores', function (Blueprint $table) {
            $table->dropColumn([
                'assesment_fragrance',
                'assesment_aroma',
                'assesment_flavor',
                'assesment_Acidity',
                'assesment_sweetness',
                'assesment_uniformity',
                'assesment_body',
                'assesment_defect',
                'fragrance_aroma_notes',
                'flavor_aftertaste_notes',
                'Acidity_Mouthfeel_other_notes'
            ]);
        });
    }
};
