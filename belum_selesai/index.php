<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$result = mysqli_query($connection, "
  SELECT 
    penjualan.*, 
    pelanggan.nama AS nama_pelanggan, 
    cabang.nama_cabang 
  FROM penjualan
  JOIN pelanggan ON penjualan.id_pelanggan = pelanggan.id_pelanggan
  JOIN cabang ON penjualan.cabang = cabang.nama_cabang
");
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Data Transaksi Penjualan</h1>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="table-1">
              <thead>
                <tr>
                  <th>No Penjualan</th>
                  <th>Nama Pelanggan</th>
                  <th>Cabang</th>
                  <th>Tanggal Masuk</th>
                  <th>Jumlah Pakaian</th>
                  <th>Status Pembayaran</th>
                  <th>Sub Pembayaran</th>
                  <th>Diskon</th>
                  <th>Cash</th>
                  <th>Total</th>
                  <th style="width: 150">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($data = mysqli_fetch_array($result)) : ?>
                  <tr>
                    <td><?= $data['id_penjualan'] ?></td>
                    <td><?= $data['nama_pelanggan'] ?></td>
                    <td><?= $data['nama_cabang'] ?></td>
                    <td><?= $data['tanggal_masuk'] ?></td>
                    <td><?= $data['jumlah_pakaian'] ?></td>
                    <td><?= ucfirst($data['pembayaran']) ?></td>
                    <td><?= $data['sub_pembayaran'] ?></td>
                    <td><?= $data['diskon'] ?></td>
                    <td><?= $data['cash'] ?></td>
                    <td><?= $data['total'] ?></td>
                    <td>
                      <a class="btn btn-sm btn-dark mb-md-0 mb-1" href="../penjualan/index.php?id_penjualan=<?= $data['id_penjualan'] ?>">
                        <i class="fas fa-check"></i>
                      </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
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
<?php if (isset($_SESSION['info'])) : ?>
  <script>
    iziToast.<?= $_SESSION['info']['status'] === 'success' ? 'success' : 'error' ?>({
      title: '<?= $_SESSION['info']['status'] === 'success' ? 'Sukses' : 'Gagal' ?>',
      message: `<?= $_SESSION['info']['message'] ?>`,
      position: 'topCenter',
      timeout: 5000
    });
  </script>
  <?php unset($_SESSION['info']); ?>
<?php endif; ?>

<script src="../assets/js/page/modules-datatables.js"></script>