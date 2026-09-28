<?php

class AuthController
{
    public function login()
    {
        if (isset($_SESSION['user'])) {
            header("Location: index.php?url=dashboard");
            exit;
        }

        require_once __DIR__ . '/../views/login.php';
    }

    public function prosesLogin()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $model = new User();

        $user = $model->login(
            $username,
            $password
        );

        if ($user) {

            $_SESSION['user'] = $user;

            header("Location: index.php?url=dashboard");
            exit;
        }

        header(
            "Location: index.php?url=login&status=gagal"
        );

        exit;
    }

    public function register()
    {
        require_once __DIR__ . '/../views/register.php';
    }

    public function prosesRegister()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $konfirmasi = $_POST['konfirmasi_password'] ?? '';
        $nama = $_POST['nama_lengkap'] ?? '';

        if (
            empty($username) ||
            empty($password) ||
            empty($nama)
        ) {
            header(
                "Location: index.php?url=register&status=gagal"
            );
            exit;
        }

        if ($password !== $konfirmasi) {
            header(
                "Location: index.php?url=register&status=password"
            );
            exit;
        }

        $model = new User();

        if (
            $model->register(
                $username,
                $password,
                $nama
            )
        ) {
            header(
                "Location: index.php?url=login&status=register"
            );
            exit;
        }

        header(
            "Location: index.php?url=register&status=gagal"
        );

        exit;
    }
}


class AlatController
{
    private function cekAdmin()
    {
        if (
            !isset($_SESSION['user']) ||
            $_SESSION['user']['role'] !== 'admin'
        ) {
            header("Location: index.php?url=dashboard");
            exit;
        }
    }

    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        $model = new Alat();

        $alat = $model->getAll();

        require_once __DIR__ . '/../views/alat.php';
    }

    public function tambah()
    {
        $this->cekAdmin();

        $kategoriModel = new Kategori();

        $kategori = $kategoriModel->getAll();

        require_once __DIR__ . '/../views/alat_tambah.php';
    }

    public function prosesTambah()
    {
        $this->cekAdmin();

        $nama = $_POST['nama_alat'] ?? '';
        $kategori = $_POST['kategori_id'] ?? '';
        $stok = $_POST['stok'] ?? 0;
        $kondisi = $_POST['kondisi'] ?? '';

        $model = new Alat();

        $model->tambah(
            $nama,
            $kategori,
            $stok,
            $kondisi
        );

        header(
            "Location: index.php?url=alat&status=berhasil"
        );

        exit;
    }

    public function edit()
    {
        $this->cekAdmin();

        $id = $_GET['id'] ?? 0;

        $model = new Alat();

        $alat = $model->getById($id);

        $kategoriModel = new Kategori();

        $kategori = $kategoriModel->getAll();

        require_once __DIR__ . '/../views/alat_edit.php';
    }

    public function prosesEdit()
    {
        $this->cekAdmin();

        $id = $_POST['id'] ?? 0;
        $nama = $_POST['nama_alat'] ?? '';
        $kategori = $_POST['kategori_id'] ?? '';
        $stok = $_POST['stok'] ?? 0;
        $kondisi = $_POST['kondisi'] ?? '';

        $model = new Alat();

        $model->edit(
            $id,
            $nama,
            $kategori,
            $stok,
            $kondisi
        );

        header(
            "Location: index.php?url=alat&status=berhasil"
        );

        exit;
    }

    public function hapus()
    {
        $this->cekAdmin();

        $id = $_GET['id'] ?? 0;

        $model = new Alat();

        $model->hapus($id);

        header(
            "Location: index.php?url=alat&status=berhasil"
        );

        exit;
    }
}


class UserController
{
    public static function peminjam()
    {
        if (
            !isset($_SESSION['user']) ||
            $_SESSION['user']['role'] !== 'admin'
        ) {
            header("Location: index.php?url=dashboard");
            exit;
        }

        $model = new User();

        $peminjam = $model->getPeminjam();

        require_once __DIR__ . '/../views/peminjam.php';
    }
}


class PeminjamanController
{
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        if (
            $_SESSION['user']['role'] !== 'petugas' &&
            $_SESSION['user']['role'] !== 'admin'
        ) {
            header("Location: index.php?url=dashboard");
            exit;
        }

        $model = new Peminjaman();

        $peminjaman = $model->getAll();

        require_once __DIR__ . '/../views/peminjaman.php';
    }

    public function pengajuan()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        $model = new Alat();

        $alat = $model->getAll();

        require_once __DIR__ . '/../views/pengajuan.php';
    }

    public function prosesTambah()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        $user_id = $_SESSION['user']['id'];

        $alat_id = $_POST['alat_id'] ?? 0;
        $jumlah = $_POST['jumlah'] ?? 0;
        $tanggal_pinjam = $_POST['tanggal_pinjam'] ?? date('Y-m-d');
        $tanggal_kembali = $_POST['tanggal_rencana_kembali'] ?? '';

        $model = new Peminjaman();

        $hasil = $model->tambah(
            $user_id,
            $alat_id,
            $jumlah,
            $tanggal_pinjam,
            $tanggal_kembali
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

    public function setujuiPeminjaman()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        $id = $_GET['id'] ?? 0;

        $model = new Peminjaman();

        $model->setujuiPeminjaman(
            $id,
            $_SESSION['user']['id']
        );

        header(
            "Location: index.php?url=peminjaman"
        );

        exit;
    }

    public function tolakPeminjaman()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        $id = $_GET['id'] ?? 0;

        $model = new Peminjaman();

        $model->tolakPeminjaman(
            $id,
            $_SESSION['user']['id']
        );

        header(
            "Location: index.php?url=peminjaman"
        );

        exit;
    }

    public function pengembalian()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        $model = new Peminjaman();

        $peminjaman = $model->getAktifByUser(
            $_SESSION['user']['id']
        );

        require_once __DIR__ . '/../views/pengembalian.php';
    }

    public function prosesPengembalian()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        $id = $_GET['id'] ?? $_POST['id'] ?? 0;

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

    public function pengembalianPetugas()
    {
        if (
            !isset($_SESSION['user']) ||
            $_SESSION['user']['role'] !== 'petugas'
        ) {
            header("Location: index.php?url=dashboard");
            exit;
        }

        $model = new Peminjaman();

        $peminjaman = $model->getMenungguPengembalian();

        require_once __DIR__ . '/../views/pengembalian_petugas.php';
    }

    public function setujuiPengembalian()
    {
        if (
            !isset($_SESSION['user']) ||
            $_SESSION['user']['role'] !== 'petugas'
        ) {
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

    public function riwayat()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            exit;
        }

        $model = new Peminjaman();

        $riwayat = $model->getByUser(
            $_SESSION['user']['id']
        );

        require_once __DIR__ . '/../views/riwayat.php';
    }

    public function denda()
    {
        if (
            !isset($_SESSION['user']) ||
            $_SESSION['user']['role'] !== 'petugas'
        ) {
            header("Location: index.php?url=dashboard");
            exit;
        }

        $model = new Peminjaman();

        $denda = $model->getDataDenda();

        require_once __DIR__ . '/../views/denda.php';
    }
}