<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Digabung dari seluruh migration sarana prasarana:
     * saranas (tabel utama), pagar_sekolahs, air_bersihs,
     * kursi/meja siswa & guru, laptop, komputer,
     * jumlah siswa & rombel, ruang kelas s.d lapangan sekolah,
     * ruang_kelas_barus, rehabilitasi_ruang_kelas.
     */
    public function up(): void
    {
        // ============================================
        // TABEL UTAMA: SARANAS
        // ============================================
        Schema::create('saranas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah');
            $table->string('NPSN')->unique();
            $table->string('alamat_sekolah');
            $table->string('nama_kepala_sekolah');
            $table->string('NIP')->unique();
            $table->string('nomor_hp')->unique();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        // ============================================
        // 1. PAGAR SEKOLAH
        // ============================================
        Schema::create('pagar_sekolahs', function (Blueprint $table) {
            $table->id();
            $table->enum('ada/tidak_ada', ['ada', 'tidak_ada']);
            $table->enum('kodisi', ['baik', 'rusak', 'nihil']);
            $table->unsignedBigInteger('sarana_id');
            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
            $table->timestamps();
        });

        // ============================================
        // 2. AIR BERSIH
        // ============================================
        Schema::create('air_bersihs', function (Blueprint $table) {
            $table->id();
            $table->enum('ada/tidak_ada', ['ada', 'tidak_ada']);
            $table->enum('kodisi', ['baik', 'rusak', 'nihil']);
            $table->unsignedBigInteger('sarana_id');
            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
            $table->timestamps();
        });

        // ============================================
        // 3. KURSI SISWA
        // ============================================
        Schema::create('kursi_siswas', function (Blueprint $table) {
            $table->id();
            $table->integer('baik')->default(0);
            $table->integer('rusak')->default(0);
            $table->unsignedBigInteger('sarana_id');
            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
            $table->timestamps();
        });

        // ============================================
        // 4. MEJA SISWA
        // ============================================
        Schema::create('meja_siswas', function (Blueprint $table) {
            $table->id();
            $table->integer('baik')->default(0);
            $table->integer('rusak')->default(0);
            $table->unsignedBigInteger('sarana_id');
            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
            $table->timestamps();
        });

        // ============================================
        // 5. KURSI GURU
        // ============================================
        Schema::create('kursi_gurus', function (Blueprint $table) {
            $table->id();
            $table->integer('baik')->default(0);
            $table->integer('rusak')->default(0);
            $table->unsignedBigInteger('sarana_id');
            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
            $table->timestamps();
        });

        // ============================================
        // 6. MEJA GURU
        // ============================================
        Schema::create('meja_gurus', function (Blueprint $table) {
            $table->id();
            $table->integer('baik')->default(0);
            $table->integer('rusak')->default(0);
            $table->unsignedBigInteger('sarana_id');
            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
            $table->timestamps();
        });

        // ============================================
        // 7. LAPTOP
        // ============================================
        Schema::create('laptops', function (Blueprint $table) {
            $table->id();
            $table->integer('baik')->default(0);
            $table->integer('rusak')->default(0);
            $table->unsignedBigInteger('sarana_id');
            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
            $table->timestamps();
        });

        // ============================================
        // 8. KOMPUTER
        // ============================================
        Schema::create('komputers', function (Blueprint $table) {
            $table->id();
            $table->integer('baik')->default(0);
            $table->integer('rusak')->default(0);
            $table->unsignedBigInteger('sarana_id');
            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
            $table->timestamps();
        });

        // ============================================
        // 9. JUMLAH SISWA
        // ============================================
        Schema::create('jumlah_siswas', function (Blueprint $table) {
            $table->id();
            $table->integer('vii')->default(0);
            $table->integer('viii')->default(0);
            $table->integer('ix')->default(0);
            $table->unsignedBigInteger('sarana_id');
            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
            $table->timestamps();
        });

        // ============================================
        // 10. JUMLAH ROMBEL
        // ============================================
        Schema::create('jumlah_rombels', function (Blueprint $table) {
            $table->id();
            $table->integer('vii')->default(0);
            $table->integer('viii')->default(0);
            $table->integer('ix')->default(0);
            $table->unsignedBigInteger('sarana_id');
            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
            $table->timestamps();
        });

        // ============================================
        // 11. RKB (RUANG KELAS BARU) 2020-2025
        // ============================================
        Schema::create('ruang_kelas_barus', function (Blueprint $table) {
            $table->id();
            $table->integer('jumlah')->default(0);
            $table->unsignedBigInteger('sarana_id');
            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
            $table->timestamps();
        });

        // ============================================
        // 12. REHABILITASI RUANG KELAS 2020-2025
        // ============================================
        Schema::create('rehabilitasi_ruang_kelas', function (Blueprint $table) {
            $table->id();
            $table->integer('jumlah')->default(0);
            $table->unsignedBigInteger('sarana_id');    
            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
            $table->timestamps();
        });

        // ============================================
        // 13. RUANG KELAS
        // ============================================
        Schema::create('ruang_kelas', function (Blueprint $table) {
            $table->id();
            $table->integer('baik')->default(0);
            $table->integer('rusak')->default(0);
            $table->unsignedBigInteger('sarana_id');
            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
            $table->timestamps();
        });

        // ============================================
        // 14. TOILET SISWA
        // ============================================
        Schema::create('toilet_siswas', function (Blueprint $table) {
            $table->id();
            $table->integer('baik')->default(0);
            $table->integer('rusak')->default(0);
            $table->unsignedBigInteger('sarana_id');
            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
            $table->timestamps();
        });

        // ============================================
        // 15. TOILET GURU
        // ============================================
        Schema::create('toilet_gurus', function (Blueprint $table) {
            $table->id();
            $table->integer('baik')->default(0);
            $table->integer('rusak')->default(0);
            $table->unsignedBigInteger('sarana_id');
            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
            $table->timestamps();
        });

        // ============================================
        // 16. RUANG PERPUSTAKAAN
        // ============================================
        Schema::create('ruang_perpustakaans', function (Blueprint $table) {
            $table->id();
            $table->enum('ada/tidak_ada', ['ada', 'tidak_ada']);
            $table->enum('kodisi', ['baik', 'rusak', 'nihil']);
            $table->unsignedBigInteger('sarana_id');
            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
            $table->timestamps();
        });

        // ============================================
        // 17. RUANG KEPALA SEKOLAH
        // ============================================
        Schema::create('ruang_kepala_sekolahs', function (Blueprint $table) {
            $table->id();
            $table->enum('ada/tidak_ada', ['ada', 'tidak_ada']);
            $table->enum('kodisi', ['baik', 'rusak', 'nihil']);
            $table->unsignedBigInteger('sarana_id');
            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
            $table->timestamps();
        });

        // ============================================
        // 18. RUANG GURU
        // ============================================
        Schema::create('ruang_gurus', function (Blueprint $table) {
            $table->id();
            $table->enum('ada/tidak_ada', ['ada', 'tidak_ada']);
            $table->enum('kodisi', ['baik', 'rusak', 'nihil']);
            $table->unsignedBigInteger('sarana_id');
            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
            $table->timestamps();
        });

        // ============================================
        // 19. RUANG KANTOR/TU
        // ============================================
        Schema::create('ruang_kantor_tus', function (Blueprint $table) {
            $table->id();
            $table->enum('ada/tidak_ada', ['ada', 'tidak_ada']);
            $table->enum('kodisi', ['baik', 'rusak', 'nihil']);
            $table->unsignedBigInteger('sarana_id');
            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
            $table->timestamps();
        });

        // ============================================
        // 20. LAB IPA
        // ============================================
        Schema::create('lab_ipas', function (Blueprint $table) {
            $table->id();
            $table->enum('ada/tidak_ada', ['ada', 'tidak_ada']);
            $table->enum('kodisi', ['baik', 'rusak', 'nihil']);
            $table->unsignedBigInteger('sarana_id');
            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
            $table->timestamps();
        });

        // ============================================
        // 21. LAB KOMPUTER
        // ============================================
        Schema::create('lab_komputers', function (Blueprint $table) {
            $table->id();
            $table->enum('ada/tidak_ada', ['ada', 'tidak_ada']);
            $table->enum('kodisi', ['baik', 'rusak', 'nihil']);
            $table->unsignedBigInteger('sarana_id');
            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
            $table->timestamps();
        });

        // ============================================
        // 22. UKS (UNIT KESEHATAN SEKOLAH)
        // ============================================
        Schema::create('unit_kesehatan_sekolahs', function (Blueprint $table) {
            $table->id();
            $table->enum('ada/tidak_ada', ['ada', 'tidak_ada']);
            $table->enum('kodisi', ['baik', 'rusak', 'nihil']);
            $table->unsignedBigInteger('sarana_id');
            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
            $table->timestamps();
        });

        // ============================================
        // 23. RUMAH DINAS
        // ============================================
        Schema::create('rumah_dinas', function (Blueprint $table) {
            $table->id();
            $table->enum('ada/tidak_ada', ['ada', 'tidak_ada']);
            $table->enum('kodisi', ['baik', 'rusak', 'nihil']);
            $table->unsignedBigInteger('sarana_id');
            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
            $table->timestamps();
        });

        // ============================================
        // 24. RUMAH IBADAH
        // ============================================
        Schema::create('rumah_ibadahs', function (Blueprint $table) {
            $table->id();
            $table->enum('ada/tidak_ada', ['ada', 'tidak_ada']);
            $table->enum('kodisi', ['baik', 'rusak', 'nihil']);
            $table->unsignedBigInteger('sarana_id');
            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
            $table->timestamps();
        });

        // ============================================
        // 25. LAPANGAN SEKOLAH
        // ============================================
        Schema::create('lapangan_sekolahs', function (Blueprint $table) {
            $table->id();
            $table->enum('ada/tidak_ada', ['ada', 'tidak_ada']);
            $table->enum('kodisi', ['baik', 'rusak', 'nihil']);
            $table->unsignedBigInteger('sarana_id');
            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lapangan_sekolahs');
        Schema::dropIfExists('rumah_ibadahs');
        Schema::dropIfExists('rumah_dinas');
        Schema::dropIfExists('unit_kesehatan_sekolahs');
        Schema::dropIfExists('lab_komputers');
        Schema::dropIfExists('lab_ipas');
        Schema::dropIfExists('ruang_kantor_tus');
        Schema::dropIfExists('ruang_gurus');
        Schema::dropIfExists('ruang_kepala_sekolahs');
        Schema::dropIfExists('ruang_perpustakaans');
        Schema::dropIfExists('toilet_gurus');
        Schema::dropIfExists('toilet_siswas');
        Schema::dropIfExists('ruang_kelas');
        Schema::dropIfExists('rehabilitasi_ruang_kelas');
        Schema::dropIfExists('ruang_kelas_barus');
        Schema::dropIfExists('jumlah_rombels');
        Schema::dropIfExists('jumlah_siswas');
        Schema::dropIfExists('komputers');
        Schema::dropIfExists('laptops');
        Schema::dropIfExists('meja_gurus');
        Schema::dropIfExists('kursi_gurus');
        Schema::dropIfExists('meja_siswas');
        Schema::dropIfExists('kursi_siswas');
        Schema::dropIfExists('air_bersihs');
        Schema::dropIfExists('pagar_sekolahs');
        Schema::dropIfExists('saranas');
    }
};