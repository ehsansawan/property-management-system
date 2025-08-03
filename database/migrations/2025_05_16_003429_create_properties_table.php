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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
           // $table->foreignId('location_id')->constrained('locations');
            $table->decimal('area',15,2)->nullable();
            $table->decimal('price')->nullable(); // we should delete it from here
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('propertyable_id')->nullable();
            $table->string('propertyable_type')->nullable();
            $table->boolean('is_ad')->default(0);
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('address')->nullable();
            $table->date('deleted_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
