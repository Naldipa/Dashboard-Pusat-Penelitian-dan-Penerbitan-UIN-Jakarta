<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('penelitians', function (Blueprint $table) {
            $table->string('nama_jurnal')->nullable()->after('judul');
            $table->string('klaster')->nullable()->after('nama_jurnal');
            $table->integer('biaya_insentif')->nullable()->after('klaster');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penelitians', function (Blueprint $table) {
            $table->dropColumn([
                'nama_jurnal',
                'klaster',
                'biaya_insentif',
            ]);
        });
    }
};
