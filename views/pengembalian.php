<?php

$active = 'pengembalian';
$pageTitle = 'Pengembalian Alat';

require_once __DIR__ . '/header.php';

$status = $_GET['status'] ?? '';

?>

<?php if ($status === 'berhasil'): ?>

<div class="alert alert-success">
    Pengajuan pengembalian berhasil dikirim.
</div>

<?php elseif ($status === 'gagal'): ?>

<div class="alert alert-danger">
    Pengajuan pengembalian gagal.
</div>

<?php endif; ?>


<div class="page-card">

    <h1>Pengembalian Alat</h1>

    <p>
        Ajukan pengembalian alat yang sedang dipinjam.
    </p>

</div>


<div class="table-card">

<table>

<thead>

<tr>
    <th>No</th>
    <th>Nama Alat</th>
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
        <?= htmlspecialchars($row['nama_alat']) ?>
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

        <?php if ($row['status'] === 'dikembalikan'): ?>

            <span class="badge badge-success">
                Dikembalikan
            </span>

        <?php elseif ($row['status'] === 'menunggu_pengembalian'): ?>

            <span class="badge badge-warning">
                Menunggu Petugas
            </span>

        <?php elseif ($row['status'] === 'disetujui'): ?>

            <span class="badge badge-success">
                Sedang Dipinjam
            </span>

        <?php elseif ($row['status'] === 'diajukan'): ?>

            <span class="badge badge-warning">
                Menunggu Persetujuan
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

        <?php if ($row['status'] === 'disetujui'): ?>

            <a
                href="index.php?url=proses-pengembalian&id=<?= $row['id'] ?>"
                class="btn btn-secondary btn-small"
                onclick="return confirm('Ajukan pengembalian alat ini?')">
                ↩ Ajukan Pengembalian
            </a>

        <?php elseif ($row['status'] === 'menunggu_pengembalian'): ?>

            <span style="font-size:12px;color:#8a96a7;">
                Pengembalian sedang diproses
            </span>

        <?php elseif ($row['status'] === 'dikembalikan'): ?>

            <span style="font-size:12px;color:#3d8b62;">
                ✓ Sudah dikembalikan
            </span>

        <?php else: ?>

            <span style="font-size:12px;color:#8a96a7;">
                -
            </span>

        <?php endif; ?>

    </td>

</tr>

<?php endforeach; ?>

<?php else: ?>

<tr>

<td colspan="7" class="empty">
    Tidak ada alat yang sedang dipinjam.
</td>

</tr>

<?php endif; ?>

</tbody>

</table>

</div>


<?php require_once __DIR__ . '/footer.php'; ?>