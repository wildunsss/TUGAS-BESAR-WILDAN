<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $judulTab }}</title>
<link rel="stylesheet" href="{{ asset('style-crud.css') }}">
</head>
<body>

<header class="atas">
  <div class="isi">
    <div class="merek">Sistem Venue</div>
    @if (!empty($tersedia) && count($tersedia) > 0)
    <div class="tersedia">
      <span>Lapangan tersedia:</span>
      @foreach ($tersedia as $nama)
        <b>{{ $nama }}</b>
      @endforeach
    </div>
    @endif

    <div class="baris-pengguna">
      <div class="info-pengguna">
        <span>Masuk sebagai: <strong>{{ Auth::user()->name ?? 'Admin' }}</strong></span>
        <span class="lencana-peran peran-admin">Admin</span>
      </div>
      <form action="{{ route('logout') }}" method="post" style="margin: 0;">
        @csrf
        <button type="submit" class="tombol-logout">Logout</button>
      </form>
    </div>
  </div>
</header>

<div class="wadah">
  <div class="judul">
    <h1>{{ $id ? 'Edit' : 'Tambah' }} lapangan</h1>
  </div>

  @if (!empty($galat) && count($galat) > 0)
    <div class="galat">
      <ul>
        @foreach ($galat as $pesanGalat)
          <li>{{ $pesanGalat }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form class="form-kartu" method="post" action="{{ $id ? route('lapangan.update', $id) : route('lapangan.store') }}" enctype="multipart/form-data">
    @csrf
    @if ($id)
      @method('PUT')
    @endif
    <input type="hidden" name="id" value="{{ $id }}">
    <div class="kolom">

      <div class="penuh">
        <label for="area_id">Area</label>
        <select id="area_id" name="area_id">
          <option value="">-- Pilih area --</option>
          @foreach ($areas as $a)
            <option value="{{ $a->id }}" {{ (string) $f['area_id'] === (string) $a->id ? 'selected' : '' }}>
              {{ $a->nama_area }} ({{ $a->tipe }})
            </option>
          @endforeach
        </select>
      </div>

      <div>
        <label for="kode">Kode lapangan</label>
        <input id="kode" name="kode" value="{{ $f['kode'] }}" placeholder="Contoh: FTS-02">
      </div>

      <div>
        <label for="nama_lapangan">Nama lapangan</label>
        <input id="nama_lapangan" name="nama_lapangan" value="{{ $f['nama_lapangan'] }}">
      </div>

      <div>
        <label for="cabang_olahraga">Cabang olahraga</label>
        <input id="cabang_olahraga" name="cabang_olahraga" value="{{ $f['cabang_olahraga'] }}" placeholder="Futsal, Badminton, Basket">
      </div>

      <div>
        <label for="jenis_permukaan">Jenis rumput / lantai</label>
        <select id="jenis_permukaan" name="jenis_permukaan">
          @foreach ($permukaan as $nilai => $label)
            <option value="{{ $nilai }}" {{ (string) $f['jenis_permukaan'] === (string) $nilai ? 'selected' : '' }}>
              {{ $label }}
            </option>
          @endforeach
        </select>
      </div>

      <div>
        <label for="panjang">Panjang (m)</label>
        <input id="panjang" name="panjang" type="number" step="0.01" min="0" value="{{ $f['panjang'] }}">
      </div>

      <div>
        <label for="lebar">Lebar (m)</label>
        <input id="lebar" name="lebar" type="number" step="0.01" min="0" value="{{ $f['lebar'] }}">
      </div>

      <div class="penuh">
        <label for="status_fisik">Status fisik</label>
        <select id="status_fisik" name="status_fisik">
          @foreach ($statusFisik as $nilai => $label)
            <option value="{{ $nilai }}" {{ (string) $f['status_fisik'] === (string) $nilai ? 'selected' : '' }}>
              {{ $label }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="penuh">
        <label for="keterangan">Keterangan</label>
        <textarea id="keterangan" name="keterangan" rows="3">{{ $f['keterangan'] }}</textarea>
      </div>

      <div class="penuh">
        <label for="foto">Foto Lapangan</label>
        @if (!empty($f['foto']))
          <div style="margin-bottom: 8px;">
            <img src="{{ asset($f['foto']) }}" alt="Foto saat ini" style="max-width: 200px; max-height: 150px; border-radius: 6px; border: 1px solid #e1e5ec;">
            <div style="font-size: 12px; color: #667085; margin-top: 4px;">Foto saat ini. Upload baru untuk mengganti.</div>
          </div>
        @endif
        <input type="file" id="foto" name="foto" accept="image/jpeg,image/png,image/jpg,image/webp">
        <div style="font-size: 12px; color: #667085; margin-top: 4px;">Format: JPG, PNG, WEBP. Maks: 2MB</div>
      </div>

    </div>

    <div class="aksi">
      <button type="submit" class="tombol utama">Simpan lapangan</button>
      <a class="tombol" href="{{ route('lapangan.index') }}">Batal</a>
    </div>
  </form>
</div>
</body>
</html>
