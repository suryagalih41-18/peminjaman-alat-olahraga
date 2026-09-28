<?php

$active = 'denda';
$pageTitle = 'Data Denda';

require_once __DIR__ . '/header.php';

?>

<div class="page-card">

    <h1>Data Denda</h1>

    <p>
        Daftar peminjaman yang melewati tanggal rencana pengembalian.
    </p>

</div>


<div class="table-card">

<table>

<thead>

<tr>
    <th>No</th>
    <th>Peminjam</th>
    <th>Alat</th>
    <th>Tanggal Kembali</th>
    <th>Hari Terlambat</th>
    <th>Denda</th>
</tr>

</thead>

<tbody>

<?php if (!empty($denda)): ?>

<?php $no = 1; ?>

<?php foreach ($denda as $row): ?>

<tr>

    <td><?= $no++ ?></td>

    <td>
        <?= htmlspecialchars(
            $row['nama_lengkap'] ?? '-'
        ) ?>
    </td>

    <td>
        <?= htmlspecialchars(
            $row['nama_alat'] ?? '-'
        ) ?>
    </td>

    <td>
        <?= htmlspecialchars(
            $row['tanggal_rencana_kembali']
        ) ?>
    </td>

    <td>
        <span class="badge badge-danger">
            <?= htmlspecialchars(
                $row['hari_terlambat']
            ) ?>
            hari
        </span>
    </td>

    <td>
        <strong>
            Rp <?= number_format(
                $row['denda'],
                0,
                ',',
                '.'
            ) ?>
        </strong>
    </td>

</tr>

<?php endforeach; ?>

<?php else: ?>

<tr>

<td colspan="6" class="empty">
    Tidak ada data denda.
</td>

</tr>

<?php endif; ?>

</tbody>

</table>

</div>


<?php require_once __DIR__ . '/footer.php'; ?>