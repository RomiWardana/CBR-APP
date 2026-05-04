<?php

/* CEK LOGIN (versi Laravel) */
if(!session('login')){
    header("Location: /login");
    exit;
}

/* MENENTUKAN HALAMAN */
$page = isset($_GET['page']) ? $_GET['page'] : "dashboard";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Diagnosa | CBR System</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-color: #fcfcfd;
            --primary: #6366f1;
            --dark: #1e293b;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            color: var(--dark);
            margin: 0;
            padding: 40px;
        }

        .main-wrapper { max-width: 1200px; margin: 0 auto; }

        /* Header Navigation */
        .header-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 60px;
        }

        .logo-area h1 { font-size: 1.4rem; font-weight: 800; margin: 0; letter-spacing: -1px; }
        .user-welcome { font-size: 14px; color: var(--text-muted); }
        .user-welcome strong { color: var(--primary); }

        .menu { display: flex; gap: 10px; }
        .menu a {
            padding: 10px 20px;
            text-decoration: none;
            color: var(--dark);
            font-weight: 600;
            font-size: 14px;
            border-radius: 10px;
        }
        .menu a.logout { color: #ef4444; background: #fef2f2; }

        /* Dashboard Grid */
        .dashboard-header { margin-bottom: 40px; }
        .dashboard-header h2 { font-size: 2.5rem; margin-bottom: 10px; }
        .dashboard-header p { color: var(--text-muted); font-size: 1.1rem; }

        .hardware-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .hardware-card {
            background: white;
            padding: 30px;
            border-radius: 24px;
            border: 1px solid #f1f5f9;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            gap: 20px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
        }

        .hardware-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary);
            box-shadow: 0 20px 40px rgba(99, 102, 241, 0.1);
        }

        .icon-box {
            width: 60px;
            height: 60px;
            background: #f5f3ff;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: var(--primary);
        }

        .card-info h3 { margin: 0 0 8px 0; font-size: 1.25rem; }
        .card-info p { margin: 0; color: var(--text-muted); font-size: 0.9rem; line-height: 1.5; }

        .btn-start {
            margin-top: 10px;
            font-weight: 700;
            color: var(--primary);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Logic Content Card */
        .content-card {
            background: white;
            padding: 40px;
            border-radius: 24px;
            border: 1px solid #f1f5f9;
        }
    </style>
</head>
<body>

<div class="main-wrapper">
    <div class="header-nav">
        <div class="logo-area">
            <h1>Intellegence System<span style="color:var(--primary)">.</span></h1>
            <div class="user-welcome">Halo, <strong><?= session('nama'); ?></strong></div>
        </div>
        <div class="menu">
            <a href="/riwayat">Riwayat</a>
            <a href="/logout" class="logout">Keluar</a>
        </div>
    </div>

    <?php if($page == "dashboard"): ?>
        <div class="dashboard-header">
            <h2>Pilih Perangkat</h2>
            <p>Silakan pilih kategori hardware yang ingin Anda diagnosa hari ini.</p>
        </div>

        <div class="hardware-grid">
            <a href="/diagnosa?cat=pc" class="hardware-card">
                <div class="icon-box">💻</div>
                <div class="card-info">
                    <h3>Komputer & PC</h3>
                    <p>Diagnosa masalah motherboard, power supply, atau kegagalan booting pada PC Desktop Anda.</p>
                </div>
                <div class="btn-start">Mulai Diagnosa &rarr;</div>
            </a>

            <a href="/diagnosa?cat=laptop" class="hardware-card">
                <div class="icon-box">🔌</div>
                <div class="card-info">
                    <h3>Laptop & Notebook</h3>
                    <p>Masalah pada baterai, layar blank, keyboard tidak berfungsi, atau suhu berlebih.</p>
                </div>
                <div class="btn-start">Mulai Diagnosa &rarr;</div>
            </a>

            <a href="/diagnosa?cat=printer" class="hardware-card">
                <div class="icon-box">🖨️</div>
                <div class="card-info">
                    <h3>Printer & Scanner</h3>
                    <p>Kerusakan mekanik printer, hasil cetak bergaris, atau masalah konektivitas perangkat.</p>
                </div>
                <div class="btn-start">Mulai Diagnosa &rarr;</div>
            </a>
        </div>

    <?php else: ?>
        <div class="content-card">
            @if($page == "diagnosa")
        @include('diagnosa')
        @elseif($page == "hasil")
        @include('hasil')
        @elseif($page == "history")
    @include('history')
@endif
        </div>
    <?php endif; ?>
</div>

</body>
</html>