<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$id_penjualan = $_GET['id_penjualan'];
$query = mysqli_query($connection, "SELECT * FROM penjualan WHERE id_penjualan='$id_penjualan'");
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Ubah Data</h1>
    <a href="./index.php" class="btn btn-light">Kembali</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- // Form -->
          <form action="./update.php" method="post">
            <?php
            while ($row = mysqli_fetch_array($query)) {
            ?>
              <input type="hidden" name="id_penjualan" value="<?= $row['id_penjualan'] ?>">
              <table cellpadding="8" class="w-100">
                <tr>
                  <td>ID</td>
                  <td><input class="form-control" type="number" name="id_penjualan" size="20" required value="<?= $row['id_penjualan'] ?>" disabled></td>
                </tr>
                <tr>
                  <td>Nama Pelanggan</td>
                  <td><input class="form-control" type="text" name="id_pelanggan" size="20" required value="<?= $row['id_pelanggan'] ?>"></td>
                </tr>
                <tr>
                  <td>Cabang</td>
                  <td><input class="form-control" type="text" name="cabang" size="20" required value="<?= $row['cabang'] ?>"></td>
                </tr>
                <td>Tanggal Masuk</td>
                  <td><input class="form-control" type="datetime-local" name="tanggal_masuk" size="20" required value="<?= $row['tanggal_masuk'] ?>"></td>
                </tr>
                <tr>
                  <td>Jumlah Pakaian</td>
                  <td><input class="form-control" type="number" name="jumlah_pakaian" size="20" required value="<?= $row['jumlah_pakaian'] ?>"></td>
                </tr>
                <tr>
                <td>Pembayaran </td>
                <td>
                  <select name="pembayaran" class="form-control" required>
                      <option value="" selected disabled>--Pilih Pembayaran--</option>
                      <option value="Depan">Depan</option>
                      <option value="Nanti">Nanti</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Sub Pembayaran</td>
                <td>
                  <select class="form-control" name="sub_pembayaran" id="sub_pembayaran" required>
                    <option value="" disabled selected>--Pilih Sub Pembayaran--</option>
                    <option value="edc">EDC</option>
                    <option value="gopay">Gopay</option>
                    <option value="tunai">Tunai</option>
                    <option value="bca ec">BCA EC</option>
                    <option value="deposit">Deposit</option>
                  </select>
                </td>
              </tr>
              <tr>
                  <td>Diskon</td>
                  <td><input class="form-control" type="number" name="diskon" size="20" required value="<?= $row['diskon'] ?>"></td>
                </tr>
                <tr>
                  <td>Cash</td>
                  <td><input class="form-control" type="number" name="cash" size="20" required value="<?= $row['cash'] ?>"></td>
                </tr>
                <tr>
                  <td>Total</td>
                  <td><input class="form-control" type="number" id="total" name="total" readonly size="20" required value="<?= $row['total'] ?>"></td>
                </tr>
                <tr>
                  <td>
                    <input class="btn btn-primary d-inline" type="submit" name="proses" value="Ubah">
                    <a href="./index.php" class="btn btn-danger ml-1">Batal</a>
                  <td>
                </tr>
              </table>

            <?php } ?>
          </form>
        </div>
      </div>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
          const diskonInput = document.querySelector('input[name="diskon"]');
          const totalInput = document.querySelector('input[name="total"]');

          const diskonAwal = parseInt(diskonInput.value) || 0;
          const totalAwal = parseInt(totalInput.value) || 0;

          diskonInput.addEventListener('input', function () {
              const diskonBaru = parseInt(diskonInput.value) || 0;
              const totalBaru = totalAwal + diskonAwal - diskonBaru;

              totalInput.value = totalBaru >= 0 ? totalBaru : 0;
          });
      });
    </script>

</section>
<?php
require_once '../layout/_bottom.php';
?>+