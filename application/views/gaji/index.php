<div class="container mt-4">
    <h3 class="mb-4"><?= $title ?></h3>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>

    <div class="mb-3">
        <a href="<?= site_url('gaji/rekap_otomatis') ?>" class="btn btn-primary">+ Rekap Otomatis</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Bulan</th>
                    <th>Izin</th>
                    <th>Sakit</th>
                    <th>Telat</th>
                    <th>Insentif</th>
                    <th>Total Tambahan</th>
                    <th>Potongan</th>
                    <th>Gaji Pokok</th>
                    <th>Total Gaji</th>
                    <th>Tanggal Input</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($gaji)) : $no = 1; foreach ($gaji as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row->nama ?></td>
                        <td><?= $row->bulan ?></td>
                        <td><?= $row->total_izin ?></td>
                        <td><?= $row->total_sakit ?? 0 ?></td>
                        <td><?= $row->total_telat ?></td>
                        <td><?= number_format($row->insentif ?? 0, 0, ',', '.') ?></td>
                        <td><?= number_format($row->total_tambahan ?? 0, 0, ',', '.') ?></td>
                        <td><?= number_format($row->potongan_absen ?? 0, 0, ',', '.') ?></td>
                        <td><?= number_format($row->gaji_pokok, 0, ',', '.') ?></td>
                        <td><strong><?= number_format($row->total_gaji, 0, ',', '.') ?></strong></td>
                        <td><?= date('d-m-Y H:i', strtotime($row->tanggal_dibuat)) ?></td>
                        <td>
                            <a href="<?= site_url('gaji/edit/' . $row->id) ?>" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="13" class="text-center">Belum ada data gaji.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
