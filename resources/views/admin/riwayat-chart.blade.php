{{-- Ditempatkan di halaman detail sekolah (sarana.show) --}}

<div class="card mb-4">
    <div class="card-body">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                <i class="bi bi-graph-up"></i> Riwayat Perubahan Sarana
            </h2>

            <select id="kategoriRiwayat" class="text-sm rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-3 py-1.5">
                {{-- diisi otomatis lewat JS dari endpoint kategori-list --}}
            </select>
        </div>

        <div class="h-72">
            <canvas id="chartRiwayatSarana"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', async function () {
    const profileSekolahId = {{ $profileSekolah->id }};
    const select = document.getElementById('kategoriRiwayat');
    let chart = null;

    // 1. Isi dropdown dari daftar kategori
    const kategoriRes = await fetch("{{ route('sarana.kategori-list') }}");
    const kategoriList = await kategoriRes.json();

    kategoriList.forEach(k => {
        const opt = document.createElement('option');
        opt.value = k.key;
        opt.textContent = k.label;
        select.appendChild(opt);
    });

    // 2. Fungsi ambil data & gambar/redraw chart
    async function loadChart(kategoriKey) {
        const res = await fetch(`/sarana/${profileSekolahId}/chart-history?kategori=${kategoriKey}`);
        const result = await res.json();

        const datasets = Object.entries(result.series).map(([label, data], idx) => ({
            label,
            data,
            borderColor: ['#22c55e', '#f43f5e', '#3b82f6', '#f59e0b'][idx % 4],
            tension: 0.3,
        }));

        if (chart) chart.destroy();

        chart = new Chart(document.getElementById('chartRiwayatSarana'), {
            type: 'line',
            data: { labels: result.labels, datasets },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            // Kategori ada_kondisi pakai skala 0/0.5/1, beri label khusus
                            callback: (value) => {
                                if (result.type === 'ada_kondisi') {
                                    return { 0: 'Tidak Ada', 0.5: 'Ada, Rusak', 1: 'Ada, Baik' }[value] ?? '';
                                }
                                return value;
                            },
                        },
                    },
                },
            },
        });
    }

    // 3. Load pertama kali + saat dropdown berubah
    if (kategoriList.length) {
        select.value = kategoriList[0].key;
        loadChart(kategoriList[0].key);
    }
    select.addEventListener('change', (e) => loadChart(e.target.value));
});
</script>
@endpush
