<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tambah Data</h1>
    <a href="./index.php" class="btn btn-light">Kembali</a>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- // Form -->
          <form action="./store.php" method="POST">
            <table cellpadding="8" class="w-100">

              <tr>
                <td>No Transaksi</td>
                <td><input class="form-control" type="text" name="id_transaksi" size="20" required></td>
              </tr>

              <tr>
                <td>Nama Pelanggan</td>
                <td>
                  <select class="form-control" name="id_pelanggan" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    <?php
                    $result = mysqli_query($connection, "SELECT id_pelanggan, nama FROM pelanggan");
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value=\"{$row['id_pelanggan']}\">{$row['nama']}</option>";
                    }
                    ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Cabang</td>
                <td><input class="form-control" type="text" name="id_cabang" size="20" required></td>
              </tr>
              <tr>
                <td>Tanggal Masuk</td>
                <td><input class="form-control" type="datetime-local" name="tanggal_masuk" size="20" required></td>
              </tr>
              <tr>
                <td>Estimasi Pengambilan</td>
                <td><input class="form-control" type="datetime-local" name="estimasi_pengambilan" size="20" required></td>
              </tr>
              <tr>
                <td>Status</td>
                <td>
                  <select class="form-control" name="status" required>
                    <option value="">--Pilih Status--</option>
                    <option value="selesai">Selesai</option>
                    <option value="belum_selesai">Belum Selesai</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Jenis Pembayaran</td>
                <td><input class="form-control" type="text" name="jenis_pembayaran" size="20" required></td>
              </tr>
              <tr>
                <td>Sub Pembayaran</td>
                <td>
                  <select class="form-control" name="sub_pembayaran" required>
                    <option value="">--Pilih Sub pembayaran--</option>
                    <option value="tunai">Tunai</option>
                    <option value="gopay">Gopay</option>
                    <option value="deposit">Deposit</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Diskon</td>
                <td><input class="form-control" type="number" step="0" name="diskon" size="20" required></td>
              </tr>
              <tr>
                <td>Total</td>
                <td><input class="form-control" type="number" step="0" name="total" size="20" required></td>
              </tr>
              <tr>
                <td>
                  <input class="btn btn-primary" type="submit" name="proses" value="Simpan">
                  <input class="btn btn-danger" type="reset" name="batal" value="Bersihkan"></td>
              </tr>

            </table>
          </form>
        </div>
      </div>
    </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>