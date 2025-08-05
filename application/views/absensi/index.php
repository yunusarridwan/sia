<div class="container mt-4">
    <h3 class="mb-3"><?= $title ?></h3>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('warning')): ?>
        <div class="alert alert-warning"><?= $this->session->flashdata('warning') ?></div>
    <?php endif; ?>

    <div class="mb-3">
        <a href="<?= site_url('absensi/upload') ?>" class="btn btn-success">Import Absensi</a>
    </div>

    <form method="get" class="form-inline mb-3">
        <label for="start_date">Dari Tanggal:</label>
        <input type="date" name="start_date" id="start_date" class="form-control mx-2" value="<?= $this->input->get('start_date') ?>">
        
        <label for="end_date">Sampai Tanggal:</label>
        <input type="date" name="end_date" id="end_date" class="form-control mx-2" value="<?= $this->input->get('end_date') ?>">
        
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Karyawan ID</th>
                <th>Nama Karyawan</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($absensi)) : ?>
                <?php $no = 1; foreach ($absensi as $a): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $a->karyawan_id ?></td>
                        <td><?= isset($a->nama) ? $a->nama : '-' ?></td>
                        <td><?= date('d-m-Y', strtotime($a->tanggal)) ?></td>
                        <td><?= $a->jam_masuk ?></td>
                        <td>
                            <?php if ($a->status == 'telat'): ?>
                                <span class="badge bg-danger text-white">Telat</span>
                            <?php else: ?>
                                <span class="badge bg-success text-white">Hadir</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" class="text-center">Belum ada data absensi</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>