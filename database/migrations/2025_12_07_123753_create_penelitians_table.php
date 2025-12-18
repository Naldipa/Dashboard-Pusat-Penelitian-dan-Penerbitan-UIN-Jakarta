<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penelitians', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('fakultas');
            $table->string('penulis_utama');
            $table->string('anggota_penulis')->nullable(); // bisa kosong
            $table->integer('tahun'); // 2021–2025
            $table->string('status')->nullable(); // contoh: "Selesai", "Proses", dll
            $table->text('abstrak')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penelitians');
    }
};
