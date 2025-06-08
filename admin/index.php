<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$sql = "SELECT p.id_penjualan, pl.nama AS nama_pelanggan, p.cabang, p.tanggal_masuk, 
               p.jumlah_pakaian, p.pembayaran, p.sub_pembayaran, p.diskon, p.cash, p.total
        FROM penjualan p
        JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan";
$result = mysqli_query($connection, $sql);
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>List Penjualan</h1>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="table-1">
              <thead>
                <tr>
                  <th>ID Penjualan</th>
                  <th>Pelanggan</th>
                  <th>Cabang</th>
                  <th>Tanggal Masuk</th>
                  <th>Jumlah Pakaian</th>
                  <th>Pembayaran</th>
                  <th>Sub Pembayaran</th>
                  <th>Diskon</th>
                  <th>Cash</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($data = mysqli_fetch_array($result)) :
                ?>

                  <tr>
                    <td><?= $data['id_penjualan'] ?></td>
                    <td><?= $data['nama_pelanggan'] ?></td>
                    <td><?= $data['cabang'] ?></td>
                    <td><?= $data['tanggal_masuk'] ?></td>
                    <td><?= $data['jumlah_pakaian']?></td>
                    <td><?= $data['pembayaran'] ?></td>
                    <td><?= $data['sub_pembayaran'] ?></td>
                    <td><?= $data['diskon'] ?></td>
                    <td><?= $data['cash']?></td>
                    <td><?= $data['total']?></td>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>