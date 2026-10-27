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
  </div>
</header>

<div class="wadah">
  <div class="judul">
    <h1>Data lapangan</h1>
    <a class="tombol utama" href="{{ route('lapangan.create') }}">Tambah lapangan</a>
  </div>

  @if ($pesan)
    <div class="pesan">{{ $pesan }}</div>
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
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @if ($data->isEmpty())
          <tr><td colspan="8" class="kosong">Belum ada data lapangan.</td></tr>
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
            <td>
              <a class="tombol kecil" href="{{ route('lapangan.edit', $l->id) }}">Edit</a>
              <form action="{{ route('lapangan.destroy', $l->id) }}" method="post" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus lapangan {{ $l->nama_lapangan }} ({{ $l->kode }})?\nData yang dihapus tidak bisa dikembalikan.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="tombol kecil merah">Hapus</button>
              </form>
            </td>
          </tr>
          @endforeach
        @endif
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
