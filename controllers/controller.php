
<?php

/*
|--------------------------------------------------------------------------
| AUTH CONTROLLER
|--------------------------------------------------------------------------
*/

class AuthController
{
    public function login()
    {
        if (isset($_SESSION['user'])) {
            header('Location: index.php?url=dashboard');
            exit;
        }

        require __DIR__ . '/../views/login.php';
    }

    public function prosesLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?url=login');
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $model = new User();
        $hasil = $model->login($username, $password);

        if (!$hasil) {
            header('Location: index.php?url=login&status=gagal');
            exit;
        }

        $_SESSION['user'] = $hasil;

        $this->catatAktivitas(
            (int) $hasil['id'],
            'Login ke sistem'
        );

        header('Location: index.php?url=dashboard');
        exit;
    }

    public function register()
    {
        if (isset($_SESSION['user'])) {
            header('Location: index.php?url=dashboard');
            exit;
        }

        require __DIR__ . '/../views/register.php';
    }

    public function prosesRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?url=register');
            exit;
        }

        $nama = trim($_POST['nama_lengkap'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $konfirmasi = $_POST['konfirmasi_password'] ?? '';

        if (
            $nama === '' ||
            $username === '' ||
            $password === '' ||
            $konfirmasi === ''
        ) {
            header('Location: index.php?url=register&status=kosong');
            exit;
        }

        if ($password !== $konfirmasi) {
            header('Location: index.php?url=register&status=password');
            exit;
        }

        $model = new User();
        $hasil = $model->register($username, $password, $nama);

        if ($hasil) {
            header('Location: index.php?url=login&status=register-berhasil');
        } else {
            header('Location: index.php?url=register&status=gagal');
        }

        exit;
    }

    public function logout()
    {
        if (isset($_SESSION['user']['id'])) {
            $this->catatAktivitas(
                (int) $_SESSION['user']['id'],
                'Logout dari sistem'
            );
        }

        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();

        header('Location: index.php?url=login');
        exit;
    }

    private function catatAktivitas($userId, $aktivitas)
    {
        try {
            $db = (new Database())->connect();

            $stmt = $db->prepare(
                'INSERT INTO log_aktivitas (user_id, aktivitas, waktu)
                 VALUES (?, ?, NOW())'
            );

            $stmt->execute([$userId, $aktivitas]);
        } catch (Throwable $e) {
            error_log($e->getMessage());
        }
    }
}


/*
|--------------------------------------------------------------------------
| ALAT CONTROLLER
|--------------------------------------------------------------------------
*/

class AlatController
{
    private function cekRole($roles)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?url=login');
            exit;
        }

        $role = $_SESSION['user']['role'] ?? '';

        if (!in_array($role, $roles, true)) {
            header('Location: index.php?url=dashboard');
            exit;
        }
    }

    public function index()
    {
        $this->cekRole(['admin', 'petugas', 'peminjam']);

        $model = new Alat();
        $dataAlat = $model->getAll();

        $active = 'alat';
        $pageTitle = 'Daftar Alat';

        require __DIR__ . '/../views/alat.php';
    }

    public function tambah()
    {
        $this->cekRole(['admin']);

        $dataKategori = (new Kategori())->getAll();

        $active = 'alat';
        $pageTitle = 'Tambah Alat';

        // Nama file sesuai proyek yang sudah dibuat.
        require __DIR__ . '/../views/alat_tambah.php';
    }

    
public function simpan()
{
    $this->cekRole(['admin']);

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: index.php?url=alat');
        exit;
    }

    $nama = trim($_POST['nama_alat'] ?? '');
    $kategoriId = (int) ($_POST['kategori_id'] ?? 0);
    $stok = filter_var($_POST['stok'] ?? null, FILTER_VALIDATE_INT);
    $kondisi = trim($_POST['kondisi'] ?? '');

    if (
        $nama === '' ||
        $kategoriId <= 0 ||
        $stok === false ||
        $stok === null ||
        $stok < 0 ||
        $kondisi === ''
    ) {
        header('Location: index.php?url=tambah-alat&status=gagal');
        exit;
    }

    try {
        $model = new Alat();

        if ($model->namaSudahAda($nama)) {
            header('Location: index.php?url=tambah-alat&status=duplikat');
            exit;
        }

        $hasil = $model->tambah($nama, $kategoriId, $stok, $kondisi);

        if ($hasil) {
            header('Location: index.php?url=alat&status=berhasil');
        } else {
            header('Location: index.php?url=tambah-alat&status=gagal');
        }
    } catch (Throwable $e) {
        error_log($e->getMessage());
        header('Location: index.php?url=tambah-alat&status=gagal');
    }

    exit;
}


    // Alias agar route lama tetap dapat digunakan.
    public function prosesTambah()
    {
        $this->simpan();
    }

   
public function edit()
{
    if (!isset($_SESSION['user'])) {
        header('Location: index.php?url=login');
        exit;
    }

    if (($_SESSION['user']['role'] ?? '') !== 'admin') {
        header('Location: index.php?url=alat');
        exit;
    }

    $id = (int) ($_GET['id'] ?? 0);

    if ($id < 1) {
        header('Location: index.php?url=alat&status=gagal');
        exit;
    }

    $model = new Alat();
    $alat = $model->getById($id);

    if (!$alat) {
        header('Location: index.php?url=alat&status=gagal');
        exit;
    }
    $kategoriModel = new Kategori();
    $kategori = $kategoriModel->getAll();

    $active = 'alat';
    $pageTitle = 'Edit Alat';

    require __DIR__ . '/../views/alat_edit.php';
}


    public function update()
    {
        $this->cekRole(['admin']);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?url=alat');
            exit;
        }

        $id = (int) ($_POST['id'] ?? 0);
        $nama = trim($_POST['nama_alat'] ?? '');
        $kategoriId = (int) ($_POST['kategori_id'] ?? 0);
        $stok = filter_var($_POST['stok'] ?? null, FILTER_VALIDATE_INT);
        $kondisi = trim($_POST['kondisi'] ?? '');

        if (
            $id <= 0 ||
            $nama === '' ||
            $kategoriId <= 0 ||
            $stok === false ||
            $stok === null ||
            $stok < 0 ||
            $kondisi === ''
        ) {
            header('Location: index.php?url=alat&status=gagal');
            exit;
        }

        try {
            $hasil = (new Alat())->edit(
                $id,
                $nama,
                $kategoriId,
                $stok,
                $kondisi
            );
        } catch (Throwable $e) {
            error_log($e->getMessage());
            $hasil = false;
        }

        header(
            'Location: index.php?url=alat&status=' .
            ($hasil ? 'berhasil-edit' : 'gagal')
        );
        exit;
    }

    // Alias agar route lama tetap dapat digunakan.
    public function prosesEdit()
    {
        $this->update();
    }

    public function hapus()
    {
        $this->cekRole(['admin']);

        $id = (int) ($_POST['id'] ?? $_GET['id'] ?? 0);

        if ($id <= 0) {
            header('Location: index.php?url=alat&status=gagal');
            exit;
        }

        try {
            $hasil = (new Alat())->hapus($id);
        } catch (Throwable $e) {
            error_log($e->getMessage());
            $hasil = false;
        }

        header(
            'Location: index.php?url=alat&status=' .
            ($hasil ? 'berhasil-hapus' : 'alat_dipinjam')
        );
        exit;
    }
}


/*
|--------------------------------------------------------------------------
| USER CONTROLLER
|--------------------------------------------------------------------------
*/

class UserController
{
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?url=login');
            exit;
        }

        if (($_SESSION['user']['role'] ?? '') !== 'admin') {
            header('Location: index.php?url=dashboard');
            exit;
        }

        $model = new User();

        // Menggunakan method yang tersedia di models/user.php.
        $dataPeminjam = $model->getPeminjam();

        // Alias untuk menyesuaikan kemungkinan nama variabel di view.
        $peminjam = $dataPeminjam;
        $users = $dataPeminjam;
        $dataUser = $dataPeminjam;

        $active = 'peminjam';
        $pageTitle = 'Data Peminjam';

        require __DIR__ . '/../views/peminjam.php';
    }

    public static function peminjam()
    {
        (new self())->index();
    }
}


/*
|--------------------------------------------------------------------------
| PEMINJAMAN CONTROLLER
|--------------------------------------------------------------------------
*/

class PeminjamanController
{
    private function cekRole($roles)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?url=login');
            exit;
        }

        $role = $_SESSION['user']['role'] ?? '';

        if (!in_array($role, $roles, true)) {
            header('Location: index.php?url=dashboard');
            exit;
        }
    }

    public function index()
    {
        $this->cekRole(['admin', 'petugas']);

        $dataPeminjaman = (new Peminjaman())->getAll();
        $peminjaman = $dataPeminjaman;

        $active = 'peminjaman';
        $pageTitle = 'Data Peminjaman';

        require __DIR__ . '/../views/peminjaman.php';
    }

    public function pengajuan()
    {
        $this->cekRole(['peminjam']);

        $dataAlat = (new Alat())->getAll();
        $alat = $dataAlat;

        $active = 'pengajuan';
        $pageTitle = 'Ajukan Peminjaman';

        require __DIR__ . '/../views/pengajuan.php';
    }

    public function prosesTambah()
    {
        // Gunakan alur pengajuan yang sudah menangani status "diajukan".
        (new RevisiController())->prosesPengajuan();
    }

    public function setujuiPeminjaman()
    {
        (new RevisiController())->setujuiPeminjaman();
    }

    public function tolakPeminjaman()
    {
        (new RevisiController())->tolakPeminjaman();
    }

    public function pengembalian()
    {
        $this->cekRole(['peminjam']);

        $model = new Peminjaman();

        $dataPeminjaman = $model->getAktifByUser(
            (int) $_SESSION['user']['id']
        );

        $peminjaman = $dataPeminjaman;

        $active = 'pengembalian';
        $pageTitle = 'Pengembalian Alat';

        require __DIR__ . '/../views/pengembalian.php';
    }

    public function prosesPengembalian()
    {
        $this->cekRole(['peminjam']);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?url=pengembalian');
            exit;
        }

        $id = (int) (
            $_POST['id'] ??
            $_POST['peminjaman_id'] ??
            0
        );

        if ($id <= 0) {
            header('Location: index.php?url=pengembalian&status=gagal');
            exit;
        }

        $userId = (int) $_SESSION['user']['id'];

        try {
            $hasil = (new Peminjaman())->kembalikan($id, $userId);
        } catch (Throwable $e) {
            error_log($e->getMessage());
            $hasil = false;
        }

        header(
            'Location: index.php?url=pengembalian&status=' .
            ($hasil ? 'berhasil' : 'gagal')
        );
        exit;
    }

    public function pengembalianPetugas()
    {
        $this->cekRole(['admin', 'petugas']);

        $dataPengembalian = (new Peminjaman())->getMenungguPengembalian();
        $peminjaman = $dataPengembalian;

        $active = 'pengembalian-petugas';
        $pageTitle = 'Data Pengembalian';

        require __DIR__ . '/../views/pengembalian_petugas.php';
    }

    public function setujuiPengembalian()
    {
        $this->cekRole(['admin', 'petugas']);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?url=pengembalian-petugas');
            exit;
        }

        $id = (int) (
            $_POST['id'] ??
            $_POST['peminjaman_id'] ??
            0
        );

        if ($id <= 0) {
            header('Location: index.php?url=pengembalian-petugas&status=gagal');
            exit;
        }

        $petugasId = (int) $_SESSION['user']['id'];

        try {
            $hasil = (new Peminjaman())->setujuiPengembalian(
                $id,
                $petugasId
            );
        } catch (Throwable $e) {
            error_log($e->getMessage());
            $hasil = false;
        }

        header(
            'Location: index.php?url=pengembalian-petugas&status=' .
            ($hasil ? 'berhasil' : 'gagal')
        );
        exit;
    }

    public function riwayat()
{
    $this->cekRole(['peminjam']);

    $riwayat = (new Peminjaman())->getByUser(
        (int) $_SESSION['user']['id']
    );

    $active = 'riwayat';
    $pageTitle = 'Riwayat Peminjaman';

    require __DIR__ . '/../views/riwayat.php';
}
    public function denda()
    {
        $this->cekRole(['admin', 'petugas']);

        $dataDenda = (new Peminjaman())->getDataDenda();
        $denda = $dataDenda;

        $active = 'denda';
        $pageTitle = 'Data Denda';

        require __DIR__ . '/../views/denda.php';
    }
}
