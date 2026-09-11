<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesans', function (Blueprint $table) {
            $table->id();

            $table->string('nama', 255)->index();
            $table->string('email', 255)->index();
            $table->string('telepon', 50)->nullable();

            $table->string('subjek', 255);

            $table->longText('pesan');

            $table->string('status', 30)
                ->default('unread')
                ->index();

            $table->timestamp('dibaca_at')->nullable();
            $table->timestamp('dibalas_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesans');
    }
};