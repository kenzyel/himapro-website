<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengumumans', function (Blueprint $table) {
            if (! Schema::hasColumn('pengumumans', 'is_published')) {
                $table->boolean('is_published')
                    ->default(false)
                    ->after('status')
                    ->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('pengumumans', function (Blueprint $table) {
            if (Schema::hasColumn('pengumumans', 'is_published')) {
                $table->dropColumn('is_published');
            }
        });
    }
};