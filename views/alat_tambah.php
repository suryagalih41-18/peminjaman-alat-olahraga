<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: /PEMINJAMAN_ALAT/public/index.php?url=dashboard");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Alat</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #F5F7FA;
            color: #263B5A;
        }

        .topbar {
            height: 90px;
            background: #263B5A;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
        }

        .topbar h2 {
            font-size: 26px;
        }

        .logout {
            background: white;
            color: #263B5A;
            text-decoration: none;
            padding: 13px 25px;
            border-radius: 8px;
            font-weight: bold;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 90px;
            width: 310px;
            height: calc(100vh - 90px);
            background: #314A6E;
            padding: 30px 20px;
        }

        .sidebar-title {
            color: white;
            text-align: center;
            font-size: 21px;
            margin-bottom: 35px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 14px 18px;
            margin-bottom: 8px;
            border-radius: 8px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #263B5A;
        }

        .content {
            margin-left: 310px;
            padding: 50px;
        }

        .content h1 {
            font-size: 36px;
            margin-bottom: 8px;
        }

        .content p {
            color: #666;
            margin-bottom: 25px;
        }

        .form-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            border: 1px solid #DCE3ED;
            max-width: 700px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input,
        select {
            width: 100%;
            padding: 13px;
            border: 1px solid #CCD5E0;
            border-radius: 6px;
            font-size: 15px;
        }

        .buttons {
            display: flex;
            gap: 12px;
            margin-top: 25px;
        }

        .btn-simpan {
            border: none;
            background: #263B5A;
            color: white;
            padding: 13px 22px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-kembali {
            background: #E9EEF5;
            color: #263B5A;
            text-decoration: none;
            padding: 13px 22px;
            border-radius: 6px;
            font-weight: bold;
        }

    </style>

</head>

<body>


<div class="topbar">

    <h2>Peminjaman Alat Olahraga</h2>

    <a
        href="/PEMINJAMAN_ALAT/public/index.php?url=logout"
        class="logout"
    >
        Logout
    </a>

</div>


<div class="sidebar">

    <div class="sidebar-title">
        MENU ADMIN
    </div>

    <a
        href="/PEMINJAMAN_ALAT/public/index.php?url=dashboard"
    >
        Dashboard
    </a>

    <a
        href="/PEMINJAMAN_ALAT/public/index.php?url=alat"
        class="active"
    >
        Data Alat
    </a>

    <a
        href="/PEMINJAMAN_ALAT/public/index.php?url=peminjaman"
    >
        Data Peminjaman
    </a>

</div>


<div class="content">

    <h1>Tambah Data Alat</h1>

    <p>Tambahkan alat olahraga baru ke dalam sistem.</p>


    <div class="form-card">

        <form
            action="/PEMINJAMAN_ALAT/public/index.php?url=proses-tambah-alat"
            method="POST"
        >

            <div class="form-group">

                <label>
                    Nama Alat
                </label>

                <input
                    type="text"
                    name="nama_alat"
                    placeholder="Contoh: Bola Futsal"
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

                    <option value="">
                        -- Pilih Kategori --
                    </option>

                    <option value="1">
                        Bola
                    </option>

                    <option value="2">
                        Raket
                    </option>

                    <option value="3">
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
                    placeholder="Contoh: 10"
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

                    <option value="">
                        -- Pilih Kondisi --
                    </option>

                    <option value="Baik">
                        Baik
                    </option>

                    <option value="Rusak Ringan">
                        Rusak Ringan
                    </option>

                    <option value="Rusak Berat">
                        Rusak Berat
                    </option>

                </select>

            </div>


            <div class="buttons">

                <button
                    type="submit"
                    class="btn-simpan"
                >
                    Simpan
                </button>

                <a
                    href="/PEMINJAMAN_ALAT/public/index.php?url=alat"
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