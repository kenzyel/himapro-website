<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengumumans', function (Blueprint $table) {
            if (! Schema::hasColumn('pengumumans', 'ringkasan')) {
                $table->string('ringkasan', 500)->nullable()->after('slug');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pengumumans', function (Blueprint $table) {
            if (Schema::hasColumn('pengumumans', 'ringkasan')) {
                $table->dropColumn('ringkasan');
            }
        });
    }
};