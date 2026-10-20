
<?php
$role = $_SESSION['user']['role'] ?? '';
$namaUser = $_SESSION['user']['nama_lengkap'] ?? 'User';

$active = 'dashboard';
$pageTitle = 'Dashboard';

require __DIR__ . '/header.php';
?>

<div class="dashboard-container">
    <div class="welcome-section">
        <h2>Selamat Datang, <?= htmlspecialchars($namaUser) ?>!</h2>
        <p>
            Selamat datang di Sistem Informasi Peminjaman Alat Olahraga.
            Silakan pilih menu yang tersedia.
        </p>
    </div>

    <div class="dashboard-cards">

        <?php if ($role === 'admin'): ?>

            <a href="index.php?url=alat" class="dashboard-card">
                <div class="card-icon">🏸</div>
                <h3>Data Alat</h3>
                <p>Kelola data dan stok alat olahraga.</p>
            </a>

            <a href="index.php?url=peminjaman" class="dashboard-card">
                <div class="card-icon">📋</div>
                <h3>Data Peminjaman</h3>
                <p>Lihat data peminjaman alat olahraga.</p>
            </a>

            <a href="index.php?url=peminjam" class="dashboard-card">
                <div class="card-icon">👥</div>
                <h3>Data Peminjam</h3>
                <p>Lihat data pengguna yang terdaftar.</p>
            </a>

            <a href="index.php?url=laporan-peminjaman" class="dashboard-card">
                <div class="card-icon">📊</div>
                <h3>Cetak Laporan</h3>
                <p>Lihat dan kelola laporan peminjaman.</p>
            </a>

            <a href="index.php?url=log-aktivitas" class="dashboard-card">
                <div class="card-icon">🕒</div>
                <h3>Log Aktivitas</h3>
                <p>Lihat catatan aktivitas sistem.</p>
            </a>

        <?php elseif ($role === 'petugas'): ?>

            <a href="index.php?url=peminjaman" class="dashboard-card">
                <div class="card-icon">📋</div>
                <h3>Data Peminjaman</h3>
                <p>Lihat dan pantau peminjaman alat.</p>
            </a>

            <a href="index.php?url=persetujuan-peminjaman"
               class="dashboard-card">
                <div class="card-icon">📝</div>
                <h3>Persetujuan Peminjaman</h3>
                <p>Setujui atau tolak pengajuan peminjaman.</p>
            </a>

            <a href="index.php?url=pengembalian-petugas"
               class="dashboard-card">
                <div class="card-icon">📦</div>
                <h3>Data Pengembalian</h3>
                <p>Kelola pengembalian alat olahraga.</p>
            </a>

            <a href="index.php?url=denda" class="dashboard-card">
                <div class="card-icon">💰</div>
                <h3>Denda</h3>
                <p>Lihat data denda peminjaman.</p>
            </a>

        <?php elseif ($role === 'peminjam'): ?>

            <a href="index.php?url=alat" class="dashboard-card">
                <div class="card-icon">🏸</div>
                <h3>Daftar Alat</h3>
                <p>Lihat alat olahraga yang tersedia.</p>
            </a>

            <a href="index.php?url=pengajuan" class="dashboard-card">
                <div class="card-icon">📝</div>
                <h3>Ajukan Peminjaman</h3>
                <p>Ajukan peminjaman alat olahraga.</p>
            </a>

            <a href="index.php?url=pengembalian" class="dashboard-card">
                <div class="card-icon">📦</div>
                <h3>Pengembalian</h3>
                <p>Ajukan pengembalian alat yang dipinjam.</p>
            </a>

            <a href="index.php?url=riwayat" class="dashboard-card">
                <div class="card-icon">📚</div>
                <h3>Riwayat Peminjaman</h3>
                <p>Lihat riwayat peminjaman alat.</p>
            </a>

        <?php endif; ?>

    </div>
</div>

<style>
.dashboard-container {
    padding: 10px 0;
}

.welcome-section {
    margin-bottom: 25px;
}

.welcome-section h2 {
    margin: 0 0 8px;
    color: #263B5A;
}

.welcome-section p {
    margin: 0;
    color: #64748b;
    line-height: 1.6;
}

.dashboard-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
}

.dashboard-card {
    display: block;
    padding: 24px;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    text-decoration: none;
    color: #263B5A;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.04);
    transition: transform 0.2s, box-shadow 0.2s;
}

.dashboard-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

.card-icon {
    font-size: 30px;
    margin-bottom: 15px;
}

.dashboard-card h3 {
    margin: 0 0 10px;
    font-size: 18px;
}

.dashboard-card p {
    margin: 0;
    color: #64748b;
    font-size: 14px;
    line-height: 1.6;
}

@media (max-width: 600px) {
    .dashboard-cards {
        grid-template-columns: 1fr;
    }
}
</style>

<?php require __DIR__ . '/footer.php'; ?>
