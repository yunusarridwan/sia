<div class="container mt-4">
    <h3 class="mb-4">Input Gaji Karyawan</h3>

    <form action="<?= site_url('gaji/simpan') ?>" method="post">
        <div class="mb-3">
            <label for="pegawai_id" class="form-label">Nama Karyawan</label>
            <select name="pegawai_id" id="pegawai_id" class="form-select" required>
                <option value="">-- Pilih Karyawan --</option>
                <?php foreach ($karyawan as $row): ?>
                    <option value="<?= $row->id ?>"><?= $row->nama ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="bulan" class="form-label">Bulan</label>
            <input type="month" name="bulan" id="bulan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
            <input type="number" name="gaji_pokok" id="gaji_pokok" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="total_telat" class="form-label">Jumlah Telat</label>
            <input type="number" name="total_telat" id="total_telat" class="form-control" value="0" required>
        </div>

        <div class="mb-3">
            <label for="total_izin" class="form-label">Jumlah Izin</label>
            <input type="number" name="total_izin" id="total_izin" class="form-control" value="0" required>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-save"></i> Simpan Gaji
        </button>
        <a href="<?= site_url('gaji') ?>" class="btn btn-secondary">Kembali</a>
    </form>
 cv raadx v a d avxZ XV  vd zr sr sav zz Ab cBS aU       B  
</div>