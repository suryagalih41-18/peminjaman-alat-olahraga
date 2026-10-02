<?php

$active = 'pengembalian-petugas';
$pageTitle = 'Data Pengembalian';

require_once __DIR__ . '/header.php';

?>

<div class="page-card">

    <h1>Data Pengembalian</h1>

    <p>
        Daftar pengembalian alat yang diajukan oleh peminjam.
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

    <td>
        <?= $no++ ?>
    </td>


    <td>
        <?= htmlspecialchars(
            $row['nama_lengkap'] ?? $row['username'] ?? '-'
        ) ?>
    </td>


    <td>
        <?= htmlspecialchars(
            $row['nama_alat'] ?? '-'
        ) ?>
    </td>


    <td>
        <?= htmlspecialchars(
            $row['jumlah'] ?? '0'
        ) ?>
    </td>


    <td>
        <?= htmlspecialchars(
            $row['tanggal_pinjam'] ?? '-'
        ) ?>
    </td>


    <td>
        <?= htmlspecialchars(
            $row['tanggal_rencana_kembali'] ?? '-'
        ) ?>
    </td>


    <td>

        <span class="badge badge-warning">
            Menunggu Pengembalian
        </span>

    </td>


    <td>

        <a
            href="index.php?url=setujui-pengembalian&id=<?= htmlspecialchars($row['id']) ?>"
            class="btn btn-success btn-small"
            onclick="return confirm('Yakin alat ini sudah dikembalikan oleh peminjam?')"
        >
            ✓ Terima Pengembalian
        </a>

    </td>

</tr>

<?php endforeach; ?>


<?php else: ?>

<tr>

    <td colspan="8" class="empty">
        Belum ada pengembalian yang menunggu.
    </td>

</tr>

<?php endif; ?>

</tbody>

</table>

</div>


<?php require_once __DIR__ . '/footer.php'; ?>

