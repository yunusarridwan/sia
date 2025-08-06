<div class="container mt-4">
    <h3 class="mb-4"><?= $title ?></h3>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="mb-4 p-3 bg-light rounded shadow-sm">
        <form action="<?= site_url('gaji') ?>" method="get" class="row align-items-end">
            <div class="col-md-5">
                <label for="start_date" class="form-label fw-bold">Dari Tanggal</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="<?= $this->input->get('start_date') ?>">
            </div>
            <div class="col-md-5">
                <label for="end_date" class="form-label fw-bold">Sampai Tanggal</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="<?= $this->input->get('end_date') ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-info w-100">Filter</button>
            </div>
        </form>
    </div>

    <?php 
    // Cek apakah pengguna sudah melakukan filter
    $is_filtered = $this->input->get('start_date') && $this->input->get('end_date');
    ?>

    <?php if ($is_filtered): ?>
    <div class="mb-3">
        <a href="<?= site_url('gaji/rekap_otomatis?start_date=' . $this->input->get('start_date') . '&end_date=' . $this->input->get('end_date')) ?>" class="btn btn-primary">+ Buat Rekap Otomatis</a>
    </div>
    <?php endif; ?>

    <?php if ($is_filtered): ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Bulan Gaji</th>
                    <th>Izin</th>
                    <th>Sakit</th>
                    <th>Telat</th>
                    <th>Gaji Pokok</th>
                    <th>Tunjangan</th>
                    <th>Potongan</th>
                    <th>Total Gaji</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($gaji)) : $no = 1; foreach ($gaji as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row->nama ?? '<span class="text-danger">Nama?</span>' ?></td>
                        <td><?= date('F Y', strtotime($row->bulan . '-01')) ?></td>
                        <td><?= $row->total_izin ?></td>
                        <td><?= $row->sakit ?? 0 ?></td>
                        <td><?= $row->total_telat ?></td>
                        <td><?= 'Rp ' . number_format($row->gaji_pokok, 0, ',', '.') ?></td>
                        <td><?= 'Rp ' . number_format($row->total_tambahan ?? 0, 0, ',', '.') ?></td>
                        <td><?= 'Rp ' . number_format($row->potongan_absen ?? 0, 0, ',', '.') ?></td>
                        <td><strong><?= 'Rp ' . number_format($row->total_gaji, 0, ',', '.') ?></strong></td>
                        <td>
                            <a href="<?= site_url('gaji/edit/' . $row->id) ?>" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr>
                        <td colspan="11" class="text-center">
                            <?php if ($this->session->flashdata('rekap_needed')): ?>
                                <div class="alert alert-warning mb-0">
                                    <?= $this->session->flashdata('rekap_needed') ?><br>
                                    <a href="<?= site_url('gaji/rekap_otomatis?start_date=' . $this->input->get('start_date') . '&end_date=' . $this->input->get('end_date')) ?>" class="btn btn-primary btn-sm mt-2">
                                        + Klik di sini untuk Membuat Rekapnya Sekarang
                                    </a>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div class="alert alert-info">
            Silakan pilih rentang tanggal terlebih dahulu, lalu klik "Filter" untuk menampilkan data.
        </div>
    <?php endif; ?>

</div>