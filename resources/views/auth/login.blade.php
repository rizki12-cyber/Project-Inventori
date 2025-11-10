<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Website Inventory SMKN 1 Talaga</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #1e3a8a;
            --secondary: #e2e8f0;
            --accent: #fbbf24;
            --text-dark: #1e293b;
            --white: #ffffff;
            --shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 900px;
            max-width: 100%;
            min-height: 520px;
            display: flex;
            flex-wrap: wrap;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: var(--shadow);
            background: var(--white);
        }

        /* kiri */
        .left-side {
            flex: 1;
            min-width: 300px;
            background: linear-gradient(145deg, #e0e7ff, #cbd5e1);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
            padding: 40px 20px;
        }

        .left-side img {
            width: 180px;
            height: auto;
            margin-bottom: 15px;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
            transition: transform 0.3s ease;
        }

        .left-side img:hover {
            transform: scale(1.05);
        }

        .left-side h2 {
            font-size: 22px;
            font-weight: 600;
            color: var(--primary);
            line-height: 1.4;
        }

        /* kanan */
        .right-side {
            flex: 1;
            min-width: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--white);
            position: relative;
            padding: 30px;
        }

        .right-side::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom right, rgba(27, 60, 138, 0.08), transparent);
        }

        .login-box {
            position: relative;
            background: #ffffff;
            border-radius: 16px;
            padding: 45px 40px;
            width: 100%;
            max-width: 360px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
            text-align: center;
            animation: fadeIn 0.7s ease;
            z-index: 1;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-box h3 {
            color: var(--primary);
            font-size: 21px;
            font-weight: 600;
            margin-bottom: 22px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 16px;
        }

        label {
            font-size: 13px;
            color: #475569;
            margin-bottom: 5px;
            display: block;
        }

        input {
            width: 100%;
            padding: 10px 12px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            font-size: 14px;
            outline: none;
            transition: all 0.25s ease;
            background: #f9fafb;
        }

        input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.3);
            background: #fff;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            color: #ffffff;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s ease;
            font-size: 15px;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(30, 58, 138, 0.4);
            background: linear-gradient(135deg, #3b82f6, #1e3a8a);
        }

        .bottom-text {
            margin-top: 14px;
            font-size: 13px;
            color: #475569;
        }

        .bottom-text a {
            color: var(--primary);
            font-weight: 500;
            text-decoration: none;
        }

        .bottom-text a:hover {
            color: #0f172a;
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

        /* --- RESPONSIVE --- */
        @media (max-width: 992px) {
            .login-container {
                width: 95%;
            }
            .left-side h2 {
                font-size: 20px;
            }
            .login-box {
                padding: 35px 30px;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 0;
            }

            .login-container {
                flex-direction: column;
                width: 95%;
                height: auto;
            }

            .left-side, .right-side {
                flex: none;
                width: 100%;
                height: auto;
                padding: 30px 20px;
            }

            .left-side {
                order: 1;
            }

            .right-side {
                order: 2;
            }

            .left-side img {
                width: 130px;
            }

            .login-box {
                width: 100%;
                padding: 25px 20px;
                box-shadow: none;
                background: transparent;
            }

            button {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .left-side h2 {
                font-size: 18px;
            }

            .login-box h3 {
                font-size: 18px;
            }

            input {
                font-size: 13px;
            }

            button {
                padding: 10px;
                font-size: 13px;
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
