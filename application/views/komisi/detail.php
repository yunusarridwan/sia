<div class="container mt-4">
    <h3 class="mb-1"><?= $title ?></h3>

    <p class="text-muted">
        Periode: <strong><?= $periode ?></strong>
    </p>

    <div class="row">
        <div class="col-md-8">
            <h5 class="mt-4">Rincian Komisi</h5>
            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Tipe</th>
                            <th class="text-end">LOT</th>
                            <th class="text-end">Rp/LOT</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total_komisi = 0; if(!empty($komisi)): foreach($komisi as $k): $total_komisi += $k['total_amount']; ?>
                        <tr>
                            <td><?= date('d M Y', strtotime($k['tanggal'])) ?></td>
                            <td><?= $k['jenis'] ?></td>
                            <td><?= $k['tipe'] ?></td>
                            <td class="text-end"><?= $k['lot'] ?></td>
                            <td class="text-end"><?= number_format($k['rupiah_per_lot']) ?></td>
                            <td class="text-end"><?= number_format($k['total_amount']) ?></td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="6" class="text-center">Tidak ada data komisi pada periode ini.</td></tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold table-light">
                            <td colspan="5">Total Pemasukan Komisi</td>
                            <td class="text-end"><?= number_format($total_komisi) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="col-md-4">
            <h5 class="mt-4">Rincian Cash Advance</h5>
            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th class="text-end">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total_ca = 0; if(!empty($cash_advance)): foreach($cash_advance as $ca): $total_ca += $ca['jumlah']; ?>
                        <tr>
                            <td><?= date('d M Y', strtotime($ca['tanggal'])) ?></td>
                            <td class="text-end"><?= number_format($ca['jumlah']) ?></td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="2" class="text-center">Tidak ada data cash advance.</td></tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold table-light">
                            <td>Total Pengambilan CA</td>
                            <td class="text-end text-danger">(<?= number_format($total_ca) ?>)</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="alert alert-primary fw-bold mt-3 d-flex justify-content-between">
                <span>TOTAL PAYOUT</span>
                <span><?= number_format($total_komisi - $total_ca) ?></span>
            </div>
        </div>
    </div>
    <a href="<?= site_url('komisi') ?>" class="btn btn-secondary mt-3">
        <i class="fas fa-arrow-left"></i> Kembali ke Rekap
    </a>
</div>