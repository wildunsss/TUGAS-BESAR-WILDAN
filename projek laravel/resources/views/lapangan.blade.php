<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $judulTab }}</title>
<link rel="stylesheet" href="{{ asset('style-crud.css') }}">
<style>
  .baris-akses {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    background: rgba(255, 255, 255, 0.15);
    padding: 10px 14px;
    border-radius: 8px;
    margin-top: 14px;
  }
  .info-peran {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
  }
  .lencana-peran {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 99px;
    font-weight: 700;
    font-size: 12px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
  }
  .peran-admin {
    background: #dcf5e6;
    color: #166534;
  }
  .peran-user {
    background: #fdf0c8;
    color: #8a5a00;
  }
  .tombol-switch {
    font-size: 13px;
    padding: 5px 12px;
    border: 1px solid rgba(255, 255, 255, 0.4);
    background: #fff;
    color: #1b2430;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
  }
  .tombol-switch:hover {
    background: #f0f2f5;
  }
</style>
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

    <div class="baris-akses">
      <div class="info-peran">
        <span>Hak Akses Saat Ini:</span>
        <span class="lencana-peran {{ $currentRole === 'admin' ? 'peran-admin' : 'peran-user' }}">
          {{ $currentRole === 'admin' ? '👑 Admin (CRUD Penuh)' : '👤 User (Hanya Lihat)' }}
        </span>
      </div>
      <form action="{{ route('switch.role') }}" method="post" style="margin: 0;">
        @csrf
        @if ($currentRole === 'admin')
          <input type="hidden" name="role" value="user">
          <button type="submit" class="tombol-switch">Ganti ke Peran User</button>
        @else
          <input type="hidden" name="role" value="admin">
          <button type="submit" class="tombol-switch">Ganti ke Peran Admin</button>
        @endif
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
        🔒 Mode Pengguna: Hak Akses Tambah, Edit & Hapus Dinonaktifkan
      </span>
    @endif
  </div>

  @if ($pesan)
    <div class="pesan">{{ $pesan }}</div>
  @endif

  @if (!empty($galatAkses))
    <div class="galat">
      <strong>Pemberitahuan Hak Akses:</strong> {{ $galatAkses }}
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
            <td colspan="{{ $currentRole === 'admin' ? 8 : 7 }}" class="kosong">Belum ada data lapangan.</td>
          </tr>
        @else
          @foreach ($data as $l)
          <tr>
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
