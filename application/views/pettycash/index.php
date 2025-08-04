<div class="container-fluid px-4">
    <h3 class="mt-4 mb-3"><?= $title ?></h3>
    
    <!-- FILTER TANGGAL -->
    <form method="get" class="row g-2 align-items-center mb-3">
        <div class="col-md-auto">
            <label for="tanggal_awal" class="col-form-label">Dari Tanggal:</label>
        </div>
        <div class="col-md-2">
            <input type="date" name="tanggal_awal" value="<?= $tanggal_awal ?>" class="form-control" required>
        </div>
        <div class="col-md-auto">
            <label for="tanggal_akhir" class="col-form-label">Sampai Tanggal:</label>
        </div>
        <div class="col-md-2">
            <input type="date" name="tanggal_akhir" value="<?= $tanggal_akhir ?>" class="form-control" required>
        </div>
        <div class="col-md-auto">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="<?= site_url('pettycash') ?>" class="btn btn-secondary ms-2">Reset</a>
        </div>
    </form>

    <!-- AKSI -->
    <div class="mb-3">
        <a href="<?= site_url('pettycash/tambah') ?>" class="btn btn-success me-2">+ Tambah Data</a>
        <a href="<?= site_url('pettycash/cetak?tanggal_awal='.$tanggal_awal.'&tanggal_akhir='.$tanggal_akhir) ?>" target="_blank" class="btn btn-danger">Cetak PDF</a>
    </div>

    <!-- TABEL -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Keterangan</th>
                    <th class="text-end">Nominal (Rp)</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                if ($pettycash) :
                    foreach ($pettycash as $row) : 
                        $total += $row->nominal;
                ?>
                <tr>
                    <td><?= date('d M Y', strtotime($row->tanggal)) ?></td>
                    <td><?= ucwords(str_replace('_', ' ', $row->kategori)) ?></td>
                    <td><?= $row->keterangan ?></td>
                    <td class="text-end"><?= number_format($row->nominal, 0, ',', '.') ?></td>
                    <td class="text-center">
                        <a href="<?= site_url('pettycash/edit/'.$row->id) ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="<?= site_url('pettycash/hapus/'.$row->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data</td>
                </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total</th>
                    <th class="text-end"><?= number_format($total, 0, ',', '.') ?></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
