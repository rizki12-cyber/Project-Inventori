<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Masuk | Sistem Inventori SMKN 1 Talaga</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset($pengaturan->favicon ?? 'assets/images/logo1.png') }}" type="image/png" sizes="32x32">
    
    <style>
        :root {
            --utama: #1e3a8a;
            --sekunder: #e2e8f0;
            --aksen: #fbbf24;
            --teks-gelap: #1e293b;
            --putih: #ffffff;
            --bayangan: 0 8px 25px rgba(0, 0, 0, 0.15);
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

        .kotak-login {
            width: 900px;
            max-width: 100%;
            min-height: 520px;
            display: flex;
            flex-wrap: wrap;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: var(--bayangan);
            background: var(--putih);
        }

        /* Bagian kiri */
        .bagian-kiri {
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

        .bagian-kiri img {
            width: 180px;
            height: auto;
            margin-bottom: 15px;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
            transition: transform 0.3s ease;
        }

        .bagian-kiri img:hover {
            transform: scale(1.05);
        }

        .bagian-kiri h2 {
            font-size: 22px;
            font-weight: 600;
            color: var(--utama);
            line-height: 1.4;
        }

        /* Bagian kanan */
        .bagian-kanan {
            flex: 1;
            min-width: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--putih);
            position: relative;
            padding: 30px;
        }

        .bagian-kanan::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom right, rgba(27, 60, 138, 0.08), transparent);
        }

        .kotak-form {
            position: relative;
            background: #ffffff;
            border-radius: 16px;
            padding: 45px 40px;
            width: 100%;
            max-width: 360px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
            text-align: center;
            animation: muncul 0.7s ease;
            z-index: 1;
        }

        @keyframes muncul {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .kotak-form h3 {
            color: var(--utama);
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
            border-color: var(--aksen);
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

        .teks-bawah {
            margin-top: 14px;
            font-size: 13px;
            color: #475569;
        }

        .teks-bawah a {
            color: var(--utama);
            font-weight: 500;
            text-decoration: none;
        }

        .teks-bawah a:hover {
            color: #0f172a;
        }

        .pesan-error {
            color: #b91c1c;
            background: #fee2e2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 18px;
            padding: 10px;
        }

        /* Responsif */
        @media (max-width: 992px) {
            .kotak-login {
                width: 95%;
            }
            .bagian-kiri h2 {
                font-size: 20px;
            }
            .kotak-form {
                padding: 35px 30px;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 0;
            }

            .kotak-login {
                flex-direction: column;
                width: 95%;
                height: auto;
            }

            .bagian-kiri, .bagian-kanan {
                flex: none;
                width: 100%;
                height: auto;
                padding: 30px 20px;
            }

            .bagian-kiri {
                order: 1;
            }

            .bagian-kanan {
                order: 2;
            }

            .bagian-kiri img {
                width: 130px;
            }

            .kotak-form {
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
            .bagian-kiri h2 {
                font-size: 18px;
            }

            .kotak-form h3 {
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
    <div class="kotak-login">
        <!-- Bagian kiri -->
        <div class="bagian-kiri">
            <img src="{{ asset($pengaturan->logo_sekolah ?? 'assets/images/logo1.png') }}" alt="Logo Sekolah">
            <h2>{{ $pengaturan->nama_sekolah ?? 'Nama Sekolah' }}</h2>
        </div>

        <!-- Bagian kanan -->
        <div class="bagian-kanan">
            <div class="kotak-form">
                <h3>Masuk ke Akun</h3>

                @if (session('error'))
                    <div class="pesan-error">{{ session('error') }}</div>
                @endif

                <form action="{{ route('login.process') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <input type="email" name="email" id="email" placeholder="Masukkan alamat email Anda" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Kata Sandi</label>
                        <input type="password" name="password" id="password" placeholder="Masukkan kata sandi Anda" required>
                    </div>

                    <button type="submit">Masuk</button>

                            <p class="teks-bawah">
                                Belum memiliki akun? 
                                <a href="https://wa.me/628991554555?text=Saya%20ingin%20masuk%20ke%20sistem%20inventaris%20barang%20SMKN%201%20Talaga%2C%20tetapi%20saya%20belum%20mempunyai%20akun." 
                                target="_blank">
                                Hubungi Administrator
                                </a>
                            </p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
