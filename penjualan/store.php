<?php
session_start();
require_once '../helper/connection.php';

$id_transaksi = $_POST['id_transaksi'];
$id_pelanggan = $_POST['id_pelanggan'];
$id_cabang = $_POST['id_cabang'];
$tanggal_masuk = $_POST['tanggal_masuk'];
$estimasi_pengambilan = $_POST['estimasi_pengambilan'];
$status = $_POST['status'] ?? '';
$valid_status = ['belum diproses', 'selesai'];
    if (!in_array($status, $valid_status)) {
        $status = 'belum diproses';
    }
$jenis_pembayaran = $_POST['jenis_pembayaran'];
$sub_pembayaran = $_POST['sub_pembayaran'];
$diskon = $_POST['diskon'];
$total = $_POST['total'];

$query = mysqli_query($connection, "insert into transaksi(id_transaksi, id_pelanggan, id_cabang, tanggal_masuk, estimasi_pengambilan, status, jenis_pembayaran, sub_pembayaran, diskon, total) 
value('$id_transaksi', '$id_pelanggan', '$id_cabang', '$tanggal_masuk', '$estimasi_pengambilan', '$status', '$jenis_pembayaran', '$sub_pembayaran', '$diskon', '$total')");
if ($query) {
  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Berhasil menambah data'
  ];
  header('Location: ./index.php');
                                            } else {
                                              $_SESSION['info'] = [
                                                'status' => 'failed',
                                                'message' => mysqli_error($connection)
                                              ];
                                              header('Location: ./index.php');
                                            }