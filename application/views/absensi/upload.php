<div class="container mt-4">
    <h3><?= $title ?></h3>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php elseif ($this->session->flashdata('warning')): ?>
        <div class="alert alert-warning"><?= $this->session->flashdata('warning') ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" action="<?= site_url('absensi/import') ?>">
        <div class="form-group">
            <label for="file_excel">Pilih File Excel</label>
            <input type="file" class="form-control-file" name="file_excel" id="file_excel" required>
        </div>
        <button type="submit" class="btn btn-primary">Import</button>
    </form>
</div>
