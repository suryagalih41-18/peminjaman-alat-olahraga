<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location: index.php?url=login");
    exit;
}

$user = $_SESSION['user'];

$role = strtolower(trim($user['role'] ?? ''));

$namaUser = $user['nama_lengkap']
    ?? $user['username']
    ?? 'User';

$totalAlat = $totalAlat ?? 0;

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5f7fa;
            color: #263b5a;
        }

        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;

            width: 230px;
            height: 100vh;

            background: #263b5a;

            padding: 20px 15px;

            color: white;
        }


        /* =========================
           LOGO
        ========================= */

        .logo {
            display: flex;
            align-items: center;

            gap: 10px;

            padding: 5px 8px 20px;

            margin-bottom: 20px;

            border-bottom:
                1px solid rgba(255,255,255,0.2);
        }

        .logo-bola {
            width: 42px;
            height: 42px;

            background: white;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 24px;
        }

        .logo-text h2 {
            color: white;

            font-size: 17px;

            margin: 0;
        }

        .logo-text p {
            color: #cbd5e1;

            font-size: 11px;

            margin-top: 3px;
        }


        /* =========================
           MENU
        ========================= */

        .menu-title {
            font-size: 11px;

            color: #aebdce;

            margin:
                0 10px 10px;

            text-transform: uppercase;
        }

        .menu {
            list-style: none;
        }

        .menu li {
            margin-bottom: 5px;
        }

        .menu a {
            display: flex;

            align-items: center;

            gap: 12px;

            text-decoration: none;

            color: #e5eaf0;

            padding: 12px;

            border-radius: 8px;

            font-size: 14px;

            transition: 0.2s;
        }

        .menu a:hover {
            background: #314a6e;

            color: white;
        }

        .menu a.active {
            background: white;

            color: #263b5a;

            font-weight: bold;
        }

        .menu-icon {
            width: 22px;

            text-align: center;

            font-size: 17px;
        }


        /* =========================
           USER
        ========================= */

        .user-box {
            position: absolute;

            left: 15px;
            right: 15px;

            bottom: 20px;

            background:
                rgba(255,255,255,0.08);

            padding: 12px;

            border-radius: 8px;
        }

        .user-name {
            font-size: 13px;

            font-weight: bold;

            color: white;
        }

        .user-role {
            font-size: 11px;

            color: #cbd5e1;

            margin-top: 3px;

            text-transform: capitalize;
        }


        /* =========================
           MAIN
        ========================= */

        .main {
            margin-left: 230px;

            min-height: 100vh;
        }


        /* =========================
           TOPBAR
        ========================= */

        .topbar {
            height: 65px;

            background: white;

            border-bottom:
                1px solid #e5e7eb;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 0 25px;
        }

        .topbar h2 {
            font-size: 20px;

            color: #263b5a;
        }

        .welcome {
            color: #64748b;

            font-size: 13px;
        }


        /* =========================
           CONTENT
        ========================= */

        .content {
            padding: 30px;
        }


        .welcome-card {
            background: white;

            padding: 25px;

            border-radius: 12px;

            border:
                1px solid #e5e7eb;

            margin-bottom: 25px;
        }

        .welcome-card h1 {
            font-size: 24px;

            color: #263b5a;

            margin-bottom: 8px;
        }

        .welcome-card p {
            color: #64748b;

            font-size: 14px;
        }


        /* =========================
           CARDS
        ========================= */

        .cards {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 20px;
        }

        .card {
            background: white;

            border-radius: 10px;

            padding: 20px;

            border:
                1px solid #e5e7eb;
        }

        .card-title {
            color: #64748b;

            font-size: 13px;

            margin-bottom: 12px;
        }

        .card-number {
            font-size: 30px;

            font-weight: bold;

            color: #263b5a;
        }

        .card-icon {
            font-size: 22px;

            margin-bottom: 10px;
        }


        /* =========================
           QUICK MENU
        ========================= */

        .quick {
            margin-top: 25px;

            background: white;

            padding: 20px;

            border-radius: 10px;

            border:
                1px solid #e5e7eb;
        }

        .quick h3 {
            margin-bottom: 15px;

            color: #263b5a;
        }

        .quick-menu {
            display: flex;

            gap: 10px;

            flex-wrap: wrap;
        }

        .quick-menu a {
            text-decoration: none;

            color: #263b5a;

            background: #e9eef5;

            padding: 11px 15px;

            border-radius: 7px;

            font-size: 13px;
        }

        .quick-menu a:hover {
            background: #dce5f0;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 800px) {

            .sidebar {
                width: 200px;
            }

            .main {
                margin-left: 200px;
            }

            .cards {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>


<body>


<!-- =========================
     SIDEBAR
========================= -->

<div class="sidebar">


    <!-- LOGO -->

    <div class="logo">

        <div class="logo-bola">
            ⚽
        </div>

        <div class="logo-text">

            <h2>Peminjaman</h2>

            <p>Alat Olahraga</p>

        </div>

    </div>


    <div class="menu-title">
        Menu Utama
    </div>


    <ul class="menu">


        <?php if ($role === 'admin'): ?>


            <li>
                <a
                    href="index.php?url=dashboard"
                    class="active"
                >
                    <span class="menu-icon">🏠</span>
                    Dashboard
                </a>
            </li>


            <li>
                <a href="index.php?url=alat">
                    <span class="menu-icon">⚽</span>
                    Data Alat
                </a>
            </li>


            <li>
                <a href="index.php?url=peminjaman">
                    <span class="menu-icon">📋</span>
                    Data Peminjaman
                </a>
            </li>


        <?php elseif ($role === 'petugas'): ?>


            <li>
                <a
                    href="index.php?url=dashboard"
                    class="active"
                >
                    <span class="menu-icon">🏠</span>
                    Dashboard
                </a>
            </li>


            <li>
                <a href="index.php?url=peminjaman">
                    <span class="menu-icon">📋</span>
                    Data Peminjaman
                </a>
            </li>


        <?php else: ?>


            <li>
                <a
                    href="index.php?url=dashboard"
                    class="active"
                >
                    <span class="menu-icon">🏠</span>
                    Dashboard
                </a>
            </li>


            <li>
                <a href="index.php?url=alat">
                    <span class="menu-icon">⚽</span>
                    Daftar Alat
                </a>
            </li>


            <li>
                <a href="index.php?url=pengajuan">
                    <span class="menu-icon">📝</span>
                    Ajukan Peminjaman
                </a>
            </li>


            <li>
                <a href="index.php?url=pengembalian">
                    <span class="menu-icon">🔄</span>
                    Pengembalian
                </a>
            </li>


            <li>
                <a href="index.php?url=riwayat">
                    <span class="menu-icon">🕒</span>
                    Riwayat Peminjaman
                </a>
            </li>


        <?php endif; ?>


        <li>
            <a href="index.php?url=logout">
                <span class="menu-icon">🚪</span>
                Logout
            </a>
        </li>


    </ul>


    <!-- USER -->

    <div class="user-box">

        <div class="user-name">

            👤 <?= htmlspecialchars($namaUser); ?>

        </div>

        <div class="user-role">

            <?= htmlspecialchars($role); ?>

        </div>

    </div>


</div>


<!-- =========================
     MAIN
========================= -->

<div class="main">


    <!-- TOPBAR -->

    <div class="topbar">

        <h2>
            Dashboard
        </h2>

        <div class="welcome">

            Selamat datang,
            <b><?= htmlspecialchars($namaUser); ?></b>

        </div>

    </div>


    <!-- CONTENT -->

    <div class="content">


        <div class="welcome-card">

            <h1>
                Halo, <?= htmlspecialchars($namaUser); ?> 👋
            </h1>

            <p>
                Selamat datang di Sistem Peminjaman Alat Olahraga.
            </p>

        </div>


        <div class="cards">


            <div class="card">

                <div class="card-icon">
                    ⚽
                </div>

                <div class="card-title">
                    Total Data Alat
                </div>

                <div class="card-number">
                    <?= $totalAlat; ?>
                </div>

            </div>


            <div class="card">

                <div class="card-icon">
                    📋
                </div>

                <div class="card-title">
                    Data Peminjaman
                </div>

                <div class="card-number">
                    0
                </div>

            </div>


            <div class="card">

                <div class="card-icon">
                    🔄
                </div>

                <div class="card-title">
                    Peminjaman Aktif
                </div>

                <div class="card-number">
                    0
                </div>

            </div>


        </div>


        <div class="quick">

            <h3>
                Menu Cepat
            </h3>


            <div class="quick-menu">


                <?php if ($role === 'admin'): ?>

                    <a href="index.php?url=alat">
                        ⚽ Kelola Data Alat
                    </a>

                    <a href="index.php?url=peminjaman">
                        📋 Data Peminjaman
                    </a>


                <?php elseif ($role === 'petugas'): ?>

                    <a href="index.php?url=peminjaman">
                        📋 Data Peminjaman
                    </a>


                <?php else: ?>

                    <a href="index.php?url=alat">
                        ⚽ Daftar Alat
                    </a>

                    <a href="index.php?url=pengajuan">
                        📝 Ajukan Peminjaman
                    </a>

                    <a href="index.php?url=riwayat">
                        🕒 Riwayat Peminjaman
                    </a>

                <?php endif; ?>


            </div>

        </div>


    </div>


</div>


</body>

</html>