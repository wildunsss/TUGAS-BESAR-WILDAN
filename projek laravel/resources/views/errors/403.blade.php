<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>403 - Akses Ditolak</title>
    <link rel="stylesheet" href="{{ asset('css/styling.css') }}">
</head>
<body>
    <div class="form-card">
        <h2 class="form-title">403 - Akses Ditolak</h2>
        <p style="text-align:center">
            {{ $exception->getMessage() ?: 'Anda tidak berhak melakukan aksi ini.' }}
        </p>

        @auth
        <div class="form-button">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Keluar</button>
            </form>
        </div>
        @endauth
    </div>
</body>
</html>