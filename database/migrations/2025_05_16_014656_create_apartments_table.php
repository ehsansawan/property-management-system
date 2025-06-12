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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
         //   $table->foreignId('property_id')->constrained('properties');
            $table->smallInteger('floor');
            $table->smallInteger('rooms');
            $table->smallInteger('bedrooms');
            $table->smallInteger('bathrooms');
            $table->boolean('has_elevator')->default(false);
            $table->boolean('has_alternative_power')->default(false);
            $table->boolean('has_garage')->default(false);
            $table->boolean('furnished')->default(false);
            $table->string('furnished_type');// deluxe ,super deluxe , normal;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
