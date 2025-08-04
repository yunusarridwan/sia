<div class="container mt-4">
    <h3 class="mb-4">Rekap Laporan</h3>
    <a href="<?= site_url('rekap_laporan/cetak') ?>" class="btn btn-sm btn-danger mb-3" target="_blank">
        <i class="bi bi-file-earmark-pdf"></i> Cetak PDF
    </a>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>Total Pemasukan (Mutasi dari Pusat)</th>
                        <td>Rp <?= number_format($laporan['pemasukan'], 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <th>Total Pengeluaran Petty Cash</th>
                        <td>Rp <?= number_format($laporan['pengeluaran_petty'], 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <th>Total Pengeluaran Fixed & Variable Cost</th>
                        <td>Rp <?= number_format($laporan['pengeluaran_fv'], 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <th>Total Pengeluaran</th>
                        <td>Rp <?= number_format($laporan['total_pengeluaran'], 0, ',', '.') ?></td>
                    </tr>
                    <tr class="table-success">
                        <th>Total</th>
                        <td><strong>Rp <?= number_format($laporan['net_margin'], 0, ',', '.') ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
