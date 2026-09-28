<?php

$active = 'peminjaman';
$pageTitle = 'Data Peminjaman';

require_once __DIR__ . '/header.php';

?>

<div class="page-card">

    <h1>Data Peminjaman</h1>

    <p>
        Kelola pengajuan peminjaman alat olahraga.
    </p>

</div>


<div class="table-card">

<table>

<thead>

<tr>
    <th>No</th>
    <th>Peminjam</th>
    <th>Alat</th>
    <th>Jumlah</th>
    <th>Tanggal Pinjam</th>
    <th>Rencana Kembali</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

</thead>

<tbody>

<?php if (!empty($peminjaman)): ?>

<?php $no = 1; ?>

<?php foreach ($peminjaman as $row): ?>

<tr>

    <td><?= $no++ ?></td>

    <td>
        <?= htmlspecialchars(
            $row['nama_lengkap'] ?? $row['username'] ?? '-'
        ) ?>
    </td>

    <td>
        <?= htmlspecialchars($row['nama_alat'] ?? '-') ?>
    </td>

    <td>
        <?= htmlspecialchars($row['jumlah']) ?>
    </td>

    <td>
        <?= htmlspecialchars($row['tanggal_pinjam']) ?>
    </td>

    <td>
        <?= htmlspecialchars($row['tanggal_rencana_kembali']) ?>
    </td>

    <td>

        <?php if ($row['status'] === 'diajukan'): ?>

            <span class="badge badge-warning">
                Menunggu Persetujuan
            </span>

        <?php elseif ($row['status'] === 'disetujui'): ?>

            <span class="badge badge-success">
                Disetujui
            </span>

        <?php elseif ($row['status'] === 'menunggu_pengembalian'): ?>

            <span class="badge badge-warning">
                Menunggu Pengembalian
            </span>

        <?php elseif ($row['status'] === 'dikembalikan'): ?>

            <span class="badge badge-success">
                Dikembalikan
            </span>

        <?php elseif ($row['status'] === 'ditolak'): ?>

            <span class="badge badge-danger">
                Ditolak
            </span>

        <?php else: ?>

            <span class="badge">
                <?= htmlspecialchars($row['status']) ?>
            </span>

        <?php endif; ?>

    </td>


    <td>

        <?php if ($row['status'] === 'diajukan'): ?>

        <div class="action">

            <a
                href="index.php?url=setujui-peminjaman&id=<?= $row['id'] ?>"
                class="btn btn-success btn-small"
                onclick="return confirm('Setujui peminjaman ini?')">
                Setujui
            </a>

            <a
                href="index.php?url=tolak-peminjaman&id=<?= $row['id'] ?>"
                class="btn btn-danger btn-small"
                onclick="return confirm('Tolak peminjaman ini?')">
                Tolak
            </a>

        </div>

        <?php else: ?>

            <span style="color:#8994a4;font-size:12px;">
                -
            </span>

        <?php endif; ?>

    </td>

</tr>

<?php endforeach; ?>

<?php else: ?>

<tr>

<td colspan="8" class="empty">
    Belum ada data peminjaman.
</td>

</tr>

<?php endif; ?>

</tbody>

</table>

</div>


<?php require_once __DIR__ . '/footer.php'; ?>