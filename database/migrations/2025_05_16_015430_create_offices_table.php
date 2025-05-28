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
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
         //   $table->foreignId('property_id')->constrained('properties');
            $table->smallInteger('floor');
            $table->smallInteger('rooms');
            $table->smallInteger('bathrooms');
            $table->smallInteger('meeting_rooms')->default(0);
            $table->boolean('has_parking')->default(false);
            $table->boolean('furnished');
            $table->string('furnished_type')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offices');
    }
};
