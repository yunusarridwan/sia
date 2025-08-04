<div class="container mt-5" style="max-width: 600px;">
    <h3 class="text-center mb-4">Edit Data Fixed / Variable Cost</h3>
    
    <form action="<?= site_url('FixedVariableCost/update') ?>" method="post">
        <input type="hidden" name="id" value="<?= $biaya->id ?>">

        
    <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" name="tanggal" value="<?= $biaya->tanggal ?>" required>
        </div>

        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select name="kategori" class="form-control" required>
                <option value="Fixed" <?= $biaya->kategori == 'Fixed' ? 'selected' : '' ?>>Fixed</option>
                <option value="Variable" <?= $biaya->kategori == 'Variable' ? 'selected' : '' ?>>Variable</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="text" class="form-control" name="keterangan" value="<?= $biaya->keterangan ?>" required>
        </div>

        <div class="mb-3">
            <label for="nominal" class="form-label">Nominal (Rp)</label>
            <input type="number" class="form-control" name="nominal" value="<?= $biaya->nominal ?>" required>
        </div>

        <input type="hidden" name="sumber" value="Manual">

        <button type="submit" class="btn btn-success">Update</button>
        <a href="<?= site_url('fixed_variable_cost') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>
