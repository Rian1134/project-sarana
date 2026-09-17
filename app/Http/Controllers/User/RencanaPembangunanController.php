<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\ProfileSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RencanaPembangunanController extends Controller
{
    public static function kategoriList(): array
    {
        return [
            'ruang_kelas_baru' => [
                'label' => 'Ruang Kelas Baru (RKB)',
                'table' => 'ruang_kelas_barus',
                'tipe' => 'jumlah',
            ],

            'rehabilitasi_ruang_kelas' => [
                'label' => 'Rehabilitasi Ruang Kelas',
                'table' => 'rehabilitasi_ruang_kelas',
                'tipe' => 'jumlah',
            ],

            'ruang_guru' => [
                'label' => 'Ruang Guru',
                'table' => 'ruang_gurus',
                'tipe' => 'ada_kondisi',
            ],

            'ruang_kepala_sekolah' => [
                'label' => 'Ruang Kepala Sekolah',
                'table' => 'ruang_kepala_sekolahs',
                'tipe' => 'ada_kondisi',
            ],

            'ruang_kantor_tu' => [
                'label' => 'Ruang Kantor TU',
                'table' => 'ruang_kantor_tus',
                'tipe' => 'ada_kondisi',
            ],

            'ruang_perpustakaan' => [
                'label' => 'Ruang Perpustakaan',
                'table' => 'ruang_perpustakaans',
                'tipe' => 'ada_kondisi',
            ],

            'lab_ipa' => [
                'label' => 'Laboratorium IPA',
                'table' => 'lab_ipas',
                'tipe' => 'ada_kondisi',
            ],

            'lab_komputer' => [
                'label' => 'Laboratorium Komputer',
                'table' => 'lab_komputers',
                'tipe' => 'ada_kondisi',
            ],

            'unit_kesehatan_sekolah' => [
                'label' => 'Unit Kesehatan Sekolah (UKS)',
                'table' => 'unit_kesehatan_sekolahs',
                'tipe' => 'ada_kondisi',
            ],

            'lapangan_sekolah' => [
                'label' => 'Lapangan Sekolah',
                'table' => 'lapangan_sekolahs',
                'tipe' => 'ada_kondisi',
            ],

            'pagar_sekolah' => [
                'label' => 'Pagar Sekolah',
                'table' => 'pagar_sekolahs',
                'tipe' => 'ada_kondisi',
            ],

            'air_bersih' => [
                'label' => 'Air Bersih',
                'table' => 'air_bersihs',
                'tipe' => 'ada_kondisi',
            ],

            'rumah_dinas' => [
                'label' => 'Rumah Dinas',
                'table' => 'rumah_dinas',
                'tipe' => 'ada_kondisi',
            ],

            'rumah_ibadah' => [
                'label' => 'Rumah Ibadah',
                'table' => 'rumah_ibadahs',
                'tipe' => 'ada_kondisi',
            ],

            'toilet_siswa' => [
                'label' => 'Toilet Siswa',
                'table' => 'toilet_siswas',
                'tipe' => 'baik_rusak',
            ],

            'toilet_guru' => [
                'label' => 'Toilet Guru',
                'table' => 'toilet_gurus',
                'tipe' => 'baik_rusak',
            ],
        ];
    }

    public static function ikonKategori(): array
    {
        return [
            'ruang_kelas_baru' => 'bi-building',
            'rehabilitasi_ruang_kelas' => 'bi-tools',
            'ruang_guru' => 'bi-people',
            'ruang_kepala_sekolah' => 'bi-person-workspace',
            'ruang_kantor_tu' => 'bi-briefcase',
            'ruang_perpustakaan' => 'bi-book',
            'lab_ipa' => 'bi-flask',
            'lab_komputer' => 'bi-pc-display-horizontal',
            'unit_kesehatan_sekolah' => 'bi-heart-pulse',
            'lapangan_sekolah' => 'bi-flag',
            'pagar_sekolah' => 'bi-border-all',
            'air_bersih' => 'bi-droplet',
            'rumah_dinas' => 'bi-house-door',
            'rumah_ibadah' => 'bi-building',
            'toilet_siswa' => 'bi-droplet-half',
            'toilet_guru' => 'bi-droplet',
        ];
    }

    public static function fieldsByTipe(): array
    {
        return [
            'jumlah' => [
                [
                    'name' => 'jumlah',
                    'label' => 'Jumlah',
                    'type' => 'number',
                ],
            ],

            'baik_rusak' => [
                [
                    'name' => 'baik',
                    'label' => 'Jumlah',
                    'type' => 'number',
                ],
            ],

            'ada_kondisi' => [],
        ];
    }

    public static function fieldLabel(string $kategori, string $field): string
    {
        $tipe = self::kategoriList()[$kategori]['tipe'] ?? null;
        $fields = self::fieldsByTipe()[$tipe] ?? [];

        foreach ($fields as $def) {
            if ($def['name'] === $field) {
                return $def['label'];
            }
        }

        return ucwords(str_replace(['/', '_'], [' / ', ' '], $field));
    }

    public static function categoryLabel(string $kategori): string
    {
        return self::kategoriList()[$kategori]['label'] ?? $kategori;
    }


    private function rulesForKategori(string $kategori): array
    {
        $kategoriData = self::kategoriList()[$kategori] ?? null;

        if (! $kategoriData) {
            return [];
        }

        $tipe = $kategoriData['tipe'];
        $rules = [];

        foreach (self::fieldsByTipe()[$tipe] ?? [] as $field) {
            $rules[$field['name']] = $field['type'] === 'select'
                ? [
                    'required',
                    Rule::in(array_keys($field['options'])),
                ]
                : [
                    'required',
                    'integer',
                    'min:0',
                ];
        }

        return $rules;
    }

    public function index(Request $request)
    {
        $kategoriKeys = array_keys(self::kategoriList());

        $pengajuans = Pengajuan::with('profileSekolah')
            ->where('user_id', Auth::id())
            ->where(function ($query) use ($kategoriKeys) {
                foreach ($kategoriKeys as $key) {
                    $query->orWhereJsonContains('pengajuan', $key);
                }
            })
            ->latest()
            ->paginate(10);

        return view(
            'user.rencana-pembangunan.index',
            compact('pengajuans')
        );
    }

    public function create(Request $request)
    {
        $kategoriList = self::kategoriList();
        $fieldsByTipe = self::fieldsByTipe();
        $ikonKategori = self::ikonKategori();

        return view(
            'user.rencana-pembangunan.create',
            compact(
                'kategoriList',
                'fieldsByTipe',
                'ikonKategori'
            )
        );
    }

    public function store(Request $request)
    {
        $kategoriList = self::kategoriList();

        $request->validate([
            'judul_perubahan' => [
                'required',
                'string',
                'max:255',
            ],
            'pilih' => [
                'nullable',
                'array',
            ],
        ]);

        $dipilih = array_values(
            array_intersect(
                array_keys($request->input('pilih', [])),
                array_keys($kategoriList)
            )
        );

        if (empty($dipilih)) {
            return back()
                ->withInput()
                ->withErrors([
                    'pilih' => 'Pilih minimal satu kategori sarana/prasarana yang ingin diajukan.',
                ]);
        }

        $rules = [];

        foreach ($dipilih as $key) {
            foreach ($this->rulesForKategori($key) as $field => $fieldRules) {
                $rules["perubahan.$key.$field"] = $fieldRules;
            }
        }

        $validated = $request->validate($rules);

        $perubahan = $validated['perubahan'] ?? [];

        foreach ($dipilih as $key) {
            if (
                isset($kategoriList[$key]) &&
                $kategoriList[$key]['tipe'] === 'ada_kondisi' &&
                ! isset($perubahan[$key])
            ) {
                $perubahan[$key] = [];
            }
        }

        $profileSekolah = ProfileSekolah::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        Pengajuan::create([
            'user_id' => Auth::id(),
            'profile_sekolah_id' => $profileSekolah->id,
            'judul' => $request->input('judul_perubahan'),
            'pengajuan' => $dipilih,
            'perubahan' => $perubahan,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('user.rencana-pembangunan.index')
            ->with(
                'success',
                'Rencana pembangunan berhasil dikirim dan menunggu review admin.'
            );
    }

    public function show(Pengajuan $pengajuan)
    {
        $this->authorizeOwner($pengajuan);

        $kategoriList = self::kategoriList();

        return view(
            'user.rencana-pembangunan.show',
            compact(
                'pengajuan',
                'kategoriList'
            )
        );
    }

    public function edit(Pengajuan $pengajuan)
    {
        $this->authorizeOwner($pengajuan);
        $this->guardEditable($pengajuan);

        $kategoriList = self::kategoriList();
        $fieldsByTipe = self::fieldsByTipe();
        $ikonKategori = self::ikonKategori();

        return view(
            'user.rencana-pembangunan.edit',
            compact(
                'pengajuan',
                'kategoriList',
                'fieldsByTipe',
                'ikonKategori'
            )
        );
    }

    public function update(
        Request $request,
        Pengajuan $pengajuan
    ) {
        $this->authorizeOwner($pengajuan);
        $this->guardEditable($pengajuan);

        $kategoriList = self::kategoriList();

        $request->validate([
            'judul_perubahan' => [
                'required',
                'string',
                'max:255',
            ],
            'pilih' => [
                'nullable',
                'array',
            ],
        ]);

        $dipilih = array_values(
            array_intersect(
                array_keys($request->input('pilih', [])),
                array_keys($kategoriList)
            )
        );

        $rules = [];

        foreach ($dipilih as $key) {
            foreach ($this->rulesForKategori($key) as $field => $fieldRules) {
                $rules["perubahan.$key.$field"] = $fieldRules;
            }
        }

        $validated = $request->validate($rules);

        $perubahanBaru = $validated['perubahan'] ?? [];

        foreach ($dipilih as $key) {
            if (
                isset($kategoriList[$key]) &&
                $kategoriList[$key]['tipe'] === 'ada_kondisi' &&
                ! isset($perubahanBaru[$key])
            ) {
                $perubahanBaru[$key] = [];
            }
        }

        $perubahanLama = is_array($pengajuan->perubahan)
            ? $pengajuan->perubahan
            : [];

        $perubahanGabungan = array_merge(
            $perubahanLama,
            $perubahanBaru
        );

        $kategoriLama = is_array($pengajuan->pengajuan)
            ? $pengajuan->pengajuan
            : array_filter([
                $pengajuan->pengajuan,
            ]);

        $kategoriGabungan = array_values(
            array_unique(
                array_merge(
                    $kategoriLama,
                    $dipilih
                )
            )
        );

        $pengajuan->update([
            'judul' => $request->input('judul_perubahan'),
            'pengajuan' => $kategoriGabungan,
            'perubahan' => $perubahanGabungan,
        ]);

        return redirect()
            ->route('user.rencana-pembangunan.index')
            ->with(
                'success',
                'Rencana pembangunan berhasil diperbarui.'
            );
    }

    public function destroy(Pengajuan $pengajuan)
    {
        $this->authorizeOwner($pengajuan);
        $this->guardEditable(
            $pengajuan,
            'dihapus'
        );

        $pengajuan->delete();

        return redirect()
            ->route('user.rencana-pembangunan.index')
            ->with(
                'success',
                'Rencana pembangunan berhasil dihapus.'
            );
    }

    private function authorizeOwner(
        Pengajuan $pengajuan
    ): void {
        abort_unless(
            $pengajuan->user_id === Auth::id(),
            403
        );
    }

    private function guardEditable(
        Pengajuan $pengajuan,
        string $aksi = 'diedit'
    ): void {
        abort_if(
            $pengajuan->status !== 'pending',
            403,
            "Hanya pengajuan berstatus pending yang bisa {$aksi}."
        );
    }
}
