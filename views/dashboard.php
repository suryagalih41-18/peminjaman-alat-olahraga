<?php

$active = 'dashboard';
$pageTitle = 'Dashboard';

require_once __DIR__ . '/header.php';

$role = $_SESSION['user']['role'] ?? '';

?>

<div class="page-card">

    <h1>Dashboard</h1>

    <p>
        Selamat datang di Sistem Peminjaman Alat Olahraga.
    </p>

</div>


<?php if ($role === 'admin'): ?>

<div class="page-card">

    <h2>Administrator</h2>

    <p>
        Kelola data alat olahraga, data peminjaman,
        dan data peminjam melalui menu yang tersedia.
    </p>

    <br>

    <div class="action">

        <a href="index.php?url=alat" class="btn">
            Data Alat
        </a>

        <a href="index.php?url=peminjam" class="btn">
            Data Peminjam
        </a>

        <a href="index.php?url=peminjaman" class="btn">
            Data Peminjaman
        </a>

    </div>

</div>


<?php elseif ($role === 'petugas'): ?>

<div class="page-card">

    <h2>Petugas</h2>

    <p>
        Kelola pengajuan peminjaman,
        pengembalian alat, dan denda.
    </p>

    <br>

    <div class="action">

        <a href="index.php?url=peminjaman" class="btn">
            Data Peminjaman
        </a>

        <a href="index.php?url=pengembalian-petugas" class="btn">
            Data Pengembalian
        </a>

        <a href="index.php?url=denda" class="btn">
            Data Denda
        </a>

    </div>

</div>


<?php else: ?>

<div class="page-card">

    <h2>Peminjam</h2>

    <p>
        Silakan memilih alat yang tersedia,
        mengajukan peminjaman, dan melakukan pengembalian.
    </p>

    <br>

    <div class="action">

        <a href="index.php?url=alat" class="btn">
            Daftar Alat
        </a>

        <a href="index.php?url=pengajuan" class="btn">
            Ajukan Peminjaman
        </a>

        <a href="index.php?url=pengembalian" class="btn">
            Pengembalian
        </a>

        <a href="index.php?url=riwayat" class="btn">
            Riwayat Peminjaman
        </a>

    </div>

</div>

<?php endif; ?>


<?php require_once __DIR__ . '/footer.php'; ?>