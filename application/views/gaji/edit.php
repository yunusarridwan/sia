<div class="container mt-4">
    <h3 class="mb-4">Edit Gaji Karyawan</h3>

    <form action="<?= site_url('gaji/update/' . $gaji->id) ?>" method="post">
        <div class="mb-3">
            <label>Nama Karyawan</label>
            <input type="text" class="form-control" value="<?= $gaji->nama ?>" readonly>
        </div>

        <div class="mb-3">
            <label>Bulan</label>
            <input type="text" class="form-control" value="<?= $gaji->bulan ?>" readonly>
        </div>

        <div class="mb-3">
            <label>Total Hadir</label>
            <input type="number" class="form-control" value="<?= $absen->total_hadir ?>" readonly>
        </div>

        <div class="mb-3">
            <label>Izin</label>
            <input type="number" class="form-control" value="<?= $absen->total_izin ?>" readonly>
        </div>

        <div class="mb-3">
            <label>Telat</label>
            <input type="number" class="form-control" value="<?= $absen->total_telat ?>" readonly>
        </div>

        <div class="mb-3">
            <label>Total Tambahan (Dari Lembur)</label>
            <input type="number" name="total_tambahan" class="form-control" value="<?= $gaji->total_tambahan ?>">
        </div>

        <div class="mb-3">
            <label>Insentif (Manual)</label>
            <input type="number" name="insentif" class="form-control" value="<?= $gaji->insentif ?>">
        </div>

        <div class="mb-3">
            <label>Gaji Pokok</label>
            <input type="number" class="form-control" value="<?= $gaji->gaji_pokok ?>" readonly>
        </div>

        <div class="mb-3">
            <label>Potongan Absen</label>
            <input type="number" class="form-control" value="<?= $gaji->potongan_absen ?>" readonly>
        </div>

        <div class="mb-3">
            <label>Total Gaji</label>
            <input type="number" class="form-control" value="<?= $gaji->total_gaji ?>" readonly>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="<?= site_url('gaji') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>