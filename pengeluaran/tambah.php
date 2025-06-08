<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

// Ambil data cabang
$cabang_result = mysqli_query($connection, "SELECT * FROM cabang");

// Ambil kode terakhir dari database
$kode_query = mysqli_query($connection, "SELECT MAX(kode_pengeluaran) as kode_terakhir FROM pengeluaran");
$data_kode = mysqli_fetch_assoc($kode_query);
$kode_terakhir = $data_kode['kode_terakhir'];

// Proses kode berikutnya
if ($kode_terakhir) {
  $urutan = (int) substr($kode_terakhir, 3) + 1; // Ambil angka setelah "PG-"
} else {
  $urutan = 1;
}
$kode_pengeluaran_baru = 'PG-' . str_pad($urutan, 3, '0', STR_PAD_LEFT);
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Tambah Pengeluaran</h1>
    <a href="index.php" class="btn btn-secondary">Kembali</a>
  </div>

  <div class="section-body">
    <form action="tambah_proses.php" method="POST">
      <div class="form-group">
        <label for="tanggal">Tanggal</label>
        <input type="date" name="tanggal" id="tanggal" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="kode_pengeluaran">Kode Pengeluaran</label>
        <input type="text" name="kode_pengeluaran" id="kode_pengeluaran" class="form-control" value="<?= $kode_pengeluaran_baru ?>" readonly>
      </div>

      <div class="form-group">
        <label for="id_cabang">Cabang</label>
        <select name="id_cabang" id="id_cabang" class="form-control" required>
          <option value="">-- Pilih Cabang --</option>
          <?php while ($cabang = mysqli_fetch_assoc($cabang_result)) : ?>
            <option value="<?= $cabang['id_cabang'] ?>"><?= $cabang['nama_cabang'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="nama_pengeluaran">Nama Pengeluaran</label>
        <input type="text" name="nama_pengeluaran" id="nama_pengeluaran" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="jumlah_pengeluaran">Jumlah Pengeluaran</label>
        <input type="number" name="jumlah_pengeluaran" id="jumlah_pengeluaran" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="keterangan">Keterangan</label>
        <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</section>

<?php require_once '../layout/_bottom.php'; ?>
