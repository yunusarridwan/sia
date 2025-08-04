<div class="container mt-4">
    <h3><?= $title ?></h3>
    <a href="<?= site_url('karyawan/create') ?>" class="btn btn-success mb-3">Tambah Karyawan</a>

    <?php if (!empty($rows)) : ?>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>ID Fingerprint</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Gaji Pokok</th>
                    <th>No Rekening</th>
                    <th>Status</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Resign</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($rows as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row->karyawan_id) ?></td>
                        <td><?= htmlspecialchars($row->nama) ?></td>
                        <td><?= htmlspecialchars($row->jabatan) ?></td>
                        <td><?= number_format($row->gaji_pokok, 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($row->no_rekening) ?></td>
                        <td><?= htmlspecialchars($row->status) ?></td>
                        <td><?= !empty($row->tgl_masuk) && $row->tgl_masuk != '0000-00-00' ? date('d-m-Y', strtotime($row->tgl_masuk)) : '-' ?></td>
                        <td><?= !empty($row->tgl_resign) && $row->tgl_resign != '0000-00-00' ? date('d-m-Y', strtotime($row->tgl_resign)) : '-' ?></td>
                        <td>
                            <a href="<?= site_url('karyawan/edit/' . $row->id) ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?= site_url('karyawan/delete/' . $row->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <div class="alert alert-info">Belum ada data karyawan.</div>
    <?php endif; ?>
</div>
