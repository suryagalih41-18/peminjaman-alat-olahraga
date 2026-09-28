<?php

class Alat
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    // Menampilkan semua data alat
    public function getAll()
    {
        $query = $this->db->prepare("
            SELECT
                alat.*,
                kategori.nama_kategori
            FROM alat
            LEFT JOIN kategori
                ON alat.kategori_id = kategori.id
            ORDER BY alat.id DESC
        ");

        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil satu data alat
    public function getById($id)
    {
        $query = $this->db->prepare("
            SELECT *
            FROM alat
            WHERE id = ?
        ");

        $query->execute([$id]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Menghitung total alat
    public function getTotal()
    {
        $query = $this->db->prepare("
            SELECT COUNT(*) AS total
            FROM alat
        ");

        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);

        return $data['total'] ?? 0;
    }

    // Tambah alat
    public function tambah(
        $nama_alat,
        $kategori_id,
        $stok,
        $kondisi
    ) {
        $query = $this->db->prepare("
            INSERT INTO alat
            (
                nama_alat,
                kategori_id,
                stok,
                kondisi
            )
            VALUES (?, ?, ?, ?)
        ");

        return $query->execute([
            $nama_alat,
            $kategori_id,
            $stok,
            $kondisi
        ]);
    }

    // Edit alat
    public function update(
        $id,
        $nama_alat,
        $kategori_id,
        $stok,
        $kondisi
    ) {
        $query = $this->db->prepare("
            UPDATE alat
            SET
                nama_alat = ?,
                kategori_id = ?,
                stok = ?,
                kondisi = ?
            WHERE id = ?
        ");

        return $query->execute([
            $nama_alat,
            $kategori_id,
            $stok,
            $kondisi,
            $id
        ]);
    }

    // Hapus alat
    public function hapus($id)
    {
        $query = $this->db->prepare("
            DELETE FROM alat
            WHERE id = ?
        ");

        return $query->execute([$id]);
    }
}