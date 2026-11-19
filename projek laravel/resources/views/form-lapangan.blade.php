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
        <div class="page-header">
            <p class="breadcrumb">
                <a href="{{ route('dashboard') }}">Dashboard</a> &gt; 
                <a href="{{ route('lapangan.index') }}">Data Lapangan</a> &gt; 
                {{ $id ? 'Edit Lapangan' : 'Tambah Lapangan' }}
            </p>
            <h1>{{ $id ? 'Edit Data Lapangan' : 'Tambah Lapangan Baru' }}</h1>
            <p>Silakan isi informasi lengkap fasilitas lapangan venue di bawah ini.</p>
        </div>

        @if (!empty($galat) && count($galat) > 0)
            <div class="alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($galat as $pesanGalat)
                        <li>{{ $pesanGalat }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-card-wide" style="margin-top: 0;">
            <form method="POST" action="{{ $id ? route('lapangan.update', $id) : route('lapangan.store') }}" enctype="multipart/form-data">
                @csrf
                @if ($id)
                    @method('PUT')
                @endif
                <input type="hidden" name="id" value="{{ $id }}">

                <div class="form-grid-2">
                    <div class="col-span-2">
                        <label for="area_id">Pilih Area Venue</label>
                        <select id="area_id" name="area_id" required>
                            <option value="">-- Pilih Area --</option>
                            @foreach ($areas as $a)
                                <option value="{{ $a->id }}" {{ (string) $f['area_id'] === (string) $a->id ? 'selected' : '' }}>
                                    {{ $a->nama_area }} ({{ ucfirst($a->tipe) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="kode">Kode Lapangan</label>
                        <input type="text" id="kode" name="kode" value="{{ $f['kode'] }}" placeholder="Contoh: BDM-01" required>
                    </div>

                    <div>
                        <label for="nama_lapangan">Nama Lapangan</label>
                        <input type="text" id="nama_lapangan" name="nama_lapangan" value="{{ $f['nama_lapangan'] }}" placeholder="Contoh: Badminton 1" required>
                    </div>

                    <div>
                        <label for="cabang_olahraga">Cabang Olahraga</label>
                        <input type="text" id="cabang_olahraga" name="cabang_olahraga" value="{{ $f['cabang_olahraga'] }}" placeholder="Futsal, Badminton, Basket" required>
                    </div>

                    <div>
                        <label for="jenis_permukaan">Jenis Permukaan / Lantai</label>
                        <select id="jenis_permukaan" name="jenis_permukaan" required>
                            @foreach ($permukaan as $nilai => $label)
                                <option value="{{ $nilai }}" {{ (string) $f['jenis_permukaan'] === (string) $nilai ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="panjang">Panjang Lapangan (meter)</label>
                        <input type="number" id="panjang" name="panjang" step="0.01" min="0" value="{{ $f['panjang'] }}" placeholder="0.00" required>
                    </div>

                    <div>
                        <label for="lebar">Lebar Lapangan (meter)</label>
                        <input type="number" id="lebar" name="lebar" step="0.01" min="0" value="{{ $f['lebar'] }}" placeholder="0.00" required>
                    </div>

                    <div class="col-span-2">
                        <label for="status_fisik">Status Kondisi Fisik</label>
                        <select id="status_fisik" name="status_fisik" required>
                            @foreach ($statusFisik as $nilai => $label)
                                <option value="{{ $nilai }}" {{ (string) $f['status_fisik'] === (string) $nilai ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-2">
                        <label for="foto">Foto Lapangan</label>
                        @if (!empty($f['foto']))
                            <div style="margin-bottom: 10px; display: flex; align-items: center; gap: 14px;">
                                <img src="{{ asset($f['foto']) }}" alt="Foto saat ini" style="width: 120px; height: 80px; object-fit: cover; border-radius: var(--radius-sm); border: 1px solid var(--border-color);">
                                <small style="color: var(--text-muted);">Foto saat ini. Pilih file baru jika ingin mengganti.</small>
                            </div>
                        @endif
                        <input type="file" id="foto" name="foto" accept="image/jpeg,image/png,image/jpg,image/webp">
                        <small style="color: var(--text-muted); display: block; margin-top: 6px;">Format: JPG, PNG, WEBP (Maksimal 2 MB).</small>
                    </div>

                    <div class="col-span-2">
                        <label for="keterangan">Keterangan Tambahan (Opsional)</label>
                        <textarea id="keterangan" name="keterangan" rows="3" placeholder="Informasi tambahan fasilitas, pencahayaan, dll...">{{ $f['keterangan'] }}</textarea>
                    </div>
                </div>

                <div style="display: flex; gap: 12px; margin-top: 24px; padding-top: 18px; border-top: 1px solid var(--border-color);">
                    <button type="submit" class="btn btn-primary">
                        Simpan Data Lapangan
                    </button>
                    <a href="{{ route('lapangan.index') }}" class="btn btn-outline">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>

</body>
</html>
