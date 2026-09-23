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

    <title>Data Peminjaman</title>

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
        }

        .menu:hover {
            background: #263B5A;
        }

        .menu.active {
            background: #263B5A;
        }

        .content {
            margin-left: 310px;
            padding: 140px 40px 50px;
        }

        .content h1 {
            font-size: 28px;
            margin-bottom: 25px;
        }

        .table-box {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
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

        .status {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .diajukan {
            background: #fff3cd;
            color: #856404;
        }

        .disetujui {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .dipinjam {
            background: #e0e7ff;
            color: #4338ca;
        }

        .dikembalikan {
            background: #dcfce7;
            color: #166534;
        }

        .ditolak {
            background: #fee2e2;
            color: #991b1b;
        }

        .kosong {
            text-align: center;
            padding: 30px;
            color: #777;
        }

    </style>

</head>

<body>

<div class="topbar">

    <h2>
        Peminjaman Alat Olahraga
    </h2>

</div>


<div class="sidebar">

    <?php if ($role === 'admin'): ?>

        <h3>MENU ADMIN</h3>

        <a href="index.php?url=dashboard" class="menu">
            Dashboard
        </a>

        <a href="index.php?url=alat" class="menu">
            Data Alat
        </a>

        <a href="index.php?url=peminjaman" class="menu active">
            Data Peminjaman
        </a>

        <a href="index.php?url=logout" class="menu">
            Logout
        </a>


    <?php elseif ($role === 'petugas'): ?>

        <h3>MENU PETUGAS</h3>

        <a href="index.php?url=dashboard" class="menu">
            Dashboard
        </a>

        <a href="index.php?url=peminjaman" class="menu active">
            Data Peminjaman
        </a>

        <a href="index.php?url=logout" class="menu">
            Logout
        </a>


    <?php elseif ($role === 'peminjam'): ?>

        <h3>MENU PEMINJAM</h3>

        <a href="index.php?url=dashboard" class="menu">
            Dashboard
        </a>

        <a href="index.php?url=alat" class="menu">
            Daftar Alat
        </a>

        <a href="index.php?url=pengajuan" class="menu">
            Ajukan Peminjaman
        </a>

        <a href="index.php?url=pengembalian" class="menu">
            Pengembalian
        </a>

        <a href="index.php?url=riwayat" class="menu">
            Riwayat Peminjaman
        </a>

        <a href="index.php?url=logout" class="menu">
            Logout
        </a>

    <?php endif; ?>

</div>


<div class="content">

    <h1>Data Peminjaman</h1>

    <div class="table-box">

        <?php if (!empty($dataPeminjaman)): ?>

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

                    <?php $no = 1; ?>

                    <?php foreach ($dataPeminjaman as $peminjaman): ?>

                        <tr>

                            <td>
                                <?= $no++; ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $peminjaman['nama_lengkap']
                                    ?? $peminjaman['username']
                                    ?? '-'
                                ); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $peminjaman['nama_alat']
                                    ?? '-'
                                ); ?>
                            </td>

                            <td>
                                <?= $peminjaman['jumlah']; ?>
                            </td>

                            <td>
                                <?= date(
                                    'd-m-Y',
                                    strtotime(
                                        $peminjaman['tanggal_pinjam']
                                    )
                                ); ?>
                            </td>

                            <td>
                                <?= date(
                                    'd-m-Y',
                                    strtotime(
                                        $peminjaman['tanggal_rencana_kembali']
                                    )
                                ); ?>
                            </td>

                            <td>

                                <span class="status <?= strtolower($peminjaman['status']); ?>">

                                    <?= ucfirst(
                                        $peminjaman['status']
                                    ); ?>

                                </span>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        <?php else: ?>

            <div class="kosong">
                Belum ada data peminjaman.
            </div>

        <?php endif; ?>

    </div>

</div>

</body>

</html>