<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel pengaturan periode RKB & Rehabilitasi — GLOBAL untuk semua sekolah
     * (bukan per-sekolah lagi), cuma admin yang boleh ubah lewat halaman
     * Pengaturan > Periode Laporan. Lihat PeriodeLaporanController.
     */
    public function up(): void
    {
        Schema::create('periode_laporans', function (Blueprint $table) {
            $table->id();
            $table->string('kategori')->unique(); // 'rkb' atau 'rehabilitasi'
            $table->integer('tahun_awal');
            $table->integer('tahun_akhir');
            $table->timestamps();
        });

        // Seed nilai default, mengikuti excel sumber (2026 s.d 2030)
        DB::table('periode_laporans')->insert([
            ['kategori' => 'rkb', 'tahun_awal' => 2026, 'tahun_akhir' => 2030, 'created_at' => now(), 'updated_at' => now()],
            ['kategori' => 'rehabilitasi', 'tahun_awal' => 2026, 'tahun_akhir' => 2030, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periode_laporans');
    }
};
