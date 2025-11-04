<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Website Inventory SMKN 1 Talaga</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font Google -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #1e3a8a;
            --secondary: #2563eb;
            --accent: #60a5fa;
            --background: #f0f4ff;
            --card-bg: #ffffff;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --shadow: 0 10px 35px rgba(0, 0, 0, 0.1);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(145deg, var(--secondary), var(--primary));
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .login-card {
            background: var(--card-bg);
            width: 380px;
            padding: 40px 35px;
            border-radius: 20px;
            box-shadow: var(--shadow);
            text-align: center;
            animation: fadeIn 0.8s ease;
        }

        /* ✅ Logo tanpa bingkai, bayangan, atau latar belakang */
        .login-card img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            margin-bottom: 12px;
            border: none;
            box-shadow: none;
            background: none;
        }

        h2 {
            color: var(--text-dark);
            margin: 8px 0 6px;
            font-weight: 600;
            font-size: 22px;
        }

        p.subtitle {
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 25px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 18px;
        }

        label {
            font-size: 13px;
            color: var(--text-dark);
            margin-bottom: 6px;
            display: block;
        }

        input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 14px;
            transition: 0.25s;
            outline: none;
        }

        input:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
        }

        button {
            width: 100%;
            background: var(--secondary);
            color: #fff;
            border: none;
            padding: 12px;
            font-size: 15px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 500;
            transition: 0.3s ease;
        }

        button:hover { background: var(--accent); }

        .error {
            color: #b91c1c;
            background: #fee2e2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 18px;
            padding: 10px;
        }

        footer {
            text-align: center;
            color: #e2e8f0;
            font-size: 13px;
            position: absolute;
            bottom: 10px;
            width: 100%;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 420px) {
            .login-card {
                width: 90%;
                padding: 30px 25px;
            }
        }
    </style>
</head>
<body>

    <div class="login-card">
        <!-- ✅ Logo sekolah tanpa bingkai -->
        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo SMKN 1 Talaga">

        <h2>Website Inventory</h2>
        <p class="subtitle">SMKN 1 Talaga</p>

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
        </form>
    </div>

    <footer>
        © {{ date('Y') }} SMKN 1 Talaga — Sistem Inventory Barang
    </footer>

</body>
</html>
