<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add details column to reports table
        Schema::table('reports', function (Blueprint $table) {
            $table->text('details')->nullable()->after('reason');
        });

        // Add performance indexes
        Schema::table('profiles', function (Blueprint $table) {
            $table->index('is_complete');
            $table->index('prefecture');
            $table->index('last_active_at');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->index('user_id');
        });

        Schema::table('likes', function (Blueprint $table) {
            $table->index('receiver_id');
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('details');
        });

        Schema::table('profiles', function (Blueprint $table) {
            $table->dropIndex(['is_complete']);
            $table->dropIndex(['prefecture']);
            $table->dropIndex(['last_active_at']);
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
        });

        Schema::table('likes', function (Blueprint $table) {
            $table->dropIndex(['receiver_id']);
        });
    }
};
