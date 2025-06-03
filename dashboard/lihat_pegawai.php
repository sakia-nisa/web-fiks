<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$query = "SELECT * FROM users WHERE role = 'kasir' OR role = 'admin'";
$result = mysqli_query($connection, $query);
$no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    $id_user = $row['id_user'];

                    $q = "
                        SELECT COUNT(penjualan_detail.id_detail) AS total
                        FROM penjualan_detail
                        JOIN penjualan ON penjualan_detail.id_penjualan = penjualan.id_penjualan
                        WHERE penjualan.id_user = '$id_user'
                        AND DATE(penjualan_detail.estimasi_pengambilan) = CURDATE()
                        AND penjualan_detail.estimasi_pengambilan IS NOT NULL
                    ";
                    $res = mysqli_query($connection, $q);
                    $d = mysqli_fetch_assoc($res);
                    $total = $d['total'];
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <style>
        body {
        background-color: #f8f9fa;
        }
        .form-profile {
        max-width: 500px;
        margin: 30px auto;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgb(0 0 0 / 0.1);
        }
        .form-profile th {
        width: 40%;
        vertical-align: middle;
        }
    </style>
  </head>
  <body>
    <div class="form-profile">
        <h1 class="text-center">Data Pegawai</h1>
        <form>
            <table class="ms-3 me-3" cellpadding="8">
                <tr>
                    <th>ID Pegawai :</th>
                    <td><?= $no++; ?></td>
                </tr>
                <tr>
                    <th>Nama Pegawai </th>
                    <td><?= htmlspecialchars($row['username']); ?></td>
                </tr>
                <tr>
                    <th>Role </th>
                    <td><?= htmlspecialchars($row['role']); ?></td>
                </tr>
                <tr>
                    <th>Email </th>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                </tr>
                <tr>
                    <th>Total Pengerjaan </th>
                    <td><?= $total; ?></td>
                </tr>
            </table>
            <a href="./index.php" class="btn btn-primary ms-4">Kembali</a>
            <?php } ?>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  </body>
</html>
