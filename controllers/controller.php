<?php

// ==========================================
// CONTROLLER AUTH
// ==========================================

class AuthController
{
    public function login()
    {
        require "../views/login.php";
    }


    public function prosesLogin()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $userModel = new User();

        $user = $userModel->login(
            $username,
            $password
        );

        if ($user) {

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['user'] = $user;

            header(
                "Location: /PEMINJAMAN_ALAT/public/index.php?url=dashboard"
            );

            exit;

        } else {

            $error = "Username atau password salah!";

            require "../views/login.php";
        }
    }


    public function register()
    {
        require "../views/register.php";
    }


    public function prosesRegister()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $konfirmasi = $_POST['konfirmasi_password'];
        $nama_lengkap = $_POST['nama_lengkap'];


        if ($password != $konfirmasi) {

            $error = "Konfirmasi password tidak sama!";

            require "../views/register.php";

            return;
        }


        $userModel = new User();


        if (
            $userModel->register(
                $username,
                $password,
                $nama_lengkap
            )
        ) {

            header(
                "Location: index.php?url=login&success=1"
            );

            exit;

        } else {

            $error = "Registrasi gagal!";

            require "../views/register.php";
        }
    }
}



// ==========================================
// CONTROLLER DATA ALAT
// ==========================================

class AlatController
{
    public function index()
    {
        $alatModel = new Alat();

        $dataAlat = $alatModel->getAll();

        require "../views/alat.php";
    }


    // ======================================
    // TAMBAH ALAT
    // ======================================

    public function tambah()
    {
        require "../views/alat_tambah.php";
    }


    public function prosesTambah()
    {
        $nama_alat = $_POST['nama_alat'];
        $kategori_id = $_POST['kategori_id'];
        $stok = $_POST['stok'];
        $kondisi = $_POST['kondisi'];


        $alatModel = new Alat();


        $alatModel->tambah(
            $nama_alat,
            $kategori_id,
            $stok,
            $kondisi
        );


        header(
            "Location: index.php?url=alat"
        );

        exit;
    }


    // ======================================
    // EDIT ALAT
    // ======================================

    public function edit()
    {
        $id = $_GET['id'];


        $alatModel = new Alat();

        $dataAlat = $alatModel->getAll();


        $alat = null;


        foreach ($dataAlat as $data) {

            if ($data['id'] == $id) {

                $alat = $data;

                break;
            }
        }


        if (!$alat) {

            header(
                "Location: index.php?url=alat"
            );

            exit;
        }


        require "../views/alat_edit.php";
    }


    public function prosesEdit()
    {
        $id = $_POST['id'];
        $nama_alat = $_POST['nama_alat'];
        $kategori_id = $_POST['kategori_id'];
        $stok = $_POST['stok'];
        $kondisi = $_POST['kondisi'];


        $alatModel = new Alat();


        $alatModel->update(
            $id,
            $nama_alat,
            $kategori_id,
            $stok,
            $kondisi
        );


        header(
            "Location: index.php?url=alat"
        );

        exit;
    }


    // ======================================
    // HAPUS ALAT
    // ======================================

    public function hapus()
    {
        $id = $_GET['id'];


        $alatModel = new Alat();


        $hasil = $alatModel->delete($id);


        if ($hasil) {

            header(
                "Location: index.php?url=alat&hapus=berhasil"
            );

            exit;

        } else {

            header(
                "Location: index.php?url=alat&hapus=gagal"
            );

            exit;
        }
    }
}



// ==========================================
// CONTROLLER PEMINJAMAN
// ==========================================

class PeminjamanController
{
    // ======================================
    // DATA PEMINJAMAN
    // ======================================

    public function index()
    {
        $peminjamanModel = new Peminjaman();

        $dataPeminjaman =
            $peminjamanModel->getAll();


        require "../views/peminjaman.php";
    }


    // ======================================
    // PROSES AJUKAN PEMINJAMAN
    // ======================================

    public function prosesTambah()
    {
        if (!isset($_SESSION['user'])) {

            header(
                "Location: index.php?url=login"
            );

            exit;
        }


        $user_id =
            $_SESSION['user']['id'];


        $alat_id =
            $_POST['alat_id'];


        $jumlah =
            $_POST['jumlah'];


        $tanggal_pinjam =
            $_POST['tanggal_pinjam'];


        $tanggal_rencana_kembali =
            $_POST['tanggal_rencana_kembali'];


        $peminjamanModel =
            new Peminjaman();


        $hasil =
            $peminjamanModel->tambah(
                $user_id,
                $alat_id,
                $jumlah,
                $tanggal_pinjam,
                $tanggal_rencana_kembali
            );


        if ($hasil) {

            header(
                "Location: index.php?url=riwayat&status=berhasil"
            );

            exit;

        } else {

            header(
                "Location: index.php?url=pengajuan&status=gagal"
            );

            exit;
        }
    }


    // ======================================
    // HALAMAN PENGEMBALIAN
    // ======================================

    public function pengembalian()
    {
        if (!isset($_SESSION['user'])) {

            header(
                "Location: index.php?url=login"
            );

            exit;
        }


        $user_id =
            $_SESSION['user']['id'];


        $peminjamanModel =
            new Peminjaman();


        $dataPeminjaman =
            $peminjamanModel->getAktifByUser(
                $user_id
            );


        require "../views/pengembalian.php";
    }


    // ======================================
    // PROSES PENGEMBALIAN
    // ======================================

    public function prosesPengembalian()
    {
        if (!isset($_SESSION['user'])) {

            header(
                "Location: index.php?url=login"
            );

            exit;
        }


        $id =
            $_POST['id'];


        $user_id =
            $_SESSION['user']['id'];


        $peminjamanModel =
            new Peminjaman();


        $hasil =
            $peminjamanModel->kembalikan(
                $id,
                $user_id
            );


        if ($hasil) {

            header(
                "Location: index.php?url=pengembalian&status=berhasil"
            );

            exit;

        } else {

            header(
                "Location: index.php?url=pengembalian&status=gagal"
            );

            exit;
        }
    }
}