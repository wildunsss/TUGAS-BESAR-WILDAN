<?php

$host   = '127.0.0.1';
$port   = 4306;      
$user   = 'root';
$pass   = '';
$namaDb = 'venue';

try {
    $db = new PDO("mysql:host=$host;port=$port;charset=utf8mb4", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Gagal terhubung ke MySQL. Pastikan MySQL menyala dan port benar. Pesan: ' . $e->getMessage());
}

$db->exec("CREATE DATABASE IF NOT EXISTS $namaDb");
$db->exec("USE $namaDb");

$db->exec("CREATE TABLE IF NOT EXISTS areas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_area VARCHAR(100) NOT NULL,
    tipe ENUM('indoor','outdoor') NOT NULL,
    deskripsi TEXT
) ENGINE=InnoDB");

$db->exec("CREATE TABLE IF NOT EXISTS lapangans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    area_id INT NOT NULL,
    kode VARCHAR(20) NOT NULL UNIQUE,
    nama_lapangan VARCHAR(100) NOT NULL,
    cabang_olahraga VARCHAR(50) NOT NULL,
    jenis_permukaan ENUM('rumput_alami','rumput_sintetis','vinyl','parket','semen','karpet') NOT NULL,
    panjang DECIMAL(6,2) NOT NULL,
    lebar DECIMAL(6,2) NOT NULL,
    status_fisik ENUM('baik','perlu_perbaikan','rusak') NOT NULL DEFAULT 'baik',
    keterangan TEXT,
    FOREIGN KEY (area_id) REFERENCES areas(id) ON DELETE CASCADE
) ENGINE=InnoDB");

if ($db->query('SELECT COUNT(*) FROM areas')->fetchColumn() == 0) {
    $db->exec("INSERT INTO areas (nama_area, tipe, deskripsi) VALUES
        ('Gedung A', 'indoor', 'Gedung olahraga tertutup'),
        ('Lapangan Terbuka', 'outdoor', 'Area luar ruangan')");
    $db->exec("INSERT INTO lapangans (area_id, kode, nama_lapangan, cabang_olahraga, jenis_permukaan, panjang, lebar, status_fisik) VALUES
        (1, 'BDM-01', 'Badminton 1', 'Badminton', 'vinyl', 13.4, 6.1, 'baik'),
        (2, 'FTS-01', 'Futsal 1', 'Futsal', 'rumput_sintetis', 25, 15, 'perlu_perbaikan')");
}

$permukaan = [
    'rumput_alami'    => 'Rumput alami',
    'rumput_sintetis' => 'Rumput sintetis',
    'vinyl'           => 'Vinyl',
    'parket'          => 'Parket',
    'semen'           => 'Semen',
    'karpet'          => 'Karpet',
];
$statusFisik = [
    'baik'            => 'Baik',
    'perlu_perbaikan' => 'Perlu perbaikan',
    'rusak'           => 'Rusak',
];
$kelasStatus = ['baik' => 'baik', 'perlu_perbaikan' => 'perbaikan', 'rusak' => 'rusak'];

function e($teks)
{
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}

function pilih($a, $b)
{
    return (string) $a === (string) $b ? 'selected' : '';
}
