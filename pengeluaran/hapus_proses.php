<?php
require_once '../helper/connection.php';
session_start();

// Ambil ID dari parameter URL
$id = $_GET['id'];

// Validasi ID
if (!isset($id) || empty($id)) {
  $_SESSION['info'] = [
    'status' => 'error',
    'message' => 'ID pengeluaran tidak valid.'
  ];
  header('Location: index.php');
  exit;
}

// Cek apakah data exists
$check_query = mysqli_query($connection, "SELECT * FROM pengeluaran WHERE id_pengeluaran = '$id'");
if (mysqli_num_rows($check_query) == 0) {
  $_SESSION['info'] = [
    'status' => 'error',
    'message' => 'Data pengeluaran tidak ditemukan.'
  ];
  header('Location: index.php');
  exit;
}

// Hapus data
$query = mysqli_query($connection, "DELETE FROM pengeluaran WHERE id_pengeluaran = '$id'");

if ($query) {
  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Data pengeluaran berhasil dihapus.'
  ];
} else {
  $_SESSION['info'] = [
    'status' => 'error',
    'message' => 'Gagal menghapus data: ' . mysqli_error($connection)
  ];
}

header('Location: index.php');
exit;