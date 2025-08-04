<?php
/**
 * File: application/views/dashboard/index.php
 * Deskripsi: Halaman utama dashboard admin
 */
?>
<div class="container">
    <h3 class="text-center fw-bold mb-4">Selamat Datang di Dashboard Admin</h3>

    <!-- Grafik Net Margin -->
    <div class="card mb-4 border-primary">
        <div class="card-header bg-primary text-white fw-bold">Grafik Net Margin</div>
        <div class="card-body">
            <canvas id="chartNetMargin" height="120"></canvas>
        </div>
    </div>

    <!-- Grafik Arus Kas -->
    <div class="card mb-4 border-success">
        <div class="card-header bg-success text-white fw-bold">Grafik Arus Kas</div>
        <div class="card-body">
            <canvas id="chartArusKas" height="120"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctxNetMargin = document.getElementById('chartNetMargin').getContext('2d');
const chartNetMargin = new Chart(ctxNetMargin, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($chart_net_margin, 'bulan')) ?>,
        datasets: [{
            label: 'Net Margin',
            data: <?= json_encode(array_column($chart_net_margin, 'total')) ?>,
            backgroundColor: 'rgba(0, 128, 0, 0.6)',
            borderColor: 'green',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            x: {
                title: { display: true, text: 'Bulan' }
            },
            y: {
                beginAtZero: true,
                title: { display: true, text: 'Total Net Margin (Rp)' },
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});

const ctxArusKas = document.getElementById('chartArusKas').getContext('2d');
const chartArusKas = new Chart(ctxArusKas, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($chart_arus_kas, 'bulan')) ?>,
        datasets: [
            {
                label: 'Pemasukan',
                data: <?= json_encode(array_column($chart_arus_kas, 'pemasukan')) ?>,
                backgroundColor: 'blue'
            },
            {
                label: 'Pengeluaran',
                data: <?= json_encode(array_column($chart_arus_kas, 'pengeluaran')) ?>,
                backgroundColor: 'red'
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            x: {
                title: { display: true, text: 'Bulan' }
            },
            y: {
                beginAtZero: true,
                title: { display: true, text: 'Jumlah (Rp)' },
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});
</script>
