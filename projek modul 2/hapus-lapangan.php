<?php
require 'koneksi.php';

$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);

$stmt = $db->prepare('SELECT * FROM lapangans WHERE id = ?');
$stmt->execute([$id]);
$l = $stmt->fetch();

if (!$l) {
    header('Location: lapangan.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db->prepare('DELETE FROM lapangans WHERE id = ?')->execute([$id]);
    header('Location: lapangan.php?pesan=hapus');
    exit;
}

$judulTab = 'Hapus Lapangan';
require 'header.php';
?>
  <div class="judul">
    <h1>Hapus lapangan</h1>
  </div>

  <form class="form-kartu" method="post">
    <p>Yakin ingin menghapus lapangan <b><?= e($l['nama_lapangan']) ?></b> (<?= e($l['kode']) ?>)?
       Data yang dihapus tidak bisa dikembalikan.</p>
    <input type="hidden" name="id" value="<?= $id ?>">
    <div class="aksi">
      <button class="tombol bahaya">Ya, hapus</button>
      <a class="tombol" href="lapangan.php">Batal</a>
    </div>
  </form>
</div>
</body>
</html>
