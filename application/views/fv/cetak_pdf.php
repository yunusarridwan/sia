<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Fixed & Variable Cost</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h3, h5 { margin: 0; padding: 0; }
        .kop { text-align: center; margin-bottom: 20px; }
        .kop h3 { margin-bottom: 5px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #000; padding: 6px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <div class="kop">
        <h3>PT. Contoh Perusahaan</h3>
        <p><strong>Laporan Fixed & Variable Cost</strong></p>
        <p>Periode: <?= date('d-m-Y', strtotime($start_date)) ?> s.d <?= date('d-m-Y', strtotime($end_date)) ?></p>
        <hr>
    </div>

    <!-- FIXED COST -->
    <h5>📌 Fixed Cost</h5>
    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php $total_fc = 0; ?>
            <?php foreach ($fixed as $row): ?>
                <?php $total_fc += $row->nominal; ?>
                <tr>
                    <td><?= date('d-m-Y', strtotime($row->tanggal)) ?></td>
                    <td><?= $row->keterangan ?></td>
                    <td class="text-right"><?= number_format($row->nominal, 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>

            <?php foreach ($pc_fc as $item): ?>
                <?php $total_fc += $item['nominal']; ?>
                <tr>
                    <td><?= date('d-m-Y', strtotime($item['tanggal'])) ?></td>
                    <td><?= $item['kategori'] ?> (Petty Cash)</td>
                    <td class="text-right"><?= number_format($item['nominal'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>

            <tr>
                <td colspan="2"><strong>Total Fixed Cost</strong></td>
                <td class="text-right"><strong><?= number_format($total_fc, 0, ',', '.') ?></strong></td>
            </tr>
        </tbody>
    </table>

    <!-- VARIABLE COST -->
    <h5>📌 Variable Cost</h5>
    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php $total_vc = 0; ?>
            <?php foreach ($variable as $row): ?>
                <?php $total_vc += $row->nominal; ?>
                <tr>
                    <td><?= date('d-m-Y', strtotime($row->tanggal)) ?></td>
                    <td><?= $row->keterangan ?></td>
                    <td class="text-right"><?= number_format($row->nominal, 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>

            <?php foreach ($pc_vc as $item): ?>
                <?php $total_vc += $item['nominal']; ?>
                <tr>
                    <td><?= date('d-m-Y', strtotime($item['tanggal'])) ?></td>
                    <td><?= $item['kategori'] ?> (Petty Cash)</td>
                    <td class="text-right"><?= number_format($item['nominal'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>

            <tr>
                <td colspan="2"><strong>Total Variable Cost</strong></td>
                <td class="text-right"><strong><?= number_format($total_vc, 0, ',', '.') ?></strong></td>
            </tr>
        </tbody>
    </table>

    <!-- TOTAL -->
    <h4 class="text-right">💰 Total Keseluruhan: Rp <?= number_format($total_fc + $total_vc, 0, ',', '.') ?></h4>

</body>
</html>
