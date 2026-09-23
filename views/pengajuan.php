<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Ajukan Peminjaman</title>

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

        .form-box {
            background: white;
            max-width: 700px;
            padding: 30px;
            border-radius: 12px;
            border: 1px solid #E1E6ED;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            color: #263B5A;
            font-weight: bold;
            margin-bottom: 7px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #D5DCE5;
            border-radius: 7px;
            font-size: 14px;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        .btn {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 7px;
            background: #263B5A;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .btn:hover {
            background: #314A6E;
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
            class="menu active"
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
            class="menu"
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
            Ajukan Peminjaman
        </h1>

        <p>
            Silakan isi data peminjaman alat olahraga.
        </p>


        <div class="form-box">

            <form
                action="/PEMINJAMAN_ALAT/public/index.php?url=proses-pengajuan"
                method="POST"
            >


                <div class="form-group">

                    <label>
                        Nama Peminjam
                    </label>

                    <input
                        type="text"
                        value="<?= htmlspecialchars($nama); ?>"
                        readonly
                    >

                </div>


                <div class="form-group">

                    <label>
                        Pilih Alat
                    </label>

                    <select
                        name="alat_id"
                        required
                    >

                        <option value="">
                            -- Pilih Alat --
                        </option>

                        <?php foreach ($dataAlat as $alat): ?>

                            <?php if ($alat['stok'] > 0): ?>

                                <option
                                    value="<?= $alat['id']; ?>"
                                >
                                    <?= htmlspecialchars(
                                        $alat['nama_alat']
                                    ); ?>
                                    - Stok:
                                    <?= $alat['stok']; ?>
                                </option>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    </select>

                </div>


                <div class="form-group">

                    <label>
                        Jumlah
                    </label>

                    <input
                        type="number"
                        name="jumlah"
                        min="1"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Tanggal Peminjaman
                    </label>

                    <input
                        type="date"
                        name="tanggal_pinjam"
                        value="<?= date('Y-m-d'); ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Tanggal Rencana Pengembalian
                    </label>

                    <input
                        type="date"
                        name="tanggal_rencana_kembali"
                        required
                    >

                </div>


                <button
                    type="submit"
                    class="btn"
                >
                    Ajukan Peminjaman
                </button>

            </form>

        </div>

    </div>

</div>

</body>

</html>