<!DOCTYPE html>
<html>
<head>
    <title>Login Sistem</title>
    <style>
        body{ font-family: Arial; background: #f2f2f2; }
        .login-box{ width:350px; margin:120px auto; padding:30px; background:white; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.1); text-align:center; }
        input{ width:100%; padding:10px; margin:10px 0; border:1px solid #ccc; border-radius:5px; box-sizing: border-box; }
        button{ width:100%; padding:10px; background:#3498db; color:white; border:none; border-radius:5px; cursor:pointer; }
        button:hover{ background:#2980b9; }
        .error { color: red; font-size: 14px; margin-bottom: 10px; }
        a { text-decoration: none; color: #3498db; }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Login Sistem</h2>

    {{-- ERROR MESSAGE --}}
    @if(session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif

    <form method="POST" action="/login">
        @csrf

        <input type="text" name="identitas" placeholder="Email atau Nomor Handphone" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="login">Login</button>

        <p>Belum punya akun? <a href="/register">Daftar disini</a></p>
    </form>
</div>

</body>
</html>