<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_references', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('penulis')->nullable();
            $table->text('isbn')->nullable();
            $table->text('e_isbn')->nullable();
            $table->longText('editor')->nullable();
            $table->longText('deskripsi')->nullable();
            $table->integer('tahun')->nullable();
            $table->text('naskah_link')->nullable();
            $table->string('cover')->nullable();
            $table->integer('jumlah_halaman')->nullable();
            $table->string('status')->default('Draft');
            $table->longText('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_references');
    }
};
