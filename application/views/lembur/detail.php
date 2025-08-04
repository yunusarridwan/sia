<div class="container mt-4">
    <h3 class="mb-4">Detail Lembur - <?= $karyawan->nama ?></h3>

    <div class="mb-3">
        <a href="<?= site_url('rekaplembur/tambah/'.$karyawan->id) ?>" class="btn btn-success">+ Tambah Lembur</a>
        <a href="<?= site_url('rekaplembur/cetak/'.$karyawan->id) ?>" class="btn btn-danger" target="_blank">Cetak PDF</a>
        <a href="<?= site_url('rekaplembur') ?>" class="btn btn-secondary">Kembali</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Tanggal</th>
                <th>Jam Mulai - Selesai</th>
                <th>Total Jam</th>
                <th>Tujuan</th>
                <th>Uang Makan</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total_jam = 0;
            $total_uang_makan = 0;
            if ($lembur): 
                foreach ($lembur as $row): 
                    $start  = new DateTime($row->jam_mulai);
                    $end    = new DateTime($row->jam_selesai);
                    $diff   = $start->diff($end);
                    $jam = $diff->h;
                    $total_jam += $jam;
                    $total_uang_makan += $row->uang_makan;
            ?>
                <tr>
                    <td><?= date('d-m-Y', strtotime($row->tanggal)) ?></td>
                    <td><?= date('H:i', strtotime($row->jam_mulai)) ?> - <?= date('H:i', strtotime($row->jam_selesai)) ?></td>
                    <td><?= $jam ?> jam</td>
                    <td><?= $row->tujuan ?></td>
                    <td>Rp <?= number_format($row->uang_makan, 0, ',', '.') ?></td>
                    <td class="text-center">
                        <a href="<?= site_url('rekaplembur/edit/'.$row->id) ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="<?= site_url('rekaplembur/hapus/'.$row->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>

                <!-- Baris Total -->
                <tr class="table-secondary fw-bold">
                    <td colspan="2" class="text-end">Total</td>
                    <td><?= $total_jam ?> jam</td>
                    <td></td>
                    <td>Rp <?= number_format($total_uang_makan, 0, ',', '.') ?></td>
                    <td></td>
                </tr>
                <tr class="table-success fw-bold">
                    <td colspan="4" class="text-end">Total Tambahan</td>
                    <td colspan="2">
                        <?php 
                            $total_tambahan = ($total_jam * 10000) + $total_uang_makan;
                            echo 'Rp ' . number_format($total_tambahan, 0, ',', '.');
                        ?>
                    </td>
                </tr>

            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Belum ada data lembur</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
