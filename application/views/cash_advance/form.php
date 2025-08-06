<div class="container mt-4">
    <h3 class="mb-4"><?= $title ?></h3>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="<?= $action_url ?>" method="post">
                <div class="mb-3">
                    <label for="karyawan_id" class="form-label fw-bold">Nama Karyawan</label>
                    <select name="karyawan_id" id="karyawan_id" class="form-select" required>
                        <option value="">-- Pilih Karyawan --</option>
                        <?php foreach ($karyawan as $k): ?>
                            <option value="<?= $k->karyawan_id ?>"><?= $k->nama ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tanggal" class="form-label fw-bold">Tanggal Pengambilan</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="jumlah" class="form-label fw-bold">Jumlah (Rp)</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control" placeholder="Masukkan hanya angka, contoh: 500000" required>
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label fw-bold">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control" rows="3"></textarea>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="<?= site_url('cash_advance') ?>" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>