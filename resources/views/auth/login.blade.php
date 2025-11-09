<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Website Inventory SMKN 1 Talaga</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #0a3a78; /* biru navy sesuai logo */
            --accent: #fcd34d; /* kuning emas lembut */
            --text-dark: #1e293b;
            --shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            --bg-light: #f8fafc;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-light);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            width: 850px;
            height: 520px;
            display: flex;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: var(--shadow);
            background: white;
        }

        /* kiri */
        .left-side {
            flex: 1;
            background: linear-gradient(135deg, var(--primary), #1e40af);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: white;
            position: relative;
        }

        .left-side img {
            width: 200px;
            height: auto;
            margin-bottom: 18px;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.3));
        }

        .left-side h2 {
            font-size: 22px;
            font-weight: 600;
            text-align: center;
            line-height: 1.4;
        }

        /* kanan */
        .right-side {
            flex: 1;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .right-side::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, rgba(252, 211, 77, 0.15), transparent);
        }

        .login-box {
            background: #fff;
            padding: 40px 35px;
            border-radius: 15px;
            box-shadow: var(--shadow);
            width: 80%;
            max-width: 340px;
            text-align: center;
            position: relative;
            z-index: 1;
            animation: fadeUp 0.8s ease;
        }

        @keyframes fadeUp {
            from { transform: translateY(40px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .login-box h3 {
            color: var(--primary);
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 16px;
        }

        label {
            font-size: 13px;
            color: #475569;
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            font-size: 14px;
            outline: none;
            transition: 0.25s;
        }

        input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(252, 211, 77, 0.3);
        }

        button {
            width: 100%;
            padding: 11px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
        }

        button:hover {
            background: #1e40af;
            transform: translateY(-2px);
        }

        .bottom-text {
            margin-top: 12px;
            font-size: 13px;
            color: #475569;
        }

        .bottom-text a {
            color: var(--primary);
            font-weight: 500;
            text-decoration: none;
        }

        .error {
            color: #b91c1c;
            background: #fee2e2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 18px;
            padding: 10px;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                height: auto;
                width: 90%;
            }

            .left-side, .right-side {
                flex: unset;
                width: 100%;
                height: auto;
                padding: 40px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- kiri -->
        <div class="left-side">
            <img src="{{ asset('assets/images/logo1.png') }}" alt="Logo SMKN 1 Talaga">
            <h2>Website Inventory<br>SMKN 1 Talaga</h2>
        </div>

        <!-- kanan -->
        <div class="right-side">
            <div class="login-box">
                <h3>Masuk ke Akun Anda</h3>

                @if (session('error'))
                    <div class="error">{{ session('error') }}</div>
                @endif

                <form action="{{ route('login.process') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <input type="email" name="email" id="email" placeholder="Masukkan email anda" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Kata Sandi</label>
                        <input type="password" name="password" id="password" placeholder="Masukkan kata sandi" required>
                    </div>

                    <button type="submit">Masuk</button>

                    <p class="bottom-text">
                        Belum punya akun? <a href="#">Hubungi Admin</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
