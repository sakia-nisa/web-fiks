<?php
require_once '../helper/connection.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID penjualan tidak valid.');
}

$id_penjualan = intval($_GET['id']);
$query = "
    SELECT 
    pelanggan.nomor_telepon,
    penjualan.id_penjualan
    FROM penjualan
    JOIN pelanggan ON penjualan.id_pelanggan = pelanggan.id_pelanggan
    WHERE penjualan.id_penjualan = ?
";

$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "i", $id_penjualan);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) === 0) {
    die('Data penjualan tidak ditemukan.');
}

$data = mysqli_fetch_assoc($result);
$nomor = preg_replace('/[^0-9]/', '', $data['nomor_telepon']); // Hilangkan karakter selain angka

// Format nomor telepon ke format internasional (contoh: 0812xxxx -> 62812xxxx)
if (substr($nomor, 0, 1) === '0') {
    $nomor = '62' . substr($nomor, 1);
}

// Buat link struk
$link_struk = "https://yourdomain.com/kasir/struk.php?id=" . $id_penjualan; // Ganti dengan domain asli kamu
$pesan = urlencode("Halo, berikut adalah struk transaksi laundry Anda:\n$link_struk");

// Redirect ke WhatsApp
header("Location: https://wa.me/$nomor?text=$pesan");
exit;
?>
