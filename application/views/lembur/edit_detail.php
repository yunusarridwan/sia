<div class="container mt-4">
    <h3 class="mb-4">Edit Data Lembur - <?= $karyawan->nama ?></h3>

    <form action="<?= site_url('lembur/update_detail') ?>" method="post">
        <!-- Hidden ID lembur dan karyawan -->
        <input type="hidden" name="id" value="<?= $lembur->id ?>">
        <input type="hidden" name="karyawan_id" value="<?= $karyawan->id ?>">

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= $lembur->tanggal ?>" required>
        </div>

        <div class="mb-3">
            <label for="jumlah_jam" class="form-label">Jumlah Jam</label>
            <input type="number" name="jumlah_jam" id="jumlah_jam" class="form-control" value="<?= $lembur->jumlah_jam ?>" min="1" required>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control" rows="3"><?= $lembur->keterangan ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-pencil-square"></i> Update
        </button>
        <a href="<?= site_url('lembur/detail/'.$karyawan->id) ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>
