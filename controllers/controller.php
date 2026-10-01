```php
<?php

/* =========================================================
   AUTH CONTROLLER
========================================================= */

class AuthController
{
    public static function login()
    {
        if (isset($_SESSION['user'])) {
            header("Location: index.php?url=dashboard");
            exit;
        }

        require_once __DIR__ . '/../views/login.php';
    }

    public static function prosesLogin()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $model = new User();

        $user = $model->login($username, $password);

        if ($user) {

            $_SESSION['user'] = $user;

            header("Location: index.php?url=dashboard");
            exit;
        }

        header("Location: index.php?url=login&status=gagal");
        exit;
    }

    public static function register()
    {
        if (isset($_SESSION['user'])) {
            header("Location: index.php?url=dashboard");
            exit;
        }

        require_once __DIR__ . '/../views/register.php';
    }

    public static function prosesRegister()
    {
        $nama_lengkap = $_POST['nama_lengkap'] ?? '';
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $konfirmasi = $_POST['konfirmasi_password'] ?? '';

        if ($password !== $konfirmasi) {
            header("Location: index.php?url=register&status=password");
            exit;
        }

        $model = new User();

        $hasil = $model->register(
            $username,
            $password,
            $nama_lengkap
        );

        if ($hasil) {
            header("Location: index.php?url=login&status=register");
            exit;
        }

        header("Location: index.php?url=register&status=gagal");
        exit;
    }
}


/* =========================================================
   ALAT CONTROLLER
========================================================= */

class AlatController
{
    public static function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        $model = new Alat();

        $alat = $model->getAll();

        require_once __DIR__ . '/../views/alat.php';
    }

    public static function tambah()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location: index.php?url=dashboard");
            exit;
        }

        $kategoriModel = new Kategori();

        $kategori = $kategoriModel->getAll();

        require_once __DIR__ . '/../views/alat_tambah.php';
    }

    public static function prosesTambah()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location: index.php?url=dashboard");
            exit;
        }

        $nama_alat = $_POST['nama_alat'] ?? '';
        $kategori_id = $_POST['kategori_id'] ?? '';
        $stok = $_POST['stok'] ?? 0;
        $kondisi = $_POST['kondisi'] ?? '';

        $model = new Alat();

        $model->tambah(
            $nama_alat,
            $kategori_id,
            $stok,
            $kondisi
        );

        header("Location: index.php?url=alat&status=berhasil");
        exit;
    }

    public static function edit()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location: index.php?url=dashboard");
            exit;
        }

        $id = $_GET['id'] ?? 0;

        $model = new Alat();

        $alat = $model->getById($id);

        $kategoriModel = new Kategori();

        $kategori = $kategoriModel->getAll();

        require_once __DIR__ . '/../views/alat_edit.php';
    }

    public static function prosesEdit()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location: index.php?url=dashboard");
            exit;
        }

        $id = $_POST['id'] ?? 0;
        $nama_alat = $_POST['nama_alat'] ?? '';
        $kategori_id = $_POST['kategori_id'] ?? '';
        $stok = $_POST['stok'] ?? 0;
        $kondisi = $_POST['kondisi'] ?? '';

        $model = new Alat();

        $model->edit(
            $id,
            $nama_alat,
            $kategori_id,
            $stok,
            $kondisi
        );

        header("Location: index.php?url=alat&status=berhasil");
        exit;
    }

    public static function hapus()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location: index.php?url=dashboard");
            exit;
        }

        $id = $_GET['id'] ?? 0;

        $model = new Alat();

        $model->hapus($id);

        header("Location: index.php?url=alat&status=berhasil");
        exit;
    }
}


/* =========================================================
   USER CONTROLLER
========================================================= */

class UserController
{
    public static function peminjam()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location: index.php?url=dashboard");
            exit;
        }

        $model = new User();

        $peminjam = $model->getPeminjam();

        require_once __DIR__ . '/../views/peminjam.php';
    }
}


/* =========================================================
   PEMINJAMAN CONTROLLER
========================================================= */

class PeminjamanController
{
    public static function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        $role = $_SESSION['user']['role'];

        if ($role !== 'admin' && $role !== 'petugas') {
            header("Location: index.php?url=dashboard");
            exit;
        }

        $model = new Peminjaman();

        $peminjaman = $model->getAll();

        require_once __DIR__ . '/../views/peminjaman.php';
    }


    public static function pengajuan()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        if ($_SESSION['user']['role'] !== 'peminjam') {
            header("Location: index.php?url=dashboard");
            exit;
        }

        $model = new Alat();

        $alat = $model->getAll();

        require_once __DIR__ . '/../views/pengajuan.php';
    }


    public static function prosesTambah()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        $user_id = $_SESSION['user']['id'];

        $alat_id = $_POST['alat_id'] ?? 0;
        $jumlah = $_POST['jumlah'] ?? 0;
        $tanggal_pinjam = $_POST['tanggal_pinjam'] ?? '';
        $tanggal_rencana_kembali =
            $_POST['tanggal_rencana_kembali'] ?? '';

        $model = new Peminjaman();

        $hasil = $model->tambah(
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

        } else {

            header(
                "Location: index.php?url=pengajuan&status=gagal"
            );
        }

        exit;
    }


    public static function setujuiPeminjaman()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        if ($_SESSION['user']['role'] !== 'petugas') {
            header("Location: index.php?url=dashboard");
            exit;
        }

        $id = $_GET['id'] ?? 0;

        $model = new Peminjaman();

        $model->setujuiPeminjaman(
            $id,
            $_SESSION['user']['id']
        );

        header("Location: index.php?url=peminjaman");
        exit;
    }


    public static function tolakPeminjaman()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        if ($_SESSION['user']['role'] !== 'petugas') {
            header("Location: index.php?url=dashboard");
            exit;
        }

        $id = $_GET['id'] ?? 0;

        $model = new Peminjaman();

        $model->tolakPeminjaman(
            $id,
            $_SESSION['user']['id']
        );

        header("Location: index.php?url=peminjaman");
        exit;
    }


    /*
     * MENU PENGEMBALIAN PEMINJAM
     */
    public static function pengembalian()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        if ($_SESSION['user']['role'] !== 'peminjam') {
            header("Location: index.php?url=dashboard");
            exit;
        }

        $model = new Peminjaman();

        /*
         * PENTING:
         * Ambil semua peminjaman milik user.
         * Jadi status disetujui akan muncul
         * dan tombol pengembalian bisa digunakan.
         */
        $peminjaman = $model->getByUser(
            $_SESSION['user']['id']
        );

        require_once __DIR__ . '/../views/pengembalian.php';
    }


    /*
     * PROSES AJUKAN PENGEMBALIAN
     */
    public static function prosesPengembalian()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        if ($_SESSION['user']['role'] !== 'peminjam') {
            header("Location: index.php?url=dashboard");
            exit;
        }

        /*
         * ID bisa berasal dari GET maupun POST.
         */
        $id = $_GET['id'] ?? $_POST['id'] ?? 0;

        if (!$id) {
            header(
                "Location: index.php?url=pengembalian&status=gagal"
            );
            exit;
        }

        $model = new Peminjaman();

        $hasil = $model->kembalikan(
            $id,
            $_SESSION['user']['id']
        );

        if ($hasil) {

            header(
                "Location: index.php?url=pengembalian&status=berhasil"
            );

        } else {

            header(
                "Location: index.php?url=pengembalian&status=gagal"
            );
        }

        exit;
    }


    /*
     * DATA PENGEMBALIAN UNTUK PETUGAS
     */
    public static function pengembalianPetugas()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        if ($_SESSION['user']['role'] !== 'petugas') {
            header("Location: index.php?url=dashboard");
            exit;
        }

        $model = new Peminjaman();

        $peminjaman = $model->getMenungguPengembalian();

        require_once __DIR__ . '/../views/pengembalian_petugas.php';
    }


    /*
     * PETUGAS MENERIMA PENGEMBALIAN
     */
    public static function setujuiPengembalian()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        if ($_SESSION['user']['role'] !== 'petugas') {
            header("Location: index.php?url=dashboard");
            exit;
        }

        $id = $_GET['id'] ?? 0;

        $model = new Peminjaman();

        $model->setujuiPengembalian(
            $id,
            $_SESSION['user']['id']
        );

        header(
            "Location: index.php?url=pengembalian-petugas"
        );

        exit;
    }


    /*
     * RIWAYAT PEMINJAMAN
     */
    public static function riwayat()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        if ($_SESSION['user']['role'] !== 'peminjam') {
            header("Location: index.php?url=dashboard");
            exit;
        }

        $model = new Peminjaman();

        $riwayat = $model->getByUser(
            $_SESSION['user']['id']
        );

        require_once __DIR__ . '/../views/riwayat.php';
    }


    /*
     * DENDA
     */
    public static function denda()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        if ($_SESSION['user']['role'] !== 'petugas') {
            header("Location: index.php?url=dashboard");
            exit;
        }

        $model = new Peminjaman();

        $denda = $model->getDataDenda();

        require_once __DIR__ . '/../views/denda.php';
    }
}
