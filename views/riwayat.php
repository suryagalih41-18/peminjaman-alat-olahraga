<?php

if (!isset($_SESSION['user'])) {
    header("Location: /PEMINJAMAN_ALAT/public/index.php?url=login");
    exit;
}

$user = $_SESSION['user'];

$nama = $user['nama_lengkap'];

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Riwayat Peminjaman</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #F5F7FA;
        }

        .navbar {
            height: 70px;
            background: #263B5A;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
        }

        .logout {
            background: white;
            color: #263B5A;
            padding: 10px 18px;
            border-radius: 7px;
            text-decoration: none;
            font-weight: bold;
        }

        .container {
            display: flex;
            min-height: calc(100vh - 70px);
        }

        .sidebar {
            width: 240px;
            background: #314A6E;
            padding: 25px 15px;
        }

        .sidebar-title {
            color: white;
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .menu {
            display: block;
            color: white;
            text-decoration: none;
            padding: 13px 15px;
            margin-bottom: 8px;
            border-radius: 8px;
        }

        .menu:hover,
        .menu.active {
            background: #263B5A;
        }

        .content {
            flex: 1;
            padding: 40px;
        }

        .content h1 {
            color: #263B5A;
            margin-bottom: 10px;
        }

        .content > p {
            color: #666;
            margin-bottom: 25px;
        }

        .table-box {
            background: white;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #E1E6ED;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #263B5A;
            color: white;
            padding: 13px;
            text-align: left;
        }

        td {
            padding: 13px;
            border-bottom: 1px solid #E1E6ED;
        }

        .status {
            font-weight: bold;
        }

        .empty {
            background: white;
            padding: 25px;
            border-radius: 12px;
            color: #666;
        }

        @media (max-width: 700px) {

            .container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .content {
                padding: 25px 15px;
            }

        }

    </style>

</head>

<body>

<div class="navbar">

    <h2>
        Peminjaman Alat Olahraga
    </h2>

    <a
        href="/PEMINJAMAN_ALAT/public/index.php?url=logout"
        class="logout"
    >
        Logout
    </a>

</div>


<div class="container">

    <div class="sidebar">

        <div class="sidebar-title">
            MENU
        </div>


        <a
            href="/PEMINJAMAN_ALAT/public/index.php?url=dashboard"
            class="menu"
        >
            Dashboard
        </a>


        <a
            href="/PEMINJAMAN_ALAT/public/index.php?url=alat"
            class="menu"
        >
            Daftar Alat
        </a>


        <a
            href="/PEMINJAMAN_ALAT/public/index.php?url=pengajuan"
            class="menu"
        >
            Ajukan Peminjaman
        </a>


        <a
            href="/PEMINJAMAN_ALAT/public/index.php?url=pengembalian"
            class="menu"
        >
            Pengembalian
        </a>


        <a
            href="/PEMINJAMAN_ALAT/public/index.php?url=riwayat"
            class="menu active"
        >
            Riwayat Peminjaman
        </a>


        <a
            href="/PEMINJAMAN_ALAT/public/index.php?url=logout"
            class="menu"
        >
            Logout
        </a>

    </div>


    <div class="content">

        <h1>
            Riwayat Peminjaman
        </h1>

        <p>
            Daftar riwayat peminjaman alat olahraga.
        </p>


        <?php if (empty($dataPeminjaman)): ?>

            <div class="empty">
                Belum ada riwayat peminjaman.
            </div>

        <?php else: ?>

            <div class="table-box">

                <table>

                    <thead>

                        <tr>

                            <th>No</th>
                            <th>Nama Alat</th>
                            <th>Jumlah</th>
                            <th>Tanggal Pinjam</th>
                            <th>Rencana Kembali</th>
                            <th>Status</th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php $no = 1; ?>

                        <?php foreach ($dataPeminjaman as $data): ?>

                            <tr>

                                <td>
                                    <?= $no++; ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $data['nama_alat']
                                    ); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $data['jumlah']
                                    ); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $data['tanggal_pinjam']
                                    ); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $data['tanggal_rencana_kembali']
                                    ); ?>
                                </td>

                                <td class="status">
                                    <?= htmlspecialchars(
                                        ucfirst($data['status'])
                                    ); ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php endif; ?>

    </div>

</div>

</body>

</html>