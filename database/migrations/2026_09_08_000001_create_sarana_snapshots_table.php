<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sarana_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_sekolah_id')->constrained()->cascadeOnDelete();
            $table->morphs('snapshotable'); // snapshotable_type, snapshotable_id
            $table->json('data');
            $table->timestamp('recorded_at');
            $table->timestamps();

            $table->index(
                ['snapshotable_type', 'snapshotable_id', 'recorded_at'],
                'sarana_snapshots_morph_recorded_at_index' // nama custom, lebih pendek dari batas 64 karakter MySQL
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sarana_snapshots');
    }
};