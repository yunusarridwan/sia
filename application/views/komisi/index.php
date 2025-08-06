<div class="container-fluid mt-4">
    <h3 class="mb-1"><?= $title ?></h3>
    
    <p class="text-muted">Untuk Periode: <strong><?= $judul_periode ?></strong></p>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="<?= site_url('komisi') ?>" method="get" class="row align-items-end">
                <div class="col-md-4">
                    <label for="bulan" class="form-label fw-bold">Pilih Periode Bulan</label>
                    <input type="month" name="bulan" id="bulan" class="form-control" value="<?= $this->input->get('bulan') ?? date('Y-m') ?>">
                </div>
                <div class="col-md-5">
                    <button type="submit" class="btn btn-info">Tampilkan Rekap</button>
                    
                    <a href="<?= site_url('komisi/export_excel?bulan=' . ($this->input->get('bulan') ?? date('Y-m'))) ?>" class="btn btn-success ms-2">
                        <i class="fas fa-file-excel"></i> Export to Excel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-8">
             <a href="<?= site_url('komisi/tambah_komisi') ?>" class="btn btn-primary">+ Tambah Komisi</a>
             <a href="<?= site_url('komisi/tambah_ca') ?>" class="btn btn-success">+ Tambah Cash Advance</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark text-center">
                <tr>
                    <th>Nama</th>
                    <th>Komisi Mini</th>
                    <th>Komisi Reguler</th>
                    <th>Total OR</th>
                    <th>Total Komisi Karyawan</th>
                    <th>Cash Advance (CA)</th>
                    <th>Total Payout</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($rekap)): ?>
                    <?php foreach ($rekap as $row): ?>
                        <tr>
                            <td><?= $row['nama'] ?></td>
                            <td class="text-end"><?= number_format($row['komisi_mini']) ?></td>
                            <td class="text-end"><?= number_format($row['komisi_reguler']) ?></td>
                            <td class="text-end"><?= number_format($row['total_or']) ?></td>
                            <td class="text-end fw-bold"><?= number_format($row['total_komisi']) ?></td>
                            <td class="text-end text-danger fw-bold">(<?= number_format($row['cash_advance']) ?>)</td>
                            <td class="text-end table-primary fw-bold"><?= number_format($row['total_payout']) ?></td>
                            <td class="text-center">
                                <a href="<?= site_url('komisi/detail/' . $row['karyawan_id'] . '?start_date=' . $start_date_for_link . '&end_date=' . $end_date_for_link) ?>" class="btn btn-sm btn-secondary">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center p-4">Tidak ada data komisi karyawan pada periode ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>