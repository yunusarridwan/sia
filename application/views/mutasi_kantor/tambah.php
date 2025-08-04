<div class="container mt-4">
    <h3>Tambah Data Mutasi Uang dari Pusat</h3>
    <hr>

    <form action="<?= site_url('mutasi_kantor/simpan') ?>" method="post">
        <!-- Tanggal -->
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

        <!-- Keterangan -->
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3" required></textarea>
        </div>

        <!-- Nominal -->
        <div class="mb-3">
            <label for="nominal" class="form-label">Nominal (Rp)</label>
            <input type="number" name="nominal" class="form-control" required>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= site_url('mutasi_kantor') ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
