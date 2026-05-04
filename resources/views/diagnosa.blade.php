<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnosa Sistem</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #fcfcfc;
            --text-main: #111111;
            --text-muted: #666666;
            --accent-black: #000000;
            --border-color: #eeeeee;
        }

        * {
            box-sizing: border-box;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            background-image: radial-gradient(circle at top right, rgba(0,0,0,0.02), transparent),
                              radial-gradient(circle at bottom left, rgba(0,0,0,0.02), transparent);
            color: var(--text-main);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .diagnosa-wrapper {
            width: 100%;
            max-width: 700px;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .diagnosa-container {
            background: #ffffff;
            padding: 60px 50px;
            border-radius: 40px;
            box-shadow: 0 40px 100px rgba(0,0,0,0.04);
            border: 1px solid var(--border-color);
            position: relative;
            overflow: hidden;
        }

        .diagnosa-container::before {
            content: "";
            position: absolute;
            top: 0; right: 0;
            width: 150px; height: 150px;
            background: linear-gradient(135deg, #f0f0f0 0%, transparent 100%);
            border-radius: 0 0 0 100%;
            z-index: 0;
        }

        .content-inner {
            position: relative;
            z-index: 1;
        }

        /* Grouping Tags */
        .tag-group {
            display: flex;
            gap: 8px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .kategori-tag {
            display: inline-block;
            background: #f5f5f5;
            color: var(--accent-black);
            padding: 8px 16px;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        /* Style khusus untuk pembeda Mechanical */
        .kategori-tag.mechanical {
            background: #111;
            color: #fff;
        }

        .judul {
            font-size: 2.8rem;
            font-weight: 800;
            letter-spacing: -2px;
            margin: 0 0 15px 0;
            line-height: 1;
        }

        .deskripsi {
            color: var(--text-muted);
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 45px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 30px;
        }

        .form-group label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 12px;
            margin-left: 5px;
            color: var(--text-main);
        }

        .input-gejala {
            width: 100%;
            background: #f9f9f9;
            border: 1px solid #eeeeee;
            padding: 22px 28px;
            border-radius: 20px;
            font-size: 1.05rem;
            font-family: inherit;
            color: var(--text-main);
            outline: none;
        }

        .input-gejala:focus {
            background: #ffffff;
            border-color: var(--accent-black);
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transform: translateY(-2px);
        }

        .btn-submit {
            width: 100%;
            background: var(--accent-black);
            color: #ffffff;
            border: none;
            padding: 22px;
            border-radius: 20px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .btn-submit:hover {
            background: #222;
            transform: scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .back-link {
            display: inline-block;
            margin-top: 30px;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .back-link:hover {
            color: var(--accent-black);
        }

        @media (max-width: 600px) {
            .diagnosa-container { padding: 40px 25px; border-radius: 30px; }
            .judul { font-size: 2rem; }
        }
    </style>
</head>
<body>

<div class="diagnosa-wrapper">
    <div class="diagnosa-container">
        <div class="content-inner">
            <div class="tag-group">
                <span class="kategori-tag">Hardware Analysis</span>
                <span class="kategori-tag mechanical">Mechanical Analyst</span>
            </div>
            
            <h2 class="judul">Identifikasi Masalah</h2>
            <p class="deskripsi">
                Ceritakan gejala yang dialami perangkat Anda. Biarkan sistem kami melakukan pemindaian data berbasis CBR.
            </p>

            @if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

        <form method="POST" action="/proses">
    @csrf

    <div class="form-group">
        <label for="masalah">Apa yang terjadi pada sistem?</label>
        <input 
            type="text" 
            name="gejala_input" 
            id="masalah" 
            class="input-gejala" 
            placeholder="Contoh: laptop panas, mati sendiri"
            required
        >
    </div>

    <button type="submit" class="btn-submit">Mulai Analisis</button>
</form>

            <a href="/index" class="back-link">← Kembali ke beranda</a>
        </div>
    </div>
</div>

</body>
</html>