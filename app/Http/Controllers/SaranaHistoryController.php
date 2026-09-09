<?php

namespace App\Http\Controllers;

use App\Models\ProfileSekolah;
use App\Models\SaranaSnapshot;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class SaranaHistoryController extends Controller
{
    /**
     * Daftar kategori sarana untuk dropdown pemilih chart.
     */
    public function kategoriList()
    {
        return collect(config('sarana.kategori'))
            ->map(fn($item, $key) => ['key' => $key, 'label' => $item['label']])
            ->values();
    }

    /**
     * Riwayat perubahan (audit log) untuk satu sekolah — dari Spatie Activity Log.
     * Menampilkan SEMUA kategori sarana sekolah itu dalam satu timeline.
     */
    public function riwayat(ProfileSekolah $profileSekolah)
    {
        $activities = Activity::forSubject($profileSekolah)
            ->with('causer')
            ->latest()
            ->paginate(20);

        return view('admin.riwayat', compact('profileSekolah', 'activities'));
    }

    /**
     * Data riwayat NUMERIK satu kategori untuk sebuah sekolah, untuk Chart.js.
     */
    public function chartHistory(ProfileSekolah $profileSekolah, Request $request)
    {
        $request->validate(['kategori' => 'required|string']);

        $kategori = config("sarana.kategori.{$request->kategori}");
        abort_if(!$kategori, 404, 'Kategori sarana tidak ditemukan.');

        $snapshots = SaranaSnapshot::where('profile_sekolah_id', $profileSekolah->id)
            ->where('snapshotable_type', $kategori['model'])
            ->orderBy('recorded_at')
            ->get()
            ->groupBy(fn($row) => $row->recorded_at->format('Y-m'))
            ->map(fn($group) => $group->last());

        return response()->json([
            'label'  => $kategori['label'],
            'type'   => $kategori['type'],
            'labels' => $snapshots->keys(),
            'series' => $this->extractSeries($snapshots, $kategori['type']),
        ]);
    }

    private function extractSeries($snapshots, string $type): array
    {
        return match ($type) {
            'baik_rusak' => [
                'Baik'  => $snapshots->map(fn($s) => $s->data['baik'] ?? 0)->values(),
                'Rusak' => $snapshots->map(fn($s) => $s->data['rusak'] ?? 0)->values(),
            ],
            'tingkat' => [
                'VII'  => $snapshots->map(fn($s) => $s->data['vii'] ?? 0)->values(),
                'VIII' => $snapshots->map(fn($s) => $s->data['viii'] ?? 0)->values(),
                'IX'   => $snapshots->map(fn($s) => $s->data['ix'] ?? 0)->values(),
            ],
            'jumlah' => [
                'Jumlah' => $snapshots->map(fn($s) => $s->data['jumlah'] ?? 0)->values(),
            ],
            'ada_kondisi' => [
                'Status' => $snapshots->map(function ($s) {
                    $ada = ($s->data['ada/tidak_ada'] ?? null) === 'ada';
                    $kondisiBaik = ($s->data['kodisi'] ?? null) === 'baik';

                    return match (true) {
                        !$ada        => 0,
                        $kondisiBaik => 1,
                        default      => 0.5,
                    };
                })->values(),
            ],
            default => [],
        };
    }
}
