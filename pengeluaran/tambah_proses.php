<?php
require_once '../helper/connection.php';
session_start();

$tanggal            = $_POST['tanggal'];
$kode_pengeluaran   = $_POST['kode_pengeluaran'];
$id_cabang          = $_POST['id_cabang'];
$nama_pengeluaran   = $_POST['nama_pengeluaran'];
$jumlah_pengeluaran = $_POST['jumlah_pengeluaran'];
$keterangan         = $_POST['keterangan'];

$query = mysqli_query($connection, "
  INSERT INTO pengeluaran (tanggal, kode_pengeluaran, id_cabang, nama_pengeluaran, jumlah_pengeluaran, keterangan)
  VALUES ('$tanggal', '$kode_pengeluaran', '$id_cabang', '$nama_pengeluaran', '$jumlah_pengeluaran', '$keterangan')
");

if ($query) {
  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Data pengeluaran berhasil ditambahkan.'
  ];
} else {
  $_SESSION['info'] = [
    'status' => 'error',
    'message' => 'Gagal menambahkan data: ' . mysqli_error($connection)
  ];
}

header('Location: index.php');
exit;
