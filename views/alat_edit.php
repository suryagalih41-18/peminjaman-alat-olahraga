<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (
    !isset($_SESSION['user']) ||
    $_SESSION['user']['role'] !== 'admin'
) {
    header("Location: ../public/index.php?url=dashboard");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Data Alat</title>

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

        /* TOPBAR */

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

        /* SIDEBAR */

        .sidebar {
            position: fixed;
            top: 90px;
            left: 0;
            bottom: 0;
            width: 310px;
            background: #314A6E;
            padding: 30px 20px;
            overflow-y: auto;
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

        /* CONTENT */

        .content {
            margin-left: 310px;
            padding: 140px 40px 50px;
        }

        .content h1 {
            margin-bottom: 25px;
            font-size: 28px;
        }

        /* FORM */

        .form-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            max-width: 700px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #263B5A;
        }

        input,
        select {
            width: 100%;
            padding: 13px;
            border: 1px solid #D5DCE5;
            border-radius: 7px;
            font-size: 15px;
            outline: none;
        }

        input:focus,
        select:focus {
            border-color: #263B5A;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        button,
        .btn-kembali {
            padding: 12px 22px;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        button {
            background: #263B5A;
            color: white;
        }

        button:hover {
            background: #1d2e47;
        }

        .btn-kembali {
            background: #E9EEF5;
            color: #263B5A;
        }

        .btn-kembali:hover {
            background: #dce3ed;
        }

    </style>

</head>

<body>

    <!-- TOPBAR -->

    <div class="topbar">

        <h2>
            Peminjaman Alat Olahraga
        </h2>

    </div>


    <!-- SIDEBAR -->

    <div class="sidebar">

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

    </div>


    <!-- CONTENT -->

    <div class="content">

        <h1>
            Edit Data Alat
        </h1>


        <div class="form-box">

            <form
                action="index.php?url=proses-edit-alat"
                method="POST"
            >

                <input
                    type="hidden"
                    name="id"
                    value="<?= $alat['id']; ?>"
                >


                <div class="form-group">

                    <label>
                        Nama Alat
                    </label>

                    <input
                        type="text"
                        name="nama_alat"
                        value="<?= htmlspecialchars($alat['nama_alat']); ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Kategori
                    </label>

                    <select
                        name="kategori_id"
                        required
                    >

                        <option
                            value="1"
                            <?= $alat['kategori_id'] == 1 ? 'selected' : ''; ?>
                        >
                            Bola
                        </option>

                        <option
                            value="2"
                            <?= $alat['kategori_id'] == 2 ? 'selected' : ''; ?>
                        >
                            Raket
                        </option>

                        <option
                            value="3"
                            <?= $alat['kategori_id'] == 3 ? 'selected' : ''; ?>
                        >
                            Perlengkapan
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label>
                        Stok
                    </label>

                    <input
                        type="number"
                        name="stok"
                        min="0"
                        value="<?= $alat['stok']; ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Kondisi
                    </label>

                    <select
                        name="kondisi"
                        required
                    >

                        <option
                            value="Baik"
                            <?= $alat['kondisi'] == 'Baik' ? 'selected' : ''; ?>
                        >
                            Baik
                        </option>

                        <option
                            value="Rusak Ringan"
                            <?= $alat['kondisi'] == 'Rusak Ringan' ? 'selected' : ''; ?>
                        >
                            Rusak Ringan
                        </option>

                        <option
                            value="Rusak Berat"
                            <?= $alat['kondisi'] == 'Rusak Berat' ? 'selected' : ''; ?>
                        >
                            Rusak Berat
                        </option>

                    </select>

                </div>


                <div class="button-group">

                    <button type="submit">
                        Simpan Perubahan
                    </button>

                    <a
                        href="index.php?url=alat"
                        class="btn-kembali"
                    >
                        Kembali
                    </a>

                </div>

            </form>

        </div>

    </div>

</body>

</html>