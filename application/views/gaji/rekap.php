<h4 class="mb-3">Rekap Gaji Pegawai – Periode <?= $bulan ?></h4>

<table class="table table-bordered table-striped">
    <thead class="table-success">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Telat</th>
            <th>Sakit</th>
            <th>Izin</th>
            <th>Gaji Pokok</th>
            <th>Insentif Visit</th>
            <th>Insentif Lain</th>
            <th>Potongan</th>
            <th>Total</th>
            <th>Gaji Diterima</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($rekap as $r): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $r['nama'] ?></td>
            <td><?= $r['jabatan'] ?></td>
            <td><?= $r['telat'] ?></td>
            <td><?= $r['sakit'] ?></td>
            <td><?= $r['izin'] ?></td>
            <td>Rp <?= number_format($r['gaji_pokok'], 0, ',', '.') ?></td>
            <td>Rp <?= number_format($r['insentif_visit'], 0, ',', '.') ?></td>
            <td>Rp <?= number_format($r['insentif_lain'], 0, ',', '.') ?></td>
            <td>Rp <?= number_format($r['potongan'], 0, ',', '.') ?></td>
            <td>Rp <?= number_format($r['total'], 0, ',', '.') ?></td>
            <td class="table-primary"><strong>Rp <?= number_format($r['gaji_diterima'], 0, ',', '.') ?></strong></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
