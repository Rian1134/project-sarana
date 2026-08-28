<?php

namespace App\Exports;

use App\Models\PeriodeLaporan;
use App\Models\Sarana;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * ExportData
 *
 * Export sarana & prasarana ke Excel dengan bentuk tabel PERSIS mengikuti
 * template "Data Keadaan Sarana Prasarana Sekolah Tingkat SMP" (73 kolom,
 * A s.d BU), yaitu:
 *
 *  - Baris 1-2  : Judul laporan (judul + "DI KABUPATEN LAHAT TAHUN <tahun>")
 *  - Baris 3    : kosong (pemisah)
 *  - Baris 4-6  : Header 3 tingkat (kategori besar -> sub kategori -> detail)
 *  - Baris 7..n : Data sekolah
 *  - Baris n+1  : Baris total "J U M L A H"
 *
 * PERUBAHAN: Menambahkan kolom:
 *  - C: NPSN
 *  - D: Alamat Sekolah
 *  - E: Nama Kepala Sekolah
 *  - F: NIP
 *  - G: Nomor HP
 *
 * Sehingga total kolom menjadi 73 (A s.d BU)
 */
class ExportData implements FromCollection, ShouldAutoSize, WithColumnWidths, WithEvents, WithMapping, WithStyles
{
    protected $saranas;

    // ================================================================
    // WARNA HEADER (SEMUA HIJAU MUDA)
    // ================================================================
    private const COLOR_HEADER    = 'FFA9EFBB'; // Warna hijau muda untuk semua header
    private const COLOR_ORANYE    = 'FFFF7F61'; // Highlight kolom "Jumlah" & "Kondisi" (baris detail & data)
    private const COLOR_TOTAL     = 'FFA4C2F4'; // Baris total "J U M L A H"

    /**
     * @param int|null $saranaId ID sarana spesifik untuk di-export.
     *                           Kosongkan (null) untuk export SEMUA sekolah.
     */
    public function __construct(?int $saranaId = null)
    {
        $query = Sarana::with([
            'jumlahSiswa',
            'jumlahRombel',
            'ruangKelasBaru',
            'rehabilitasiRuangKelas',
            'ruangKelas',
            'toiletSiswa',
            'toiletGuru',
            'ruangPerpustakaan',
            'ruangKepalaSekolah',
            'ruangGuru',
            'ruangKantorTu',
            'labIpa',
            'labKomputer',
            'unitKesehatanSekolah',
            'rumahDinas',
            'rumahIbadah',
            'lapanganSekolah',
            'pagarSekolah',
            'airBersih',
            'kursiSiswa',
            'mejaSiswa',
            'kursiGuru',
            'mejaGuru',
            'laptop',
            'komputer',
        ]);

        if ($saranaId) {
            $query->where('id', $saranaId);
        }

        $this->saranas = $query->get();
    }

    public function collection()
    {
        return $this->saranas;
    }

    /**
     * MAPPING DATA KE 73 KOLOM (A - BU), MENGIKUTI URUTAN TEMPLATE EXCEL:
     *
     * A     = No
     * B     = Nama Sekolah
     * C     = NPSN
     * D     = Alamat Sekolah
     * E     = Nama Kepala Sekolah
     * F     = NIP
     * G     = Nomor HP
     * H-K   = Jumlah Siswa (VII, VIII, IX, Jumlah)
     * L-O   = Jumlah Rombongan Belajar (VII, VIII, IX, Jumlah)
     * P-S   = Jumlah Ruang Kelas per tingkat (VII, VIII, IX, Jumlah)
     * T     = Pembangunan RKB (teks: "n Ruang" / "Tidak Ada")
     * U     = Rehabilitasi Ruang Kelas (teks: "n Ruang" / "Tidak Ada")
     * V-X   = Ruang Kelas (Baik, Rusak, Jumlah)
     * Y-AA  = Toilet Siswa (Baik, Rusak, Jumlah)
     * AB-AD = Toilet Guru (Baik, Rusak, Jumlah)
     * AE-AF = R. Perpustakaan (Ada/Tidak, Kondisi)
     * AG-AH = R. Kepala Sekolah (Ada/Tidak, Kondisi)
     * AI-AJ = R. Guru (Ada/Tidak, Kondisi)
     * AK-AL = R. Kantor/TU (Ada/Tidak, Kondisi)
     * AM-AN = Lab IPA (Ada/Tidak, Kondisi)
     * AO-AP = Lab Komputer (Ada/Tidak, Kondisi)
     * AQ-AR = UKS (Ada/Tidak, Kondisi)
     * AS-AT = Rumah Dinas (Ada/Tidak, Kondisi)
     * AU-AV = Rumah Ibadah (Ada/Tidak, Kondisi)
     * AW-AX = Lapangan Sekolah (Ada/Tidak, Kondisi)
     * AY-AZ = Pagar Sekolah (Ada/Tidak, Kondisi)
     * BA-BB = Persediaan Air Bersih (Ada/Tidak, Kondisi)
     * BC-BE = Kursi Siswa (Baik, Rusak, Jumlah)
     * BF-BH = Meja Siswa (Baik, Rusak, Jumlah)
     * BI-BK = Kursi Guru (Baik, Rusak, Jumlah)
     * BL-BN = Meja Guru (Baik, Rusak, Jumlah)
     * BO-BQ = Laptop/Chromebook (Baik, Rusak, Jumlah)
     * BR-BT = Komputer/PC (Baik, Rusak, Jumlah)
     * BU    = Keterangan / Catatan
     */
    public function map($item): array
    {
        static $no = 0;
        $no++;

        // ============================================================
        // 1. JUMLAH SISWA (H-K)
        // ============================================================
        $siswaVii  = $item->jumlahSiswa?->vii ?? 0;
        $siswaViii = $item->jumlahSiswa?->viii ?? 0;
        $siswaIx   = $item->jumlahSiswa?->ix ?? 0;
        $jmlSiswa  = $siswaVii + $siswaViii + $siswaIx;

        // ============================================================
        // 2. JUMLAH ROMBEL (L-O)
        // ============================================================
        $rombelVii  = $item->jumlahRombel?->vii ?? 0;
        $rombelViii = $item->jumlahRombel?->viii ?? 0;
        $rombelIx   = $item->jumlahRombel?->ix ?? 0;
        $jmlRombel  = $rombelVii + $rombelViii + $rombelIx;

        // ============================================================
        // 3. RUANG KELAS PER TINGKAT (P-S)
        // ============================================================
        $rkVii  = $rombelVii;
        $rkViii = $rombelViii;
        $rkIx   = $rombelIx;
        $jmlRkTingkat = $jmlRombel;

        // ============================================================
        // 4. RKB (T) & REHABILITASI (U) — ditulis sebagai teks
        // ============================================================
        $rkb          = $item->ruangKelasBaru?->jumlah ?? 0;
        $rehabilitasi = $item->rehabilitasiRuangKelas?->jumlah ?? 0;

        // ============================================================
        // 5. RUANG KELAS (V-X)
        // ============================================================
        $rkBaik = $item->ruangKelas?->baik ?? 0;
        $rkRusak = $item->ruangKelas?->rusak ?? 0;
        $jmlRk   = $rkBaik + $rkRusak;

        // ============================================================
        // 6. TOILET SISWA (Y-AA)
        // ============================================================
        $tsBaik = $item->toiletSiswa?->baik ?? 0;
        $tsRusak = $item->toiletSiswa?->rusak ?? 0;
        $jmlTs   = $tsBaik + $tsRusak;

        // ============================================================
        // 7. TOILET GURU (AB-AD)
        // ============================================================
        $tgBaik = $item->toiletGuru?->baik ?? 0;
        $tgRusak = $item->toiletGuru?->rusak ?? 0;
        $jmlTg   = $tgBaik + $tgRusak;

        // ============================================================
        // 8-19. ADA/TIDAK & KONDISI (AE-BB)
        // ============================================================
        $perpustakaan_ada     = $this->formatAdaTidak($item->ruangPerpustakaan?->{'ada/tidak_ada'});
        $perpustakaan_kondisi = $this->formatKondisi($item->ruangPerpustakaan?->kodisi);

        $kepsek_ada         = $this->formatAdaTidak($item->ruangKepalaSekolah?->{'ada/tidak_ada'});
        $kepsek_kondisi     = $this->formatKondisi($item->ruangKepalaSekolah?->kodisi);

        $ruangGuru_ada      = $this->formatAdaTidak($item->ruangGuru?->{'ada/tidak_ada'});
        $ruangGuru_kondisi  = $this->formatKondisi($item->ruangGuru?->kodisi);

        $kantorTu_ada       = $this->formatAdaTidak($item->ruangKantorTu?->{'ada/tidak_ada'});
        $kantorTu_kondisi   = $this->formatKondisi($item->ruangKantorTu?->kodisi);

        $labIpa_ada         = $this->formatAdaTidak($item->labIpa?->{'ada/tidak_ada'});
        $labIpa_kondisi     = $this->formatKondisi($item->labIpa?->kodisi);

        $labKomputer_ada    = $this->formatAdaTidak($item->labKomputer?->{'ada/tidak_ada'});
        $labKomputer_kondisi = $this->formatKondisi($item->labKomputer?->kodisi);

        $uks_ada            = $this->formatAdaTidak($item->unitKesehatanSekolah?->{'ada/tidak_ada'});
        $uks_kondisi        = $this->formatKondisi($item->unitKesehatanSekolah?->kodisi);

        $rumahDinas_ada     = $this->formatAdaTidak($item->rumahDinas?->{'ada/tidak_ada'});
        $rumahDinas_kondisi = $this->formatKondisi($item->rumahDinas?->kodisi);

        $rumahIbadah_ada     = $this->formatAdaTidak($item->rumahIbadah?->{'ada/tidak_ada'});
        $rumahIbadah_kondisi = $this->formatKondisi($item->rumahIbadah?->kodisi);

        $lapangan_ada     = $this->formatAdaTidak($item->lapanganSekolah?->{'ada/tidak_ada'});
        $lapangan_kondisi = $this->formatKondisi($item->lapanganSekolah?->kodisi);

        $pagar_ada     = $this->formatAdaTidak($item->pagarSekolah?->{'ada/tidak_ada'});
        $pagar_kondisi = $this->formatKondisi($item->pagarSekolah?->kodisi);

        $air_ada     = $this->formatAdaTidak($item->airBersih?->{'ada/tidak_ada'});
        $air_kondisi = $this->formatKondisi($item->airBersih?->kodisi);

        // ============================================================
        // 20. KURSI SISWA (BC-BE)
        // ============================================================
        $ksBaik = $item->kursiSiswa?->baik ?? 0;
        $ksRusak = $item->kursiSiswa?->rusak ?? 0;
        $jmlKs   = $ksBaik + $ksRusak;

        // ============================================================
        // 21. MEJA SISWA (BF-BH)
        // ============================================================
        $msBaik = $item->mejaSiswa?->baik ?? 0;
        $msRusak = $item->mejaSiswa?->rusak ?? 0;
        $jmlMs   = $msBaik + $msRusak;

        // ============================================================
        // 22. KURSI GURU (BI-BK)
        // ============================================================
        $kgBaik = $item->kursiGuru?->baik ?? 0;
        $kgRusak = $item->kursiGuru?->rusak ?? 0;
        $jmlKg   = $kgBaik + $kgRusak;

        // ============================================================
        // 23. MEJA GURU (BL-BN)
        // ============================================================
        $mgBaik = $item->mejaGuru?->baik ?? 0;
        $mgRusak = $item->mejaGuru?->rusak ?? 0;
        $jmlMg   = $mgBaik + $mgRusak;

        // ============================================================
        // 24. LAPTOP (BO-BQ)
        // ============================================================
        $laptopBaik = $item->laptop?->baik ?? 0;
        $laptopRusak = $item->laptop?->rusak ?? 0;
        $jmlLaptop   = $laptopBaik + $laptopRusak;

        // ============================================================
        // 25. KOMPUTER (BR-BT)
        // ============================================================
        $komputerBaik = $item->komputer?->baik ?? 0;
        $komputerRusak = $item->komputer?->rusak ?? 0;
        $jmlKomputer   = $komputerBaik + $komputerRusak;

        // ============================================================
        // OUTPUT 73 KOLOM (A - BU)
        // ============================================================
        return [
            // === IDENTITAS (A-G) ===
            $no,                                     // A: No
            $item->nama_sekolah,                     // B: Nama Sekolah
            $item->NPSN ?? '',                       // C: NPSN
            $item->alamat_sekolah ?? '',             // D: Alamat Sekolah
            $item->nama_kepala_sekolah ?? '',        // E: Nama Kepala Sekolah
            $item->NIP ?? '',                        // F: NIP
            $item->nomor_hp ?? '',                   // G: Nomor HP

            // === 1. JUMLAH SISWA (H-K) ===
            $siswaVii, $siswaViii, $siswaIx, $jmlSiswa,

            // === 2. JUMLAH ROMBEL (L-O) ===
            $rombelVii, $rombelViii, $rombelIx, $jmlRombel,

            // === 3. RUANG KELAS PER TINGKAT (P-S) ===
            $rkVii, $rkViii, $rkIx, $jmlRkTingkat,

            // === 4. RKB & REHABILITASI (T-U) ===
            $this->formatJumlahRuang($rkb),          // T
            $this->formatJumlahRuang($rehabilitasi), // U

            // === 5. RUANG KELAS (V-X) ===
            $rkBaik, $rkRusak, $jmlRk,

            // === 6. TOILET SISWA (Y-AA) ===
            $tsBaik, $tsRusak, $jmlTs,

            // === 7. TOILET GURU (AB-AD) ===
            $tgBaik, $tgRusak, $jmlTg,

            // === 8-19. ADA/TIDAK & KONDISI (AE-BB) ===
            $perpustakaan_ada, $perpustakaan_kondisi,
            $kepsek_ada, $kepsek_kondisi,
            $ruangGuru_ada, $ruangGuru_kondisi,
            $kantorTu_ada, $kantorTu_kondisi,
            $labIpa_ada, $labIpa_kondisi,
            $labKomputer_ada, $labKomputer_kondisi,
            $uks_ada, $uks_kondisi,
            $rumahDinas_ada, $rumahDinas_kondisi,
            $rumahIbadah_ada, $rumahIbadah_kondisi,
            $lapangan_ada, $lapangan_kondisi,
            $pagar_ada, $pagar_kondisi,
            $air_ada, $air_kondisi,

            // === 20. KURSI SISWA (BC-BE) ===
            $ksBaik, $ksRusak, $jmlKs,

            // === 21. MEJA SISWA (BF-BH) ===
            $msBaik, $msRusak, $jmlMs,

            // === 22. KURSI GURU (BI-BK) ===
            $kgBaik, $kgRusak, $jmlKg,

            // === 23. MEJA GURU (BL-BN) ===
            $mgBaik, $mgRusak, $jmlMg,

            // === 24. LAPTOP (BO-BQ) ===
            $laptopBaik, $laptopRusak, $jmlLaptop,

            // === 25. KOMPUTER (BR-BT) ===
            $komputerBaik, $komputerRusak, $jmlKomputer,

            // === 26. KETERANGAN / CATATAN (BU) ===
            $item->keterangan ?? '',                 // BU
        ];
    }

    /**
     * 'baik' / 'rusak' / 'nihil' (nilai di DB) -> label rapi seperti di template.
     */
    private function formatKondisi(?string $kondisi): string
    {
        if (!$kondisi) {
            return '-';
        }

        return match ($kondisi) {
            'baik' => 'Baik',
            'rusak' => 'Rusak',
            'nihil' => 'Nihil',
            default => ucfirst(str_replace('_', ' ', $kondisi)),
        };
    }

    /**
     * 'ada' / 'tidak_ada' (nilai di DB) -> "Ada" / "Tidak Ada".
     */
    private function formatAdaTidak(?string $adaTidak): string
    {
        if (!$adaTidak) {
            return '-';
        }

        return match ($adaTidak) {
            'ada' => 'Ada',
            'tidak_ada' => 'Tidak Ada',
            default => ucfirst(str_replace('_', ' ', $adaTidak)),
        };
    }

    /**
     * Angka jumlah ruang (RKB/Rehabilitasi) -> teks seperti di template
     * (mis. 2 -> "2 Ruang", 0 -> "Tidak Ada").
     */
    private function formatJumlahRuang(int $jumlah): string
    {
        return $jumlah > 0 ? "{$jumlah} Ruang" : 'Tidak Ada';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $rkbPeriode   = PeriodeLaporan::forKategori('rkb');
                $rehabPeriode = PeriodeLaporan::forKategori('rehabilitasi');
                $tahunSekarang = date('Y');

                // ============================================================
                // SISIPKAN 6 BARIS DI ATAS: 2 baris judul, 1 baris kosong,
                // 3 baris header (kategori besar -> sub kategori -> detail)
                // ============================================================
                $sheet->insertNewRowBefore(1, 6);

                // ============================================================
                // BARIS 1-2: JUDUL LAPORAN
                // ============================================================
                $sheet->setCellValue('A1', 'DATA KEADAAN SARANA PRASARANA SEKOLAH TINGKAT SMP');
                $sheet->setCellValue('A2', "DI KABUPATEN LAHAT TAHUN {$tahunSekarang}");

                $sheet->getStyle('A1:A2')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                ]);

                // ============================================================
                // BARIS 4-6: HEADER 3 TINGKAT
                // ============================================================
                // --- Identitas (rowspan 4-6) ---
                $sheet->mergeCells('A4:A6');
                $sheet->setCellValue('A4', 'No');

                $sheet->mergeCells('B4:B6');
                $sheet->setCellValue('B4', 'Nama Sekolah');

                // --- Kolom identitas tambahan (C-G) rowspan 4-6 ---
                $sheet->mergeCells('C4:C6');
                $sheet->setCellValue('C4', 'NPSN');

                $sheet->mergeCells('D4:D6');
                $sheet->setCellValue('D4', 'Alamat Sekolah');

                $sheet->mergeCells('E4:E6');
                $sheet->setCellValue('E4', 'Nama Kepala Sekolah');

                $sheet->mergeCells('F4:F6');
                $sheet->setCellValue('F4', 'NIP');

                $sheet->mergeCells('G4:G6');
                $sheet->setCellValue('G4', 'Nomor HP');

                // --- Jumlah Siswa (H-K) ---
                $sheet->mergeCells('H4:J5');
                $sheet->setCellValue('H4', 'Jumlah Siswa / Kelas');
                $sheet->mergeCells('K4:K6');
                $sheet->setCellValue('K4', 'Jumlah');

                // --- Jumlah Rombel (L-O) ---
                $sheet->mergeCells('L4:N5');
                $sheet->setCellValue('L4', 'Jumlah Rombel / Kelas');
                $sheet->mergeCells('O4:O6');
                $sheet->setCellValue('O4', 'Jumlah');

                // --- Jumlah Ruang Kelas per tingkat (P-S) ---
                $sheet->mergeCells('P4:R5');
                $sheet->setCellValue('P4', 'Jumlah Ruang Kelas');
                $sheet->mergeCells('S4:S6');
                $sheet->setCellValue('S4', 'Jumlah');

                // --- RKB (T) & Rehabilitasi (U), rowspan 4-6 ---
                $sheet->mergeCells('T4:T6');
                $sheet->setCellValue('T4', "Pembangunan Ruang Kelas Baru (RKB) Dari Tahun {$rkbPeriode->label()}");

                $sheet->mergeCells('U4:U6');
                $sheet->setCellValue('U4', "Rehabilitasi Ruang Kelas Dari Tahun {$rehabPeriode->label()}");

                // --- Grup besar "Ruang / Bangunan Gedung Sekolah" (V-BT) ---
                $sheet->mergeCells('V4:BT4');
                $sheet->setCellValue('V4', 'Ruang / Bangunan Gedung Sekolah');

                // Sub kategori baris 5 (colspan 2 atau 3, tergantung kategori)
                $subKategori = [
                    'V5:X5'   => 'Ruang Kelas',
                    'Y5:AA5'  => 'Toilet / Jamban Siswa / Ruang',
                    'AB5:AD5' => 'Toilet / Jamban Guru / Ruang',
                    'AE5:AF5' => 'R. Perpustakaan',
                    'AG5:AH5' => 'R. Kepala Sekolah',
                    'AI5:AJ5' => 'R. Guru',
                    'AK5:AL5' => 'R. Kantor / Tata Usaha',
                    'AM5:AN5' => 'R. Laboratorium IPA',
                    'AO5:AP5' => 'R. Laboratorium Komputer',
                    'AQ5:AR5' => 'R. Unit Kesehatan Sekolah',
                    'AS5:AT5' => 'Rumah Dinas',
                    'AU5:AV5' => 'Rumah Ibadah',
                    'AW5:AX5' => 'Lapangan Sekolah',
                    'AY5:AZ5' => 'Pagar Sekolah',
                    'BA5:BB5' => 'Persediaan Air Bersih',
                    'BC5:BE5' => 'Kursi Siswa',
                    'BF5:BH5' => 'Meja Siswa',
                    'BI5:BK5' => 'Kursi Guru',
                    'BL5:BN5' => 'Meja Guru',
                    'BO5:BQ5' => 'Laptop / Chromebook',
                    'BR5:BT5' => 'Komputer / PC',
                ];

                foreach ($subKategori as $range => $label) {
                    $sheet->mergeCells($range);
                    [$startCell] = explode(':', $range);
                    $sheet->setCellValue($startCell, $label);
                }

                // --- Keterangan / Catatan (BU), rowspan 4-6 ---
                $sheet->mergeCells('BU4:BU6');
                $sheet->setCellValue('BU4', 'Keterangan / Catatan');

                // ============================================================
                // BARIS 6: DETAIL (Baik/Rusak/Jumlah, VII/VIII/IX, Ada/Kondisi)
                // ============================================================
                $detailHeaders = [
                    'H' => 'VII', 'I' => 'VIII', 'J' => 'IX',
                    'L' => 'VII', 'M' => 'VIII', 'N' => 'IX',
                    'P' => 'VII', 'Q' => 'VIII', 'R' => 'IX',
                    'V' => 'Baik', 'W' => 'Rusak', 'X' => 'Jumlah',
                    'Y' => 'Baik', 'Z' => 'Rusak', 'AA' => 'Jumlah',
                    'AB' => 'Baik', 'AC' => 'Rusak', 'AD' => 'Jumlah',
                    'AE' => 'Ada / Tidak Ada', 'AF' => 'Kondisi',
                    'AG' => 'Ada / Tidak Ada', 'AH' => 'Kondisi',
                    'AI' => 'Ada / Tidak Ada', 'AJ' => 'Kondisi',
                    'AK' => 'Ada / Tidak Ada', 'AL' => 'Kondisi',
                    'AM' => 'Ada / Tidak Ada', 'AN' => 'Kondisi',
                    'AO' => 'Ada / Tidak Ada', 'AP' => 'Kondisi',
                    'AQ' => 'Ada / Tidak Ada', 'AR' => 'Kondisi',
                    'AS' => 'Ada / Tidak Ada', 'AT' => 'Kondisi',
                    'AU' => 'Ada / Tidak Ada', 'AV' => 'Kondisi',
                    'AW' => 'Ada / Tidak Ada', 'AX' => 'Kondisi',
                    'AY' => 'Ada / Tidak Ada', 'AZ' => 'Kondisi',
                    'BA' => 'Ada / Tidak Ada', 'BB' => 'Kondisi',
                    'BC' => 'Baik', 'BD' => 'Rusak', 'BE' => 'Jumlah',
                    'BF' => 'Baik', 'BG' => 'Rusak', 'BH' => 'Jumlah',
                    'BI' => 'Baik', 'BJ' => 'Rusak', 'BK' => 'Jumlah',
                    'BL' => 'Baik', 'BM' => 'Rusak', 'BN' => 'Jumlah',
                    'BO' => 'Baik', 'BP' => 'Rusak', 'BQ' => 'Jumlah',
                    'BR' => 'Baik', 'BS' => 'Rusak', 'BT' => 'Jumlah',
                ];

                foreach ($detailHeaders as $col => $label) {
                    $sheet->setCellValue($col.'6', $label);
                }

                // ============================================================
                // STYLING HEADER (baris 4-6) - SEMUA HIJAU MUDA
                // ============================================================
                $baseHeaderStyle = [
                    'font' => ['bold' => true, 'size' => 11],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => self::COLOR_HEADER],
                    ],
                ];

                // Apply ke seluruh header (A4:BU6)
                $sheet->getStyle('A4:BU6')->applyFromArray($baseHeaderStyle);

                // Highlight kolom "Jumlah" & "Kondisi" di baris detail (baris 6) dengan warna oranye
                $highlightCols = [
                    'X', 'AA', 'AD',
                    'AF', 'AH', 'AJ', 'AL', 'AN', 'AP', 'AR', 'AT', 'AV', 'AX', 'AZ', 'BB',
                    'BE', 'BH', 'BK', 'BN', 'BQ', 'BT',
                ];
                foreach ($highlightCols as $col) {
                    $sheet->getStyle($col.'6')->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['argb' => self::COLOR_ORANYE],
                        ],
                    ]);
                }

                // ============================================================
                // DATA ROWS (mulai baris 7)
                // ============================================================
                $highestRow = $sheet->getHighestRow();

                if ($highestRow >= 7) {
                    $sheet->getStyle('A7:BU'.$highestRow)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['argb' => 'FF000000'],
                            ],
                        ],
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_CENTER,
                            'wrapText' => true,
                        ],
                    ]);

                    // Highlight kolom "Jumlah"/"Kondisi"/RKB/Rehab di data
                    $dataHighlightCols = array_merge(['K', 'O', 'S', 'T', 'U'], $highlightCols);
                    foreach ($dataHighlightCols as $col) {
                        $sheet->getStyle($col.'7:'.$col.$highestRow)->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['argb' => self::COLOR_ORANYE],
                            ],
                            'font' => ['bold' => true],
                        ]);
                    }

                    // Center semua kolom data (H-BU)
                    $dataColumns = [
                        'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q',
                        'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
                        'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI',
                        'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ',
                        'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY',
                        'AZ', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG',
                        'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO',
                        'BP', 'BQ', 'BR', 'BS', 'BT', 'BU',
                    ];

                    foreach ($dataColumns as $col) {
                        $sheet->getStyle($col.'7:'.$col.$highestRow)
                            ->getAlignment()
                            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    }

                    $sheet->getStyle('A7:A'.$highestRow)
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    // Kolom B-G (identitas) rata kiri
                    $identitasCols = ['B', 'C', 'D', 'E', 'F', 'G'];
                    foreach ($identitasCols as $col) {
                        $sheet->getStyle($col.'7:'.$col.$highestRow)
                            ->getAlignment()
                            ->setHorizontal(Alignment::HORIZONTAL_LEFT);
                    }
                }

                // ============================================================
                // BARIS TOTAL: "J U M L A H"
                // ============================================================
                $footerRow = $highestRow + 1;

                $sheet->mergeCells('A'.$footerRow.':G'.$footerRow);
                $sheet->setCellValue('A'.$footerRow, 'J U M L A H');

                // Kolom yang dijumlahkan biasa (Baik/Rusak/Jumlah/VII/VIII/IX)
                $sumColumns = [
                    'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S',
                    'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD',
                    'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK',
                    'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT',
                ];
                foreach ($sumColumns as $col) {
                    $sum = 0;
                    for ($r = 7; $r <= $highestRow; $r++) {
                        $sum += (int) $sheet->getCell($col.$r)->getValue();
                    }
                    $sheet->setCellValue($col.$footerRow, $sum);
                }

                // Kolom "Ada / Tidak Ada" -> total = jumlah sekolah "Tidak Ada"
                // Kolom "Kondisi" -> total = jumlah sekolah dengan kondisi "Rusak"
                $adaTidakCols = [
                    'AE', 'AG', 'AI', 'AK', 'AM', 'AO', 'AQ', 'AS', 'AU', 'AW', 'AY', 'BA',
                ];
                $kondisiCols = [
                    'AF', 'AH', 'AJ', 'AL', 'AN', 'AP', 'AR', 'AT', 'AV', 'AX', 'AZ', 'BB',
                ];

                foreach ($adaTidakCols as $col) {
                    $count = 0;
                    for ($r = 7; $r <= $highestRow; $r++) {
                        if ($sheet->getCell($col.$r)->getValue() === 'Tidak Ada') {
                            $count++;
                        }
                    }
                    $sheet->setCellValue($col.$footerRow, $count);
                }

                foreach ($kondisiCols as $col) {
                    $count = 0;
                    for ($r = 7; $r <= $highestRow; $r++) {
                        if ($sheet->getCell($col.$r)->getValue() === 'Rusak') {
                            $count++;
                        }
                    }
                    $sheet->setCellValue($col.$footerRow, $count);
                }

                // T, U (RKB/Rehabilitasi teks) & BU (Keterangan) dibiarkan kosong di baris total

                // Styling baris total
                $sheet->getStyle('A'.$footerRow.':BU'.$footerRow)->applyFromArray([
                    'font' => ['bold' => true, 'size' => 13],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => self::COLOR_TOTAL],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // ============================================================
                // ROW HEIGHT, LEBAR KOLOM & FREEZE PANE
                // ============================================================
                $sheet->getRowDimension(1)->setRowHeight(18);
                $sheet->getRowDimension(2)->setRowHeight(18);
                $sheet->getRowDimension(4)->setRowHeight(20);
                $sheet->getRowDimension(5)->setRowHeight(20);
                $sheet->getRowDimension(6)->setRowHeight(28);

                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(33);
                $sheet->getColumnDimension('C')->setWidth(15);
                $sheet->getColumnDimension('D')->setWidth(30);
                $sheet->getColumnDimension('E')->setWidth(25);
                $sheet->getColumnDimension('F')->setWidth(15);
                $sheet->getColumnDimension('G')->setWidth(15);
                $sheet->getColumnDimension('T')->setWidth(18);
                $sheet->getColumnDimension('U')->setWidth(17);
                $sheet->getColumnDimension('BU')->setWidth(13);

                $sheet->freezePane('A7');
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 33,
            'C' => 15,
            'D' => 30,
            'E' => 25,
            'F' => 15,
            'G' => 15,
            'T' => 18,
            'U' => 17,
            'BU' => 13,
        ];
    }
}