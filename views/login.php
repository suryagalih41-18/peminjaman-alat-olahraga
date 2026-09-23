<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Peminjaman Alat</title>

    <style>

        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;

            background: #dff3ff;
        }

        .login-card {
            width: 400px;

            background: white;

            padding: 35px;

            border-radius: 15px;

            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        h2 {
            text-align: center;

            color: #000102;

            margin-bottom: 5px;
        }

        .judul {
            text-align: center;

            color: #777;

            margin-bottom: 30px;
        }

        label {
            display: block;

            margin-bottom: 7px;

            font-weight: bold;

            color: #333;
        }

        input {
            width: 100%;

            padding: 13px;

            margin-bottom: 18px;

            border: 1px solid #bbb;

            border-radius: 7px;

            font-size: 14px;
        }

        input:focus {
            outline: none;

            border: 2px solid #2196f3;
        }

        .btn-login {
            width: 100%;

            padding: 13px;

            border: none;

            border-radius: 7px;

            background: #000000;

            color: white;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;
        }

        .btn-login:hover {
            background: #333333;
        }

        .daftar {
            text-align: center;

            margin-top: 25px;

            color: #666;
        }

        .daftar a {
            color: #2196f3;

            font-weight: bold;

            text-decoration: none;
        }

        .daftar a:hover {
            text-decoration: underline;
        }

    </style>

</head>


<body>


<div class="login-card">


    <h2>LOGIN</h2>


    <div class="judul">
        Peminjaman Alat Olahraga
    </div>


    <form action="index.php?url=proses-login" method="POST">


        <label>
            Username
        </label>


        <input
            type="text"
            name="username"
            placeholder="Masukkan username"
            required
        >


        <label>
            Password
        </label>


        <input
            type="password"
            name="password"
            placeholder="Masukkan password"
            required
        >


        <button
            type="submit"
            class="btn-login"
        >
            LOGIN
        </button>


    </form>


    <div class="daftar">

        Belum punya akun?

        <a href="index.php?url=register">
            Daftar
        </a>

    </div>


</div>


</body>

</html>
```
