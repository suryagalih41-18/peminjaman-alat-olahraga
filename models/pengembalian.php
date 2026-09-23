<?php

class Pengembalian
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }


    // ==============================
    // PEMINJAMAN YANG BISA DIKEMBALIKAN
    // ==============================

    public function getPeminjamanUser($user_id)
    {
        $query = $this->db->prepare(
            "SELECT
                p.id,
                p.jumlah,
                p.tanggal_pinjam,
                p.tanggal_rencana_kembali,
                p.status,
                a.nama_alat
             FROM peminjaman p
             INNER JOIN alat a
                ON p.alat_id = a.id
             WHERE p.user_id = ?
             AND p.status != 'dikembalikan'
             ORDER BY p.id DESC"
        );

        $query->execute([$user_id]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    // ==============================
    // SIMPAN DATA PENGEMBALIAN
    // ==============================

    public function proses(
        $peminjaman_id,
        $tanggal_dikembalikan,
        $kondisi_kembali,
        $terlambat,
        $denda,
        $keterangan,
        $diproses_oleh
    ) {

        $query = $this->db->prepare(
            "INSERT INTO pengembalian
            (
                peminjaman_id,
                tanggal_dikembalikan,
                kondisi_kembali,
                terlambat,
                denda,
                keterangan,
                diproses_oleh
            )
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        $berhasil = $query->execute([
            $peminjaman_id,
            $tanggal_dikembalikan,
            $kondisi_kembali,
            $terlambat,
            $denda,
            $keterangan,
            $diproses_oleh
        ]);


        // Jika berhasil, ubah status peminjaman
        if ($berhasil) {

            $update = $this->db->prepare(
                "UPDATE peminjaman
                 SET status = 'dikembalikan'
                 WHERE id = ?"
            );

            $update->execute([
                $peminjaman_id
            ]);
        }


        return $berhasil;
    }
}