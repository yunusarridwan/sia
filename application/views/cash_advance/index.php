<div class="container-fluid mt-4">
    <h3 class="mb-4"><?= $title ?></h3>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="mb-3">
        <a href="<?= site_url('cash_advance/tambah') ?>" class="btn btn-success">+ Tambah Cash Advance</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Karyawan</th>
                    <th>Jabatan</th>
                    <th>No. Account</th>
                    <th class="text-end">Total LOT</th>
                    <th class="text-end">Jumlah CA</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($cash_advance_list)): $no = 1; ?>
                    <?php foreach ($cash_advance_list as $ca): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('d F Y', strtotime($ca->tanggal)) ?></td>
                            <td><?= $ca->nama_karyawan ?? 'N/A' ?></td>
                            <td><?= $ca->jabatan ?></td>
                            <td><?= $ca->no_rekening ?></td>
                            <td class="text-end"><?= $ca->total_lot ?? 0 ?></td>
                            <td class="text-end fw-bold"><?= number_format($ca->jumlah, 0, ',', '.') ?></td>
                            <td><?= $ca->keterangan ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center p-4">Tidak ada data cash advance pada periode ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>