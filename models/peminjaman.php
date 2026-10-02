<?php

class Peminjaman
{
    private $db;


    public function __construct()
    {
        $this->db = (new Database())->connect();
    }


    /*
     * MENGAMBIL SEMUA DATA PEMINJAMAN
     */
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


    /*
     * MENGAMBIL DATA PEMINJAMAN BERDASARKAN USER
     */
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

        $query->execute([
            $user_id
        ]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    /*
     * MENAMBAH PEMINJAMAN
     *
     * Status langsung menjadi:
     * disetujui
     *
     * Jadi peminjam langsung dapat
     * menggunakan alat dan dapat
     * mengajukan pengembalian.
     */
    public function tambah(
        $user_id,
        $alat_id,
        $jumlah,
        $tanggal_pinjam,
        $tanggal_rencana_kembali
    ) {
        try {

            $this->db->beginTransaction();


            /*
             * Cek stok alat
             */
            $query = $this->db->prepare(
                "SELECT stok
                 FROM alat
                 WHERE id = ?
                 FOR UPDATE"
            );

            $query->execute([
                $alat_id
            ]);

            $alat = $query->fetch(PDO::FETCH_ASSOC);


            /*
             * Alat tidak ditemukan
             */
            if (!$alat) {

                $this->db->rollBack();

                return false;
            }


            /*
             * Stok tidak cukup
             */
            if ($alat['stok'] < $jumlah) {

                $this->db->rollBack();

                return false;
            }


            /*
             * Kurangi stok ketika peminjaman dibuat.
             */
            $query = $this->db->prepare(
                "UPDATE alat
                 SET stok = stok - ?
                 WHERE id = ?"
            );

            $query->execute([
                $jumlah,
                $alat_id
            ]);


            /*
             * Masukkan peminjaman.
             *
             * STATUS LANGSUNG DISETUJUI
             */
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
                VALUES (?, ?, ?, ?, ?, 'disetujui')"
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


    /*
     * MENYETUJUI PEMINJAMAN
     *
     * Method ini tetap dipertahankan
     * untuk menjaga controller yang sudah ada.
     */
    public function setujuiPeminjaman(
        $id,
        $petugas_id
    ) {
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


    /*
     * MENOLAK PEMINJAMAN
     *
     * Jika masih ada data lama dengan status
     * diajukan, method ini tetap bisa digunakan.
     */
    public function tolakPeminjaman(
        $id,
        $petugas_id
    ) {
        try {

            $this->db->beginTransaction();


            /*
             * Ambil peminjaman yang masih diajukan.
             */
            $query = $this->db->prepare(
                "SELECT *
                 FROM peminjaman
                 WHERE id = ?
                 AND status = 'diajukan'
                 FOR UPDATE"
            );

            $query->execute([
                $id
            ]);

            $peminjaman = $query->fetch(PDO::FETCH_ASSOC);


            /*
             * Data tidak ditemukan.
             */
            if (!$peminjaman) {

                $this->db->rollBack();

                return false;
            }


            /*
             * Jika ditolak,
             * stok dikembalikan.
             */
            $query = $this->db->prepare(
                "UPDATE alat
                 SET stok = stok + ?
                 WHERE id = ?"
            );

            $query->execute([
                $peminjaman['jumlah'],
                $peminjaman['alat_id']
            ]);


            /*
             * Ubah status menjadi ditolak.
             */
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


    /*
     * MENGAJUKAN PENGEMBALIAN
     */
    public function kembalikan(
        $id,
        $user_id
    ) {
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


    /*
     * METHOD TAMBAHAN UNTUK PENGEMBALIAN
     */
    public function ajukanPengembalian($id)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        if (!isset($_SESSION['user']['id'])) {
            return false;
        }


        $user_id = $_SESSION['user']['id'];


        return $this->kembalikan(
            $id,
            $user_id
        );
    }


    /*
     * DATA YANG MENUNGGU DITERIMA PETUGAS
     */
    public function getMenungguPengembalian()
    {
        $sql = "
            SELECT
                p.*,
                u.nama_lengkap,
                u.username,
                a.nama_alat
            FROM peminjaman p
            LEFT JOIN users u
                ON p.user_id = u.id
            LEFT JOIN alat a
                ON p.alat_id = a.id
            WHERE p.status = 'menunggu_pengembalian'
            ORDER BY p.id DESC
        ";


        $query = $this->db->prepare($sql);

        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    /*
     * PETUGAS MENERIMA PENGEMBALIAN
     */
    public function setujuiPengembalian(
        $id,
        $petugas_id
    ) {
        try {

            $this->db->beginTransaction();


            /*
             * Ambil data yang sedang menunggu
             * pengembalian.
             */
            $query = $this->db->prepare(
                "SELECT *
                 FROM peminjaman
                 WHERE id = ?
                 AND status = 'menunggu_pengembalian'
                 FOR UPDATE"
            );


            $query->execute([
                $id
            ]);


            $peminjaman =
                $query->fetch(PDO::FETCH_ASSOC);


            /*
             * Data tidak ditemukan.
             */
            if (!$peminjaman) {

                $this->db->rollBack();

                return false;
            }


            /*
             * Kembalikan stok alat.
             */
            $query = $this->db->prepare(
                "UPDATE alat
                 SET stok = stok + ?
                 WHERE id = ?"
            );


            $query->execute([
                $peminjaman['jumlah'],
                $peminjaman['alat_id']
            ]);


            /*
             * Ubah status menjadi dikembalikan.
             */
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


    /*
     * DATA PEMINJAMAN AKTIF
     */
    public function getAktifByUser($user_id)
    {
        $sql = "
            SELECT
                p.*,
                a.nama_alat
            FROM peminjaman p
            LEFT JOIN alat a
                ON p.alat_id = a.id
            WHERE p.user_id = ?
            AND p.status IN (
                'disetujui',
                'menunggu_pengembalian'
            )
            ORDER BY p.id DESC
        ";


        $query = $this->db->prepare($sql);

        $query->execute([
            $user_id
        ]);


        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    /*
     * DATA DENDA
     */
    public function getDataDenda()
    {
        $data = $this->getAll();

        $hasil = [];

        $hariIni = new DateTime();


        foreach ($data as $row) {

            /*
             * Tidak ada tanggal kembali.
             */
            if (
                empty(
                    $row['tanggal_rencana_kembali']
                )
            ) {
                continue;
            }


            /*
             * Jika sudah dikembalikan,
             * tidak dihitung sebagai denda.
             */
            if (
                $row['status'] === 'dikembalikan'
            ) {
                continue;
            }


            $tanggalKembali =
                new DateTime(
                    $row['tanggal_rencana_kembali']
                );


            /*
             * Cek keterlambatan.
             */
            if ($hariIni > $tanggalKembali) {

                $selisih =
                    $tanggalKembali->diff(
                        $hariIni
                    );


                $hariTerlambat =
                    $selisih->days;


                $denda =
                    $hariTerlambat * 5000;


                $row['hari_terlambat'] =
                    $hariTerlambat;


                $row['denda'] =
                    $denda;


                $hasil[] = $row;
            }
        }


        return $hasil;
    }
}