
<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/alat.php';
require_once __DIR__ . '/../models/kategori.php';
require_once __DIR__ . '/../models/peminjaman.php';
require_once __DIR__ . '/../controllers/controller.php';
require_once __DIR__ . '/../controllers/revisi_controller.php';

$url = $_GET['url'] ?? 'login';

switch ($url) {
    // LOGIN DAN REGISTER
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

    case 'logout':
        try {
            if (isset($_SESSION['user']['id'])) {
                $db = (new Database())->connect();
                $stmt = $db->prepare(
                    'INSERT INTO log_aktivitas (user_id, aktivitas, waktu)
                     VALUES (?, ?, NOW())'
                );
                $stmt->execute([
                    $_SESSION['user']['id'],
                    'Logout dari sistem'
                ]);
            }
        } catch (Throwable $e) {
            error_log($e->getMessage());
        }

        $_SESSION = [];
        session_destroy();

        header('Location: index.php?url=login');
        exit;

    // DASHBOARD
    case 'dashboard':
        (new RevisiController())->dashboard();
        break;

    // DATA ALAT
    case 'alat':
        (new AlatController())->index();
        break;

    case 'tambah-alat':
        (new AlatController())->tambah();
        break;

    case 'proses-tambah-alat':
        (new AlatController())->simpan();
        break;

    case 'edit-alat':
        (new AlatController())->edit();
        break;

    case 'proses-edit-alat':
        (new AlatController())->update();
        break;

    case 'hapus-alat':
        (new AlatController())->hapus();
        break;

    // DATA PEMINJAM
    case 'peminjam':
        (new UserController())->index();
        break;

    // DATA PEMINJAMAN
    case 'peminjaman':
        (new PeminjamanController())->index();
        break;

    case 'pengajuan':
        (new PeminjamanController())->pengajuan();
        break;

    case 'proses-pengajuan':
        (new RevisiController())->prosesPengajuan();
        break;

    case 'persetujuan-peminjaman':
        (new RevisiController())->halamanPersetujuan();
        break;

    case 'setujui-peminjaman':
        (new RevisiController())->setujuiPeminjaman();
        break;

    case 'tolak-peminjaman':
        (new RevisiController())->tolakPeminjaman();
        break;

    // PENGEMBALIAN
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

    // RIWAYAT DAN DENDA
    case 'riwayat':
        (new PeminjamanController())->riwayat();
        break;

    case 'denda':
        (new PeminjamanController())->denda();
        break;

    // LAPORAN DAN LOG AKTIVITAS
    case 'laporan-peminjaman':
        (new RevisiController())->laporan();
        break;

    case 'log-aktivitas':
        (new RevisiController())->logAktivitas();
        break;

    default:
        if (isset($_SESSION['user'])) {
            header('Location: index.php?url=dashboard');
        } else {
            header('Location: index.php?url=login');
        }
        exit;
}
