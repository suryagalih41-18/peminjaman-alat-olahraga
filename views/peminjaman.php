<?php

$active = 'peminjaman';
$pageTitle = 'Data Peminjaman';

require_once __DIR__ . '/header.php';

?>

<div class="page-card">

    <h1>Data Peminjaman</h1>

    <p>
        Daftar seluruh peminjaman alat olahraga.
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

        <?php if (($row['status'] ?? '') === 'diajukan'): ?>

            <span class="badge badge-warning">
                Menunggu Persetujuan
            </span>

        <?php elseif (($row['status'] ?? '') === 'disetujui'): ?>

            <span class="badge badge-success">
                Dipinjam
            </span>

        <?php elseif (($row['status'] ?? '') === 'menunggu_pengembalian'): ?>

            <span class="badge badge-warning">
                Menunggu Pengembalian
            </span>

        <?php elseif (($row['status'] ?? '') === 'dikembalikan'): ?>

            <span class="badge badge-success">
                Dikembalikan
            </span>

        <?php elseif (($row['status'] ?? '') === 'ditolak'): ?>

            <span class="badge badge-danger">
                Ditolak
            </span>

        <?php else: ?>

            <span class="badge">
                <?= htmlspecialchars(
                    $row['status'] ?? '-'
                ) ?>
            </span>

        <?php endif; ?>

    </td>

</tr>

<?php endforeach; ?>

<?php else: ?>

<tr>

<td colspan="7" class="empty">
    Belum ada data peminjaman.
</td>

</tr>

<?php endif; ?>

</tbody>

</table>

</div>


<?php require_once __DIR__ . '/footer.php'; ?>

