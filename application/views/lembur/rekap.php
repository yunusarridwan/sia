<div class="container mt-4">
    <h3><?= $title ?></h3>
    <form method="get" class="form-inline mb-3">
        <label>Dari:</label>
        <input type="date" name="start" value="<?= $data['start'] ?>" class="form-control mx-2" required>
        <label>Sampai:</label>
        <input type="date" name="end" value="<?= $data['end'] ?>" class="form-control mx-2" required>
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="<?= site_url('rekap_lembur/cetak_pdf?start=' . $data['start'] . '&end=' . $data['end']) ?>" class="btn btn-danger ml-2" target="_blank">Cetak PDF</a>
    </form>

    <?php if (!empty($data['rows'])) : ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Total Jam</th>
                    <th>Total Lembur</th>
                    <th>Uang Makan</th>
                    <th>Total Semua</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['rows'] as $nama => $row) : ?>
                    <tr>
                        <td><?= $nama ?></td>
                        <td><?= $row['jabatan'] ?></td>
                        <td><?= $row['total_jam'] ?></td>
                        <td>Rp <?= number_format($row['total_lembur'], 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($row['total_makan'], 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($row['total_all'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php else : ?>
        <div class="alert alert-info">Data tidak ditemukan.</div>
    <?php endif ?>
</div>
