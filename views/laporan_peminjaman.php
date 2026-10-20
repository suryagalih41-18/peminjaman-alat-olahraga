
<?php
$active = 'laporan-peminjaman';
$pageTitle = 'Laporan Peminjaman';

require_once __DIR__ . '/header.php';

function amanLaporan($nilai)
{
    return htmlspecialchars((string)($nilai ?? '-'), ENT_QUOTES, 'UTF-8');
}
?>

<style>
.laporan-tabel {
    width: 100%;
    border-collapse: collapse;
    margin-top: 18px;
}
.laporan-tabel th,
.laporan-tabel td {
    padding: 10px;
    border-bottom: 1px solid #e3e8ef;
    text-align: left;
    font-size: 13px;
}
.laporan-tabel th {
    background: #f4f7fb;
    color: #263b5a;
}
.laporan-scroll {
    overflow-x: auto;
}
.tombol-laporan {
    display: inline-block;
    padding: 9px 14px;
    border-radius: 5px;
    background: #263b5a;
    color: white;
    text-decoration: none;
    border: 0;
    cursor: pointer;
    margin: 4px 4px 12px 0;
}
@media print {
    .sidebar, .topbar, header, footer, .no-print {
        display: none !important;
    }
    body {
        background: white !important;
    }
    .page-card {
        border: none !important;
        box-shadow: none !important;
    }
    .laporan-tabel th,
    .laporan-tabel td {
        font-size: 10px;
    }
}
</style>

<div class="page-card">
    <h1>Laporan Peminjaman Alat Olahraga</h1>
    <p>Berikut adalah data peminjaman alat olahraga yang tercatat dalam sistem.</p>

    <div class="no-print">
        <button class="tombol-laporan" onclick="window.print()">
            Cetak Laporan
        </button>
        <a class="tombol-laporan" href="index.php?url=dashboard">
            Kembali ke Dashboard
        </a>
    </div>

    <div class="laporan-scroll">
        <table class="laporan-tabel">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Peminjam</th>
                    <th>Username</th>
                    <th>Nama Alat</th>
                    <th>Jumlah</th>
                    <th>Tanggal Pinjam</th>
                    <th>Rencana Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($peminjaman)): ?>
                    <tr>
                        <td colspan="8">Belum ada data peminjaman.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($peminjaman as $i => $p): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= amanLaporan($p['nama_lengkap'] ?? '-') ?></td>
                            <td><?= amanLaporan($p['username'] ?? '-') ?></td>
                            <td><?= amanLaporan($p['nama_alat'] ?? '-') ?></td>
                            <td><?= (int)($p['jumlah'] ?? 0) ?></td>
                            <td><?= amanLaporan($p['tanggal_pinjam'] ?? '-') ?></td>
                            <td><?= amanLaporan($p['tanggal_rencana_kembali'] ?? '-') ?></td>
                            <td><?= amanLaporan($p['status'] ?? '-') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
