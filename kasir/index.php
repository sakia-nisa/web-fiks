<!-- File: kasir.php -->
<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

// Ambil data layanan untuk dropdown
$layanan = mysqli_query($connection, "SELECT * FROM layanan");

// Ambil data pelanggan lama
$pelanggan_lama = mysqli_query($connection, "SELECT * FROM pelanggan");
?>

<section class="section">
  <div class="section-header">
    <h1>Kasir</h1>
  </div>
  
  <div class="container">
    <div class="mb-3">
        <label for="layananSelect" class="form-label">Pilih Layanan</label>
        <select class="form-select" id="layananSelect" name="layanan">
            <option value="">-- Pilih Layanan --</option>
            <?php while ($row = mysqli_fetch_assoc($layanan)) { ?>
                <option value="<?= $row['id_layanan'] ?>"
                data-nama="<?= $row['nama_layanan'] ?>"
                data-harga="<?= $row['harga_per_kilo'] ?>">
                <?= ucfirst($row['tipe']) ?> - <?= $row['nama_layanan'] ?>
            </option>
            <?php } ?>
        </select>
    </div>

    <!-- Tabel Layanan Dipilih -->
    <table class="table table-bordered" id="layananTable">
      <thead>
        <tr>
          <th>No</th>
          <th>Estimasi Pengambilan</th>
          <th>Servis</th>
          <th>Satuan</th>
          <th>Berat</th>
          <th>Harga</th>
          <th>Total</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>

    <!-- Form Input Penjualan -->
    <form id="penjualanForm" method="post" action="proses_penjualan.php">
      <div class="mb-3">
        <label for="cabang" class="form-label">Cabang</label>
        <input type="text" name="cabang" id="cabang" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Status Pelanggan</label>
        <select class="form-select" id="statusPelanggan" name="statusPelanggan">
          <option value="lama">Pelanggan Lama</option>
          <option value="baru">Pelanggan Baru</option>
        </select>
      </div>

      <div id="pelangganLamaForm" class="mb-3">
        <label for="namaLama" class="form-label">Nama Pelanggan</label>
        <input list="listPelanggan" name="namaLama" id="namaLama" class="form-control">
        <datalist id="listPelanggan">
          <?php while ($p = mysqli_fetch_assoc($pelanggan_lama)) { ?>
            <option value="<?= $p['nama'] ?>" data-id="<?= $p['id_pelanggan'] ?>">
          <?php } ?>
        </datalist>
        <input type="hidden" name="id_pelanggan" id="id_pelanggan">
      </div>

      <div id="pelangganBaruForm" class="mb-3" style="display: none;">
        <input type="text" name="nama_baru" class="form-control mb-2" placeholder="Nama Pelanggan" required>
        <input type="text" name="telepon" class="form-control mb-2" placeholder="Nomor Telepon" required>
        <input type="email" name="email" class="form-control mb-2" placeholder="Email">
        <textarea name="alamat" class="form-control mb-2" placeholder="Alamat" required></textarea>
        <textarea name="catatan" class="form-control mb-2" placeholder="Catatan"></textarea>
      </div>

      <div class="mb-3">
        <label for="tanggalMasuk" class="form-label">Tanggal Masuk</label>
        <input type="datetime-local" name="tanggal_masuk" id="tanggalMasuk" class="form-control" required>
      </div>
    
      <div class="mb-3">
        <label for="jumlah_pakaian" class="form-label">Jumlah Pakaian (pcs)</label>
        <input type="number" name="jumlah_pakaian" id="jumlah_pakaian" class="form-control" min="1" required>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label>Pembayaran</label>
          <select name="pembayaran" class="form-select" required>
            <option value="depan">Bayar di Depan</option>
            <option value="nanti">Bayar Nanti</option>
          </select>
        </div>
        <div class="col-md-6 mb-3">
          <label>Sub Pembayaran</label>
          <select name="sub_pembayaran" class="form-select" required>
            <option value="edc">EDC</option>
            <option value="gopay">GoPay</option>
            <option value="tunai">Tunai</option>
            <option value="bca">BCA EC</option>
            <option value="deposit">Deposit</option>
          </select>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4 mb-3">
          <label>Diskon</label>
          <input type="number" name="diskon" class="form-control" value="0" min="0">
        </div>
        <div class="col-md-4 mb-3">
          <label>Cash</label>
          <input type="number" name="cash" class="form-control" value="0" min="0">
        </div>
        <div class="col-md-4 mb-3">
          <label>Total</label>
          <input type="number" name="total" class="form-control" id="totalHarga" readonly>
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</section>

<script>
  const layananSelect = document.getElementById('layananSelect');
  const layananTableBody = document.querySelector('#layananTable tbody');
  let layananCount = 0;

  // Update estimasi saat tanggal berubah
  document.getElementById('tanggalMasuk').addEventListener('change', function() {
    document.querySelectorAll('input[name="estimasi[]"]').forEach(input => {
      input.value = hitungEstimasi();
    });
  });

  layananSelect.addEventListener('change', function () {
    const selected = this.options[this.selectedIndex];
    if (!selected.value) return;

    layananCount++;
    const nama = selected.getAttribute('data-nama');
    const harga = parseInt(selected.getAttribute('data-harga'));
    const row = `
      <tr>
        <td>${layananCount}</td>
        <td><input type="text" name="estimasi[]" class="form-control" value="${hitungEstimasi()}" readonly></td>
        <td><input type="text" name="servis[]" class="form-control" value="${nama}" readonly></td>
        <td>Kilo</td>
        <td><input type="number" name="berat[]" class="form-control berat" value="1" min="0.1" step="0.1" required></td>
        <td><input type="number" class="form-control harga" value="${harga}" readonly></td>
        <td><input type="number" class="form-control total" value="${harga}" readonly></td>
        <td><button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove(); updateTotal()">Hapus</button></td>
      </tr>
    `;
    layananTableBody.insertAdjacentHTML('beforeend', row);
    updateTotal();
  });

  document.addEventListener('input', function (e) {
    if (e.target.classList.contains('berat')) {
      const tr = e.target.closest('tr');
      const berat = parseFloat(e.target.value) || 0;
      const harga = parseFloat(tr.querySelector('.harga').value);
      const total = berat * harga;
      tr.querySelector('.total').value = total;
      updateTotal();
    }
  });

  function updateTotal() {
    const totalInputs = document.querySelectorAll('.total');
    let total = 0;
    totalInputs.forEach(input => {
      total += parseFloat(input.value || 0);
    });
    document.getElementById('totalHarga').value = total;
  }

  document.getElementById('statusPelanggan').addEventListener('change', function () {
    const status = this.value;
    document.getElementById('pelangganLamaForm').style.display = status === 'lama' ? 'block' : 'none';
    document.getElementById('pelangganBaruForm').style.display = status === 'baru' ? 'block' : 'none';
  });

  function hitungEstimasi() {
    const tglMasuk = document.getElementById('tanggalMasuk').value;
    if (!tglMasuk) return ''; // jika belum dipilih
    const date = new Date(tglMasuk);
    date.setDate(date.getDate() + 2);
    const estimasi = date.toISOString().slice(0, 16); // format YYYY-MM-DDTHH:MM
    return estimasi;
  }

  // Tangkap perubahan nama pelanggan untuk dapatkan ID
  document.getElementById('namaLama').addEventListener('input', function() {
    const option = document.querySelector(`#listPelanggan option[value="${this.value}"]`);
    if (option) {
      document.getElementById('id_pelanggan').value = option.getAttribute('data-id');
    }
  });
</script>

<?php require_once '../layout/_bottom.php'; ?>