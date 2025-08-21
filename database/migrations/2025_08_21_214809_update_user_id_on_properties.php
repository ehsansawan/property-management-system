<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            // إذا فيه FK بنفس الاسم ممكن يكون مسجل، نحاول نحذفه احتياطيًا
            $table->dropForeign(['user_id']); // هذا يحذف أي FK مربوط بالعمود

            // نرجع نضيف FK صحيح مع ON DELETE CASCADE
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropForeign(['user_id']);

            // نرجع بدون cascade (الوضع القديم كان مجرد key مش FK، بس من باب التراجع نخليه هيك)
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }
};
