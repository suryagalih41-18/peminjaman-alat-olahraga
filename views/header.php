<?php
$user = $_SESSION['user'] ?? null;
$role = $user['role'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Peminjaman Alat Olahraga</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f6f9;
            color: #263238;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: linear-gradient(180deg, #172a46, #263b5a);
            padding: 25px 15px;
            box-shadow: 4px 0 15px rgba(0,0,0,0.08);
        }

        /* LOGO */
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 5px 10px 25px;
            color: white;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            margin-bottom: 25px;
        }

        .logo-icon {
            width: 45px;
            height: 45px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            box-shadow: 0 5px 12px rgba(0,0,0,0.15);
        }

        .logo-text h2 {
            font-size: 19px;
            font-weight: bold;
        }

        .logo-text p {
            font-size: 11px;
            color: #cbd5e1;
            margin-top: 4px;
        }

        /* MENU */
        .menu-title {
            color: #94a3b8;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 0 12px;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .menu {
            list-style: none;
        }

        .menu li {
            margin-bottom: 7px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 13px;
            text-decoration: none;
            color: #dbe4ef;
            padding: 13px 14px;
            border-radius: 10px;
            font-size: 14px;
            transition: 0.3s;
        }

        .menu a:hover {
            background: rgba(255,255,255,0.12);
            color: white;
            transform: translateX(4px);
        }

        .menu a.active {
            background: white;
            color: #263b5a;
            font-weight: bold;
            box-shadow: 0 5px 12px rgba(0,0,0,0.12);
        }

        .menu-icon {
            width: 22px;
            text-align: center;
            font-size: 18px;
        }

        /* USER */
        .user-box {
            position: absolute;
            left: 15px;
            right: 15px;
            bottom: 20px;
            padding: 13px;
            background: rgba(255,255,255,0.08);
            border-radius: 12px;
            color: white;
        }

        .user-name {
            font-size: 13px;
            font-weight: bold;
        }

        .user-role {
            font-size: 11px;
            color: #b9c7d8;
            margin-top: 4px;
            text-transform: capitalize;
        }

        /* CONTENT */
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
        }

        /* TOP HEADER */
        .top-header {
            height: 70px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            border-bottom: 1px solid #e5e7eb;
        }

        .page-title {
            font-size: 20px;
            font-weight: bold;
            color: #263b5a;
        }

        .welcome {
            font-size: 13px;
            color: #64748b;
        }

        .content {
            padding: 30px;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {

            .sidebar {
                width: 210px;
            }

            .main-content {
                margin-left: 210px;
            }

            .logo-text {
                display: none;
            }

            .menu a span.text {
                display: none;
            }
        }
    </style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo">

        <div class="logo-icon">
            ⚽
        </div>

        <div class="logo-text">
            <h2>SportRent</h2>
            <p>Peminjaman Alat</p>
        </div>

    </div>


    <div class="menu-title">
        Menu Utama
    </div>


    <ul class="menu">

        <?php if ($role === 'admin'): ?>

            <li>
                <a href="index.php?url=dashboard">
                    <span class="menu-icon">🏠</span>
                    <span class="text">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="index.php?url=alat">
                    <span class="menu-icon">⚽</span>
                    <span class="text">Data Alat</span>
                </a>
            </li>

            <li>
                <a href="index.php?url=peminjaman">
                    <span class="menu-icon">📋</span>
                    <span class="text">Data Peminjaman</span>
                </a>
            </li>

        <?php elseif ($role === 'petugas'): ?>

            <li>
                <a href="index.php?url=dashboard">
                    <span class="menu-icon">🏠</span>
                    <span class="text">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="index.php?url=peminjaman">
                    <span class="menu-icon">📋</span>
                    <span class="text">Data Peminjaman</span>
                </a>
            </li>

        <?php else: ?>

            <li>
                <a href="index.php?url=dashboard">
                    <span class="menu-icon">🏠</span>
                    <span class="text">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="index.php?url=alat">
                    <span class="menu-icon">⚽</span>
                    <span class="text">Daftar Alat</span>
                </a>
            </li>

            <li>
                <a href="index.php?url=pengajuan">
                    <span class="menu-icon">📝</span>
                    <span class="text">Ajukan Peminjaman</span>
                </a>
            </li>

            <li>
                <a href="index.php?url=pengembalian">
                    <span class="menu-icon">🔄</span>
                    <span class="text">Pengembalian</span>
                </a>
            </li>

            <li>
                <a href="index.php?url=riwayat">
                    <span class="menu-icon">🕒</span>
                    <span class="text">Riwayat Peminjaman</span>
                </a>
            </li>

        <?php endif; ?>

        <li>
            <a href="index.php?url=logout">
                <span class="menu-icon">🚪</span>
                <span class="text">Logout</span>
            </a>
        </li>

    </ul>


    <!-- USER BOX -->
    <?php if ($user): ?>

        <div class="user-box">

            <div class="user-name">
                👤 <?= htmlspecialchars($user['nama_lengkap']); ?>
            </div>

            <div class="user-role">
                <?= htmlspecialchars($role); ?>
            </div>

        </div>

    <?php endif; ?>

</div>


<!-- MAIN CONTENT -->
<div class="main-content">

    <div class="top-header">

        <div class="page-title">
            Peminjaman Alat Olahraga
        </div>

        <div class="welcome">
            Selamat datang, <?= htmlspecialchars($user['nama_lengkap'] ?? 'User'); ?>
        </div>

    </div>

    <div class="content">
        
</div>