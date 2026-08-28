/**
 * Live Search — Tabel "Data Sarana Sekolah"
 * ============================================================
 * Memfilter baris tabel secara langsung (tanpa reload halaman)
 * berdasarkan SEMUA teks yang tampil di setiap baris — nama
 * sekolah, NPSN, alamat, kepala sekolah, NIP, no. HP, jumlah
 * siswa/rombel, status ruang/bangunan, kondisi, keterangan, dsb.
 * Jadi pencarian tidak dibatasi hanya ke nama sekolah saja.
 *
 * Elemen yang dibutuhkan di HTML (lihat resources/views/admin/data/index.blade.php):
 *   #tabelSarana          -> elemen <x-table> (pembungkus tabel)
 *   [data-sarana-row]     -> penanda pada setiap <x-table.row> data
 *   #searchSarana         -> input teks pencarian
 *   #searchSaranaClear    -> tombol "x" untuk menghapus pencarian
 *   #searchSaranaCount    -> label "X dari Y sekolah"
 *   #searchSaranaNoResult -> baris yang muncul saat hasil kosong
 *
 * Cara pakai: import file ini di resources/js/app.js
 *   import './sarana-search.js';
 */

document.addEventListener('DOMContentLoaded', function () {
    const table = document.getElementById('tabelSarana');
    const input = document.getElementById('searchSarana');

    // Kalau halaman ini tidak punya tabel/input pencarian, tidak usah jalan
    if (!table || !input) {
        return;
    }

    const clearBtn   = document.getElementById('searchSaranaClear');
    const countLabel = document.getElementById('searchSaranaCount');
    const noResult   = document.getElementById('searchSaranaNoResult');

    const rows = table.querySelectorAll('[data-sarana-row]');
    const totalData = rows.length;

    function applyFilter() {
        const keyword = input.value.trim().toLowerCase();
        let visibleCount = 0;

        rows.forEach(function (row) {
            // Cari dari APAPUN teks yang tampil di baris ini (semua kolom)
            const teksBaris = row.textContent.toLowerCase();
            const cocok = keyword === '' || teksBaris.includes(keyword);

            row.classList.toggle('hidden', !cocok);
            if (cocok) {
                visibleCount++;
            }
        });

        // Tombol "x" untuk menghapus pencarian
        if (clearBtn) {
            clearBtn.classList.toggle('hidden', keyword === '');
        }

        // Label jumlah hasil
        if (countLabel) {
            if (keyword === '') {
                countLabel.classList.add('hidden');
            } else {
                countLabel.textContent = visibleCount + ' dari ' + totalData + ' sekolah';
                countLabel.classList.remove('hidden');
            }
        }

        // Baris "tidak ditemukan"
        if (noResult) {
            const tampilkanNoResult = keyword !== '' && visibleCount === 0;
            noResult.classList.toggle('hidden', !tampilkanNoResult);
        }
    }

    input.addEventListener('input', applyFilter);

    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            input.value = '';
            applyFilter();
            input.focus();
        });
    }
});
