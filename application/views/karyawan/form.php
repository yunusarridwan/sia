<div class="container mt-4">
    <h3><?= isset($row) ? 'Edit Karyawan' : 'Tambah Karyawan' ?></h3>
    <form method="post" action="<?= isset($row) ? site_url('karyawan/update/' . $row->id) : site_url('karyawan/store') ?>">

        <div class="form-group">
            <label for="karyawan_id">ID Fingerprint</label>
            <input type="text" class="form-control" name="karyawan_id" id="karyawan_id" value="<?= isset($row) ? htmlspecialchars($row->karyawan_id) : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" name="nama" id="nama" value="<?= isset($row) ? htmlspecialchars($row->nama) : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="jabatan">Jabatan</label>
            <input type="text" class="form-control" name="jabatan" id="jabatan" value="<?= isset($row) ? htmlspecialchars($row->jabatan) : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="no_rekening">No. Rekening</label>
            <input type="text" class="form-control" name="no_rekening" id="no_rekening" value="<?= isset($row) ? htmlspecialchars($row->no_rekening) : '' ?>">
        </div>

        <div class="form-group">
            <label for="gaji_pokok">Gaji Pokok</label>
            <input type="number" class="form-control" name="gaji_pokok" id="gaji_pokok" value="<?= isset($row) ? htmlspecialchars($row->gaji_pokok) : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="tgl_masuk">Tanggal Masuk</label>
            <input type="date" class="form-control" name="tgl_masuk" id="tgl_masuk" value="<?= isset($row) ? htmlspecialchars($row->tgl_masuk) : '' ?>">
        </div>

        <div class="form-group">
            <label for="tgl_resign">Tanggal Resign</label>
            <input type="date" class="form-control" name="tgl_resign" id="tgl_resign" value="<?= isset($row) ? htmlspecialchars($row->tgl_resign) : '' ?>">
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" name="status" id="status">
                <option value="Aktif" <?= isset($row) && $row->status == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                <option value="Resign" <?= isset($row) && $row->status == 'Resign' ? 'selected' : '' ?>>Resign</option>
                <option value="Nonaktif" <?= isset($row) && $row->status == 'Nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= site_url('karyawan') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>
