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
            $table->text('judul'); // Judul Buku (Can be long)
            $table->string('penulis'); // Penulis
            $table->string('isbn')->nullable(); // ISBN
            $table->string('e_isbn')->nullable(); // E-ISBN
            $table->string('isbn_fk')->nullable(); // ISBN FK
            $table->string('e_isbn_fk')->nullable(); // E-ISBN FK
            $table->string('editor')->nullable(); // Editor
            $table->longText('deskripsi')->nullable(); // Deskripsi Buku
            $table->integer('tahun')->nullable(); // Tahun
            $table->text('naskah_link')->nullable(); // Naskah Buku (Link PDF)
            $table->string('cover')->nullable(); // Cover
            $table->integer('jumlah_halaman')->nullable(); // Jumlah Halaman
            $table->string('status')->default('Draft'); // Status
            $table->string('keterangan')->nullable(); // Keterangan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_references');
    }
};
