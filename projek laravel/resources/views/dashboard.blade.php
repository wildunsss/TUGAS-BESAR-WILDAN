<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Venue</title>
    <link rel="stylesheet" href="{{ asset('css/styling.css') }}?v=2">
</head>
<body>

    <header class="app-navbar">
        <div class="nav-container">
            <div class="nav-left">
                <a href="{{ route('dashboard') }}" class="nav-brand">
                    <div class="brand-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                            <line x1="12" y1="4" x2="12" y2="20"></line>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </div>
                    <span>Sistem<strong>Venue</strong></span>
                </a>
                <nav class="nav-links">
                    <a href="{{ route('dashboard') }}" class="nav-link active">Dashboard</a>
                    <a href="{{ route('lapangan.index') }}" class="nav-link">Data Lapangan</a>
                </nav>
            </div>

            <div class="nav-right">
                <div class="user-profile-badge">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <span class="badge-role role-{{ auth()->user()->role }}">{{ ucfirst(auth()->user()->role) }}</span>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="btn-logout" title="Keluar dari sistem">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="dashboard-hero">
            <div class="hero-content">
                <div class="hero-tag">
                    <span class="status-indicator"></span> Sesi Login Aktif
                </div>
                <h1>Selamat datang, {{ auth()->user()->name }}! 👋</h1>
                <p>
                    Anda masuk ke dalam sistem pengelolaan venue dengan hak akses sebagai 
                    <span class="hero-role-pill role-{{ auth()->user()->role }}">{{ ucfirst(auth()->user()->role) }}</span>
                </p>
            </div>
            <div class="hero-meta">
                <div class="meta-item">
                    <span class="meta-label">Email Terdaftar</span>
                    <span class="meta-val">{{ auth()->user()->email }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Bergabung Sejak</span>
                    <span class="meta-val">{{ auth()->user()->created_at ? auth()->user()->created_at->format('d M Y') : '-' }}</span>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert-success">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('pesan'))
            <div class="alert-success">
                <span>{{ session('pesan') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="alert-error">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 16px; margin-bottom: 24px;">
            <div class="card" style="display: flex; align-items: center; gap: 16px; padding: 20px;">
                <div class="card-icon-wrapper" style="width: 46px; height: 46px; background-color: var(--primary-light); color: var(--primary);">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"></rect><line x1="12" y1="4" x2="12" y2="20"></line></svg>
                </div>
                <div>
                    <span style="font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: uppercase;">Total Lapangan</span>
                    <h2 style="margin: 2px 0 0 0; font-size: 24px; font-weight: 800; color: var(--text-main);">{{ $totalLapangan }}</h2>
                </div>
            </div>

            <div class="card" style="display: flex; align-items: center; gap: 16px; padding: 20px;">
                <div class="card-icon-wrapper" style="width: 46px; height: 46px; background-color: #dcfce7; color: #15803d;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </div>
                <div>
                    <span style="font-size: 12px; font-weight: 600; color: #15803d; text-transform: uppercase;">Kondisi Baik (Siap)</span>
                    <h2 style="margin: 2px 0 0 0; font-size: 24px; font-weight: 800; color: #15803d;">{{ $lapanganBaik }}</h2>
                </div>
            </div>

            <div class="card" style="display: flex; align-items: center; gap: 16px; padding: 20px;">
                <div class="card-icon-wrapper" style="width: 46px; height: 46px; background-color: #fef3c7; color: #b45309;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                </div>
                <div>
                    <span style="font-size: 12px; font-weight: 600; color: #b45309; text-transform: uppercase;">Perlu Perawatan</span>
                    <h2 style="margin: 2px 0 0 0; font-size: 24px; font-weight: 800; color: #b45309;">{{ $lapanganPerbaikan }}</h2>
                </div>
            </div>

            <div class="card" style="display: flex; align-items: center; gap: 16px; padding: 20px;">
                <div class="card-icon-wrapper" style="width: 46px; height: 46px; background-color: #ede9fe; color: #6d28d9;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                </div>
                <div>
                    <span style="font-size: 12px; font-weight: 600; color: #6d28d9; text-transform: uppercase;">Area Venue</span>
                    <h2 style="margin: 2px 0 0 0; font-size: 24px; font-weight: 800; color: #6d28d9;">{{ $totalArea }}</h2>
                </div>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="dashboard-col-main" style="display: flex; flex-direction: column; gap: 20px;">
                <div class="card module-card highlight">
                    <div class="card-icon-wrapper">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                            <line x1="12" y1="4" x2="12" y2="20"></line>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </div>
                    <div class="module-details">
                        <h3>Kelola Data Lapangan & Fasilitas</h3>
                        <p>Akses daftar lengkap lapangan venue, informasi jenis permukaan/lantai, ukuran fisik lapangan, status kondisi fasilitas, dan dokumentasi foto.</p>
                        <div class="module-actions">
                            <a href="{{ route('lapangan.index') }}" class="btn btn-primary">
                                Buka Data Lapangan
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </a>
                            @if (auth()->user()->role === 'admin')
                                <a href="{{ route('lapangan.create') }}" class="btn btn-outline">
                                    + Tambah Lapangan
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card" style="padding: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                        <div>
                            <h3 style="margin: 0; font-size: 17px; font-weight: 700; color: var(--text-main);">Daftar Area Venue</h3>
                            <p style="margin: 2px 0 0 0; font-size: 13px; color: var(--text-muted);">Area olahraga yang terdaftar dalam venue</p>
                        </div>
                        <span class="badge" style="background-color: var(--primary-light); color: var(--primary); font-weight: 600; padding: 4px 10px; border-radius: 20px; font-size: 12px;">
                            {{ $areas->count() }} Area Terdaftar
                        </span>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px;">
                        @foreach ($areas as $area)
                            <div style="border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 14px; background-color: #f8fafc;">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                    <h4 style="margin: 0; font-size: 14.5px; font-weight: 700; color: var(--text-main);">{{ $area->nama_area }}</h4>
                                    <span class="badge" style="background-color: {{ $area->tipe === 'indoor' ? '#dbeafe' : '#fef3c7' }}; color: {{ $area->tipe === 'indoor' ? '#1e40af' : '#92400e' }}; font-size: 11px; padding: 2px 8px; border-radius: 12px; text-transform: uppercase; font-weight: 700;">
                                        {{ $area->tipe }}
                                    </span>
                                </div>
                                <p style="margin: 6px 0 0 0; font-size: 13px; color: var(--text-muted);">
                                    {{ $area->deskripsi ?? 'Area fasilitas olahraga venue.' }}
                                </p>
                                <div style="margin-top: 10px; font-size: 12.5px; font-weight: 600; color: var(--primary);">
                                    {{ $area->lapangans_count }} Lapangan tersedia
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if ($lapangansTerbaru->count() > 0)
                    <div class="card" style="padding: 24px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                            <div>
                                <h3 style="margin: 0; font-size: 17px; font-weight: 700; color: var(--text-main);">Lapangan Terbaru</h3>
                                <p style="margin: 2px 0 0 0; font-size: 13px; color: var(--text-muted);">Fasilitas lapangan yang baru ditambahkan</p>
                            </div>
                            <a href="{{ route('lapangan.index') }}" style="font-size: 13px; font-weight: 600;">Lihat Semua &rarr;</a>
                        </div>

                        <table>
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Lapangan</th>
                                    <th>Area</th>
                                    <th>Cabang Olahraga</th>
                                    <th>Status Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lapangansTerbaru as $lap)
                                    <tr>
                                        <td><strong>{{ $lap->kode }}</strong></td>
                                        <td>{{ $lap->nama_lapangan }}</td>
                                        <td>{{ $lap->area ? $lap->area->nama_area : '-' }}</td>
                                        <td>{{ $lap->cabang_olahraga }}</td>
                                        <td>
                                            <span class="badge badge-{{ $lap->kelas_status }}">
                                                {{ $lap->label_status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="dashboard-col-side">
                <div class="card permission-card">
                    <div class="card-title-row">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        <h4>Ringkasan Hak Akses Anda</h4>
                    </div>
                    <ul class="permission-list">
                        <li class="active">
                            <span class="icon-check">✓</span>
                            <div>
                                <strong>Akses Dashboard</strong>
                                <small>Melihat beranda dan ringkasan statistik</small>
                            </div>
                        </li>
                        <li class="active">
                            <span class="icon-check">✓</span>
                            <div>
                                <strong>Lihat Data Lapangan</strong>
                                <small>Melihat daftar & foto lapangan venue</small>
                            </div>
                        </li>
                        <li class="{{ auth()->user()->role === 'admin' ? 'active' : 'disabled' }}">
                            <span class="icon-check">{{ auth()->user()->role === 'admin' ? '✓' : '✕' }}</span>
                            <div>
                                <strong>Tambah Lapangan Baru</strong>
                                <small>Mendaftarkan fasilitas lapangan ke sistem</small>
                            </div>
                        </li>
                        <li class="{{ auth()->user()->role === 'admin' ? 'active' : 'disabled' }}">
                            <span class="icon-check">{{ auth()->user()->role === 'admin' ? '✓' : '✕' }}</span>
                            <div>
                                <strong>Ubah & Perbarui Data</strong>
                                <small>Memperbarui spesifikasi & status fisik</small>
                            </div>
                        </li>
                        <li class="{{ auth()->user()->role === 'admin' ? 'active' : 'disabled' }}">
                            <span class="icon-check">{{ auth()->user()->role === 'admin' ? '✓' : '✕' }}</span>
                            <div>
                                <strong>Upload & Ganti Foto</strong>
                                <small>Dokumentasi foto fasilitas lapangan</small>
                            </div>
                        </li>
                        <li class="{{ auth()->user()->role === 'admin' ? 'active' : 'disabled' }}">
                            <span class="icon-check">{{ auth()->user()->role === 'admin' ? '✓' : '✕' }}</span>
                            <div>
                                <strong>Hapus Data Lapangan</strong>
                                <small>Khusus hak akses Administrator</small>
                            </div>
                        </li>
                    </ul>

                    @if (auth()->user()->role !== 'admin')
                        <div class="alert-info" style="margin-top: 18px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                            <span>Akun Member memiliki hak akses baca (read-only) untuk ketersediaan dan informasi lapangan.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

</body>
</html>
