<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judulTab }} - Sistem Venue</title>
    <link rel="stylesheet" href="{{ asset('css/styling.css') }}">
</head>
<body>

    <header class="app-navbar">
        <div class="nav-container">
            <div class="nav-left">
                <a href="{{ route('dashboard') }}" class="nav-brand">
                    <div class="brand-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <span>Sistem<strong>Venue</strong></span>
                </a>
                <nav class="nav-links">
                    <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
                    <a href="{{ route('lapangan.index') }}" class="nav-link active">Data Lapangan</a>
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
        <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <div>
                <p class="breadcrumb"><a href="{{ route('dashboard') }}">Dashboard</a> &gt; Data Lapangan</p>
                <h1>Data Fasilitas Lapangan</h1>
                <p>Kelola data fasilitas lapangan venue, jenis permukaan, dimensi ukuran, status fisik, dan foto.</p>
            </div>
            @if (auth()->user()->role === 'admin')
                <div>
                    <a href="{{ route('lapangan.create') }}" class="btn btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        Tambah Lapangan
                    </a>
                </div>
            @else
                <div>
                    <span class="badge-role role-member" style="font-size: 12.5px; padding: 6px 12px;">
                        Mode Lihat Saja (Member)
                    </span>
                </div>
            @endif
        </div>

        @if ($pesan)
            <div class="alert-success">{{ $pesan }}</div>
        @endif

        @if (!empty($galatAkses))
            <div class="alert-error">
                <strong>Hak Akses:</strong> {{ $galatAkses }}
            </div>
        @endif

        <form method="GET" action="{{ route('lapangan.index') }}">
            <div class="filter-box">
                <input type="text" name="cari" value="{{ $cari }}" placeholder="Cari nama atau kode lapangan...">

                <select name="status">
                    <option value="">Semua Status Fisik</option>
                    @foreach ($statusFisik as $nilai => $label)
                        <option value="{{ $nilai }}" {{ (string) $status === (string) $nilai ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="{{ route('lapangan.index') }}" class="btn-reset">Reset</a>
            </div>
        </form>

        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th style="width: 90px;">Foto</th>
                        <th>Kode</th>
                        <th>Nama Lapangan</th>
                        <th>Area</th>
                        <th>Cabang</th>
                        <th>Permukaan</th>
                        <th>Ukuran</th>
                        <th>Status</th>
                        @if (auth()->user()->role === 'admin')
                            <th style="text-align: right;">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if ($data->isEmpty())
                        <tr>
                            <td colspan="{{ auth()->user()->role === 'admin' ? 9 : 8 }}" style="text-align: center; color: var(--text-muted); padding: 32px;">
                                Belum ada data lapangan yang terdaftar.
                            </td>
                        </tr>
                    @else
                        @foreach ($data as $l)
                        <tr>
                            <td>
                                @if ($l->foto)
                                    <img src="{{ asset($l->foto) }}" alt="{{ $l->nama_lapangan }}" class="foto-lapangan">
                                @else
                                    <div class="foto-kosong">Tidak ada foto</div>
                                @endif
                            </td>
                            <td><strong>{{ $l->kode }}</strong></td>
                            <td>{{ $l->nama_lapangan }}</td>
                            <td>{{ $l->area->nama_area ?? '-' }}</td>
                            <td>{{ $l->cabang_olahraga }}</td>
                            <td>{{ $permukaan[$l->jenis_permukaan] ?? $l->jenis_permukaan }}</td>
                            <td>{{ $l->panjang + 0 }} x {{ $l->lebar + 0 }} m</td>
                            <td>
                                <span class="lencana-{{ $kelasStatus[$l->status_fisik] ?? 'baik' }}">
                                    {{ $statusFisik[$l->status_fisik] ?? $l->status_fisik }}
                                </span>
                            </td>
                            @if (auth()->user()->role === 'admin')
                            <td style="text-align: right; white-space: nowrap;">
                                <a href="{{ route('lapangan.edit', $l->id) }}" class="btn-sm">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    Edit
                                </a>
                                <form action="{{ route('lapangan.destroy', $l->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus lapangan {{ $l->nama_lapangan }} ({{ $l->kode }})?\nData yang dihapus tidak bisa dikembalikan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-sm btn-sm-danger">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
