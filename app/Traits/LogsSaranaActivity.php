<?php

namespace App\Traits;

use Spatie\Activitylog\Support\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Models\Activity;

/**
 * LogsSaranaActivity
 *
 * Pasang di semua model kategori sarana (KursiSiswa, RuangKelas, dst).
 * Riwayat perubahan model-model ini akan "dialihkan" jadi milik
 * ProfileSekolah, sehingga semua histori sarana satu sekolah bisa
 * ditampilkan sebagai satu timeline di halaman detail sekolah.
 *
 * SYARAT: model yang memakai trait ini harus punya relasi
 * belongsTo ke ProfileSekolah bernama profileSekolah(), atau
 * kolom profile_sekolah_id langsung.
 */
trait LogsSaranaActivity
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->useLogName('sarana');
    }

    public function tapActivity(Activity $activity, string $eventName): void
    {
        $profileSekolahId = $this->profile_sekolah_id
            ?? $this->profileSekolah?->id
            ?? null;

        if ($profileSekolahId) {
            $activity->subject_type = \App\Models\ProfileSekolah::class;
            $activity->subject_id   = $profileSekolahId;
        }

        $activity->description = class_basename($this).' '.$this->activityLabel($eventName);
    }

    private function activityLabel(string $eventName): string
    {
        return match ($eventName) {
            'created' => 'ditambahkan',
            'updated' => 'diperbarui',
            'deleted' => 'dihapus',
            default   => $eventName,
        };
    }
}   