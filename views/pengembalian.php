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

<?php endif; ?>


<?php if ($status === 'gagal'): ?>

<div class="alert alert-danger">
    Pengajuan pengembalian gagal.
</div>

<?php endif; ?>


<div class="page-card">

    <h1>
        Pengembalian Alat
    </h1>

    <p>
        Kembalikan alat yang sedang kamu pinjam.
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


    <td>
        <?= $no++ ?>
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
                Sedang Dipinjam
            </span>


        <?php elseif (($row['status'] ?? '') === 'menunggu_pengembalian'): ?>

            <span class="badge badge-warning">
                Menunggu Petugas
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


    <td>


        <?php if (($row['status'] ?? '') === 'disetujui'): ?>


            <form
                method="POST"
                action="index.php?url=proses-pengembalian"
                style="display:inline;"
            >

                <input
                    type="hidden"
                    name="id"
                    value="<?= htmlspecialchars($row['id']) ?>"
                >

                <button
                    type="submit"
                    class="btn btn-secondary btn-small"
                    onclick="return confirm('Yakin ingin mengembalikan alat ini?')"
                >
                    ↩ Kembalikan
                </button>

            </form>


        <?php elseif (($row['status'] ?? '') === 'menunggu_pengembalian'): ?>


            <span
                style="
                    font-size:12px;
                    color:#946b18;
                "
            >
                Menunggu pemeriksaan petugas
            </span>


        <?php elseif (($row['status'] ?? '') === 'dikembalikan'): ?>


            <span
                style="
                    font-size:12px;
                    color:#267348;
                "
            >
                ✓ Sudah dikembalikan
            </span>


        <?php elseif (($row['status'] ?? '') === 'diajukan'): ?>


            <span
                style="
                    font-size:12px;
                    color:#8994a4;
                "
            >
                Belum disetujui
            </span>


        <?php elseif (($row['status'] ?? '') === 'ditolak'): ?>


            <span
                style="
                    font-size:12px;
                    color:#b42318;
                "
            >
                Peminjaman ditolak
            </span>


        <?php else: ?>


            <span
                style="
                    font-size:12px;
                    color:#8994a4;
                "
            >
                -
            </span>


        <?php endif; ?>


    </td>


</tr>


<?php endforeach; ?>


<?php else: ?>


<tr>

    <td
        colspan="7"
        class="empty"
    >
        Belum ada data peminjaman.
    </td>

</tr>


<?php endif; ?>


</tbody>

</table>

</div>


<?php require_once __DIR__ . '/footer.php'; ?>

