<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h4, h5 { margin: 0; padding: 0; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 6px; text-align: left; }
        .kop { text-align: center; margin-bottom: 10px; }
        .periode { margin-top: 5px; text-align: center; }
    </style>
</head>
<body>

<div class="kop">
    <h4>PT MAHADANA ASTA BERJANGKA - CABANG SKY SERPONG</h4>
    <p>Jl. Boulevard Raya Gading Serpong, No.30, Cihuni, Kec. Pagedangan, Kab. Tangerang Banten<br>
    Telp: (021) 55680511 | Email: mabskyserpong01@gmail.com</p>
    <hr>
</div>

<h5>LAPORAN REKAPAN ARUS KAS</h5>
<p class="periode">Periode: <?= $start_date ?> s.d <?= $end_date ?></p>

<table>
    <tbody>
        <tr>
            <th>Total Pemasukan (Mutasi dari Pusat)</th>
            <td>Rp <?= number_format($laporan['pemasukan'], 0, ',', '.') ?></td>
        </tr>
        <tr>
            <th>Total Pengeluaran Petty Cash</th>
            <td>Rp <?= number_format($laporan['pengeluaran_petty'], 0, ',', '.') ?></td>
        </tr>
        <tr>
            <th>Total Pengeluaran Fixed & Variable Cost</th>
            <td>Rp <?= number_format($laporan['pengeluaran_fv'], 0, ',', '.') ?></td>
        </tr>
        <tr>
            <th>Total Pengeluaran</th>
            <td>Rp <?= number_format($laporan['total_pengeluaran'], 0, ',', '.') ?></td>
        </tr>
        <tr>
            <th><strong>Total</strong></th>
            <td><strong>Rp <?= number_format($laporan['net_margin'], 0, ',', '.') ?></strong></td>
        </tr>
    </tbody>
</table>

</body>
</html>
