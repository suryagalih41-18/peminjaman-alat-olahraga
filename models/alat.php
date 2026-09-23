<?php

class Alat
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    // =========================
    // MENAMPILKAN SEMUA ALAT
    // =========================

    public function getAll()
    {
        $query = $this->db->prepare(
            "SELECT * FROM alat ORDER BY id ASC"
        );

        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    // =========================
    // TAMBAH ALAT
    // =========================

    public function tambah(
        $nama_alat,
        $kategori_id,
        $stok,
        $kondisi
    ) {
        $query = $this->db->prepare(
            "INSERT INTO alat
            (nama_alat, kategori_id, stok, kondisi)
            VALUES (?, ?, ?, ?)"
        );

        return $query->execute([
            $nama_alat,
            $kategori_id,
            $stok,
            $kondisi
        ]);
    }


    // =========================
    // EDIT ALAT
    // =========================

    public function update(
        $id,
        $nama_alat,
        $kategori_id,
        $stok,
        $kondisi
    ) {
        $query = $this->db->prepare(
            "UPDATE alat
            SET nama_alat = ?,
                kategori_id = ?,
                stok = ?,
                kondisi = ?
            WHERE id = ?"
        );

        return $query->execute([
            $nama_alat,
            $kategori_id,
            $stok,
            $kondisi,
            $id
        ]);
    }


    // =========================
    // HAPUS ALAT
    // =========================

    public function delete($id)
    {
        try {

            $query = $this->db->prepare(
                "DELETE FROM alat WHERE id = ?"
            );

            return $query->execute([$id]);

        } catch (PDOException $e) {

            // Jika alat sudah digunakan di tabel peminjaman
            if ($e->getCode() == "23000") {

                return false;
            }

            throw $e;
        }
    }
}