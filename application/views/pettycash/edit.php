<div class="container mt-4">
    <h3>Edit Data Petty Cash</h3>
    <hr>

    <form action="<?= site_url('pettycash/update') ?>" method="post">
        <input type="hidden" name="id" value="<?= $pettycash->id ?>">

        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="<?= $pettycash->tanggal ?>" required>
        </div>

        <div class="form-group">
            <label for="kategori">Kategori</label>
            <select name="kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="air_galon" <?= ($pettycash->kategori == 'air_galon') ? 'selected' : '' ?>>Air Galon</option>
                <option value="bensin" <?= ($pettycash->kategori == 'bensin') ? 'selected' : '' ?>>Reimbursement Bensin</option>
                <option value="lainnya" <?= ($pettycash->kategori == 'lainnya') ? 'selected' : '' ?>>Pengeluaran Lain</option>
                <option value="bulanan" <?= ($pettycash->kategori == 'bulanan') ? 'selected' : '' ?>>Pengeluaran Bulanan</option>
            </select>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3" required><?= $pettycash->keterangan ?></textarea>
        </div>

        <div class="form-group">
            <label for="nominal">Nominal (Rp)</label>
            <input type="number" name="nominal" class="form-control" value="<?= $pettycash->nominal ?>" required>
        </div>

        <!-- Tombol Aksi -->
        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= site_url('pettycash') ?>" class="btn btn-secondary">Kembali</a>
        </div>

    </form>
</div>
