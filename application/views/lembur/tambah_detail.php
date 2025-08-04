<div class="container-fluid px-4">
    <h3 class="mt-4 mb-3">Tambah Lembur - <?= $pegawai->nama ?></h3>

    <form method="post" action="<?= site_url('rekaplembur/simpan') ?>">
        <!-- Hidden input -->
        <input type="hidden" name="pegawai_id" value="<?= $pegawai->id ?>">

        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>

            <div class="col-md-2 mb-3">
                <label class="form-label">Jam Mulai</label>
                <input type="time" name="jam_mulai" class="form-control" required>
            </div>

            <div class="col-md-2 mb-3">
                <label class="form-label">Jam Selesai</label>
                <input type="time" name="jam_selesai" class="form-control" required>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Tujuan Lembur</label>
                <input type="text" name="tujuan" class="form-control" placeholder="Misal: Pengiriman" required>
            </div>

            <div class="col-md-2 mb-3">
                <label class="form-label">Uang Makan</label>
                <input type="number" name="uang_makan" class="form-control" value="20000" required>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-3">
            <a href="<?= site_url('rekaplembur/detail/' . $pegawai->id) ?>" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
