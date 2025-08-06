<div class="container mt-4">
    <h3 class="mb-4"><?= $title ?></h3>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="<?= site_url('komisi/simpan_komisi') ?>" method="post">
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
                    <label for="tanggal" class="form-label fw-bold">Tanggal Transaksi</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="jenis" class="form-label fw-bold">Jenis Komisi</label>
                        <select name="jenis" id="jenis" class="form-select" required>
                            <option value="Komisi">Komisi</option>
                            <option value="OR">OR</option>
                            <option value="Office">Office</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3" id="kolom-tipe">
                        <label for="tipe" class="form-label fw-bold">Tipe Komisi</label>
                        <select name="tipe" id="tipe" class="form-select" required>
                            <option value="Mini">Mini</option>
                            <option value="Reguler">Reguler</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="lot" class="form-label fw-bold">LOT</label>
                        <input type="number" step="any" name="lot" id="lot" class="form-control" placeholder="Contoh: 10.5" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="rupiah_per_lot" class="form-label fw-bold">Rupiah per LOT</label>
                        <input type="number" name="rupiah_per_lot" id="rupiah_per_lot" class="form-control" placeholder="Contoh: 15000" required>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <a href="<?= site_url('komisi') ?>" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Komisi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jenisSelect = document.getElementById('jenis');
        const kolomTipe = document.getElementById('kolom-tipe');
        const tipeSelect = document.getElementById('tipe');

        function toggleTipe() {
            if (jenisSelect.value === 'Office') {
                kolomTipe.style.display = 'none'; // Sembunyikan kolom Tipe
                tipeSelect.required = false;      // Hapus validasi 'required' agar form bisa disubmit
                tipeSelect.value = 'Mini';        // Set nilai default agar tidak error
            } else {
                kolomTipe.style.display = 'block';// Tampilkan kembali kolom Tipe
                tipeSelect.required = true;       // Tambahkan kembali validasi 'required'
            }
        }

        // Jalankan fungsi saat halaman pertama kali dimuat
        toggleTipe();

        // Jalankan fungsi setiap kali dropdown "Jenis" diubah
        jenisSelect.addEventListener('change', toggleTipe);
    });
</script>