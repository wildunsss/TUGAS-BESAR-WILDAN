<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Daftar Member - Sistem Venue</title>
<link rel="stylesheet" href="{{ asset('style-crud.css') }}">
</head>
<body class="halaman-auth">

<div class="wadah-auth">
  <div class="kartu-auth">
    <div class="auth-header">
      <h1>Daftar Akun Baru</h1>
      <p>Pendaftaran akun member untuk melihat data venue</p>
    </div>

    @if ($errors->any())
      <div class="galat">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form class="auth-form" method="post" action="{{ route('register') }}">
      @csrf

      <div class="grup-input">
        <label for="name">Nama Lengkap</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" required autofocus>
      </div>

      <div class="grup-input">
        <label for="email">Alamat Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required>
      </div>

      <div class="grup-input">
        <label for="password">Kata Sandi</label>
        <input type="password" id="password" name="password" placeholder="Minimal 6 karakter" required>
      </div>

      <div class="grup-input">
        <label for="password_confirmation">Konfirmasi Kata Sandi</label>
        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi kata sandi" required>
      </div>

      <button type="submit" class="tombol-blok">Daftar Sebagai Member</button>
    </form>

    <div class="auth-footer">
      Sudah memiliki akun? <a href="{{ route('login') }}">Masuk di sini</a>
    </div>
  </div>
</div>

</body>
</html>
