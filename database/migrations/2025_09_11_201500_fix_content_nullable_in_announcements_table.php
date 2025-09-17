<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('announcements')) {
            if (Schema::hasColumn('announcements', 'content')) {
                // Make existing content column nullable (no DBAL dependency, use raw SQL)
                DB::statement("ALTER TABLE announcements MODIFY content TEXT NULL");
            } else {
                Schema::table('announcements', function (Blueprint $table) {
                    $table->text('content')->nullable()->after('description');
                });
            }
        }
    }

    public function down(): void
    {
        // No-op: we won't make the column NOT NULL again to avoid data loss
    }
};


