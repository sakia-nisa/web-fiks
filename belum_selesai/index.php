<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$result = mysqli_query($connection, "
  SELECT 
    transaksi.*, 
    pelanggan.nama AS nama_pelanggan, 
    cabang.nama_cabang 
  FROM transaksi
  JOIN pelanggan ON transaksi.id_pelanggan = pelanggan.id_pelanggan
  JOIN cabang ON transaksi.id_cabang = cabang.id_cabang
");
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Data Transaksi Belum Selesai</h1>
    <a href="./create.php" class="btn btn-primary">Tambah Data</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="table-1">
              <thead>
                <tr>
                  <th>No Transaksi</th>
                  <th>Nama Pelanggan</th>
                  <th>Cabang</th>
                  <th>Tanggal Masuk</th>
                  <th>Estimasi Pengambilan</th>
                  <th>Status</th>
                  <th>Jenis Pembayaran</th>
                  <th>Sub Pembayaran</th>
                  <th>Diskon</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($data = mysqli_fetch_array($result)) :
                ?>

                  <tr>
                    <td><?= $data['id_transaksi'] ?></td>
                    <td><?= $data['nama_pelanggan'] ?></td>
                    <td><?= $data['nama_cabang'] ?></td>
                    <td><?= $data['tanggal_masuk'] ?></td>
                    <td><?= $data['estimasi_pengambilan'] ?></td>
                    <td><?= $data['status'] ?></td>
                    <td><?= $data['jenis_pembayaran'] ?></td>
                    <td><?= $data['sub_pembayaran'] ?></td>
                    <td><?= $data['diskon'] ?></td>
                    <td><?= $data['total'] ?></td>
                  </tr>

                <?php
                endwhile;
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>
<!-- Page Specific JS File -->
<?php
if (isset($_SESSION['info'])) :
  if ($_SESSION['info']['status'] == 'success') {
?>
    <script>
      iziToast.success({
        title: 'Sukses',
        message: `<?= $_SESSION['info']['message'] ?>`,
        position: 'topCenter',
        timeout: 5000
      });
    </script>
  <?php
  } else {
  ?>
    <script>
      iziToast.error({
        title: 'Gagal',
        message: `<?= $_SESSION['info']['message'] ?>`,
        timeout: 5000,
        position: 'topCenter'
      });
    </script>
<?php
  }

  unset($_SESSION['info']);
  $_SESSION['info'] = null;
endif;
?>
<script src="../assets/js/page/modules-datatables.js"></script>