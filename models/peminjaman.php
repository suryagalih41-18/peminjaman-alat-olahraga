<?php

class Peminjaman
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }


    // ==========================================
    // AMBIL SEMUA DATA PEMINJAMAN
    // ==========================================

    public function getAll()
    {
        $query = $this->db->prepare(
            "SELECT
                p.id,
                p.user_id,
                p.alat_id,
                p.jumlah,
                p.tanggal_pinjam,
                p.tanggal_rencana_kembali,
                p.status,
                p.disetujui_oleh,
                p.created_at,
                u.nama_lengkap,
                u.username,
                a.nama_alat
            FROM peminjaman p
            LEFT JOIN users u
                ON p.user_id = u.id
            LEFT JOIN alat a
                ON p.alat_id = a.id
            ORDER BY p.id DESC"
        );

        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    // ==========================================
    // RIWAYAT USER
    // ==========================================

    public function getByUser($user_id)
    {
        $query = $this->db->prepare(
            "SELECT
                p.id,
                p.user_id,
                p.alat_id,
                p.jumlah,
                p.tanggal_pinjam,
                p.tanggal_rencana_kembali,
                p.status,
                p.disetujui_oleh,
                p.created_at,
                a.nama_alat
            FROM peminjaman p
            LEFT JOIN alat a
                ON p.alat_id = a.id
            WHERE p.user_id = ?
            ORDER BY p.id DESC"
        );

        $query->execute([$user_id]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    // ==========================================
    // TAMBAH PEMINJAMAN
    // STOK BERKURANG
    // ==========================================

    public function tambah(
        $user_id,
        $alat_id,
        $jumlah,
        $tanggal_pinjam,
        $tanggal_rencana_kembali
    ) {
        try {

            $this->db->beginTransaction();

            // Cek stok
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

            // Stok tidak cukup
            if ((int)$alat['stok'] < (int)$jumlah) {
                $this->db->rollBack();
                return false;
            }

            // Kurangi stok
            $query = $this->db->prepare(
                "UPDATE alat
                 SET stok = stok - ?
                 WHERE id = ?"
            );

            $query->execute([
                $jumlah,
                $alat_id
            ]);

            // Simpan peminjaman
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

            $hasil = $query->execute([
                $user_id,
                $alat_id,
                $jumlah,
                $tanggal_pinjam,
                $tanggal_rencana_kembali
            ]);

            if (!$hasil) {
                $this->db->rollBack();
                return false;
            }

            $this->db->commit();

            return true;

        } catch (PDOException $e) {

            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            return false;
        }
    }


    // ==========================================
    // PEMINJAMAN AKTIF
    // ==========================================

    public function getAktifByUser($user_id)
    {
        $query = $this->db->prepare(
            "SELECT
                p.id,
                p.user_id,
                p.alat_id,
                p.jumlah,
                p.tanggal_pinjam,
                p.tanggal_rencana_kembali,
                p.status,
                a.nama_alat
            FROM peminjaman p
            LEFT JOIN alat a
                ON p.alat_id = a.id
            WHERE p.user_id = ?
            AND p.status != 'dikembalikan'
            ORDER BY p.id DESC"
        );

        $query->execute([$user_id]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    // ==========================================
    // PENGEMBALIAN
    // STOK BERTAMBAH
    // STATUS = DIKEMBALIKAN
    // ==========================================

    public function kembalikan($id, $user_id)
    {
        try {

            $this->db->beginTransaction();


            // Ambil data peminjaman
            $query = $this->db->prepare(
                "SELECT
                    id,
                    user_id,
                    alat_id,
                    jumlah,
                    status
                 FROM peminjaman
                 WHERE id = ?
                 AND user_id = ?
                 FOR UPDATE"
            );

            $query->execute([
                $id,
                $user_id
            ]);

            $peminjaman = $query->fetch(PDO::FETCH_ASSOC);


            // Tidak ditemukan
            if (!$peminjaman) {

                $this->db->rollBack();

                return false;
            }


            // Sudah dikembalikan
            if ($peminjaman['status'] === 'dikembalikan') {

                $this->db->rollBack();

                return false;
            }


            // Tambahkan stok kembali
            $query = $this->db->prepare(
                "UPDATE alat
                 SET stok = stok + ?
                 WHERE id = ?"
            );

            $query->execute([
                $peminjaman['jumlah'],
                $peminjaman['alat_id']
            ]);


            // Pastikan stok berhasil diubah
            if ($query->rowCount() === 0) {

                $this->db->rollBack();

                return false;
            }


            // Ubah status peminjaman
            $query = $this->db->prepare(
                "UPDATE peminjaman
                 SET status = 'dikembalikan'
                 WHERE id = ?
                 AND user_id = ?"
            );

            $query->execute([
                $id,
                $user_id
            ]);


            // Pastikan status berhasil diubah
            if ($query->rowCount() === 0) {

                $this->db->rollBack();

                return false;
            }


            $this->db->commit();

            return true;


        } catch (PDOException $e) {

            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            return false;
        }
    }
}