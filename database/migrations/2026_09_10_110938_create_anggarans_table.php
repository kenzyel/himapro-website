<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggarans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('departemen_id')
                ->nullable()
                ->constrained('departemens')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('program_kerja_id')
                ->nullable()
                ->constrained('program_kerjas')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->string('nama', 255);

            $table->string('periode', 20)->index();

            $table->decimal('jumlah', 15, 2);

            $table->string('status', 30)
                ->default('draft')
                ->index();

            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggarans');
    }
};