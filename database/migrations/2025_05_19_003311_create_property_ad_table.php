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
        Schema::create('property_ad', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_id')->constrained('ads');
            $table->foreignId('property_id')->constrained('properties');
            // we have to add a price column for the property
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_ad');
    }
};
