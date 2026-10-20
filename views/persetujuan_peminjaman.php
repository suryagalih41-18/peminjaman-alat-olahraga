<?php
$active = 'persetujuan-peminjaman';
$pageTitle = 'Persetujuan Peminjaman';

require_once __DIR__ . '/header.php';

$pesan = [
    'disetujui' => 'Peminjaman berhasil disetujui.',
    'ditolak' => 'Pengajuan peminjaman berhasil ditolak.',
    'stok' => 'Stok alat tidak mencukupi atau pengajuan sudah diproses.',
    'gagal' => 'Proses gagal atau pengajuan sudah diproses.'
];

$status = $_GET['status'] ?? '';
?>

<div class="page-card">
    <h1>Persetujuan Peminjaman</h1>
    <p>Periksa pengajuan peminjaman dan pilih Setujui atau Tolak.</p>
</div>

<?php if (isset($pesan[$status])): ?>
    <div class="alert <?= in_array($status, ['disetujui', 'ditolak'], true) ? 'alert-success' : 'alert-danger' ?>">
        <?= htmlspecialchars($pesan[$status], ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<div class="table-card">
    <div style="margin-bottom:15px">
        <h2 style="margin:0 0 7px;color:#263b5a">
            Pengajuan Menunggu Persetujuan
        </h2>
        <p style="margin:0;color:#64748b;font-size:13px">
            Pengajuan yang sudah diproses tidak akan ditampilkan di tabel ini.
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Peminjam</th>
                <th>Nama Alat</th>
                <th>Jumlah</th>
                <th>Tanggal Pinjam</th>
                <th>Rencana Kembali</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $nomor = 1;
        $adaPengajuan = false;

        foreach (($peminjaman ?? []) as $p):
            if (($p['status'] ?? '') !== 'diajukan') {
                continue;
            }

            $adaPengajuan = true;
        ?>
            <tr>
                <td><?= $nomor++ ?></td>
                <td>
                    <?= htmlspecialchars($p['nama_lengkap'] ?? '-', ENT_QUOTES, 'UTF-8') ?>
                </td>
                <td>
                    <?= htmlspecialchars($p['nama_alat'] ?? '-', ENT_QUOTES, 'UTF-8') ?>
                </td>
                <td><?= (int) ($p['jumlah'] ?? 0) ?></td>
                <td>
                    <?= htmlspecialchars($p['tanggal_pinjam'] ?? '-', ENT_QUOTES, 'UTF-8') ?>
                </td>
                <td>
                    <?= htmlspecialchars($p['tanggal_rencana_kembali'] ?? '-', ENT_QUOTES, 'UTF-8') ?>
                </td>
                <td>
                    <div class="action">
                        <form method="POST"
                              action="index.php?url=setujui-peminjaman"
                              onsubmit="return confirm('Setujui peminjaman ini?')">
                            <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
                            <button type="submit" class="btn btn-success btn-small">
                                Setujui
                            </button>
                        </form>

                        <form method="POST"
                              action="index.php?url=tolak-peminjaman"
                              onsubmit="return confirm('Tolak peminjaman ini?')">
                            <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
                            <button type="submit" class="btn btn-danger btn-small">
                                Tolak
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>

        <?php if (!$adaPengajuan): ?>
            <tr>
                <td colspan="7" class="empty">
                    Tidak ada pengajuan yang menunggu persetujuan.
                </td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>