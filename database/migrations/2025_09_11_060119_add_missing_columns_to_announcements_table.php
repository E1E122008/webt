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
        Schema::table('announcements', function (Blueprint $table) {
            if (!Schema::hasColumn('announcements', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('announcements', 'announcement_date')) {
                $table->date('announcement_date');
            }
            if (!Schema::hasColumn('announcements', 'announcement_time')) {
                $table->time('announcement_time')->nullable();
            }
            if (!Schema::hasColumn('announcements', 'location')) {
                $table->string('location')->nullable();
            }
            if (!Schema::hasColumn('announcements', 'priority')) {
                $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            }
            if (!Schema::hasColumn('announcements', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
            if (!Schema::hasColumn('announcements', 'sort_order')) {
                $table->integer('sort_order')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn(['description', 'announcement_date', 'announcement_time', 'location', 'priority', 'is_active', 'sort_order']);
        });
    }
};
