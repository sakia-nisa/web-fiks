<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$result = mysqli_query($connection, "
  SELECT penjualan.*, penjualan_detail.estimasi_pengambilan, pelanggan.nama
  FROM penjualan
  JOIN penjualan_detail ON penjualan.id_penjualan = penjualan_detail.id_penjualan
  JOIN pelanggan ON penjualan.id_pelanggan = pelanggan.id_pelanggan
  WHERE penjualan_detail.estimasi_pengambilan IS NOT NULL
    AND penjualan_detail.status != 'selesai'
  ORDER BY penjualan_detail.estimasi_pengambilan DESC
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
                  <th>Pembayaran</th>
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
                    <td><?= $data['nama'] ?></td>
                    <td><?= $data['cabang'] ?></td>
                    <td><?= $data['tanggal_masuk'] ?></td>
                    <td><?= $data['jumlah_pakaian'] ?></td>
                    <td><?= $data['pembayaran']?></td>
                    <td><?= $data['sub_pembayaran'] ?></td>
                    <td><?= $data['diskon'] ?></td>
                    <td><?= $data['cash'] ?></td>
                    <td><?= $data['total'] ?></td>
                    <td>
                      <div style="display: flex; gap: 10px; justify-content: center; align-items: center;">
                        <a class="btn btn-sm btn-info mb-md-0 mb-1" href="edit.php?id_penjualan=<?= $data['id_penjualan'] ?>">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a class="btn btn-sm btn-dark" href="../penjualan/selesaikan.php?id_penjualan=<?= $data['id_penjualan'] ?>" onclick="return confirm('Tandai pesanan ini sebagai selesai?')">
                        <i class="fas fa-check"></i>
                      </a>
                      </div>
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