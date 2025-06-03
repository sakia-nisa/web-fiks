<?php
require_once '../helper/connection.php';

header('Content-Type: application/json');

if (!isset($_GET['id_pelanggan'])) {
    echo json_encode(['saldo_deposit' => 0]);
    exit;
}

$id_pelanggan = intval($_GET['id_pelanggan']);
$query = "SELECT SUM(deposit_masuk - deposit_keluar) as saldo_deposit 
          FROM deposit 
          WHERE id_pelanggan = $id_pelanggan";
$result = mysqli_query($connection, $query);
$data = mysqli_fetch_assoc($result);

echo json_encode([
    'saldo_deposit' => floatval($data['saldo_deposit'] ?? 0)
]);