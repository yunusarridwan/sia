<h3 style="text-align:center">Laporan Lembur</h3>
<p><strong>Nama:</strong> <?= $karyawan->nama ?></p>

<table width="100%" border="1" cellpadding="6" cellspacing="0">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Jumlah Jam</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($detail as $row): ?>
        <tr>
            <td><?= date('d-m-Y', strtotime($row->tanggal)) ?></td>
            <td><?= $row->jumlah_jam ?> jam</td>
            <td><?= $row->keterangan ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
