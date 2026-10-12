<?php
require 'koneksi.php';

$cari   = $_GET['cari'] ?? '';
$status = $_GET['status'] ?? '';

$sql = "SELECT l.*, a.nama_area
        FROM lapangans l
        JOIN areas a ON a.id = l.area_id
        WHERE (l.nama_lapangan LIKE ? OR l.kode LIKE ?)
          AND (? = '' OR l.status_fisik = ?)
        ORDER BY l.id DESC";
$stmt = $db->prepare($sql);
$stmt->execute(["%$cari%", "%$cari%", $status, $status]);
$data = $stmt->fetchAll();

$tersedia = $db->query('SELECT nama_lapangan FROM lapangans ORDER BY nama_lapangan')->fetchAll(PDO::FETCH_COLUMN);

$daftarPesan = [
    'tambah' => 'Lapangan berhasil ditambahkan.',
    'ubah'   => 'Lapangan berhasil diperbarui.',
    'hapus'  => 'Lapangan berhasil dihapus.',
];
$pesan = $daftarPesan[$_GET['pesan'] ?? ''] ?? '';

$judulTab = 'Data Lapangan';
require 'header.php';
?>
  <div class="judul">
    <h1>Data lapangan</h1>
    <a class="tombol utama" href="form-lapangan.php">Tambah lapangan</a>
  </div>

  <?php if ($pesan): ?>
    <div class="pesan"><?= e($pesan) ?></div>
  <?php endif; ?>

  <form class="cari" method="get">
    <input name="cari" value="<?= e($cari) ?>" placeholder="Cari nama atau kode lapangan">
    <select name="status">
      <option value="">Semua status</option>
      <?php foreach ($statusFisik as $nilai => $label): ?>
        <option value="<?= $nilai ?>" <?= pilih($status, $nilai) ?>><?= $label ?></option>
      <?php endforeach; ?>
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
        <?php if (!$data): ?>
          <tr><td colspan="8" class="kosong">Belum ada data lapangan.</td></tr>
        <?php endif; ?>

        <?php foreach ($data as $l): ?>
        <tr>
          <td><?= e($l['kode']) ?></td>
          <td><?= e($l['nama_lapangan']) ?></td>
          <td><?= e($l['nama_area']) ?></td>
          <td><?= e($l['cabang_olahraga']) ?></td>
          <td><?= e($permukaan[$l['jenis_permukaan']]) ?></td>
          <td><?= e($l['panjang'] + 0) ?> x <?= e($l['lebar'] + 0) ?> m</td>
          <td><span class="lencana <?= $kelasStatus[$l['status_fisik']] ?>"><?= e($statusFisik[$l['status_fisik']]) ?></span></td>
          <td>
            <a class="tombol kecil" href="form-lapangan.php?id=<?= $l['id'] ?>">Edit</a>
            <a class="tombol kecil merah" href="hapus-lapangan.php?id=<?= $l['id'] ?>">Hapus</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
