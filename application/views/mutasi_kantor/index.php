<div class="container mt-4">
    <h3><?= $title ?></h3>

    <a href="<?= site_url('mutasi_kantor/tambah') ?>" class="btn btn-success mb-3">+ Tambah Mutasi</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Nominal (Rp)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0; foreach ($mutasi as $row): $total += $row->nominal; ?>
            <tr>
                <td><?= date('d-m-Y', strtotime($row->tanggal)) ?></td>
                <td><?= $row->keterangan ?></td>
                <td class="text-end">Rp <?= number_format($row->nominal, 0, ',', '.') ?></td>
                <td>
                    <a href="<?= site_url('mutasi_kantor/edit/' . $row->id) ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="<?= site_url('mutasi_kantor/hapus/' . $row->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus mutasi ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="2"><strong>Total Uang Masuk</strong></td>
                <td class="text-end"><strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>
