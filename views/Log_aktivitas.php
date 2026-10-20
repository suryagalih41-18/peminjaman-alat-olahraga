
<?php
$active = 'log-aktivitas';
$pageTitle = 'Log Aktivitas';

require_once __DIR__ . '/header.php';

function amanLog($nilai)
{
    return htmlspecialchars((string)($nilai ?? '-'), ENT_QUOTES, 'UTF-8');
}
?>

<style>
.log-tabel {
    width: 100%;
    border-collapse: collapse;
    margin-top: 18px;
}
.log-tabel th,
.log-tabel td {
    padding: 11px;
    border-bottom: 1px solid #e3e8ef;
    text-align: left;
    font-size: 13px;
}
.log-tabel th {
    background: #f4f7fb;
    color: #263b5a;
}
.log-scroll {
    overflow-x: auto;
}
.log-tombol {
    display: inline-block;
    padding: 9px 14px;
    margin: 4px 4px 12px 0;
    border-radius: 5px;
    background: #263b5a;
    color: #fff;
    text-decoration: none;
    border: 0;
    cursor: pointer;
}
@media print {
    .sidebar, .topbar, header, footer, .no-print {
        display: none !important;
    }
}
</style>

<div class="page-card">
    <h1>Log Aktivitas</h1>
    <p>Catatan aktivitas pengguna dalam sistem peminjaman alat olahraga.</p>

    <div class="no-print">
        <button class="log-tombol" onclick="window.print()">
            Cetak Log
        </button>
        <a class="log-tombol" href="index.php?url=dashboard">
            Kembali ke Dashboard
        </a>
    </div>

    <div class="log-scroll">
        <table class="log-tabel">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Pengguna</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aktivitas</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($logs)): ?>
                    <tr>
                        <td colspan="6">Belum ada aktivitas yang tercatat.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($logs as $i => $log): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= amanLog($log['nama_lengkap'] ?? 'Pengguna tidak tersedia') ?></td>
                            <td><?= amanLog($log['username'] ?? '-') ?></td>
                            <td><?= amanLog($log['role'] ?? '-') ?></td>
                            <td><?= amanLog($log['aktivitas'] ?? '-') ?></td>
                            <td><?= amanLog($log['waktu'] ?? '-') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
