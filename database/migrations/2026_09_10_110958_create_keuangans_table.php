<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keuangans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();

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

            $table->string('jenis', 30)->index();

            $table->date('tanggal')->index();

            $table->string('kategori', 100)->index();

            $table->string('deskripsi', 255);

            $table->decimal('jumlah', 15, 2);

            $table->string('bukti_path', 500)->nullable();

            $table->string('status', 30)
                ->default('pending')
                ->index();

            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keuangans');
    }
};