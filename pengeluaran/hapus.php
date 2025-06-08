<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

// Ambil ID dari parameter URL
$id = $_GET['id'];

// Ambil data pengeluaran berdasarkan ID
$pengeluaran_query = mysqli_query($connection, "
  SELECT p.*, c.nama_cabang 
  FROM pengeluaran p 
  LEFT JOIN cabang c ON p.id_cabang = c.id_cabang 
  WHERE p.id_pengeluaran = '$id'
");
$pengeluaran = mysqli_fetch_assoc($pengeluaran_query);

// Jika data tidak ditemukan, redirect ke index
if (!$pengeluaran) {
  header('Location: index.php');
  exit;
}
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Konfirmasi Hapus Pengeluaran</h1>
    <a href="index.php" class="btn btn-secondary">Kembali</a>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-header">
        <h4>Apakah Anda yakin ingin menghapus data berikut?</h4>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <table class="table table-borderless">
              <tr>
                <td><strong>Tanggal</strong></td>
                <td>: <?= date('d/m/Y', strtotime($pengeluaran['tanggal'])) ?></td>
              </tr>
              <tr>
                <td><strong>Kode Pengeluaran</strong></td>
                <td>: <?= $pengeluaran['kode_pengeluaran'] ?></td>
              </tr>
              <tr>
                <td><strong>Cabang</strong></td>
                <td>: <?= $pengeluaran['nama_cabang'] ?></td>
              </tr>
              <tr>
                <td><strong>Nama Pengeluaran</strong></td>
                <td>: <?= $pengeluaran['nama_pengeluaran'] ?></td>
              </tr>
              <tr>
                <td><strong>Jumlah</strong></td>
                <td>: Rp <?= number_format($pengeluaran['jumlah_pengeluaran'], 0, ',', '.') ?></td>
              </tr>
              <tr>
                <td><strong>Keterangan</strong></td>
                <td>: <?= $pengeluaran['keterangan'] ?: '-' ?></td>
              </tr>
            </table>
          </div>
        </div>
        
        <div class="alert alert-warning">
          <i class="fas fa-exclamation-triangle"></i>
          <strong>Peringatan!</strong> Data yang dihapus tidak dapat dikembalikan.
        </div>

        <div class="mt-4">
          <a href="hapus_proses.php?id=<?= $pengeluaran['id_pengeluaran'] ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda benar-benar yakin ingin menghapus data ini?')">
            <i class="fas fa-trash"></i> Ya, Hapus Data
          </a>
          <a href="index.php" class="btn btn-secondary">
            <i class="fas fa-times"></i> Batal
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once '../layout/_bottom.php'; ?>