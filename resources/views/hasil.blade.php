<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Hasil Diagnosa</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
<style>
body{font-family:'Plus Jakarta Sans';background:#f8fafc;margin:0;padding:40px}
.container{max-width:900px;margin:auto}
.card{background:#fff;padding:30px;border-radius:20px;box-shadow:0 10px 30px rgba(0,0,0,0.05);margin-bottom:20px}
.title{font-size:28px;font-weight:800;margin-bottom:10px}
.subtitle{color:#64748b;margin-bottom:30px}

.top-result{
    border:2px solid #6366f1;
    background:#eef2ff;
}

.rank{
    font-size:14px;
    font-weight:700;
    color:#6366f1;
}

.similarity{
    font-size:22px;
    font-weight:800;
}

.bar{
    width:100%;
    height:10px;
    background:#e5e7eb;
    border-radius:10px;
    overflow:hidden;
    margin-top:10px;
}
.fill{
    height:100%;
    background:#6366f1;
}

.item{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.small{
    font-size:14px;
    color:#64748b;
}
.btn-back{
    display:inline-block;
    margin-top:20px;
    padding:12px 20px;
    background:#111;
    color:#fff;
    border-radius:10px;
    text-decoration:none;
}
</style>
</head>
<body>

<div class="container">

    <div class="card">
        <div class="title">🧠 Hasil Analisis</div>
        <div class="subtitle">Sistem menemukan solusi terbaik berdasarkan kemiripan kasus sebelumnya</div>
    </div>

    {{-- 🔥 TOP RESULT --}}
    <div class="card top-result">
        <div class="rank">#1 Paling Mirip</div>

        <h2>{{ $terbaik['kasus']->diagnosa->nama_diagnosa ?? 'Tidak diketahui' }}</h2>

        <p style="margin-top:10px; color:#64748b;">
            {{ $terbaik['kasus']->diagnosa->solusi ?? 'Solusi belum tersedia' }}
        </p>
    </div>

    {{-- 🔥 LIST RANKING --}}
    <div class="card">
        <h3>📊 Ranking Kemiripan Kasus</h3>

        @php
    $clean = collect($hasil)
        ->groupBy('kasus_id')
        ->map(fn($items) => $items->first())
        ->values();
        @endphp

        @foreach($clean as $index => $item)
            <div class="item" style="margin-top:20px">
                <div>
                    <strong>#{{ $index + 1 }}</strong> 
                    {{ $item['kasus']->diagnosa->nama_diagnosa ?? '-' }}

                    <div class="small">
                        {{ $item['kasus']->diagnosa->solusi ?? '' }}
                    </div>
                </div>

                <div style="text-align:right">
                    <div><strong>{{ round($item['similarity'] * 100, 2) }}%</strong></div>
                </div>
            </div>

            <div class="bar">
                <div class="fill" style="width: {{ $item['similarity'] * 100 }}%"></div>
            </div>
        @endforeach

        <a href="/index" class="btn-back">← Kembali</a>
    </div>

</div>

</body>
</html>