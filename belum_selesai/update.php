<?php
session_start();
require_once '../helper/connection.php';

$id_transaksi = $_POST['id_transaksi'];
$id_pelanggan = $_POST['id_pelanggan'];
$id_cabang = $_POST['id_cabang'];
$tanggal_masuk = $_POST['tanggal_masuk'];
$estimasi_pengambilan = $_POST['estimasi_pengambilan'];
$status = $_POST['status'];
$jenis_pembayaran = $_POST['jenis_pembayaran'];
$sub_pembayaran = $_POST['status_pembayaran'];
$diskon = $_POST['diskon'];
$total = $_POST['total'];

$query = mysqli_query($connection, "UPDATE transaksi SET id_transaksi = '$id_transaksi', id_pelanggan = '$id_pelanggan', id_cabang = '$id_cabang', 
tanggal_masuk = '$tanggal_masuk', estimasi_pengambilan = '$estimasi_pengambilan', status = '$status', jenis_pembayaran = '$jenis_pembayaran', sub_pembayaran = '$sub_pembayaran', 
diskon = '$diskon', total = $_POST['total'] WHERE id_transaksi = '$id_transaksi'");
if ($query) {
  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Berhasil mengubah data'
  ];
  header('Location: ./index.php');
} else {
  $_SESSION['info'] = [
    'status' => 'failed',
    'message' => mysqli_error($connection)
  ];
  header('Location: ./index.php');
}
