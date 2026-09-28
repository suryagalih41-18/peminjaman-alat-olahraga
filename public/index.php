<?php

session_start();

require_once __DIR__ . '/../config/database.php';

require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/alat.php';
require_once __DIR__ . '/../models/kategori.php';
require_once __DIR__ . '/../models/peminjaman.php';

require_once __DIR__ . '/../controllers/controller.php';


$url = $_GET['url'] ?? 'login';


switch ($url) {

    case 'login':
        (new AuthController())->login();
        break;

    case 'proses-login':
        (new AuthController())->prosesLogin();
        break;

    case 'register':
        (new AuthController())->register();
        break;

    case 'proses-register':
        (new AuthController())->prosesRegister();
        break;


    case 'dashboard':

        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        require_once __DIR__ . '/../views/dashboard.php';

        break;


    case 'alat':
        (new AlatController())->index();
        break;

    case 'tambah-alat':
        (new AlatController())->tambah();
        break;

    case 'proses-tambah-alat':
        (new AlatController())->prosesTambah();
        break;

    case 'edit-alat':
        (new AlatController())->edit();
        break;

    case 'proses-edit-alat':
        (new AlatController())->prosesEdit();
        break;

    case 'hapus-alat':
        (new AlatController())->hapus();
        break;


    case 'peminjam':
        UserController::peminjam();
        break;


    case 'peminjaman':
        (new PeminjamanController())->index();
        break;

    case 'pengajuan':
        (new PeminjamanController())->pengajuan();
        break;

    case 'proses-pengajuan':
        (new PeminjamanController())->prosesTambah();
        break;

    case 'setujui-peminjaman':
        (new PeminjamanController())->setujuiPeminjaman();
        break;

    case 'tolak-peminjaman':
        (new PeminjamanController())->tolakPeminjaman();
        break;


    case 'pengembalian':
        (new PeminjamanController())->pengembalian();
        break;

    case 'proses-pengembalian':
        (new PeminjamanController())->prosesPengembalian();
        break;

    case 'pengembalian-petugas':
        (new PeminjamanController())->pengembalianPetugas();
        break;

    case 'setujui-pengembalian':
        (new PeminjamanController())->setujuiPengembalian();
        break;


    case 'riwayat':
        (new PeminjamanController())->riwayat();
        break;

    case 'denda':
        (new PeminjamanController())->denda();
        break;


    case 'logout':

        session_unset();
        session_destroy();

        header("Location: index.php?url=login");
        exit;

        break;


    default:

        header("Location: index.php?url=login");
        exit;
}