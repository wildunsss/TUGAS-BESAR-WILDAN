<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login - Sistem Venue</title>
<link rel="stylesheet" href="{{ asset('style-crud.css') }}">
</head>
<body class="halaman-auth">

<div class="wadah-auth">
  <div class="kartu-auth">
    <div class="auth-header">
      <h1>Login</h1>
      <p>Masuk ke Sistem Venue</p>
    </div>

    @if (session('pesan'))
      <div class="pesan">{{ session('pesan') }}</div>
    @endif

    @if ($errors->any())
      <div class="galat">
        @foreach ($errors->all() as $error)
          {{ $error }}<br>
        @endforeach
      </div>
    @endif

    <form class="auth-form" method="post" action="{{ route('login') }}">
      @csrf
      <div class="grup-input">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com" required autofocus>
      </div>
      <div class="grup-input">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Masukkan password" required>
      </div>
      <button type="submit" class="tombol-blok">Masuk</button>
    </form>

    <div class="auth-footer">
      Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
    </div>

    <hr style="border: none; border-top: 1px solid #e1e5ec; margin: 20px 0 16px;">

    <table class="tabel-akun-demo">
      <thead>
        <tr>
          <th colspan="3">Akun Demo</th>
        </tr>
        <tr>
          <td>Peran</td>
          <td>Email</td>
          <td>Password</td>
        </tr>
      </thead>
      <tbody>
        <tr onclick="isiAkun('admin@gmail.com', 'admin123')" style="cursor:pointer;" title="Klik untuk mengisi form login">
          <td><span class="lencana-peran peran-admin">Admin</span></td>
          <td>admin@gmail.com</td>
          <td>admin123</td>
        </tr>
        <tr onclick="isiAkun('member@gmail.com', 'member123')" style="cursor:pointer;" title="Klik untuk mengisi form login">
          <td><span class="lencana-peran peran-member">Member</span></td>
          <td>member@gmail.com</td>
          <td>member123</td>
        </tr>
      </tbody>
    </table>
    <div style="font-size: 11px; color: #999; text-align: center; margin-top: 6px;">Klik baris untuk mengisi form login otomatis</div>
  </div>
</div>

<script>
function isiAkun(email, pass) {
  document.getElementById('email').value = email;
  document.getElementById('password').value = pass;
}
</script>

</body>
</html>
