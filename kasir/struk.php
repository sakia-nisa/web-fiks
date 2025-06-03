<?php
require_once '../helper/connection.php';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) die('ID tidak valid!');

// Ambil data penjualan
$q = mysqli_query($connection, "SELECT penjualan.*, pelanggan.nama, pelanggan.nomor_telepon, pelanggan.alamat 
    FROM penjualan 
    LEFT JOIN pelanggan ON penjualan.id_pelanggan = pelanggan.id_pelanggan 
    WHERE penjualan.id_penjualan = '$id'");
$data = mysqli_fetch_assoc($q);
if (!$data) die('Data tidak ditemukan!');

// Ambil detail layanan
$details = [];
$q2 = mysqli_query($connection, "SELECT * FROM penjualan_detail WHERE id_penjualan = '$id'");
while ($row = mysqli_fetch_assoc($q2)) $details[] = $row;
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Struk Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <style>
        body { font-family: Arial, sans-serif; max-width: 400px; margin: 20px auto; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        td, th { border: 1px solid #ccc; padding: 4px 8px; }
        .right { text-align: right; }
        .center { text-align: center; }
        .no-border { border: none; }
        .btn-print { margin: 10px 0; display: block; width: 100%; }
    </style>
  </head>
  <body>
    <h2>Struk Pembayaran</h2>
    <table>
        <tr><td>Nama</td><td><?= htmlspecialchars($data['nama']) ?></td></tr>
        <tr><td>Telepon</td><td><?= htmlspecialchars($data['nomor_telepon']) ?></td></tr>
        <tr><td>Alamat</td><td><?= htmlspecialchars($data['alamat']) ?></td></tr>
        <tr><td>Cabang</td><td><?= htmlspecialchars($data['cabang']) ?></td></tr>
        <tr><td>Tanggal Masuk</td><td><?= htmlspecialchars($data['tanggal_masuk']) ?></td></tr>
        <tr><td>Metode Bayar</td><td><?= htmlspecialchars($data['pembayaran']) ?> (<?= htmlspecialchars($data['sub_pembayaran']) ?>)</td></tr>
    </table>
    <table>
        <tr>
            <th>Layanan</th>
            <th>Berat (kg)</th>
            <th>Estimasi</th>
        </tr>
        <?php foreach ($details as $d): ?>
        <tr>
            <td><?= htmlspecialchars($d['layanan']) ?></td>
            <td class="center"><?= number_format($d['berat'], 2) ?></td>
            <td><?= htmlspecialchars($d['estimasi_pengambilan']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <table>
        <tr><td class="right">Jumlah Pakaian</td><td class="right"><?= $data['jumlah_pakaian'] ?></td></tr>
        <tr><td class="right">Diskon</td><td class="right">Rp <?= number_format($data['diskon'], 0, ',', '.') ?></td></tr>
        <tr><td class="right">Total</td><td class="right"><b>Rp <?= number_format($data['total'], 0, ',', '.') ?></b></td></tr>
        <tr><td class="right">Cash</td><td class="right">Rp <?= number_format($data['cash'], 0, ',', '.') ?></td></tr>
        <tr><td class="right">Kembalian</td><td class="right">Rp <?= number_format($data['cash'] - $data['total'], 0, ',', '.') ?></td></tr>
    </table>
    <center>
        <a href="kirim_struk.php?id=<?= $id ?>" class="btn btn-primary">Kirim Struk</a>
        <button type="button" class="btn btn-primary" onclick="window.print()">Cetak Struk</button>
        <button class="btn btn-primary" onclick="history.back()">Kembali</button>
        <p>Terima Kasih Sudah Laundry Disini !</p>
    </center>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  </body>
</html>