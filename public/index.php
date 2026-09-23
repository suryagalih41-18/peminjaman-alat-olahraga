<?php

session_start();

require_once "../config/database.php";

require_once "../models/user.php";
require_once "../models/alat.php";
require_once "../models/kategori.php";
require_once "../models/peminjaman.php";

require_once "../controllers/controller.php";


$url = $_GET['url'] ?? 'login';


// ==================================================
// ROUTING
// ==================================================

switch ($url) {


    // ==================================================
    // LOGIN
    // ==================================================

    case 'login':

        $controller = new AuthController();

        $controller->login();

        break;


    // ==================================================
    // PROSES LOGIN
    // ==================================================

    case 'proses-login':

        $controller = new AuthController();

        $controller->prosesLogin();

        break;


    // ==================================================
    // REGISTER
    // ==================================================

    case 'register':

        $controller = new AuthController();

        $controller->register();

        break;


    // ==================================================
    // PROSES REGISTER
    // ==================================================

    case 'proses-register':

        $controller = new AuthController();

        $controller->prosesRegister();

        break;


    // ==================================================
    // DASHBOARD
    // ==================================================

    case 'dashboard':

        if (!isset($_SESSION['user'])) {

            header("Location: index.php?url=login");

            exit;
        }


        $alatModel = new Alat();

        $dataAlat = $alatModel->getAll();

        $totalAlat = count($dataAlat);


        require "../views/dashboard.php";

        break;


    // ==================================================
    // DATA ALAT
    // ==================================================

    case 'alat':

        if (!isset($_SESSION['user'])) {

            header("Location: index.php?url=login");

            exit;
        }


        $controller = new AlatController();

        $controller->index();

        break;


    // ==================================================
    // TAMBAH ALAT
    // ==================================================

    case 'tambah-alat':

        if (
            !isset($_SESSION['user']) ||
            $_SESSION['user']['role'] !== 'admin'
        ) {

            header("Location: index.php?url=dashboard");

            exit;
        }


        $controller = new AlatController();

        $controller->tambah();

        break;


    // ==================================================
    // PROSES TAMBAH ALAT
    // ==================================================

    case 'proses-tambah-alat':

        if (
            !isset($_SESSION['user']) ||
            $_SESSION['user']['role'] !== 'admin'
        ) {

            header("Location: index.php?url=dashboard");

            exit;
        }


        $controller = new AlatController();

        $controller->prosesTambah();

        break;


    // ==================================================
    // EDIT ALAT
    // ==================================================

    case 'edit-alat':

        if (
            !isset($_SESSION['user']) ||
            $_SESSION['user']['role'] !== 'admin'
        ) {

            header("Location: index.php?url=dashboard");

            exit;
        }


        $controller = new AlatController();

        $controller->edit();

        break;


    // ==================================================
    // PROSES EDIT ALAT
    // ==================================================

    case 'proses-edit-alat':

        if (
            !isset($_SESSION['user']) ||
            $_SESSION['user']['role'] !== 'admin'
        ) {

            header("Location: index.php?url=dashboard");

            exit;
        }


        $controller = new AlatController();

        $controller->prosesEdit();

        break;


    // ==================================================
    // HAPUS ALAT
    // ==================================================

    case 'hapus-alat':

        if (
            !isset($_SESSION['user']) ||
            $_SESSION['user']['role'] !== 'admin'
        ) {

            header("Location: index.php?url=dashboard");

            exit;
        }


        $controller = new AlatController();

        $controller->hapus();

        break;


    // ==================================================
    // FORM PENGAJUAN PEMINJAMAN
    // ==================================================

    case 'pengajuan':

        if (!isset($_SESSION['user'])) {

            header("Location: index.php?url=login");

            exit;
        }


        $alatModel = new Alat();

        $dataAlat = $alatModel->getAll();


        require "../views/pengajuan.php";

        break;


    // ==================================================
    // PROSES PENGAJUAN PEMINJAMAN
    // ==================================================

    case 'proses-pengajuan':

        if (!isset($_SESSION['user'])) {

            header("Location: index.php?url=login");

            exit;
        }


        $controller = new PeminjamanController();

        $controller->prosesTambah();

        break;


    // ==================================================
    // DATA PEMINJAMAN
    // ADMIN / PETUGAS
    // ==================================================

    case 'peminjaman':

        if (!isset($_SESSION['user'])) {

            header("Location: index.php?url=login");

            exit;
        }


        $controller = new PeminjamanController();

        $controller->index();

        break;


    // ==================================================
    // PENGEMBALIAN
    // ==================================================

    case 'pengembalian':

        if (!isset($_SESSION['user'])) {

            header("Location: index.php?url=login");

            exit;
        }


        $controller = new PeminjamanController();

        $controller->pengembalian();

        break;


    // ==================================================
    // PROSES PENGEMBALIAN
    // ==================================================

    case 'proses-pengembalian':

        if (!isset($_SESSION['user'])) {

            header("Location: index.php?url=login");

            exit;
        }


        $controller = new PeminjamanController();

        $controller->prosesPengembalian();

        break;


    // ==================================================
    // RIWAYAT PEMINJAMAN
    // ==================================================

    case 'riwayat':

        if (!isset($_SESSION['user'])) {

            header("Location: index.php?url=login");

            exit;
        }


        $peminjamanModel = new Peminjaman();


        $user_id = $_SESSION['user']['id'];


        $dataPeminjaman =
            $peminjamanModel->getByUser($user_id);


        require "../views/riwayat.php";

        break;


    // ==================================================
    // LOGOUT
    // ==================================================

    case 'logout':

        session_unset();

        session_destroy();


        header("Location: index.php?url=login");

        exit;

        break;


    // ==================================================
    // DEFAULT
    // ==================================================

    default:

        header("Location: index.php?url=login");

        exit;

}