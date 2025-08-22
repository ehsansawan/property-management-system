<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // تعديل جدول favorites
        Schema::table('favorites', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['ad_id']);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('ad_id')->references('id')->on('ads')->cascadeOnDelete();
        });

        // // تعديل جدول review
        // Schema::table('reviews', function (Blueprint $table) {
        //     $table->dropForeign(['user_id']);
        //     $table->dropForeign(['ad_id']);
        //     $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        //     $table->foreign('ad_id')->references('id')->on('ads')->cascadeOnDelete();
        // });


        Schema::table('reviews', function (Blueprint $table) {
            // Drop the existing indexes (not foreign keys)
            // $table->dropIndex('reviews_user_id_foreign');
            if (Schema::hasColumn('reviews', 'user_id')) {
               $table->dropIndex('reviews_user_id_foreign');
            }

            
            if (Schema::hasColumn('reviews', 'ad_id')) {
                // only drop if an index actually exists
                // if no index, skip this line
                $table->dropIndex('reviews_ad_id_foreign');
            }

            // Add proper foreign keys with cascade delete
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('ad_id')->references('id')->on('ads')->cascadeOnDelete();
        });


        // تعديل جدول subscriptions
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down()
    {
        // التراجع عن تعديل جدول favorites
        Schema::table('favorites', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['ad_id']);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('ad_id')->references('id')->on('ads');
        });

        // // التراجع عن تعديل جدول review
        // Schema::table('review', function (Blueprint $table) {
        //     $table->dropForeign(['user_id']);
        //     $table->dropForeign(['ad_id']);
        //     $table->foreign('user_id')->references('id')->on('users');
        //     $table->foreign('ad_id')->references('id')->on('ads');
        // });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['ad_id']);
            $table->index('user_id', 'reviews_user_id_foreign');
            $table->index('ad_id', 'reviews_ad_id_foreign');
        });


        // التراجع عن تعديل جدول subscriptions
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
};
