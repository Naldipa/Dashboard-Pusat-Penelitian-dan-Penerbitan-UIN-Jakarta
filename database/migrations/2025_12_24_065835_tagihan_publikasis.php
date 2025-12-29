<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tagihan_publikasis', function (Blueprint $table) {
            $table->id();
            $table->string('no_reg')->nullable(); // From "No_Reg"
            $table->text('judul');
            $table->string('ketua'); // From "Ketua"
            $table->string('fakultas')->nullable();
            $table->string('kategori')->nullable();
            $table->string('artikel_jurnal')->nullable()->default('belum ada');
            $table->string('proceeding')->nullable()->default('belum ada');
            $table->string('haki')->nullable()->default('belum ada');
            $table->string('buku')->nullable()->default('belum ada');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihan_publikasis');
    }
};
