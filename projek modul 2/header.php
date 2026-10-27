<?php
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($judulTab) ?></title>
<link rel="stylesheet" href="style-crud.css">
</head>
<body>

<header class="atas">
  <div class="isi">
    <div class="merek">Sistem Venue</div>
    <?php if (!empty($tersedia)): ?>
    <div class="tersedia">
      <span>Lapangan tersedia:</span>
      <?php foreach ($tersedia as $nama): ?>
        <b><?= e($nama) ?></b>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</header>

<div class="wadah">
