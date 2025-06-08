<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$id_pegawai = intval($_GET['id_pegawai'] ?? 0);
if ($id_pegawai <= 0) die('ID pegawai tidak valid.');

// Ambil data user berdasarkan id_pegawai
$query = "
  SELECT u.username, u.role, u.email, u.total_pengerjaan
  FROM users u
  WHERE u.id_pegawai = '$id_pegawai'
";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) die('Data pegawai tidak ditemukan.');

// Hitung ulang total pengerjaan hari ini dari detail transaksi
$q = "
  SELECT COUNT(pd.id_detail) AS total
  FROM penjualan_detail pd
  JOIN penjualan pj ON pd.id_penjualan = pj.id_penjualan
  WHERE pj.id_user = (
    SELECT id_user FROM users WHERE id_pegawai = '$id_pegawai'
  )
  AND DATE(pd.estimasi_pengambilan) = CURDATE()
  AND pd.estimasi_pengambilan IS NOT NULL
";
$res = mysqli_query($connection, $q);
$total = mysqli_fetch_assoc($res)['total'] ?? 0;
?>

<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body class="bg-light">
    <div class="container mt-5">
      <div class="card shadow">
        <div class="card-body">
          <h3 class="card-title mb-4">Detail Pegawai</h3>
          <p><strong>Nama:</strong> <?= htmlspecialchars($row['username']); ?></p>
          <p><strong>Role:</strong> <?= htmlspecialchars($row['role']); ?></p>
          <p><strong>Email:</strong> <?= htmlspecialchars($row['email']); ?></p>
          <p><strong>Total Pengerjaan Hari Ini:</strong> <?= $total; ?></p>
          <a href="./index.php" class="btn btn-sm btn-primary mt-2">Kembali</a>
        </div>
      </div>
    </div>
  </body>
</html>
