<div class="container mt-4">
    <h3 class="mb-4">Input Data Gaji</h3>

    <form action="<?= site_url('gaji/simpan') ?>" method="post">
        <div class="mb-3">
            <label for="karyawan_id" class="form-label">Nama karyawan</label>
            <select name="karyawan_id" id="karyawan_id" class="form-select" required>
                <option value="">-- Pilih karyawan --</option>
                <?php foreach ($karyawan as $row): ?>
                    <option value="<?= $row->id ?>"><?= $row->nama ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="bulan" class="form-label">Bulan (YYYY-MM)</label>
            <input type="month" name="bulan" id="bulan" class="form-control" required>
        </div>

        <div class="row">
            <div class="col-md-3">
                <label class="form-label">Total Hadir</label>
                <input type="number" name="total_hadir" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Total Izin</label>
                <input type="number" name="total_izin" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Total Telat</label>
                <input type="number" name="total_telat" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Total Lembur</label>
                <input type="number" name="total_lembur" class="form-control" required>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-4">
                <label class="form-label">Bonus Lembur (Rp)</label>
                <input type="number" name="bonus_lembur" step="0.01" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Potongan Absen (Rp)</label>
                <input type="number" name="potongan_absen" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Total Potongan (Rp)</label>
                <input type="number" name="total_potongan" step="0.01" class="form-control" required>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label class="form-label">Gaji Pokok (Rp)</label>
                <input type="number" name="gaji_pokok" step="0.01" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Total Gaji (Rp)</label>
                <input type="number" name="total_gaji" step="0.01" class="form-control" required>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Simpan
            </button>
            <a href="<?= site_url('gaji') ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
