<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Diagnosa PC</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
<style>
body{font-family:'Plus Jakarta Sans';background:#f8fafc;margin:0;padding:40px}
.container{max-width:700px;margin:auto;background:#fff;padding:40px;border-radius:20px;box-shadow:0 10px 30px rgba(0,0,0,0.05)}
h2{margin-bottom:10px}
p{color:#64748b}
input{width:100%;padding:15px;margin-top:15px;border:1px solid #ddd;border-radius:10px}
button{margin-top:20px;padding:15px;width:100%;background:#6366f1;color:#fff;border:none;border-radius:10px;font-weight:600;cursor:pointer}
button:hover{background:#4f46e5}
</style>
</head>
<body>

<div class="container">
    <h2>💻 Diagnosa Komputer / PC</h2>
    <p>Masukkan gejala yang terjadi pada PC Anda</p>

    <form method="POST" action="/proses">
        @csrf
        <input type="text" name="gejala_input" required>
        <button type="submit">Analisa Sekarang</button>
    </form>
</div>

</body>
</html>