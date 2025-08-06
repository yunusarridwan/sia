<?php  
$uri = $this->uri->segment(1);

$is_petty_active    = in_array($uri, ['pettycash', 'FixedVariableCost', 'mutasi_kantor']) ? 'show' : '';
$is_karyawan_active = in_array($uri, ['karyawan', 'gaji', 'rekaplembur', 'absensi', 'lembur']) ? 'show' : '';
$is_komisi_active   = in_array($uri, ['komisi', 'komisi_office']) ? 'show' : '';
$is_laporan_active  = in_array($uri, ['net_margin', 'rekap_laporan']) ? 'show' : '';
?>

<div class="sidebar">
    <h5 class="text-center text-white">Admin</h5>
    <ul class="nav flex-column">

        <!-- Beranda -->
        <li class="nav-item">
            <a class="nav-link <?= $uri == 'dashboard' ? 'active' : '' ?>" href="<?= site_url('dashboard') ?>">
                <i class="bi bi-house"></i> Beranda
            </a>
        </li>

        <!-- Petty Cash -->
        <li class="nav-item">
            <a class="nav-link <?= $is_petty_active ? 'active' : '' ?>" data-bs-toggle="collapse" href="#menuPetty" aria-expanded="<?= $is_petty_active ? 'true' : 'false' ?>">
                <i class="bi bi-cash"></i> Petty Cash
            </a>
            <div class="collapse ms-3 <?= $is_petty_active ?>" id="menuPetty">
                <a class="nav-link <?= $uri == 'pettycash' ? 'active' : '' ?>" href="<?= site_url('pettycash') ?>">• Rekap Data</a>
                <a class="nav-link <?= $uri == 'FixedVariableCost' ? 'active' : '' ?>" href="<?= site_url('FixedVariableCost') ?>">• Fixed & Variable Cost</a>
                <a class="nav-link <?= $uri == 'mutasi_kantor' ? 'active' : '' ?>" href="<?= site_url('mutasi_kantor') ?>">• Mutasi Kantor</a>
                <a class="nav-link <?= $uri == 'rekap_laporan' ? 'active' : '' ?>" href="<?= site_url('rekap_laporan') ?>">• Rekap Laporan</a>
            </div>
        </li>

        <!-- Karyawan -->
        <li class="nav-item">
            <a class="nav-link <?= $is_karyawan_active ? 'active' : '' ?>" data-bs-toggle="collapse" href="#menuKaryawan" aria-expanded="<?= $is_karyawan_active ? 'true' : 'false' ?>">
                <i class="bi bi-person-badge"></i> Karyawan
            </a>
            <div class="collapse ms-3 <?= $is_karyawan_active ?>" id="menuKaryawan">
                <a class="nav-link <?= $uri == 'karyawan' ? 'active' : '' ?>" href="<?= site_url('karyawan') ?>">• Data Karyawan</a>
                <a class="nav-link <?= $uri == 'gaji' ? 'active' : '' ?>" href="<?= site_url('gaji') ?>">• Gaji</a>
                <a class="nav-link <?= $uri == 'rekaplembur' ? 'active' : '' ?>" href="<?= site_url('rekaplembur') ?>">• Rekap Lembur</a>
                <a class="nav-link <?= $uri == 'absensi' ? 'active' : '' ?>" href="<?= site_url('absensi') ?>">• Absensi</a>
                <a class="nav-link <?= $uri == 'lembur' ? 'active' : '' ?>" href="<?= site_url('lembur') ?>">• Detail Lembur</a>
            </div>
        </li>

        <!-- Komisi -->
        <li class="nav-item">
            <a class="nav-link <?= $is_komisi_active ? 'active' : '' ?>" data-bs-toggle="collapse" href="#menuKomisi" aria-expanded="<?= $is_komisi_active ? 'true' : 'false' ?>">
                <i class="bi bi-percent"></i> Komisi
            </a>
            <div class="collapse ms-3 <?= $is_komisi_active ?>" id="menuKomisi">
                <a class="nav-link <?= $uri == 'komisi' ? 'active' : '' ?>" href="<?= site_url('komisi') ?>">• Rekapan Komisi</a>
                <a class="nav-link <?= $uri == 'komisi_office' ? 'active' : '' ?>" href="<?= site_url('cash_advance') ?>">• Cash Advance</a>
            </div>
        </li>

        <!-- Laporan -->
        <li class="nav-item">
            <a class="nav-link <?= $is_laporan_active ? 'active' : '' ?>" data-bs-toggle="collapse" href="#menuLaporan" aria-expanded="<?= $is_laporan_active ? 'true' : 'false' ?>">
                <i class="bi bi-graph-up"></i> Laporan
            </a>
            <div class="collapse ms-3 <?= $is_laporan_active ?>" id="menuLaporan">
                <a class="nav-link <?= $uri == 'net_margin' ? 'active' : '' ?>" href="<?= site_url('net_margin') ?>">• Net Margin</a>
                <a class="nav-link <?= $uri == 'rekap_laporan' ? 'active' : '' ?>" href="<?= site_url('rekap_laporan') ?>">• Rekapan Arus Kas</a>
            </div>
        </li>

        <!-- Logout -->
        <li class="nav-item mt-2">
            <a class="nav-link text-danger" href="<?= site_url('auth/logout') ?>">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </li>
    </ul>
</div>
