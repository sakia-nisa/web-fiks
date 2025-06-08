<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

// Total pelanggan
$q_total_pelanggan = mysqli_query($connection, "SELECT COUNT(*) as total FROM pelanggan");
$pelanggan_terdaftar = mysqli_fetch_assoc($q_total_pelanggan)['total'];

// Pelanggan masuk hari ini
$today = date('Y-m-d');
$q_pelanggan_hari_ini = mysqli_query($connection, "SELECT COUNT(*) as total FROM penjualan WHERE DATE(tanggal_masuk) = '$today'");
$pelanggan_hari_ini = mysqli_fetch_assoc($q_pelanggan_hari_ini)['total'];

// Penghasilan hari ini
$q_penghasilan_hari_ini = mysqli_query($connection, "SELECT SUM(total) as total FROM penjualan WHERE DATE(tanggal_masuk) = '$today'");
$penghasilan_hari_ini = mysqli_fetch_assoc($q_penghasilan_hari_ini)['total'] ?? 0;

// Data pegawai
$pegawai = mysqli_query($connection, "
  SELECT 
    pegawai.*, 
    cabang.nama_cabang,
    users.total_pengerjaan
  FROM pegawai
  JOIN cabang ON pegawai.id_cabang = cabang.id_cabang
  LEFT JOIN users ON users.id_pegawai = pegawai.id_pegawai
");
?>

<section class="section">
  <div class="section-header">
    <h1>Dashboard Admin</h1>
  </div>
  <div class="container mt-4">
    <div class="row mb-4">
      <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
          <div class="card-body">
            <h5 class="card-title">Pelanggan Terdaftar</h5>
            <p class="card-text fs-4"><?php echo $pelanggan_terdaftar; ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
          <div class="card-body">
            <h5 class="card-title">Pelanggan Masuk: Hari Ini</h5>
            <p class="card-text fs-4"><?php echo $pelanggan_hari_ini; ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-white bg-warning mb-3">
          <div class="card-body">
            <h5 class="card-title">Penghasilan Hari Ini</h5>
            <p class="card-text fs-4">Rp <?php echo number_format($penghasilan_hari_ini, 0, ',', '.'); ?></p>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h5>Data Pegawai</h5>
        <table class="table table-bordered table-sm">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Cabang</th>
              <th>Total Pengerjaan</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($p = mysqli_fetch_assoc($pegawai)) { ?>
              <tr>
                <td><?php echo $p['nama_pegawai']; ?></td>
                <td><?php echo $p['nama_cabang']; ?></td>
                <td><?php echo $p['total_pengerjaan']; ?></td>
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
