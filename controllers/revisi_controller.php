
<?php

class RevisiController
{
    private function wajibLogin()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?url=login');
            exit;
        }
    }

    private function wajibPetugas()
    {
        $this->wajibLogin();

        if (($_SESSION['user']['role'] ?? '') !== 'petugas') {
            header('Location: index.php?url=dashboard');
            exit;
        }
    }

    private function wajibAdminPetugas()
    {
        $this->wajibLogin();

        $role = $_SESSION['user']['role'] ?? '';

        if (!in_array($role, ['admin', 'petugas'], true)) {
            header('Location: index.php?url=dashboard');
            exit;
        }
    }

    private function db()
    {
        return (new Database())->connect();
    }

    private function catat($aktivitas)
    {
        try {
            $db = $this->db();

            $stmt = $db->prepare(
                "INSERT INTO log_aktivitas
                    (user_id, aktivitas, waktu)
                 VALUES (?, ?, NOW())"
            );

            $stmt->execute([
                $_SESSION['user']['id'] ?? null,
                $aktivitas
            ]);
        } catch (Throwable $e) {
            error_log(
                'Gagal mencatat aktivitas: ' . $e->getMessage()
            );
        }
    }

    // DASHBOARD
    public function dashboard()
    {
        $this->wajibLogin();

        $role = $_SESSION['user']['role'] ?? '';

        $peminjaman = [];

        $totalJenisAlat = 0;
        $totalStokAlat = 0;
        $totalStokHabis = 0;

        if ($role === 'petugas') {
            $modelPeminjaman = new Peminjaman();
            $peminjaman = $modelPeminjaman->getAll();
        }

        if ($role === 'admin') {
            $modelAlat = new Alat();

            $totalJenisAlat = $modelAlat->getTotalJenis();
            $totalStokAlat = $modelAlat->getTotalStok();
            $totalStokHabis = $modelAlat->getTotalStokHabis();
        }

        require __DIR__ . '/../views/dashboard.php';
    }

    // HALAMAN PERSETUJUAN PEMINJAMAN
    public function halamanPersetujuan()
    {
        $this->wajibPetugas();

        $model = new Peminjaman();
        $peminjaman = $model->getAll();

        $active = 'persetujuan-peminjaman';
        $pageTitle = 'Persetujuan Peminjaman';

        require __DIR__ . '/../views/persetujuan_peminjaman.php';
    }

    // PROSES PENGAJUAN PEMINJAMAN OLEH PEMINJAM
    public function prosesPengajuan()
    {
        $this->wajibLogin();

        if (($_SESSION['user']['role'] ?? '') !== 'peminjam') {
            header('Location: index.php?url=dashboard');
            exit;
        }

        $userId = (int) ($_SESSION['user']['id'] ?? 0);
        $alatId = (int) ($_POST['alat_id'] ?? 0);
        $jumlah = (int) ($_POST['jumlah'] ?? 0);
        $tanggalPinjam = $_POST['tanggal_pinjam'] ?? '';
        $tanggalKembali = $_POST['tanggal_rencana_kembali'] ?? '';

        if (
            $userId < 1 ||
            $alatId < 1 ||
            $jumlah < 1 ||
            $tanggalPinjam === '' ||
            $tanggalKembali === '' ||
            $tanggalKembali < $tanggalPinjam
        ) {
            header('Location: index.php?url=pengajuan&status=gagal');
            exit;
        }

        try {
            $db = $this->db();

            $cek = $db->prepare(
                'SELECT id FROM alat WHERE id = ?'
            );

            $cek->execute([$alatId]);

            if (!$cek->fetch(PDO::FETCH_ASSOC)) {
                header('Location: index.php?url=pengajuan&status=gagal');
                exit;
            }

            $stmt = $db->prepare(
                "INSERT INTO peminjaman
                    (
                        user_id,
                        alat_id,
                        jumlah,
                        tanggal_pinjam,
                        tanggal_rencana_kembali,
                        status
                    )
                 VALUES (?, ?, ?, ?, ?, 'diajukan')"
            );

            $stmt->execute([
                $userId,
                $alatId,
                $jumlah,
                $tanggalPinjam,
                $tanggalKembali
            ]);

            $idPeminjaman = $db->lastInsertId();

            $this->catat(
                'Mengajukan peminjaman ID ' . $idPeminjaman
            );

            header(
                'Location: index.php?url=riwayat&status=berhasil'
            );
            exit;

        } catch (Throwable $e) {
            error_log(
                'Pengajuan gagal: ' . $e->getMessage()
            );

            header(
                'Location: index.php?url=pengajuan&status=gagal'
            );
            exit;
        }
    }

    // MENYETUJUI PEMINJAMAN
    public function setujuiPeminjaman()
    {
        $this->wajibPetugas();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header(
                'Location: index.php?url=persetujuan-peminjaman'
            );
            exit;
        }

        $id = (int) ($_POST['id'] ?? 0);

        if ($id < 1) {
            header(
                'Location: index.php?url=persetujuan-peminjaman&status=gagal'
            );
            exit;
        }

        $db = $this->db();

        try {
            $db->beginTransaction();

            $stmt = $db->prepare(
                "SELECT p.id, p.alat_id, p.jumlah, a.stok
                 FROM peminjaman p
                 JOIN alat a ON a.id = p.alat_id
                 WHERE p.id = ?
                   AND p.status = 'diajukan'
                 FOR UPDATE"
            );

            $stmt->execute([$id]);

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$data) {
                $db->rollBack();

                header(
                    'Location: index.php?url=persetujuan-peminjaman&status=gagal'
                );
                exit;
            }

            if ((int) $data['stok'] < (int) $data['jumlah']) {
                $db->rollBack();

                header(
                    'Location: index.php?url=persetujuan-peminjaman&status=stok'
                );
                exit;
            }

            $kurangi = $db->prepare(
                'UPDATE alat
                 SET stok = stok - ?
                 WHERE id = ? AND stok >= ?'
            );

            $kurangi->execute([
                (int) $data['jumlah'],
                (int) $data['alat_id'],
                (int) $data['jumlah']
            ]);

            if ($kurangi->rowCount() !== 1) {
                $db->rollBack();

                header(
                    'Location: index.php?url=persetujuan-peminjaman&status=stok'
                );
                exit;
            }

            $update = $db->prepare(
                "UPDATE peminjaman
                 SET status = 'disetujui',
                     disetujui_oleh = ?
                 WHERE id = ?
                   AND status = 'diajukan'"
            );

            $update->execute([
                $_SESSION['user']['id'],
                $id
            ]);

            if ($update->rowCount() !== 1) {
                $db->rollBack();

                header(
                    'Location: index.php?url=persetujuan-peminjaman&status=gagal'
                );
                exit;
            }

            $log = $db->prepare(
                'INSERT INTO log_aktivitas
                    (user_id, aktivitas, waktu)
                 VALUES (?, ?, NOW())'
            );

            $log->execute([
                $_SESSION['user']['id'],
                'Menyetujui peminjaman ID ' . $id
            ]);

            $db->commit();

            header(
                'Location: index.php?url=persetujuan-peminjaman&status=disetujui'
            );
            exit;

        } catch (Throwable $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }

            error_log(
                'Persetujuan gagal: ' . $e->getMessage()
            );

            header(
                'Location: index.php?url=persetujuan-peminjaman&status=gagal'
            );
            exit;
        }
    }

    // MENOLAK PEMINJAMAN
    public function tolakPeminjaman()
    {
        $this->wajibPetugas();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header(
                'Location: index.php?url=persetujuan-peminjaman'
            );
            exit;
        }

        $id = (int) ($_POST['id'] ?? 0);

        if ($id < 1) {
            header(
                'Location: index.php?url=persetujuan-peminjaman&status=gagal'
            );
            exit;
        }

        $db = $this->db();

        try {
            $db->beginTransaction();

            $stmt = $db->prepare(
                "UPDATE peminjaman
                 SET status = 'ditolak',
                     disetujui_oleh = ?
                 WHERE id = ?
                   AND status = 'diajukan'"
            );

            $stmt->execute([
                $_SESSION['user']['id'],
                $id
            ]);

            if ($stmt->rowCount() !== 1) {
                $db->rollBack();

                header(
                    'Location: index.php?url=persetujuan-peminjaman&status=gagal'
                );
                exit;
            }

            $log = $db->prepare(
                'INSERT INTO log_aktivitas
                    (user_id, aktivitas, waktu)
                 VALUES (?, ?, NOW())'
            );

            $log->execute([
                $_SESSION['user']['id'],
                'Menolak peminjaman ID ' . $id
            ]);

            $db->commit();

            header(
                'Location: index.php?url=persetujuan-peminjaman&status=ditolak'
            );
            exit;

        } catch (Throwable $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }

            error_log(
                'Penolakan gagal: ' . $e->getMessage()
            );

            header(
                'Location: index.php?url=persetujuan-peminjaman&status=gagal'
            );
            exit;
        }
    }

    // LAPORAN PEMINJAMAN
    public function laporan()
    {
        $this->wajibAdminPetugas();

        $model = new Peminjaman();
        $peminjaman = $model->getAll();

        $this->catat('Membuka laporan peminjaman');

        require __DIR__ . '/../views/laporan_peminjaman.php';
    }

    // LOG AKTIVITAS
  

public function logAktivitas()
{
    $this->wajibAdminPetugas();

    $active = 'log-aktivitas';
    $pageTitle = 'Log Aktivitas';

    try {
        $db = $this->db();

        $stmt = $db->query(
            "SELECT l.id, l.aktivitas, l.waktu,
                    u.nama_lengkap, u.username, u.role
             FROM log_aktivitas l
             LEFT JOIN users u ON u.id = l.user_id
             ORDER BY l.id DESC
             LIMIT 500"
        );

        $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/log_aktivitas.php';

    } catch (Throwable $e) {
        error_log('Log Aktivitas: ' . $e->getMessage());

        http_response_code(500);

        echo '<h2>Log Aktivitas gagal dimuat</h2>';
        echo '<p>Pesan error: ' .
            htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') .
            '</p>';
        echo '<p><a href="index.php?url=dashboard">Kembali ke Dashboard</a></p>';
    }
}


}
