<?php

$active = 'dashboard';
$pageTitle = 'Dashboard';

require_once __DIR__ . '/header.php';

$role = $_SESSION['user']['role'] ?? '';

?>

<style>

.dashboard-card {
    background: #ffffff;
    border: 1px solid #e3e8ef;
    border-radius: 10px;
    padding: 22px;
    transition: .2s;
    text-decoration: none;
    display: block;
}

.dashboard-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,.08);
}

.dashboard-card-icon {
    width: 48px;
    height: 48px;
    border-radius: 9px;
    background: #eef3f8;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 23px;
    margin-bottom: 15px;
}

.dashboard-card h3 {
    margin: 0 0 7px;
    color: #263b5a;
    font-size: 17px;
}

.dashboard-card p {
    margin: 0;
    color: #718096;
    font-size: 13px;
    line-height: 1.5;
}

.dashboard-cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
}

.card-arrow {
    margin-top: 17px;
    color: #263b5a;
    font-size: 12px;
    font-weight: bold;
}

@media (max-width: 1100px) {
    .dashboard-cards {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 600px) {
    .dashboard-cards {
        grid-template-columns: 1fr;
    }
}

</style>


<!-- HEADER DASHBOARD -->

<div class="page-card">

    <h1>Dashboard</h1>

    <p>
        Selamat datang di Sistem Peminjaman Alat Olahraga.
    </p>

</div>


<?php if ($role === 'peminjam'): ?>


<!-- DASHBOARD PEMINJAM -->

<div class="page-card">

    <h2 style="margin-bottom:8px;">
        Peminjam
    </h2>

    <p style="margin-bottom:22px;">
        Kelola peminjaman alat olahraga melalui menu berikut.
    </p>


    <div class="dashboard-cards">


        <!-- DAFTAR ALAT -->

        <a
            href="index.php?url=alat"
            class="dashboard-card"
        >

            <div class="dashboard-card-icon">
                ⚽
            </div>

            <h3>
                Daftar Alat
            </h3>

            <p>
                Lihat daftar alat olahraga yang tersedia
                dan jumlah stoknya.
            </p>

            <div class="card-arrow">
                Lihat Daftar →
            </div>

        </a>


        <!-- AJUKAN PEMINJAMAN -->

        <a
            href="index.php?url=pengajuan"
            class="dashboard-card"
        >

            <div class="dashboard-card-icon">
                📝
            </div>

            <h3>
                Ajukan Peminjaman
            </h3>

            <p>
                Ajukan peminjaman alat olahraga
                yang ingin digunakan.
            </p>

            <div class="card-arrow">
                Ajukan Sekarang →
            </div>

        </a>


        <!-- PENGEMBALIAN -->

        <a
            href="index.php?url=pengembalian"
            class="dashboard-card"
        >

            <div class="dashboard-card-icon">
                ↩️
            </div>

            <h3>
                Pengembalian
            </h3>

            <p>
                Ajukan pengembalian alat yang
                sedang dipinjam.
            </p>

            <div class="card-arrow">
                Pengembalian →
            </div>

        </a>


        <!-- RIWAYAT -->

        <a
            href="index.php?url=riwayat"
            class="dashboard-card"
        >

            <div class="dashboard-card-icon">
                📜
            </div>

            <h3>
                Riwayat Peminjaman
            </h3>

            <p>
                Lihat riwayat pengajuan dan
                status peminjaman.
            </p>

            <div class="card-arrow">
                Lihat Riwayat →
            </div>

        </a>


    </div>

</div>


<?php elseif ($role === 'admin'): ?>


<!-- DASHBOARD ADMIN -->

<div class="page-card">

    <h2 style="margin-bottom:8px;">
        Administrator
    </h2>

    <p style="margin-bottom:22px;">
        Kelola data sistem peminjaman alat olahraga.
    </p>


    <div class="dashboard-cards">


        <!-- DATA ALAT -->

        <a
            href="index.php?url=alat"
            class="dashboard-card"
        >

            <div class="dashboard-card-icon">
                ⚽
            </div>

            <h3>
                Data Alat
            </h3>

            <p>
                Kelola data alat olahraga,
                stok, kategori, dan kondisi.
            </p>

            <div class="card-arrow">
                Kelola Data →
            </div>

        </a>


        <!-- DATA PEMINJAMAN -->

        <a
            href="index.php?url=peminjaman"
            class="dashboard-card"
        >

            <div class="dashboard-card-icon">
                📋
            </div>

            <h3>
                Data Peminjaman
            </h3>

            <p>
                Lihat data peminjaman
                alat olahraga.
            </p>

            <div class="card-arrow">
                Lihat Data →
            </div>

        </a>


        <!-- DATA PEMINJAM -->

        <a
            href="index.php?url=peminjam"
            class="dashboard-card"
        >

            <div class="dashboard-card-icon">
                👥
            </div>

            <h3>
                Data Peminjam
            </h3>

            <p>
                Lihat pengguna yang
                terdaftar sebagai peminjam.
            </p>

            <div class="card-arrow">
                Lihat Data →
            </div>

        </a>


    </div>

</div>


<?php elseif ($role === 'petugas'): ?>


<!-- DASHBOARD PETUGAS -->

<div class="page-card">

    <h2 style="margin-bottom:8px;">
        Petugas
    </h2>

    <p style="margin-bottom:22px;">
        Kelola peminjaman, pengembalian, dan denda.
    </p>


    <div class="dashboard-cards">


        <!-- DATA PEMINJAMAN -->

        <a
            href="index.php?url=peminjaman"
            class="dashboard-card"
        >

            <div class="dashboard-card-icon">
                📋
            </div>

            <h3>
                Data Peminjaman
            </h3>

            <p>
                Periksa dan kelola pengajuan
                peminjaman alat.
            </p>

            <div class="card-arrow">
                Kelola Peminjaman →
            </div>

        </a>


        <!-- DATA PENGEMBALIAN -->

        <a
            href="index.php?url=pengembalian-petugas"
            class="dashboard-card"
        >

            <div class="dashboard-card-icon">
                ↩️
            </div>

            <h3>
                Data Pengembalian
            </h3>

            <p>
                Periksa pengembalian alat
                dari peminjam.
            </p>

            <div class="card-arrow">
                Kelola Pengembalian →
            </div>

        </a>


        <!-- DENDA -->

        <a
            href="index.php?url=denda"
            class="dashboard-card"
        >

            <div class="dashboard-card-icon">
                💰
            </div>

            <h3>
                Denda
            </h3>

            <p>
                Lihat data keterlambatan
                dan denda peminjaman.
            </p>

            <div class="card-arrow">
                Lihat Denda →
            </div>

        </a>


    </div>

</div>


<?php endif; ?>


<?php require_once __DIR__ . '/footer.php'; ?>

