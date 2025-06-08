<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

// Ambil ID dari parameter URL
$id = $_GET['id'];

// Ambil data pengeluaran berdasarkan ID
$pengeluaran_query = mysqli_query($connection, "SELECT * FROM pengeluaran WHERE id_pengeluaran = '$id'");
$pengeluaran = mysqli_fetch_assoc($pengeluaran_query);

// Jika data tidak ditemukan, redirect ke index
if (!$pengeluaran) {
  header('Location: index.php');
  exit;
}

// Ambil data cabang
$cabang_result = mysqli_query($connection, "SELECT * FROM cabang");
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Edit Pengeluaran</h1>
    <a href="index.php" class="btn btn-secondary">Kembali</a>
  </div>

  <div class="section-body">
    <form action="edit_proses.php" method="POST">
      <input type="hidden" name="id_pengeluaran" value="<?= $pengeluaran['id_pengeluaran'] ?>">
      
      <div class="form-group">
        <label for="tanggal">Tanggal</label>
        <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= $pengeluaran['tanggal'] ?>" required>
      </div>

      <div class="form-group">
        <label for="kode_pengeluaran">Kode Pengeluaran</label>
        <input type="text" name="kode_pengeluaran" id="kode_pengeluaran" class="form-control" value="<?= $pengeluaran['kode_pengeluaran'] ?>" readonly>
      </div>

      <div class="form-group">
        <label for="id_cabang">Cabang</label>
        <select name="id_cabang" id="id_cabang" class="form-control" required>
          <option value="">-- Pilih Cabang --</option>
          <?php while ($cabang = mysqli_fetch_assoc($cabang_result)) : ?>
            <option value="<?= $cabang['id_cabang'] ?>" <?= ($cabang['id_cabang'] == $pengeluaran['id_cabang']) ? 'selected' : '' ?>>
              <?= $cabang['nama_cabang'] ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="nama_pengeluaran">Nama Pengeluaran</label>
        <input type="text" name="nama_pengeluaran" id="nama_pengeluaran" class="form-control" value="<?= $pengeluaran['nama_pengeluaran'] ?>" required>
      </div>

      <div class="form-group">
        <label for="jumlah_pengeluaran">Jumlah Pengeluaran</label>
        <input type="number" name="jumlah_pengeluaran" id="jumlah_pengeluaran" class="form-control" value="<?= $pengeluaran['jumlah_pengeluaran'] ?>" required>
      </div>

      <div class="form-group">
        <label for="keterangan">Keterangan</label>
        <textarea name="keterangan" id="keterangan" class="form-control"><?= $pengeluaran['keterangan'] ?></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Update</button>
      <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</section>

<?php require_once '../layout/_bottom.php'; ?>