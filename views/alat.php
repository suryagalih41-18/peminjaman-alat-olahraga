<?php

$active = 'alat';
$pageTitle = 'Daftar Alat';

require_once __DIR__ . '/header.php';

$status = $_GET['status'] ?? '';

?>

<!-- NOTIFIKASI -->

<?php if ($status === 'berhasil' || $status === 'hapus_berhasil'): ?>

<div class="alert alert-success">
    ✅ <strong>Alat berhasil dihapus.</strong>
</div>

<?php elseif ($status === 'alat_dipinjam'): ?>

<div class="alert alert-warning">
    ⚠️ <strong>Alat tidak bisa dihapus!</strong><br>
    Alat ini masih memiliki data peminjaman.
    Selesaikan peminjaman terlebih dahulu.
</div>

<?php endif; ?>


<div class="page-card">

    <h1>Daftar Alat</h1>

    <p>
        Daftar alat olahraga yang tersedia.
    </p>

</div>


<?php if ($_SESSION['user']['role'] === 'admin'): ?>

<div style="margin-bottom:20px;">

    <a href="index.php?url=tambah-alat" class="btn">
        + Tambah Alat
    </a>

</div>

<?php endif; ?>


<div class="table-card">

<table>

<thead>

<tr>
    <th>No</th>
    <th>Nama Alat</th>
    <th>Kategori</th>
    <th>Stok</th>
    <th>Kondisi</th>

    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
        <th>Aksi</th>
    <?php endif; ?>

</tr>

</thead>

<tbody>

<?php if (!empty($alat)): ?>

<?php $no = 1; ?>

<?php foreach ($alat as $row): ?>

<tr>

    <td><?= $no++ ?></td>

    <td>
        <?= htmlspecialchars($row['nama_alat']) ?>
    </td>

    <td>
        <?= htmlspecialchars(
            $row['nama_kategori'] ?? $row['kategori_id']
        ) ?>
    </td>

    <td>
        <span class="badge">
            <?= htmlspecialchars($row['stok']) ?>
        </span>
    </td>

    <td>
        <?= htmlspecialchars($row['kondisi']) ?>
    </td>


    <?php if ($_SESSION['user']['role'] === 'admin'): ?>

    <td>

        <div class="action">

            <!-- TOMBOL EDIT -->
            <a
                href="index.php?url=edit-alat&id=<?= $row['id'] ?>"
                class="btn btn-secondary btn-small">
                Edit
            </a>


            <!-- TOMBOL HAPUS -->
            <a
                href="index.php?url=hapus-alat&id=<?= $row['id'] ?>"
                class="btn btn-danger btn-small"
                onclick="return confirm('Yakin ingin menghapus alat ini?')">
                Hapus
            </a>

        </div>

    </td>

    <?php endif; ?>

</tr>

<?php endforeach; ?>

<?php else: ?>

<tr>

<td
    colspan="<?= $_SESSION['user']['role'] === 'admin' ? '6' : '5' ?>"
    class="empty">
    Belum ada data alat.
</td>

</tr>

<?php endif; ?>

</tbody>

</table>

</div>


<!-- CSS NOTIFIKASI -->

<style>

.alert {
    padding: 14px 18px;
    margin-bottom: 20px;
    border-radius: 8px;
    font-size: 14px;
}

.alert-success {
    background: #d1e7dd;
    color: #0f5132;
    border: 1px solid #badbcc;
}

.alert-warning {
    background: #fff3cd;
    color: #856404;
    border: 1px solid #ffe69c;
}

</style>


<?php require_once __DIR__ . '/footer.php'; ?>