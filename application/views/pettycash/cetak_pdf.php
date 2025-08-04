<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .kop {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }
        .kop h2, .kop p { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        .subtotal, .total {
            font-weight: bold;
            text-align: right;
        }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="kop">
        <h2>PT MAHADANA ASTA BERJANGKA - CABANG SKY SERPONG</h2>
        <p>Jl.Boulevard Raya Gading Serpong, No.30, Cihuni, Kec. Pagedangan, Kab.Tanggerang Banten</p>
        <p>Telp: (021) 55680511 | Email: mabskyserpon01@gmail.com</p>
    </div>

    <h3 style="text-align:center; margin-bottom: 10px;">LAPORAN PETTY CASH</h3>
    <p style="text-align:center; margin-top: 0;">Periode: <?= date('d/m/Y', strtotime($start)) ?> s.d <?= date('d/m/Y', strtotime($end)) ?></p>

    <?php 
        $grand_total = 0;
        if (!empty($result)) :
            foreach ($result as $kategori => $items): 
                $kategori_label = ucwords(str_replace('_', ' ', $kategori));
                $subtotal = 0;
    ?>
        <h4>Kategori: <?= $kategori_label ?></h4>
        <table>
            <thead>
                <tr>
                    <th style="width: 20%;">Tanggal</th>
                    <th style="width: 50%;">Keterangan</th>
                    <th style="width: 30%;">Nominal (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $row): 
                    $subtotal += $row->nominal;
                ?>
                <tr>
                    <td><?= date('d-m-Y', strtotime($row->tanggal)) ?></td>
                    <td><?= $row->keterangan ?></td>
                    <td class="text-right">Rp <?= number_format($row->nominal, 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2" class="subtotal">Subtotal</td>
                    <td class="text-right"><strong>Rp <?= number_format($subtotal, 0, ',', '.') ?></strong></td>
                </tr>
            </tbody>
        </table>
    <?php 
        $grand_total += $subtotal;
        endforeach; 
    ?>
        <h4 class="text-right">Total Keseluruhan: <span style="font-weight:bold;">Rp <?= number_format($grand_total, 0, ',', '.') ?></span></h4>
    <?php else : ?>
        <p style="text-align:center;">Tidak ada data untuk periode ini.</p>
    <?php endif; ?>

    <p style="text-align: right; font-style: italic;">Dicetak pada: <?= date('d-m-Y H:i') ?></p>
</body>
</html>
