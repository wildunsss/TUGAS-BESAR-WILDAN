<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Member - Sistem Venue</title>
    <link rel="stylesheet" href="{{ asset('css/styling.css') }}">
</head>
<body>
    <div class="form-card" style="margin-top: 40px; margin-bottom: 40px;">
        <div style="text-align: center; margin-bottom: 20px;">
            <div class="brand-icon" style="margin: 0 auto 12px auto; width: 42px; height: 42px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <h2 class="form-title" style="margin-bottom: 4px;">Daftar Akun Member</h2>
            <p style="color: var(--text-muted); font-size: 14px; margin: 0;">Pendaftaran anggota baru sistem venue</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.proses') }}" method="POST">
            @csrf

            <label for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Wildan Pratama" required autofocus>

            <label for="email">Alamat Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required>

            <label for="password">Kata Sandi (Minimal 6 Karakter)</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required>

            <label for="password_confirmation">Ulangi Kata Sandi</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>

            <div class="form-button">
                <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
            </div>
        </form>

        <p style="text-align: center; font-size: 13.5px; color: var(--text-muted); margin-top: 20px;">
            Sudah memiliki akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </p>
    </div>
</body>
</html>
