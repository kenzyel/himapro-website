<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengurus', function (Blueprint $table) {
            if (! Schema::hasColumn('pengurus', 'is_bph')) {
                $table->boolean('is_bph')
                    ->default(false)
                    ->after('parent_id')
                    ->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('pengurus', function (Blueprint $table) {
            if (Schema::hasColumn('pengurus', 'is_bph')) {
                $table->dropColumn('is_bph');
            }
        });
    }
};