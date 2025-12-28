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
            $table->string('fakultas')->nullable();
            $table->string('penulis_utama');
            $table->string('anggota_penulis')->nullable();
            $table->string('penulis_dua')->nullable();
            $table->string('penulis_tiga')->nullable();
            $table->string('jabatan')->nullable();
            $table->integer('tahun');
            $table->string('status')->nullable();
            $table->text('abstrak')->nullable();
            $table->string('file_path')->nullable();
            $table->string('id_register')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penelitians');
    }
};
