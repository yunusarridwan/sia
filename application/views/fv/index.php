<div class="container mt-4">   
    <h3><?= $title ?></h3>

    <form method="get" class="form-inline mb-3">
        <label for="start_date">Dari Tanggal:</label>
        <input type="date" name="start_date" class="form-control mx-2" value="<?= $start ?>">
        <label for="end_date">Sampai Tanggal:</label>
        <input type="date" name="end_date" class="form-control mx-2" value="<?= $end ?>">
        <button type="submit" class="btn btn-primary mx-1">Filter</button>
        <a href="<?= site_url('FixedVariableCost') ?>" class="btn btn-secondary">Reset</a>
        <a href="<?= site_url('FixedVariableCost/cetak?start_date=' . $start . '&end_date=' . $end) ?>" class="btn btn-danger mx-2" target="_blank">Cetak PDF</a>
        <a href="<?= site_url('fixed_variable_cost/tambah') ?>" class="btn btn-success">+ Tambah Data</a>

    </form>

    <div class="row">
        <!-- FIXED COST -->
        <div class="col-md-6">
            <h5>📌 Fixed Cost</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Nominal (Rp)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total_fc = 0;
                    foreach ($fc as $row): 
                        $total_fc += $row->nominal;
                    ?>
                    <tr>
                        <td><?= date('d-m-Y', strtotime($row->tanggal)) ?></td>
                        <td><?= $row->keterangan ?></td>
                        <td class="text-right">Rp <?= number_format($row->nominal, 0, ',', '.') ?></td>
                        <td>
                            <a href="<?= site_url('FixedVariableCost/edit/' . $row->id) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="<?= site_url('FixedVariableCost/hapus/' . $row->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <!-- Tambahan dari Petty Cash kategori FC -->
                    <?php foreach ($pc_fc as $row): ?>
                    <tr>
                        <td><?= $row['tanggal'] ? date('d-m-Y', strtotime($row['tanggal'])) : '' ?></td>
                        <td><?= $row['kategori'] ?></td>
                        <td class="text-right">Rp <?= number_format($row['nominal'], 0, ',', '.') ?></td>
                        <td></td>
                    </tr>
                    <?php $total_fc += $row['nominal']; endforeach; ?>

                    <tr>
                        <td colspan="2"><strong>Subtotal</strong></td>
                        <td class="text-right"><strong>Rp <?= number_format($total_fc, 0, ',', '.') ?></strong></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- VARIABLE COST -->
        <div class="col-md-6">
            <h5>📌 Variable Cost</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Nominal (Rp)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total_vc = 0;
                    foreach ($vc as $row): 
                        $total_vc += $row->nominal;
                    ?>
                    <tr>
                        <td><?= date('d-m-Y', strtotime($row->tanggal)) ?></td>
                        <td><?= $row->keterangan ?></td>
                        <td class="text-right">Rp <?= number_format($row->nominal, 0, ',', '.') ?></td>
                        <td>
                            <a href="<?= site_url('FixedVariableCost/edit/' . $row->id) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="<?= site_url('FixedVariableCost/hapus/' . $row->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <!-- Tambahan dari Petty Cash kategori VC -->
                    <?php foreach ($pc_vc as $row): ?>
                    <tr>
                        <td><?= $row['tanggal'] ? date('d-m-Y', strtotime($row['tanggal'])) : '' ?></td>
                        <td><?= $row['kategori'] ?></td>
                        <td class="text-right">Rp <?= number_format($row['nominal'], 0, ',', '.') ?></td>
                        <td></td>
                    </tr>
                    <?php $total_vc += $row['nominal']; endforeach; ?>

                    <tr>
                        <td colspan="2"><strong>Subtotal</strong></td>
                        <td class="text-right"><strong>Rp <?= number_format($total_vc, 0, ',', '.') ?></strong></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <h5 class="text-right mt-3">💰 Total Keseluruhan: 
        <strong>Rp <?= number_format($total_fc + $total_vc, 0, ',', '.') ?></strong>
    </h5>
</div>
