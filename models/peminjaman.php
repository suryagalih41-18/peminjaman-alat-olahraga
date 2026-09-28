<?php

class Peminjaman
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function getAll()
    {
        $sql = "
            SELECT 
                p.*,
                u.nama_lengkap,
                u.username,
                a.nama_alat
            FROM peminjaman p
            LEFT JOIN users u ON p.user_id = u.id
            LEFT JOIN alat a ON p.alat_id = a.id
            ORDER BY p.id DESC
        ";

        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUser($user_id)
    {
        $sql = "
            SELECT 
                p.*,
                a.nama_alat
            FROM peminjaman p
            LEFT JOIN alat a ON p.alat_id = a.id
            WHERE p.user_id = ?
            ORDER BY p.id DESC
        ";

        $query = $this->db->prepare($sql);
        $query->execute([$user_id]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tambah(
        $user_id,
        $alat_id,
        $jumlah,
        $tanggal_pinjam,
        $tanggal_rencana_kembali
    ) {
        try {

            $this->db->beginTransaction();

            $query = $this->db->prepare(
                "SELECT stok
                 FROM alat
                 WHERE id = ?
                 FOR UPDATE"
            );

            $query->execute([$alat_id]);

            $alat = $query->fetch(PDO::FETCH_ASSOC);

            if (!$alat) {
                $this->db->rollBack();
                return false;
            }

            if ($alat['stok'] < $jumlah) {
                $this->db->rollBack();
                return false;
            }

            $query = $this->db->prepare(
                "UPDATE alat
                 SET stok = stok - ?
                 WHERE id = ?"
            );

            $query->execute([
                $jumlah,
                $alat_id
            ]);

            $query = $this->db->prepare(
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

            $query->execute([
                $user_id,
                $alat_id,
                $jumlah,
                $tanggal_pinjam,
                $tanggal_rencana_kembali
            ]);

            $this->db->commit();

            return true;

        } catch (Exception $e) {

            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            return false;
        }
    }

    public function setujuiPeminjaman($id, $petugas_id)
    {
        $query = $this->db->prepare(
            "UPDATE peminjaman
             SET status = 'disetujui',
                 disetujui_oleh = ?
             WHERE id = ?
             AND status = 'diajukan'"
        );

        return $query->execute([
            $petugas_id,
            $id
        ]);
    }

    public function tolakPeminjaman($id, $petugas_id)
    {
        try {

            $this->db->beginTransaction();

            $query = $this->db->prepare(
                "SELECT *
                 FROM peminjaman
                 WHERE id = ?
                 AND status = 'diajukan'
                 FOR UPDATE"
            );

            $query->execute([$id]);

            $peminjaman = $query->fetch(PDO::FETCH_ASSOC);

            if (!$peminjaman) {
                $this->db->rollBack();
                return false;
            }

            $query = $this->db->prepare(
                "UPDATE alat
                 SET stok = stok + ?
                 WHERE id = ?"
            );

            $query->execute([
                $peminjaman['jumlah'],
                $peminjaman['alat_id']
            ]);

            $query = $this->db->prepare(
                "UPDATE peminjaman
                 SET status = 'ditolak',
                     disetujui_oleh = ?
                 WHERE id = ?"
            );

            $query->execute([
                $petugas_id,
                $id
            ]);

            $this->db->commit();

            return true;

        } catch (Exception $e) {

            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            return false;
        }
    }

    public function getAktifByUser($user_id)
    {
        $sql = "
            SELECT
                p.*,
                a.nama_alat
            FROM peminjaman p
            LEFT JOIN alat a ON p.alat_id = a.id
            WHERE p.user_id = ?
            AND p.status IN (
                'disetujui',
                'menunggu_pengembalian'
            )
            ORDER BY p.id DESC
        ";

        $query = $this->db->prepare($sql);
        $query->execute([$user_id]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function kembalikan($id, $user_id)
    {
        $query = $this->db->prepare(
            "UPDATE peminjaman
             SET status = 'menunggu_pengembalian'
             WHERE id = ?
             AND user_id = ?
             AND status = 'disetujui'"
        );

        return $query->execute([
            $id,
            $user_id
        ]);
    }

    public function ajukanPengembalian($id)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']['id'])) {
            return false;
        }

        return $this->kembalikan(
            $id,
            $_SESSION['user']['id']
        );
    }

    public function getMenungguPengembalian()
    {
        $sql = "
            SELECT
                p.*,
                u.nama_lengkap,
                u.username,
                a.nama_alat
            FROM peminjaman p
            LEFT JOIN users u ON p.user_id = u.id
            LEFT JOIN alat a ON p.alat_id = a.id
            WHERE p.status = 'menunggu_pengembalian'
            ORDER BY p.id DESC
        ";

        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function setujuiPengembalian($id, $petugas_id)
    {
        try {

            $this->db->beginTransaction();

            $query = $this->db->prepare(
                "SELECT *
                 FROM peminjaman
                 WHERE id = ?
                 AND status = 'menunggu_pengembalian'
                 FOR UPDATE"
            );

            $query->execute([$id]);

            $peminjaman = $query->fetch(PDO::FETCH_ASSOC);

            if (!$peminjaman) {
                $this->db->rollBack();
                return false;
            }

            $query = $this->db->prepare(
                "UPDATE alat
                 SET stok = stok + ?
                 WHERE id = ?"
            );

            $query->execute([
                $peminjaman['jumlah'],
                $peminjaman['alat_id']
            ]);

            $query = $this->db->prepare(
                "UPDATE peminjaman
                 SET status = 'dikembalikan',
                     disetujui_oleh = ?
                 WHERE id = ?"
            );

            $query->execute([
                $petugas_id,
                $id
            ]);

            $this->db->commit();

            return true;

        } catch (Exception $e) {

            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            return false;
        }
    }

    public function getDataDenda()
    {
        $data = $this->getAll();

        $hasil = [];

        $hariIni = new DateTime();

        foreach ($data as $row) {

            if (empty($row['tanggal_rencana_kembali'])) {
                continue;
            }

            if ($row['status'] === 'dikembalikan') {
                continue;
            }

            $tanggalKembali = new DateTime(
                $row['tanggal_rencana_kembali']
            );

            if ($hariIni > $tanggalKembali) {

                $selisih = $tanggalKembali->diff($hariIni);

                $hariTerlambat = $selisih->days;

                $row['hari_terlambat'] = $hariTerlambat;
                $row['denda'] = $hariTerlambat * 5000;

                $hasil[] = $row;
            }
        }

        return $hasil;
    }
}