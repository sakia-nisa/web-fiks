<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$pelanggan_lama = mysqli_query($connection, "SELECT * FROM pelanggan");
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tambah Deposit</h1>
  </div>
<div class="container mt-5"> 
<form action="proses_tambah_deposit.php" method="POST">
  <label>Nama Pelanggan:</label>
  <input list="listPelanggan" name="namaLama" id="namaLama" class="form-control" autocomplete="off">
        <datalist id="listPelanggan">
          <?php 
          // Reset pointer untuk query pelanggan
          mysqli_data_seek($pelanggan_lama, 0);
          while ($p = mysqli_fetch_assoc($pelanggan_lama)) { ?>
            <option value="<?= $p['nama'] ?>" data-id="<?= $p['id_pelanggan'] ?>">
          <?php } ?>
        </datalist>
        <input type="hidden" name="id_pelanggan" id="id_pelanggan">

  <div class="form-group" id="deposito-container">
    <label for="deposito" class="form-label">Deposito</label>
    <input type="number" class="form-control" id="deposito" name="deposito" required>
  </div>

  <button type="submit" class="btn btn-primary">Tambah Deposit</button>
</form>
</div>
</section>
<?php
require_once '../layout/_bottom.php';
?>