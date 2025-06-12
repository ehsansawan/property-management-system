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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();

            $table->smallInteger('floor');
            $table->enum('type', ['retail', 'grocery', 'pharmacy', 'bookstore', 'restaurant', 'salon', 'other']);
            $table->boolean('has_warehouse')->default(false);
            $table->boolean('has_bathroom')->default(false);
            $table->boolean('has_ac')->default(false);
           // $table->boolean('is_ready')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
