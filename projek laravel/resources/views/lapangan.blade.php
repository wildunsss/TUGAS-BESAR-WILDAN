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
  <div class="garis-tepi"></div>
  <div class="garis-kotak-kiri"></div>
  <div class="garis-kotak-kanan"></div>
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
        <span>Masuk sebagai: <strong>{{ Auth::user()->name ?? 'Pengguna' }}</strong></span>
        <span class="lencana-peran {{ $currentRole === 'admin' ? 'peran-admin' : 'peran-member' }}">
          {{ $currentRole === 'admin' ? 'Admin' : 'Member' }}
        </span>
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
    <h1>Data lapangan</h1>
    @if ($currentRole === 'admin')
      <a class="tombol utama" href="{{ route('lapangan.create') }}">+ Tambah lapangan</a>
    @else
      <span class="lencana perbaikan" style="padding: 7px 14px; font-size: 13px;">
        🔒 Mode Member: Tambah, Edit & Hapus Dinonaktifkan
      </span>
    @endif
  </div>

  @if ($pesan)
    <div class="pesan">{{ $pesan }}</div>
  @endif

  @if (!empty($galatAkses))
    <div class="galat">
      <strong>Hak Akses:</strong> {{ $galatAkses }}
    </div>
  @endif

  <form class="cari" method="get" action="{{ route('lapangan.index') }}">
    <input name="cari" value="{{ $cari }}" placeholder="Cari nama atau kode lapangan">
    <select name="status">
      <option value="">Semua status</option>
      @foreach ($statusFisik as $nilai => $label)
        <option value="{{ $nilai }}" {{ (string) $status === (string) $nilai ? 'selected' : '' }}>{{ $label }}</option>
      @endforeach
    </select>
    <button class="tombol">Cari</button>
  </form>

  <div class="kartu">
    <table>
      <thead>
        <tr>
          <th>Foto</th>
          <th>Kode</th>
          <th>Nama</th>
          <th>Area</th>
          <th>Cabang</th>
          <th>Permukaan</th>
          <th>Ukuran</th>
          <th>Status</th>
          @if ($currentRole === 'admin')
            <th>Aksi</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @if ($data->isEmpty())
          <tr>
            <td colspan="{{ $currentRole === 'admin' ? 9 : 8 }}" class="kosong">Belum ada data lapangan.</td>
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
            <td>{{ $l->kode }}</td>
            <td>{{ $l->nama_lapangan }}</td>
            <td>{{ $l->area->nama_area ?? '-' }}</td>
            <td>{{ $l->cabang_olahraga }}</td>
            <td>{{ $permukaan[$l->jenis_permukaan] ?? $l->jenis_permukaan }}</td>
            <td>{{ $l->panjang + 0 }} x {{ $l->lebar + 0 }} m</td>
            <td><span class="lencana {{ $kelasStatus[$l->status_fisik] ?? 'baik' }}">{{ $statusFisik[$l->status_fisik] ?? $l->status_fisik }}</span></td>
            @if ($currentRole === 'admin')
            <td>
              <a class="tombol kecil" href="{{ route('lapangan.edit', $l->id) }}">Edit</a>
              <form action="{{ route('lapangan.destroy', $l->id) }}" method="post" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus lapangan {{ $l->nama_lapangan }} ({{ $l->kode }})?\nData yang dihapus tidak bisa dikembalikan.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="tombol kecil merah">Hapus</button>
              </form>
            </td>
            @endif
          </tr>
          @endforeach
        @endif
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
