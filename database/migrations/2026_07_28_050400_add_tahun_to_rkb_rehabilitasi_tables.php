<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tambah kolom tahun_awal & tahun_akhir supaya periode RKB/Rehabilitasi
     * bisa diubah admin langsung dari form, tidak hardcode di kode.
     */
    public function up(): void
    {
        Schema::table('ruang_kelas_barus', function (Blueprint $table) {
            $table->integer('tahun_awal')->default(2020)->after('jumlah');
            $table->integer('tahun_akhir')->default(2025)->after('tahun_awal');
        });

        Schema::table('rehabilitasi_ruang_kelas', function (Blueprint $table) {
            $table->integer('tahun_awal')->default(2020)->after('jumlah');
            $table->integer('tahun_akhir')->default(2025)->after('tahun_awal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ruang_kelas_barus', function (Blueprint $table) {
            $table->dropColumn(['tahun_awal', 'tahun_akhir']);
        });

        Schema::table('rehabilitasi_ruang_kelas', function (Blueprint $table) {
            $table->dropColumn(['tahun_awal', 'tahun_akhir']);
        });
    }
};
