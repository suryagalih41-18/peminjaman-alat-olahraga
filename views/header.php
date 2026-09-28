<?php
$role = $_SESSION['user']['role'] ?? '';
$namaUser = $_SESSION['user']['nama_lengkap'] ?? 'User';
$active = $active ?? '';
$pageTitle = $pageTitle ?? 'Peminjaman Alat Olahraga';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($pageTitle) ?> - Peminjaman Alat Olahraga</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7fa;
            color: #26364d;
        }

        a {
            text-decoration: none;
        }

        .topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 65px;
            background: #ffffff;
            border-bottom: 1px solid #e4e8ee;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px 0 265px;
            z-index: 1000;
        }

        .topbar-title {
            font-size: 20px;
            font-weight: bold;
            color: #263b5a;
        }

        .welcome {
            color: #65748b;
            font-size: 14px;
        }

        .welcome strong {
            color: #263b5a;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 238px;
            background: #294365;
            color: white;
            z-index: 1100;
            padding: 22px 15px;
        }

        .brand {
            height: 78px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 8px 18px;
            border-bottom: 1px solid rgba(255,255,255,.12);
        }

        .brand-icon {
            width: 43px;
            height: 43px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
        }

        .brand-name {
            font-size: 18px;
            font-weight: bold;
        }

        .brand-sub {
            font-size: 11px;
            margin-top: 3px;
            color: #d6e0ed;
        }

        .menu-title {
            font-size: 11px;
            color: #d0dbea;
            margin: 27px 10px 10px;
            text-transform: uppercase;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            padding: 15px 14px;
            margin-bottom: 5px;
            border-radius: 9px;
            font-size: 14px;
            transition: .2s;
        }

        .menu a:hover {
            background: #38577f;
        }

        .menu a.active {
            background: white;
            color: #263b5a;
        }

        .menu-icon {
            width: 22px;
            text-align: center;
            font-size: 17px;
        }

        .user-box {
            position: absolute;
            left: 15px;
            right: 15px;
            bottom: 18px;
            background: #34547d;
            padding: 14px;
            border-radius: 8px;
        }

        .user-name {
            font-size: 14px;
            font-weight: bold;
        }

        .user-role {
            font-size: 11px;
            color: #d9e4f0;
            margin-top: 3px;
        }

        .main {
            margin-left: 238px;
            padding-top: 65px;
            min-height: 100vh;
        }

        .content {
            padding: 32px 30px 45px;
        }

        .page-card {
            background: white;
            border: 1px solid #e4e8ee;
            border-radius: 10px;
            padding: 28px;
            margin-bottom: 25px;
        }

        .page-card h1,
        .page-card h2 {
            margin: 0 0 7px;
            color: #263b5a;
        }

        .page-card p {
            margin: 0;
            color: #64748b;
        }

        .btn {
            display: inline-block;
            border: 0;
            border-radius: 7px;
            padding: 10px 16px;
            background: #263b5a;
            color: white;
            font-size: 13px;
            cursor: pointer;
        }

        .btn:hover {
            opacity: .9;
        }

        .btn-primary {
            background: #263b5a;
        }

        .btn-success {
            background: #3d8b62;
        }

        .btn-danger {
            background: #9b3d3d;
        }

        .btn-secondary {
            background: #607a9d;
        }

        .btn-small {
            padding: 8px 13px;
            font-size: 12px;
        }

        .table-card {
            background: white;
            border: 1px solid #e4e8ee;
            border-radius: 10px;
            padding: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #263b5a;
            color: white;
            padding: 13px 14px;
            text-align: left;
            font-size: 13px;
        }

        td {
            padding: 13px 14px;
            border-bottom: 1px solid #e5e9ef;
            font-size: 13px;
            color: #303b4d;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 6px;
            background: #edf2f8;
            color: #263b5a;
            font-size: 12px;
        }

        .badge-success {
            background: #e5f5eb;
            color: #267348;
        }

        .badge-warning {
            background: #fff4dc;
            color: #946b18;
        }

        .badge-danger {
            background: #fae6e6;
            color: #9b3d3d;
        }

        .action {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .empty {
            text-align: center;
            padding: 35px;
            color: #7b8798;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 7px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .alert-success {
            background: #e6f5eb;
            color: #267348;
        }

        .alert-danger {
            background: #fae7e7;
            color: #963e3e;
        }

        .form-card {
            max-width: 650px;
            margin: 0 auto;
            background: white;
            border: 1px solid #e4e8ee;
            border-radius: 10px;
            padding: 28px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            color: #34445c;
            margin-bottom: 7px;
        }

        input,
        select,
        textarea {
            width: 100%;
            border: 1px solid #d6dce5;
            border-radius: 7px;
            padding: 11px 12px;
            font-family: inherit;
            font-size: 13px;
            outline: none;
            background: white;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #607a9d;
        }

        .form-actions {
            display: flex;
            gap: 8px;
            margin-top: 20px;
        }

        @media(max-width: 800px) {

            .sidebar {
                width: 200px;
            }

            .main {
                margin-left: 200px;
            }

            .topbar {
                padding-left: 220px;
            }

            .content {
                padding: 25px 18px;
            }
        }
    </style>
</head>

<body>

<div class="sidebar">

    <div class="brand">
        <div class="brand-icon">⚽</div>

        <div>
            <div class="brand-name">Peminjaman</div>
            <div class="brand-sub">Alat Olahraga</div>
        </div>
    </div>

    <div class="menu-title">Menu Utama</div>

    <div class="menu">

        <a href="index.php?url=dashboard"
           class="<?= $active === 'dashboard' ? 'active' : '' ?>">
            <span class="menu-icon">🏠</span>
            <span>Dashboard</span>
        </a>


        <?php if ($role === 'admin'): ?>

            <a href="index.php?url=alat"
               class="<?= $active === 'alat' ? 'active' : '' ?>">
                <span class="menu-icon">⚽</span>
                <span>Data Alat</span>
            </a>

            <a href="index.php?url=peminjaman"
               class="<?= $active === 'peminjaman' ? 'active' : '' ?>">
                <span class="menu-icon">📋</span>
                <span>Data Peminjaman</span>
            </a>

            <a href="index.php?url=peminjam"
               class="<?= $active === 'peminjam' ? 'active' : '' ?>">
                <span class="menu-icon">👥</span>
                <span>Data Peminjam</span>
            </a>

        <?php elseif ($role === 'petugas'): ?>

            <a href="index.php?url=peminjaman"
               class="<?= $active === 'peminjaman' ? 'active' : '' ?>">
                <span class="menu-icon">📋</span>
                <span>Data Peminjaman</span>
            </a>

            <a href="index.php?url=pengembalian-petugas"
               class="<?= $active === 'pengembalian-petugas' ? 'active' : '' ?>">
                <span class="menu-icon">↩️</span>
                <span>Data Pengembalian</span>
            </a>

            <a href="index.php?url=denda"
               class="<?= $active === 'denda' ? 'active' : '' ?>">
                <span class="menu-icon">💰</span>
                <span>Denda</span>
            </a>

        <?php elseif ($role === 'peminjam'): ?>

            <a href="index.php?url=alat"
               class="<?= $active === 'alat' ? 'active' : '' ?>">
                <span class="menu-icon">⚽</span>
                <span>Daftar Alat</span>
            </a>

            <a href="index.php?url=pengajuan"
               class="<?= $active === 'pengajuan' ? 'active' : '' ?>">
                <span class="menu-icon">📝</span>
                <span>Ajukan Peminjaman</span>
            </a>

            <a href="index.php?url=pengembalian"
               class="<?= $active === 'pengembalian' ? 'active' : '' ?>">
                <span class="menu-icon">↩️</span>
                <span>Pengembalian</span>
            </a>

            <a href="index.php?url=riwayat"
               class="<?= $active === 'riwayat' ? 'active' : '' ?>">
                <span class="menu-icon">📜</span>
                <span>Riwayat Peminjaman</span>
            </a>

        <?php endif; ?>


        <a href="index.php?url=logout">
            <span class="menu-icon">🚪</span>
            <span>Logout</span>
        </a>

    </div>


    <div class="user-box">

        <div class="user-name">
            👤 <?= htmlspecialchars($namaUser) ?>
        </div>

        <div class="user-role">
            <?= ucfirst(htmlspecialchars($role)) ?>
        </div>

    </div>

</div>


<div class="topbar">

    <div class="topbar-title">
        <?= htmlspecialchars($pageTitle) ?>
    </div>

    <div class="welcome">
        Selamat datang,
        <strong><?= htmlspecialchars($namaUser) ?></strong>
    </div>

</div>


<div class="main">

    <div class="content">