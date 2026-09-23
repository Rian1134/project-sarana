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
        Schema::create('kondisi_staffs', function (Blueprint $table) {
            $table->id();
            
            $table->string('pns')->nullable(true);
            $table->string('pppk')->nullable(true);
            $table->string('pppk_paruh_waktu')->nullable(true);
            $table->string('honor')->nullable(true);

            $table->string('i');
            $table->string('ii');
            $table->string('iii');
            $table->string('iv');

            $table->unsignedBigInteger('profile_sekolah_id');
            $table->foreign('profile_sekolah_id')->references('id')->on('profile_sekolahs')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kondisi_staff');
    }
};
