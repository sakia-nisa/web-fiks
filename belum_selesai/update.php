<?php
session_start();
require_once '../helper/connection.php';

$id_penjualan = $_POST['id_penjualan'];
$id_pelanggan = $_POST['id_pelanggan'];
$cabang = $_POST['cabang'];
$tanggal_masuk = $_POST['tanggal_masuk'];
$jumlah_pakaian = $_POST['jumlah_pakaian'];
$pembayaran = $_POST['pembayaran'] ?? null;
$sub_pembayaran = $_POST['sub_pembayaran'] ?? null;
$diskon = $_POST['diskon'];
$cash = $_POST['cash'];
$total = $_POST['total'];

$query = mysqli_query($connection, "UPDATE penjualan SET id_penjualan = '$id_penjualan', id_pelanggan = '$id_pelanggan', cabang = '$cabang', 
tanggal_masuk = '$tanggal_masuk', jumlah_pakaian = '$jumlah_pakaian', pembayaran = '$pembayaran', sub_pembayaran = '$sub_pembayaran', 
diskon = '$diskon', cash = '$cash', total = '$total' WHERE id_penjualan = '$id_penjualan'");
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