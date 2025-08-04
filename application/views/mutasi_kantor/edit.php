<div class="container mt-4">
    <h3>Edit Data Mutasi</h3>
    <hr>

    <form action="<?= site_url('mutasi_kantor/update/' . $mutasi->id) ?>" method="post">
        <!-- Tanggal -->
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="<?= $mutasi->tanggal ?>" required>
        </div>

        <!-- Keterangan -->
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3" required><?= $mutasi->keterangan ?></textarea>
        </div>

        <!-- Nominal -->
        <div class="mb-3">
            <label for="nominal" class="form-label">Nominal (Rp)</label>
            <input type="number" name="nominal" class="form-control" value="<?= $mutasi->nominal ?>" required>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-4">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="<?= site_url('mutasi_kantor') ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
