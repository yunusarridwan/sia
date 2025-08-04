<div class="container mt-4">
    <h3>Tambah Data Biaya</h3>
    <form method="post" action="<?= site_url('fixed_variable_cost/simpan') ?>">

        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="kategori">Kategori</label>
            <select name="kategori" class="form-control" required>
                <option value="Fixed">Fixed Cost</option>
                <option value="Variable">Variable Cost</option>
            </select>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="nominal">Nominal</label>
            <input type="number" name="nominal" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="<?= site_url('FixedVariableCost') ?>" class="btn btn-secondary">Kembali</a>

    </form>
</div>
