<div class="container-fluid px-4">  
    <h3 class="mt-4 mb-3"><?= $title ?? 'Form Lembur' ?></h3>

    <?php if (isset($karyawan)): ?>
        <form method="post" action="<?= isset($lembur) ? site_url('rekaplembur/update') : site_url('rekaplembur/simpan') ?>">
            <!-- Hidden Field: ID Lembur dan ID karyawan -->
            <?php if (isset($lembur)): ?>
                <input type="hidden" name="id" value="<?= $lembur->id ?>">
            <?php endif; ?>
            <input type="hidden" name="karyawan_id" value="<?= $karyawan->id ?>">

            <!-- Nama karyawan (Readonly) -->
            <div class="mb-3">
                <label class="form-label">Nama Karyawan</label>
                <input type="text" class="form-control" value="<?= $karyawan->nama ?>" readonly>
            </div>

            <!-- Tanggal -->
            <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required value="<?= isset($lembur) ? $lembur->tanggal : '' ?>">
            </div>

            <!-- Jam Mulai & Selesai -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jam Mulai</label>
                    <input type="time" name="jam_mulai" class="form-control" required value="<?= isset($lembur) ? $lembur->jam_mulai : '' ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jam Selesai</label>
                    <input type="time" name="jam_selesai" class="form-control" required value="<?= isset($lembur) ? $lembur->jam_selesai : '' ?>">
                </div>
            </div>

            <!-- Tujuan Lembur -->
            <div class="mb-3">
                <label class="form-label">Tujuan Lembur</label>
                <input type="text" name="tujuan" class="form-control" value="<?= isset($lembur) ? $lembur->tujuan : '' ?>">
            </div>

            <!-- Uang Makan -->
            <div class="mb-3">
                <label class="form-label">Uang Makan</label>
                <input type="number" name="uang_makan" class="form-control" required value="<?= isset($lembur) ? $lembur->uang_makan : '20000' ?>">
            </div>

            <!-- Tombol Aksi -->
            <div class="d-flex justify-content-between">
                <a href="<?= site_url('rekaplembur/detail/' . $karyawan->id) ?>" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary"><?= isset($lembur) ? 'Update' : 'Simpan' ?></button>
            </div>
        </form>
    <?php else: ?>
        <div class="alert alert-danger">
            <strong>Error!</strong> Data karyawan tidak ditemukan.
        </div>
    <?php endif; ?>
</div>
