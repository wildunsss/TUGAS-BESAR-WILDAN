<?php
require 'koneksi.php';

$id    = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
$areas = $db->query('SELECT * FROM areas ORDER BY nama_area')->fetchAll();
$galat = [];

$f = [
    'area_id' => '', 'kode' => '', 'nama_lapangan' => '', 'cabang_olahraga' => '',
    'jenis_permukaan' => 'rumput_alami', 'panjang' => '', 'lebar' => '',
    'status_fisik' => 'baik', 'keterangan' => '',
];

if ($id && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $stmt = $db->prepare('SELECT * FROM lapangans WHERE id = ?');
    $stmt->execute([$id]);
    $f = $stmt->fetch();
    if (!$f) {
        header('Location: lapangan.php');
        exit;
    }
    $f['panjang'] += 0; 
    $f['lebar']   += 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($f as $kolom => $isi) {
        $f[$kolom] = trim($_POST[$kolom] ?? '');
    }

    $cekArea = $db->prepare('SELECT id FROM areas WHERE id = ?');
    $cekArea->execute([$f['area_id']]);
    if (!$cekArea->fetch())                          $galat[] = 'Area wajib dipilih.';
    if ($f['kode'] === '')                           $galat[] = 'Kode wajib diisi.';
    if ($f['nama_lapangan'] === '')                  $galat[] = 'Nama lapangan wajib diisi.';
    if ($f['cabang_olahraga'] === '')                $galat[] = 'Cabang olahraga wajib diisi.';
    if (!isset($permukaan[$f['jenis_permukaan']]))   $galat[] = 'Jenis permukaan tidak valid.';
    if (!isset($statusFisik[$f['status_fisik']]))    $galat[] = 'Status fisik tidak valid.';
    if (!is_numeric($f['panjang']) || $f['panjang'] <= 0) $galat[] = 'Panjang harus angka lebih dari 0.';
    if (!is_numeric($f['lebar']) || $f['lebar'] <= 0)     $galat[] = 'Lebar harus angka lebih dari 0.';

    $cekKode = $db->prepare('SELECT id FROM lapangans WHERE kode = ? AND id <> ?');
    $cekKode->execute([$f['kode'], $id]);
    if ($cekKode->fetch()) $galat[] = 'Kode sudah dipakai lapangan lain.';

    if (!$galat) {
        $nilai = [
            $f['area_id'], $f['kode'], $f['nama_lapangan'], $f['cabang_olahraga'],
            $f['jenis_permukaan'], $f['panjang'], $f['lebar'], $f['status_fisik'], $f['keterangan'],
        ];

        if ($id) { 
            $nilai[] = $id;
            $db->prepare('UPDATE lapangans SET area_id=?, kode=?, nama_lapangan=?, cabang_olahraga=?,
                          jenis_permukaan=?, panjang=?, lebar=?, status_fisik=?, keterangan=? WHERE id=?')
               ->execute($nilai);
            header('Location: lapangan.php?pesan=ubah');
        } else {   
            $db->prepare('INSERT INTO lapangans (area_id, kode, nama_lapangan, cabang_olahraga,
                          jenis_permukaan, panjang, lebar, status_fisik, keterangan)
                          VALUES (?,?,?,?,?,?,?,?,?)')
               ->execute($nilai);
            header('Location: lapangan.php?pesan=tambah');
        }
        exit;
    }
}

$judulTab = ($id ? 'Edit' : 'Tambah') . ' Lapangan';
require 'header.php';
?>
  <div class="judul">
    <h1><?= $id ? 'Edit' : 'Tambah' ?> lapangan</h1>
  </div>

  <?php if ($galat): ?>
    <div class="galat">
      <ul>
        <?php foreach ($galat as $pesan): ?>
          <li><?= e($pesan) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form class="form-kartu" method="post">
    <input type="hidden" name="id" value="<?= $id ?>">
    <div class="kolom">

      <div class="penuh">
        <label for="area_id">Area</label>
        <select id="area_id" name="area_id">
          <option value="">-- Pilih area --</option>
          <?php foreach ($areas as $a): ?>
            <option value="<?= $a['id'] ?>" <?= pilih($f['area_id'], $a['id']) ?>><?= e($a['nama_area']) ?> (<?= $a['tipe'] ?>)</option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label for="kode">Kode lapangan</label>
        <input id="kode" name="kode" value="<?= e($f['kode']) ?>" placeholder="Contoh: FTS-02">
      </div>

      <div>
        <label for="nama_lapangan">Nama lapangan</label>
        <input id="nama_lapangan" name="nama_lapangan" value="<?= e($f['nama_lapangan']) ?>">
      </div>

      <div>
        <label for="cabang_olahraga">Cabang olahraga</label>
        <input id="cabang_olahraga" name="cabang_olahraga" value="<?= e($f['cabang_olahraga']) ?>" placeholder="Futsal, Badminton, Basket">
      </div>

      <div>
        <label for="jenis_permukaan">Jenis rumput / lantai</label>
        <select id="jenis_permukaan" name="jenis_permukaan">
          <?php foreach ($permukaan as $nilai => $label): ?>
            <option value="<?= $nilai ?>" <?= pilih($f['jenis_permukaan'], $nilai) ?>><?= $label ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label for="panjang">Panjang (m)</label>
        <input id="panjang" name="panjang" type="number" step="0.01" min="0" value="<?= e($f['panjang']) ?>">
      </div>

      <div>
        <label for="lebar">Lebar (m)</label>
        <input id="lebar" name="lebar" type="number" step="0.01" min="0" value="<?= e($f['lebar']) ?>">
      </div>

      <div class="penuh">
        <label for="status_fisik">Status fisik</label>
        <select id="status_fisik" name="status_fisik">
          <?php foreach ($statusFisik as $nilai => $label): ?>
            <option value="<?= $nilai ?>" <?= pilih($f['status_fisik'], $nilai) ?>><?= $label ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="penuh">
        <label for="keterangan">Keterangan</label>
        <textarea id="keterangan" name="keterangan" rows="3"><?= e($f['keterangan']) ?></textarea>
      </div>

    </div>

    <div class="aksi">
      <button class="tombol utama">Simpan lapangan</button>
      <a class="tombol" href="lapangan.php">Batal</a>
    </div>
  </form>
</div>
</body>
</html>
