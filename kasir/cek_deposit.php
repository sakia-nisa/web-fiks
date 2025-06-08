<?php
require_once '../helper/connection.php';

if (isset($_GET['nama'])) {
    $nama = mysqli_real_escape_string($connection, $_GET['nama']);
    
    // Cari ID pelanggan berdasarkan nama
    $pelanggan = mysqli_query($connection, "SELECT id_pelanggan FROM pelanggan WHERE nama = '$nama' LIMIT 1");
    if ($row = mysqli_fetch_assoc($pelanggan)) {
        $id = $row['id_pelanggan'];

        // Hitung total saldo deposito
        $deposit = mysqli_query($connection, "SELECT 
            COALESCE(SUM(deposit_masuk),0) - COALESCE(SUM(deposit_keluar),0) as saldo 
            FROM deposit WHERE id_pelanggan = '$id'");

        $d = mysqli_fetch_assoc($deposit);
        $saldo = $d['saldo'];

        echo json_encode([
            'ada' => $saldo > 0,
            'deposito' => number_format($saldo, 2),
            'id_pelanggan' => $id
        ]);
    } else {
        echo json_encode(['ada' => false]);
    }
}
?>
