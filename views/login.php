<?php

$status = $_GET['status'] ?? '';

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Login - Peminjaman Alat Olahraga</title>

<style>

* {
    box-sizing: border-box;
}

body {
    margin: 0;
    min-height: 100vh;
    background: #f5f7fa;
    font-family: Arial, Helvetica, sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
}

.login-box {
    width: 390px;
    background: white;
    border: 1px solid #e0e5ec;
    border-radius: 12px;
    padding: 35px;
    box-shadow: 0 8px 25px rgba(0,0,0,.06);
}

.logo {
    width: 55px;
    height: 55px;
    margin: 0 auto 18px;
    border-radius: 50%;
    background: #263b5a;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 27px;
}

h1 {
    text-align: center;
    margin: 0;
    color: #263b5a;
    font-size: 23px;
}

.subtitle {
    text-align: center;
    color: #778499;
    font-size: 13px;
    margin: 8px 0 25px;
}

label {
    display: block;
    font-size: 13px;
    font-weight: bold;
    color: #35445a;
    margin-bottom: 7px;
}

.form-group {
    margin-bottom: 17px;
}

input {
    width: 100%;
    padding: 12px;
    border: 1px solid #d4dae3;
    border-radius: 7px;
    outline: none;
}

input:focus {
    border-color: #263b5a;
}

button {
    width: 100%;
    padding: 12px;
    border: 0;
    border-radius: 7px;
    background: #263b5a;
    color: white;
    cursor: pointer;
    font-weight: bold;
}

button:hover {
    opacity: .9;
}

.register {
    text-align: center;
    margin-top: 18px;
    font-size: 13px;
}

.register a {
    color: #263b5a;
    font-weight: bold;
}

.alert {
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 18px;
    font-size: 12px;
}

.success {
    background: #e7f5eb;
    color: #267348;
}

.danger {
    background: #fae7e7;
    color: #963e3e;
}

</style>

</head>

<body>

<div class="login-box">

    <div class="logo">
        ⚽
    </div>

    <h1>Peminjaman Alat</h1>

    <div class="subtitle">
        Alat Olahraga
    </div>


    <?php if ($status === 'gagal'): ?>

        <div class="alert danger">
            Username atau password salah.
        </div>

    <?php elseif ($status === 'register'): ?>

        <div class="alert success">
            Registrasi berhasil. Silakan login.
        </div>

    <?php endif; ?>


    <form
        method="POST"
        action="index.php?url=proses-login"
    >

        <div class="form-group">

            <label>Username</label>

            <input
                type="text"
                name="username"
                placeholder="Masukkan username"
                required
            >

        </div>


        <div class="form-group">

            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Masukkan password"
                required
            >

        </div>


        <button type="submit">
            Login
        </button>

    </form>


    <div class="register">

        Belum punya akun?

        <a href="index.php?url=register">
            Daftar
        </a>

    </div>

</div>

</body>

</html>