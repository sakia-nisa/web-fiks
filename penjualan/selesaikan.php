<?php
ob_start(); // Tambahkan ini agar header() tetap bisa dipanggil walaupun ada output yang tidak sengaja
session_start();
require_once '../helper/connection.php';

$id_penjualan = $_GET['id_penjualan'];
$id_user = $_SESSION['login']['id_user'] ?? null;

if (!$id_user) {
  $_SESSION['info'] = [
    'status' => 'error',
    'message' => 'User tidak login.'
  ];
  header('Location: index.php');
  exit;
}

// Update status penjualan_detail menjadi "selesai"
$update = mysqli_query($connection, "
  UPDATE penjualan_detail 
  SET status = 'selesai' 
  WHERE id_penjualan = '$id_penjualan'
");

// Jika update berhasil, tambahkan total pengerjaan user
if ($update) {
  mysqli_query($connection, "
    UPDATE users 
    SET total_pengerjaan = total_pengerjaan + 1 
    WHERE id_user = '$id_user'
  ");

  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Pesanan ditandai selesai dan pengerjaan Anda tercatat.'
  ];
} else {
  $_SESSION['info'] = [
    'status' => 'error',
    'message' => 'Gagal menandai pesanan selesai.'
  ];
}

header('Location: ./index.php');
exit;

ob_end_flush(); // Tambahkan ini di akhir
?>
