<?php
require_once '../helper/connection.php';
session_start();

$id_pengeluaran     = $_POST['id_pengeluaran'];
$tanggal            = $_POST['tanggal'];
$kode_pengeluaran   = $_POST['kode_pengeluaran'];
$id_cabang          = $_POST['id_cabang'];
$nama_pengeluaran   = $_POST['nama_pengeluaran'];
$jumlah_pengeluaran = $_POST['jumlah_pengeluaran'];
$keterangan         = $_POST['keterangan'];

$query = mysqli_query($connection, "
  UPDATE pengeluaran SET 
    tanggal = '$tanggal',
    kode_pengeluaran = '$kode_pengeluaran',
    id_cabang = '$id_cabang',
    nama_pengeluaran = '$nama_pengeluaran',
    jumlah_pengeluaran = '$jumlah_pengeluaran',
    keterangan = '$keterangan'
  WHERE id_pengeluaran = '$id_pengeluaran'
");

if ($query) {
  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Data pengeluaran berhasil diupdate.'
  ];
} else {
  $_SESSION['info'] = [
    'status' => 'error',
    'message' => 'Gagal mengupdate data: ' . mysqli_error($connection)
  ];
}

header('Location: index.php');
exit;