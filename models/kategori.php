<?php

class Kategori
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function getAll()
    {
        $query = $this->db->prepare(
            "SELECT * FROM kategori ORDER BY id ASC"
        );

        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $query = $this->db->prepare(
            "SELECT * FROM kategori WHERE id = ?"
        );

        $query->execute([$id]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }
}