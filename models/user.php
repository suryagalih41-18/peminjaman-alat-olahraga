<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    // LOGIN
    public function login($username, $password)
    {
        $query = $this->db->prepare(
            "SELECT * FROM users WHERE username = ?"
        );

        $query->execute([$username]);

        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    // REGISTER
    public function register($username, $password, $nama_lengkap)
    {
        // Cek username sudah digunakan atau belum
        $query = $this->db->prepare(
            "SELECT * FROM users WHERE username = ?"
        );

        $query->execute([$username]);

        if ($query->fetch()) {
            return false;
        }

        // Hash password
        $passwordHash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        // Simpan user baru
        $query = $this->db->prepare(
            "INSERT INTO users 
            (username, password, nama_lengkap, role)
            VALUES (?, ?, ?, 'peminjam')"
        );

        return $query->execute([
            $username,
            $passwordHash,
            $nama_lengkap
        ]);
    }
}