<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Masuk - Sistem Venue</title>
<link rel="stylesheet" href="{{ asset('style-crud.css') }}">
</head>
<body class="halaman-auth">

<div class="wadah-auth">
  <div class="kartu-auth">
    <div class="auth-header">
      <h1>Sistem Venue</h1>
      <p>Silakan masuk ke akun Anda</p>
    </div>

    @if (session('pesan'))
      <div class="pesan">{{ session('pesan') }}</div>
    @endif

    @if (session('galat'))
      <div class="galat">{{ session('galat') }}</div>
    @endif

    @if ($errors->any())
      <div class="galat">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="box-akun-dosen">
      <div class="box-akun-header">
        <span>📋 Akun Demo untuk Dosen / Penguji:</span>
      </div>
      <div class="grid-akun">
        <div class="kartu-akun kartu-admin" onclick="isiAkun('admin@gmail.com', 'admin123')">
          <span class="badge-role-admin">👑 Admin</span>
          <p><strong>Akses:</strong> CRUD Penuh</p>
          <p><strong>Email:</strong> <code>admin@gmail.com</code></p>
          <p><strong>Password:</strong> <code>admin123</code></p>
          <button type="button" class="btn-pilih-akun">Gunakan Akun Admin</button>
        </div>

        <div class="kartu-akun kartu-member" onclick="isiAkun('member@gmail.com', 'member123')">
          <span class="badge-role-member">👤 Member</span>
          <p><strong>Akses:</strong> Hanya Lihat</p>
          <p><strong>Email:</strong> <code>member@gmail.com</code></p>
          <p><strong>Password:</strong> <code>member123</code></p>
          <button type="button" class="btn-pilih-akun">Gunakan Akun Member</button>
        </div>
      </div>
      <div style="margin-top: 10px; font-size: 11px; color: var(--redup); text-align: center;">
        Klik salah satu kartu di atas untuk mengisi formulir login secara otomatis.
      </div>
    </div>

    <form class="auth-form" method="post" action="{{ route('login') }}">
      @csrf

      <div class="grup-input">
        <label for="email">Alamat Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
      </div>

      <div class="grup-input">
        <label for="password">Kata Sandi</label>
        <input type="password" id="password" name="password" placeholder="Masukkan password" required>
      </div>

      <button type="submit" class="tombol-blok">Masuk Sekarang</button>
    </form>

    <div class="auth-footer">
      Belum memiliki akun? <a href="{{ route('register') }}">Daftar Member Baru</a>
    </div>
  </div>
</div>

<script>
function isiAkun(email, pass) {
  document.getElementById('email').value = email;
  document.getElementById('password').value = pass;
  document.getElementById('password').focus();
}
</script>

</body>
</html>
