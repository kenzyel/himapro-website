<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notulensis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->string('judul', 255);

            $table->dateTime('tanggal')->index();

            $table->string('tempat', 255)->nullable();

            $table->text('agenda')->nullable();
            $table->text('peserta')->nullable();

            $table->longText('isi');

            $table->string('file_path', 500)->nullable();

            $table->string('status', 30)
                ->default('draft')
                ->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notulensis');
    }
};