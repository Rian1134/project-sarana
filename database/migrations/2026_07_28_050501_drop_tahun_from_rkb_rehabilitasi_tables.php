<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Kolom tahun_awal/tahun_akhir dipindah dari per-sekolah (tabel ini)
     * ke satu tabel global 'periode_laporans' — lihat migration
     * create_periode_laporans_table.
     */
    public function up(): void
    {
        Schema::table('ruang_kelas_barus', function (Blueprint $table) {
            $table->dropColumn(['tahun_awal', 'tahun_akhir']);
        });

        Schema::table('rehabilitasi_ruang_kelas', function (Blueprint $table) {
            $table->dropColumn(['tahun_awal', 'tahun_akhir']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ruang_kelas_barus', function (Blueprint $table) {
            $table->integer('tahun_awal')->default(2026)->after('jumlah');
            $table->integer('tahun_akhir')->default(2030)->after('tahun_awal');
        });

        Schema::table('rehabilitasi_ruang_kelas', function (Blueprint $table) {
            $table->integer('tahun_awal')->default(2026)->after('jumlah');
            $table->integer('tahun_akhir')->default(2030)->after('tahun_awal');
        });
    }
};
