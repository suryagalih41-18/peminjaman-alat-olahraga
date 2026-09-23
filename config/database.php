<?php

class Database
{
    private $host = "localhost";
    private $db = "db_peminjaman_olahraga";
    private $user = "root";
    private $pass = "";

    public function connect()
    {
        try {
            $conn = new PDO(
                "mysql:host=$this->host;dbname=$this->db",
                $this->user,
                $this->pass
            );

            $conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            return $conn;

        } catch (PDOException $e) {
            die("Koneksi gagal: " . $e->getMessage());
        }
    }
}