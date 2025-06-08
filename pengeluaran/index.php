<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$result = mysqli_query($connection, "
  SELECT pengeluaran.*, cabang.nama_cabang
  FROM pengeluaran
  JOIN cabang ON pengeluaran.id_cabang = cabang.id_cabang
  ORDER BY pengeluaran.tanggal DESC
");
?>

<section class="section">
  <div class="section-header d-flex justify-content-between">
    <h1>Data Pengeluaran</h1>
    <a href="tambah.php" class="btn btn-primary">+ Tambah Pengeluaran</a>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="table-1">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Tanggal</th>
                  <th>Kode</th>
                  <th>Cabang</th>
                  <th>Nama Pengeluaran</th>
                  <th>Jumlah</th>
                  <th>Keterangan</th>
                  <th style="width: 150px;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($data = mysqli_fetch_array($result)) : ?>
                  <tr>
                    <td><?= $data['id_pengeluaran'] ?></td>
                    <td><?= date('d/m/Y', strtotime($data['tanggal'])) ?></td>
                    <td><?= $data['kode_pengeluaran'] ?></td>
                    <td><?= $data['nama_cabang'] ?></td>
                    <td><?= $data['nama_pengeluaran'] ?></td>
                    <td>Rp <?= number_format($data['jumlah_pengeluaran'], 0, ',', '.') ?></td>
                    <td><?= $data['keterangan'] ?: '-' ?></td>
                    <td>
                      <div class="btn-group" role="group" style="gap: 10px; justify-content: center; align-items: center;">
                        <!-- Tombol Edit -->
                        <a href="edit.php?id=<?= $data['id_pengeluaran'] ?>" class="btn btn-sm btn-warning" title="Edit">
                          <i class="fas fa-edit"></i>
                        </a>
                        <!-- Tombol Delete dengan konfirmasi -->
                        <a href="hapus.php?id=<?= $data['id_pengeluaran'] ?>" class="btn btn-sm btn-danger" title="Hapus">
                          <i class="fas fa-trash"></i>
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