<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user'] ?? null;

if (!$user) {
    header("Location: ../public/index.php?url=login");
    exit;
}

$role = $user['role'];

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Alat</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background: #F5F7FA;
            color: #263B5A;
        }

        /* =========================
           TOPBAR
        ========================= */

        .topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 90px;
            background: #263B5A;
            color: white;

            display: flex;
            align-items: center;

            padding: 0 35px;

            z-index: 1000;
        }

        .topbar h2 {
            font-size: 24px;
        }


        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            position: fixed;

            top: 90px;
            left: 0;
            bottom: 0;

            width: 310px;

            background: #314A6E;

            padding: 30px 20px;

            overflow-y: auto;

            z-index: 999;
        }

        .sidebar h3 {
            color: white;

            margin-bottom: 25px;

            font-size: 18px;
        }

        .menu {
            display: block;

            text-decoration: none;

            color: white;

            padding: 15px 18px;

            margin-bottom: 8px;

            border-radius: 8px;

            transition: 0.2s;
        }

        .menu:hover {
            background: #263B5A;
        }

        .menu.active {
            background: #263B5A;
        }


        /* =========================
           CONTENT
        ========================= */

        .content {
            margin-left: 310px;

            padding: 140px 40px 50px;
        }

        .content-header {
            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 25px;
        }

        .content-header h1 {
            font-size: 28px;
        }


        /* =========================
           BUTTON
        ========================= */

        .btn {
            display: inline-block;

            text-decoration: none;

            padding: 11px 18px;

            border-radius: 7px;

            font-size: 14px;

            border: none;

            cursor: pointer;
        }

        .btn-tambah {
            background: #263B5A;

            color: white;
        }

        .btn-tambah:hover {
            background: #1d2e47;
        }

        .btn-edit {
            background: #E9EEF5;

            color: #263B5A;

            margin-right: 5px;
        }

        .btn-hapus {
            background: #ffe5e5;

            color: #b00020;
        }


        /* =========================
           ALERT
        ========================= */

        .alert {
            padding: 15px 18px;

            border-radius: 8px;

            margin-bottom: 20px;

            font-weight: bold;
        }

        .alert-success {
            background: #e4f7e9;

            color: #187a35;
        }

        .alert-error {
            background: #ffe5e5;

            color: #b00020;
        }


        /* =========================
           TABLE
        ========================= */

        .table-box {
            background: white;

            border-radius: 12px;

            padding: 20px;

            box-shadow:
                0 3px 12px rgba(0,0,0,0.08);

            overflow-x: auto;
        }

        table {
            width: 100%;

            border-collapse: collapse;
        }

        th {
            background: #263B5A;

            color: white;

            padding: 14px;

            text-align: left;
        }

        td {
            padding: 14px;

            border-bottom: 1px solid #E5E9EF;

            color: #333;
        }

        tr:hover {
            background: #F8FAFC;
        }

        .empty {
            text-align: center;

            padding: 30px;

            color: #777;
        }

    </style>

</head>


<body>


<!-- =========================
     TOPBAR
========================= -->

<div class="topbar">

    <h2>
        Peminjaman Alat Olahraga
    </h2>

</div>


<!-- =========================
     SIDEBAR
========================= -->

<div class="sidebar">

    <?php if ($role === 'admin'): ?>

        <h3>
            MENU ADMIN
        </h3>

        <a
            href="index.php?url=dashboard"
            class="menu"
        >
            Dashboard
        </a>

        <a
            href="index.php?url=alat"
            class="menu active"
        >
            Data Alat
        </a>

        <a
            href="index.php?url=peminjaman"
            class="menu"
        >
            Data Peminjaman
        </a>

        <a
            href="index.php?url=logout"
            class="menu"
        >
            Logout
        </a>


    <?php else: ?>

        <h3>
            MENU PEMINJAM
        </h3>

        <a
            href="index.php?url=dashboard"
            class="menu"
        >
            Dashboard
        </a>

        <a
            href="index.php?url=alat"
            class="menu active"
        >
            Daftar Alat
        </a>

        <a
            href="index.php?url=pengajuan"
            class="menu"
        >
            Ajukan Peminjaman
        </a>

        <a
            href="index.php?url=pengembalian"
            class="menu"
        >
            Pengembalian
        </a>

        <a
            href="index.php?url=riwayat"
            class="menu"
        >
            Riwayat Peminjaman
        </a>

        <a
            href="index.php?url=logout"
            class="menu"
        >
            Logout
        </a>

    <?php endif; ?>

</div>


<!-- =========================
     CONTENT
========================= -->

<div class="content">


    <div class="content-header">

        <h1>

            <?php if ($role === 'admin'): ?>

                Data Alat

            <?php else: ?>

                Daftar Alat

            <?php endif; ?>

        </h1>


        <?php if ($role === 'admin'): ?>

            <a
                href="index.php?url=tambah-alat"
                class="btn btn-tambah"
            >
                + Tambah Alat
            </a>

        <?php endif; ?>

    </div>


    <!-- =========================
         ALERT BERHASIL
    ========================= -->

    <?php if (
        isset($_GET['hapus']) &&
        $_GET['hapus'] === 'berhasil'
    ): ?>

        <div class="alert alert-success">

            Data alat berhasil dihapus.

        </div>

    <?php endif; ?>


    <!-- =========================
         ALERT GAGAL
    ========================= -->

    <?php if (
        isset($_GET['hapus']) &&
        $_GET['hapus'] === 'gagal'
    ): ?>

        <div class="alert alert-error">

            Data alat tidak dapat dihapus karena
            alat tersebut sudah digunakan dalam
            data peminjaman.

        </div>

    <?php endif; ?>


    <!-- =========================
         TABLE
    ========================= -->

    <div class="table-box">

        <?php if (!empty($dataAlat)): ?>

            <table>

                <thead>

                    <tr>

                        <th>
                            No
                        </th>

                        <th>
                            Nama Alat
                        </th>

                        <th>
                            Kategori
                        </th>

                        <th>
                            Stok
                        </th>

                        <th>
                            Kondisi
                        </th>

                        <?php if ($role === 'admin'): ?>

                            <th>
                                Aksi
                            </th>

                        <?php endif; ?>

                    </tr>

                </thead>


                <tbody>

                    <?php $no = 1; ?>

                    <?php foreach ($dataAlat as $alat): ?>

                        <tr>

                            <td>
                                <?= $no++; ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $alat['nama_alat']
                                ); ?>
                            </td>

                            <td>

                                <?php

                                if ($alat['kategori_id'] == 1) {
                                    echo "Bola";
                                } elseif ($alat['kategori_id'] == 2) {
                                    echo "Raket";
                                } elseif ($alat['kategori_id'] == 3) {
                                    echo "Perlengkapan";
                                } else {
                                    echo "-";
                                }

                                ?>

                            </td>

                            <td>
                                <?= $alat['stok']; ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $alat['kondisi']
                                ); ?>
                            </td>


                            <?php if ($role === 'admin'): ?>

                                <td>

                                    <a
                                        href="index.php?url=edit-alat&id=<?= $alat['id']; ?>"
                                        class="btn btn-edit"
                                    >
                                        Edit
                                    </a>


                                    <a
                                        href="index.php?url=hapus-alat&id=<?= $alat['id']; ?>"
                                        class="btn btn-hapus"
                                        onclick="return confirm('Yakin ingin menghapus data alat ini?');"
                                    >
                                        Hapus
                                    </a>

                                </td>

                            <?php endif; ?>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>


        <?php else: ?>

            <div class="empty">

                Belum ada data alat.

            </div>

        <?php endif; ?>

    </div>

</div>


</body>

</html>