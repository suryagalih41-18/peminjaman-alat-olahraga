<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function login($username, $password)
    {
        $query = $this->db->prepare(
            "SELECT * FROM users WHERE username = ? LIMIT 1"
        );

        $query->execute([$username]);

        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    public function register(
        $username,
        $password,
        $nama_lengkap
    ) {
        $cek = $this->db->prepare(
            "SELECT id FROM users WHERE username = ?"
        );

        $cek->execute([$username]);

        if ($cek->fetch()) {
            return false;
        }

        $passwordHash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $query = $this->db->prepare(
            "INSERT INTO users
            (
                username,
                password,
                nama_lengkap,
                role
            )
            VALUES (?, ?, ?, 'peminjam')"
        );

        return $query->execute([
            $username,
            $passwordHash,
            $nama_lengkap
        ]);
    }

    public function getPeminjam()
    {
        $query = $this->db->prepare(
            "SELECT *
             FROM users
             WHERE role = 'peminjam'
             ORDER BY id DESC"
        );

        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}