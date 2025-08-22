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
        Schema::table('favorites', function (Blueprint $table) {
        
            if (Schema::hasColumn('favorites', 'property_id')) {
                $table->dropForeign(['property_id']);
                $table->dropColumn('property_id');
            }

            
            if (!Schema::hasColumn('favorites', 'ad_id')) {
                $table->foreignId('ad_id')
                      ->constrained('ads')
                      ->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('favorites', function (Blueprint $table) {
            if (Schema::hasColumn('favorites', 'ad_id')) {
                $table->dropForeign(['ad_id']);
                $table->dropColumn('ad_id');
            }

            if (!Schema::hasColumn('favorites', 'property_id')) {
                $table->foreignId('property_id')
                      ->constrained('properties')
                      ->after('id');
            }
        });
    }
};
