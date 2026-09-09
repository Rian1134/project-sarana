<?php

namespace App\Traits;

use App\Models\SaranaSnapshot;

trait RecordsSaranaSnapshot
{
    /**
     * Kolom yang TIDAK ikut disimpan ke snapshot (metadata, bukan data sarana).
     */
    protected static array $snapshotExcludedColumns = [
        'id', 'profile_sekolah_id', 'created_at', 'updated_at',
    ];

    protected static function bootRecordsSaranaSnapshot(): void
    {
        static::saved(function ($model) {
            $relevantData = collect($model->getAttributes())
                ->except(static::$snapshotExcludedColumns)
                ->toArray();

            // Kalau tidak ada perubahan nilai apa pun (selain timestamp), skip.
            if (!$model->wasRecentlyCreated && empty(array_intersect_key(
                $relevantData,
                array_flip($model->getChanges())
            ))) {
                return;
            }

            SaranaSnapshot::create([
                'profile_sekolah_id' => $model->profile_sekolah_id,
                'snapshotable_type'  => static::class,
                'snapshotable_id'    => $model->id,
                'data'               => $relevantData,
                'recorded_at'        => now(),
            ]);
        });

        static::deleted(function ($model) {
            SaranaSnapshot::create([
                'profile_sekolah_id' => $model->profile_sekolah_id,
                'snapshotable_type'  => static::class,
                'snapshotable_id'    => $model->id,
                'data'               => ['_deleted' => true],
                'recorded_at'        => now(),
            ]);
        });
    }

    public function snapshots()
    {
        return $this->morphMany(SaranaSnapshot::class, 'snapshotable')
            ->orderBy('recorded_at');
    }
}