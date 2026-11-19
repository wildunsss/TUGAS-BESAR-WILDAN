<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Venue</title>
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
            <h2 class="form-title" style="margin-bottom: 4px;">Sistem<strong>Venue</strong></h2>
            <p style="color: var(--text-muted); font-size: 14px; margin: 0;">Silakan masuk ke akun Anda</p>
        </div>

        @if (session('pesan'))
            <div class="alert-success">{{ session('pesan') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('login.proses') }}" method="POST">
            @csrf

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>

            <label for="password">Kata Sandi</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required>

            <div class="form-button">
                <button type="submit" class="btn btn-primary">Masuk</button>
            </div>
        </form>

        <p style="text-align: center; font-size: 13.5px; color: var(--text-muted); margin-top: 20px;">
            Belum punya akun? <a href="{{ route('register') }}">Daftar Member</a>
        </p>

        <div style="border-top: 1px solid var(--border-color); margin-top: 24px; padding-top: 18px;">
            <p style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 10px 0;">
                Akun Demo
            </p>
            <table class="tabel-akun-demo">
                <thead>
                    <tr>
                        <th>Peran</th>
                        <th>Email</th>
                        <th>Password</th>
                    </tr>
                </thead>
                <tbody>
                    <tr onclick="isiAkun('admin@gmail.com', 'admin123')" style="cursor: pointer;" title="Klik untuk mengisi form">
                        <td><span class="badge-role role-admin">Admin</span></td>
                        <td><code>admin@gmail.com</code></td>
                        <td><code>admin123</code></td>
                    </tr>
                    <tr onclick="isiAkun('staff@gmail.com', 'staff123')" style="cursor: pointer;" title="Klik untuk mengisi form">
                        <td><span class="badge-role role-staff">Staff</span></td>
                        <td><code>staff@gmail.com</code></td>
                        <td><code>staff123</code></td>
                    </tr>
                    <tr onclick="isiAkun('member@gmail.com', 'member123')" style="cursor: pointer;" title="Klik untuk mengisi form">
                        <td><span class="badge-role role-member">Member</span></td>
                        <td><code>member@gmail.com</code></td>
                        <td><code>member123</code></td>
                    </tr>
                </tbody>
            </table>
            <small style="color: var(--text-light); display: block; text-align: center; margin-top: 8px; font-size: 11px;">
                Klik baris tabel di atas untuk mengisi formulir secara otomatis.
            </small>
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
