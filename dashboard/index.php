<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$q_total_pelanggan = mysqli_query($connection, "SELECT COUNT(*) as total FROM pelanggan");
$pelanggan_terdaftar = mysqli_fetch_assoc($q_total_pelanggan)['total'];
$today = date('Y-m-d');
$q_pelanggan_hari_ini = mysqli_query($connection, "SELECT COUNT(*) as total FROM penjualan WHERE DATE(tanggal_masuk) = '$today'");
$pelanggan_hari_ini = mysqli_fetch_assoc($q_pelanggan_hari_ini)['total'];
$deposit = $deposit = mysqli_query($connection, "SELECT deposit.*, pelanggan.nama FROM deposit JOIN pelanggan ON deposit.id_pelanggan = pelanggan.id_pelanggan");
$pegawai = mysqli_query($connection, "
  SELECT pegawai.*, cabang.nama_cabang, users.total_pengerjaan
  FROM pegawai
  JOIN cabang ON pegawai.id_cabang = cabang.id_cabang
  LEFT JOIN users ON users.id_pegawai = pegawai.id_pegawai
");


?>

<section class="section">
  <div class="section-header">
    <h1>Dashboard</h1>
  </div>
  <div class="container mt-4">
  <div class="row mb-4">
    <div class="col-md-6">
      <div class="card text-white bg-danger mb-3">
        <div class="card-body">
          <h5 class="card-title">Pelanggan Terdaftar</h5>
          <p class="card-text fs-4"><?php echo $pelanggan_terdaftar; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card text-white bg-danger mb-3">
        <div class="card-body">
          <h5 class="card-title">Pelanggan Masuk : Hari Ini</h5>
          <p class="card-text fs-4"><?php echo $pelanggan_hari_ini; ?></p>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <h5>Deposit Pelanggan</h5>
      <table class="table table-bordered table-sm">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Deposit Masuk</th>
            <th>Deposit Keluar</th>
            <th>Dilihat</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($d = mysqli_fetch_assoc($deposit)) { ?>
            <tr>
              <td><?php echo $d['nama']; ?></td>
              <td><?php echo $d['deposit_masuk']; ?></td>
              <td><?php echo $d['deposit_keluar']; ?></td>
              <td><i class="fa fa-eye"></i></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <div class="col-md-6">
      <h5>Data Pegawai</h5>
      <table class="table table-bordered table-sm">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Cabang</th>
            <th>Total Pengerjaan</th>
            <th>Lihat</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($p = mysqli_fetch_assoc($pegawai)) { ?>
            <tr>
              <td><?php echo $p['nama_pegawai']; ?></td>
              <td><?php echo $p['nama_cabang']; ?></td>
              <td><?php echo $p['total_pengerjaan']; ?></td>
              <td><a href="lihat_pegawai.php?id_pegawai=<?php echo $p['id_pegawai']; ?>" class="btn btn-sm btn-info">Lihat</a></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</section>

<?php
require_once '../layout/_bottom.php';
?>