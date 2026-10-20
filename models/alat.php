
<?php

class Alat
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    /*
    |--------------------------------------------------------------------------
    | MENGAMBIL SEMUA DATA ALAT
    |--------------------------------------------------------------------------
    */
    public function getAll()
    {
        $sql = "SELECT
                    alat.*,
                    kategori.nama_kategori
                FROM alat
                LEFT JOIN kategori
                    ON alat.kategori_id = kategori.id
                ORDER BY alat.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | MENGAMBIL DATA ALAT BERDASARKAN ID
    |--------------------------------------------------------------------------
    */
    public function getById($id)
    {
        $sql = "SELECT *
                FROM alat
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([(int) $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | MENGHITUNG JUMLAH JENIS ALAT
    |--------------------------------------------------------------------------
    */
    public function getTotalJenis()
    {
        $sql = "SELECT COUNT(*) FROM alat";

        $stmt = $this->db->query($sql);

        return (int) $stmt->fetchColumn();
    }

    /*
    |--------------------------------------------------------------------------
    | MENGHITUNG TOTAL STOK SEMUA ALAT
    |--------------------------------------------------------------------------
    */
    public function getTotalStok()
    {
        $sql = "SELECT COALESCE(SUM(stok), 0) FROM alat";

        $stmt = $this->db->query($sql);

        return (int) $stmt->fetchColumn();
    }

    /*
    |--------------------------------------------------------------------------
    | MENGHITUNG JENIS ALAT YANG STOKNYA HABIS
    |--------------------------------------------------------------------------
    */
    public function getTotalStokHabis()
    {
        $sql = "SELECT COUNT(*)
                FROM alat
                WHERE stok <= 0";

        $stmt = $this->db->query($sql);

        return (int) $stmt->fetchColumn();
    }

    /*
    |--------------------------------------------------------------------------
    | MENGAMBIL TOTAL ALAT (KOMPATIBILITAS DENGAN KODE LAMA)
    |--------------------------------------------------------------------------
    */
    public function getTotal()
    {
        return $this->getTotalJenis();
    }

    /*
    |--------------------------------------------------------------------------
    | MEMERIKSA NAMA ALAT DUPLIKAT
    |--------------------------------------------------------------------------
    */
    public function namaSudahAda($nama_alat, $id = 0)
    {
        $sql = "SELECT COUNT(*)
                FROM alat
                WHERE LOWER(TRIM(nama_alat)) = LOWER(TRIM(?))";

        $params = [trim($nama_alat)];

        if ((int) $id > 0) {
            $sql .= " AND id != ?";
            $params[] = (int) $id;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (int) $stmt->fetchColumn() > 0;
    }

    /*
    |--------------------------------------------------------------------------
    | MENAMBAH ALAT
    |--------------------------------------------------------------------------
    */
    public function tambah(
        $nama_alat,
        $kategori_id,
        $stok,
        $kondisi
    ) {
        $nama_alat = trim($nama_alat);
        $kategori_id = (int) $kategori_id;
        $stok = (int) $stok;
        $kondisi = trim($kondisi);

        if (
            $nama_alat === '' ||
            $kategori_id <= 0 ||
            $stok < 0 ||
            $kondisi === ''
        ) {
            return false;
        }

        if ($this->namaSudahAda($nama_alat)) {
            return false;
        }

        $sql = "INSERT INTO alat
                    (nama_alat, kategori_id, stok, kondisi)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $nama_alat,
            $kategori_id,
            $stok,
            $kondisi
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT ALAT
    |--------------------------------------------------------------------------
    */
    public function edit(
        $id,
        $nama_alat,
        $kategori_id,
        $stok,
        $kondisi
    ) {
        return $this->update(
            $id,
            $nama_alat,
            $kategori_id,
            $stok,
            $kondisi
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MEMPERBARUI DATA ALAT
    |--------------------------------------------------------------------------
    */
    public function update(
        $id,
        $nama_alat,
        $kategori_id,
        $stok,
        $kondisi
    ) {
        $id = (int) $id;
        $nama_alat = trim($nama_alat);
        $kategori_id = (int) $kategori_id;
        $stok = (int) $stok;
        $kondisi = trim($kondisi);

        if (
            $id <= 0 ||
            $nama_alat === '' ||
            $kategori_id <= 0 ||
            $stok < 0 ||
            $kondisi === ''
        ) {
            return false;
        }

        if ($this->namaSudahAda($nama_alat, $id)) {
            return false;
        }

        $sql = "UPDATE alat
                SET nama_alat = ?,
                    kategori_id = ?,
                    stok = ?,
                    kondisi = ?
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $nama_alat,
            $kategori_id,
            $stok,
            $kondisi,
            $id
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | MENGHAPUS ALAT
    |--------------------------------------------------------------------------
    */
    public function hapus($id)
    {
        $id = (int) $id;

        if ($id <= 0) {
            return false;
        }

        try {
            // Cegah penghapusan alat yang memiliki riwayat peminjaman.
            $cek = $this->db->prepare(
                "SELECT COUNT(*)
                 FROM peminjaman
                 WHERE alat_id = ?"
            );

            $cek->execute([$id]);

            if ((int) $cek->fetchColumn() > 0) {
                return false;
            }

            $stmt = $this->db->prepare(
                "DELETE FROM alat WHERE id = ?"
            );

            $stmt->execute([$id]);

            return $stmt->rowCount() > 0;

        } catch (PDOException $e) {
            error_log($e->getMessage());

            return false;
        }
    }
}
