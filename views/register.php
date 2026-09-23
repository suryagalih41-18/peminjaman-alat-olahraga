<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register - Peminjaman Alat Olahraga</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f2f4f7;
        }

        .register-container {
            width: 380px;
            margin: 80px auto;
            background: white;
            padding: 35px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: #777;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            width: 100%;
            padding: 12px;  
            background: #01060b;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #3783e0;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: #0b7dee;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="register-container">

    <h2>Daftar Akun</h2>

    <p class="subtitle">
        Peminjaman Alat Olahraga
    </p>

    <form method="POST" action="../public/index.php?url=proses-register">

        <label>Username</label>
        <input 
            type="text" 
            name="username" 
            placeholder="Masukkan username"
            required
        >

        <label>Nama lengkap</label>
        <input 
            type="text" 
            name="nama_lengkap" 
            placeholder="Masukan nama lengkap"
            required
        >

        <label>Password</label>
        <input 
            type="password" 
            name="password" 
            placeholder="Masukkan password"
            required
        >

        <label>Konfirmasi Password</label>
        <input 
            type="password" 
            name="konfirmasi_password"
            placeholder="konfirmasi password"
            required
        >

        <button type="submit">
            DAFTAR
        </button>

    </form>

    <div class="login-link">
        Sudah punya akun?
        <a href="../public/index.php">
            Login
        </a>
    </div>

</div>

</body>
</html>