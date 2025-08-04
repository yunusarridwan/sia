<div class="container mt-4">
    <h3>Tambah Data Petty Cash</h3>
    <hr>

    <form action="<?= site_url('pettycash/simpan') ?>" method="post">
        <!-- Tanggal -->
        <div class="form-group mb-3">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
        </div>

        <!-- Kategori -->
        <div class="form-group mb-3">
            <label for="kategori">Kategori</label>
            <select name="kategori" id="kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="air_galon">Air Galon</option>
                <option value="bensin">Reimbursement Bensin</option>
                <option value="lainnya">Pengeluaran Lain</option>
                <option value="bulanan">Pengeluaran Bulanan</option>
            </select>
        </div>

        <!-- Keterangan -->
        <div class="form-group mb-3">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control" rows="3" required></textarea>
        </div>

        <!-- Nominal -->
        <div class="form-group mb-3">
            <label for="nominal">Nominal (Rp)</label>
            <input type="number" name="nominal" id="nominal" class="form-control" required>
        </div>

        <!-- Tombol Aksi -->
        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= site_url('pettycash') ?>" class="btn btn-secondary">Kembali</a>
        </div>

    </form>
</div>
