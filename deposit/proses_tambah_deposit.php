<?php
require_once '../helper/connection.php';

$namaLama = $_POST['namaLama'];
$jumlah = $_POST['deposito'];

if ($jumlah <= 0) {
    die('Jumlah deposit tidak valid.');
}

$query = "SELECT id_pelanggan FROM pelanggan WHERE nama = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $namaLama);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id_pelanggan = $row['id_pelanggan'];

    $update_query = "UPDATE pelanggan SET deposito = deposito + ? WHERE id_pelanggan = ?";
    $update_stmt = $connection->prepare($update_query);
    $update_stmt->bind_param("ds", $jumlah, $id_pelanggan);

    if ($update_stmt->execute()) {
        header("Location: ../dashboard/index.php");
        exit;
    } else {
        echo "Gagal menambahkan deposit: " . $update_stmt->error;
    }

    $update_stmt->close();
} else {
    echo "Pelanggan tidak ditemukan.";
}

$stmt->close();
$connection->close();
?>
