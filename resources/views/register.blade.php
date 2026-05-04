<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<style>
    body{ font-family:Arial; background:#f2f2f2; }
    .box{ width:350px; margin:120px auto; padding:30px; background:white; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.1); text-align:center; }
    input{ width:100%; padding:10px; margin:10px 0; border:1px solid #ccc; border-radius:5px; box-sizing: border-box; }
    button{ width:100%; padding:10px; background:#00b894; color:white; border:none; border-radius:5px; cursor:pointer; }
    button:hover{ background:#019875; }
    a { text-decoration: none; color: #6c5ce7; font-size: 14px; }
</style>
</head>
<body>

<div class="box">
    <h2>Register</h2>

    {{-- ERROR --}}
    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    {{-- SUCCESS --}}
    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <form method="POST" action="/register">
        @csrf

        <input type="text" name="nama" placeholder="Nama Lengkap" required>
        
        <input type="text" name="identitas" placeholder="Email atau Nomor Handphone" required>
        
        <input type="password" name="password" placeholder="Password" required>
        
        <button name="register" type="submit">Daftar</button>
    </form>

    <br>
    <a href="/login">Kembali ke Login</a>
</div>

</body>
</html>