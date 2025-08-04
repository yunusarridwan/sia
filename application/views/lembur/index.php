<div class="container-fluid px-4">
    <h3 class="mt-4 mb-3">Daftar Lembur Pegawai</h3>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nama Pegawai</th>
                <th>Jabatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($karyawan as $row): ?>
                <tr>
                    <td><?= $row->nama ?></td>
                    <td><?= $row->jabatan ?></td>
                    <td>
                        <a href="<?= site_url('rekaplembur/detail/' . $row->id) ?>" class="btn btn-primary btn-sm">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
