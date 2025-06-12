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
        Schema::create('lands', function (Blueprint $table) {
            $table->id();
          //  $table->foreignId('property_id')->constrained('properties');
            $table->enum('type',['industrial','agricultural','commercial','residential'])->nullable();//(تجاري , سكني , زراعي ,صناعي)
            $table->boolean('is_inside_master_plan')->default(false);// داخل مخطط تنظيمي
            $table->boolean('is_serviced')->default(false);
            $table->enum('slope', ['flat', 'sloped', 'mountainous'])->nullable();//['مستوية','منحدرة','جبلية']
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lands');
    }
};
