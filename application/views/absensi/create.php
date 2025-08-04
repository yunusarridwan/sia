<div class="container mt-4"> 
    <h3 class="mb-4">Tambah Data Absensi</h3>

    <!-- Arahkan ke 'absensi/simpan' sesuai controller -->
    <form action="<?= site_url('absensi/simpan') ?>" method="post">
        <!-- Pilih Pegawai -->
        <div class="mb-3">
            <label for="pegawai_id" class="form-label">Nama Pegawai</label>
            <select name="pegawai_id" id="pegawai_id" class="form-select" required>
                <option value="">-- Pilih Pegawai --</option>
                <?php foreach ($karyawan as $row): ?>
                    <option value="<?= $row->id ?>"><?= $row->nama ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <!-- Tanggal -->
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
        </div>

        <!-- Status Kehadiran -->
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="">-- Pilih Status --</option>
                <option value="hadir">Hadir</option>
                <option value="izin">Izin</option>
                <option value="telat">Telat</option>
                <option value="lembur">Lembur</option>
            </select>
        </div>

        <!-- Keterangan -->
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
            <textarea name="keterangan" id="keterangan" class="form-control" rows="3"></textarea>
        </div>

        <!-- Tombol Simpan -->
        <button type="submit" class="btn btn-success">
            <i class="bi bi-save"></i> Simpan
        </button>
        <a href="<?= site_url('absensi') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>
