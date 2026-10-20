
<?php

$active = 'alat';
$pageTitle = 'Daftar Alat';

require_once __DIR__ . '/header.php';

// Ambil data alat dari variabel yang dikirim controller
if (!isset($alat) || !is_array($alat)) {
    $alat = isset($dataAlat) && is_array($dataAlat)
        ? $dataAlat
        : [];
}

$status = $_GET['status'] ?? '';
$role = $_SESSION['user']['role'] ?? '';

?>

<!-- NOTIFIKASI -->

<?php if ($status === 'berhasil' || $status === 'hapus_berhasil'): ?>

    <div class="alert alert-success">
        <strong>Alat berhasil dihapus.</strong>
    </div>

<?php elseif ($status === 'tambah_berhasil'): ?>

    <div class="alert alert-success">
        <strong>Alat berhasil ditambahkan.</strong>
    </div>

<?php elseif ($status === 'edit_berhasil'): ?>

    <div class="alert alert-success">
        <strong>Data alat berhasil diperbarui.</strong>
    </div>

<?php elseif ($status === 'alat_dipinjam'): ?>

    <div class="alert alert-warning">
        <strong>Alat tidak bisa dihapus!</strong><br>
        Alat ini masih memiliki data peminjaman.
        Selesaikan peminjaman terlebih dahulu.
    </div>

<?php elseif ($status === 'gagal'): ?>

    <div class="alert alert-danger">
        <strong>Operasi gagal.</strong>
        Silakan periksa kembali data alat.
    </div>

<?php endif; ?>


<!-- JUDUL HALAMAN -->

<div class="page-card">
    <h1>Daftar Alat</h1>
    <p>Daftar alat olahraga yang tersedia.</p>
</div>


<!-- TOMBOL TAMBAH ALAT -->

<?php if ($role === 'admin'): ?>

    <div style="margin-bottom: 20px;">
        <a href="index.php?url=tambah-alat" class="btn">
            + Tambah Alat
        </a>
    </div>

<?php endif; ?>


<!-- TABEL DATA ALAT -->

<div class="table-card">

    <table>

        <thead>
            <tr>
                <th>No</th>
                <th>Nama Alat</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Kondisi</th>

                <?php if ($role === 'admin'): ?>
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
                            <?= htmlspecialchars(
                                (string) ($row['nama_alat'] ?? '-'),
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                (string) (
                                    $row['nama_kategori']
                                    ?? $row['kategori_id']
                                    ?? '-'
                                ),
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <span class="badge">
                                <?= htmlspecialchars(
                                    (string) ($row['stok'] ?? 0),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </span>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                (string) ($row['kondisi'] ?? '-'),
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <?php if ($role === 'admin'): ?>

                            <td>
                                <div class="action">

                                    <a
                                        href="index.php?url=edit-alat&id=<?= (int) ($row['id'] ?? 0) ?>"
                                        class="btn btn-secondary btn-small">
                                        Edit
                                    </a>

                                    <a
                                        href="index.php?url=hapus-alat&id=<?= (int) ($row['id'] ?? 0) ?>"
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
                        colspan="<?= $role === 'admin' ? 6 : 5 ?>"
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

.alert-danger {
    background: #f8d7da;
    color: #842029;
    border: 1px solid #f5c2c7;
}
</style>


<?php require_once __DIR__ . '/footer.php'; ?>
