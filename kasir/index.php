<!-- File: index.php -->
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

  <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Berhasil!</strong> Data penjualan berhasil disimpan.
      <?php if (isset($_GET['id'])): ?>
        ID Penjualan: <?= htmlspecialchars($_GET['id']) ?>
      <?php endif; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Error!</strong> 
      <?php 
      if (isset($_GET['msg'])) {
        echo htmlspecialchars(urldecode($_GET['msg']));
      } else {
        echo 'Terjadi kesalahan dalam memproses data.';
      }
      ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>
  
  <div class="container">
    <!-- Pilih Layanan -->
    <div class="mb-3">
        <label for="layananSelect" class="form-label">Pilih Layanan</label>
        <select class="form-select" id="layananSelect" name="layanan">
            <option value="">-- Pilih Layanan --</option>
            <?php while ($row = mysqli_fetch_assoc($layanan)) { ?>
                <option value="<?= $row['id_layanan'] ?>"
                data-nama="<?= $row['nama_layanan'] ?>"
                data-harga="<?= $row['harga_per_kilo'] ?>"
                data-tipe="<?= $row['tipe'] ?>">
                <?= ucfirst($row['tipe']) ?> - <?= $row['nama_layanan'] ?>
            </option>
            <?php } ?>
        </select>
    </div>

    <!-- Tabel Layanan Dipilih -->
    <div class="table-responsive mb-4">
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
    </div>

    <!-- Form Input Penjualan -->
    <form id="penjualanForm" method="post" action="proses_penjualan.php">
      <!-- Hidden inputs untuk layanan -->
      <div id="hiddenInputs"></div>

      <div class="row mb-3">
        <div class="col-md-12">
          <label for="cabang" class="form-label">Cabang</label>
          <input type="text" name="cabang" id="cabang" class="form-control" required>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-12">
          <label class="form-label">Status Pelanggan</label>
          <select class="form-select" id="statusPelanggan" name="statusPelanggan">
            <option value="lama">Pelanggan Lama</option>
            <option value="baru">Pelanggan Baru</option>
          </select>
        </div>
      </div>

      <!-- Pelanggan Lama Form -->
      <div id="pelangganLamaForm" class="mb-3">
        <label for="namaLama" class="form-label">Nama Pelanggan</label>
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
      </div>

      <!-- Pelanggan Baru Form -->
      <div id="pelangganBaruForm" class="mb-3" style="display: none;">
        <div class="row">
          <div class="col-md-6 mb-2">
            <input type="text" name="nama_baru" id="nama_baru" class="form-control" placeholder="Nama Pelanggan">
          </div>
          <div class="col-md-6 mb-2">
            <input type="text" name="telepon" id="telepon" class="form-control" placeholder="Nomor Telepon">
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mb-2">
            <input type="email" name="email" id="email" class="form-control" placeholder="Email">
          </div>
          <div class="col-md-6 mb-2">
            <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat" rows="2"></textarea>
          </div>
        </div>
        <textarea name="catatan" id="catatan" class="form-control mb-2" placeholder="Catatan" rows="2"></textarea>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label for="tanggalMasuk" class="form-label">Tanggal Masuk</label>
          <input type="datetime-local" name="tanggal_masuk" id="tanggalMasuk" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label for="jumlah_pakaian" class="form-label">Jumlah Pakaian (pcs)</label>
          <input type="number" name="jumlah_pakaian" id="jumlah_pakaian" class="form-control" min="1" required>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Pembayaran</label>
          <select name="pembayaran" class="form-select" required>
            <option value="depan">Bayar di Depan</option>
            <option value="nanti">Bayar Nanti</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Sub Pembayaran</label>
          <select name="sub_pembayaran" class="form-select" required>
            <option value="edc">EDC</option>
            <option value="gopay">GoPay</option>
            <option value="tunai">Tunai</option>
            <option value="bca">BCA EC</option>
            <option value="deposit">Deposit</option>
          </select>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-4">
          <label class="form-label">Diskon</label>
          <input type="number" name="diskon" id="diskon" class="form-control" value="0" min="0" step="0.01">
        </div>
        <div class="col-md-4">
          <label class="form-label">Cash</label>
          <input type="number" name="cash" id="cash" class="form-control" value="0" min="0" step="0.01">
        </div>
        <div class="col-md-4">
          <label class="form-label">Total</label>
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
  const hiddenInputsDiv = document.getElementById('hiddenInputs');
  let layananCount = 0;

  // Set tanggal masuk ke sekarang
  document.addEventListener('DOMContentLoaded', function() {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    
    const currentDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
    document.getElementById('tanggalMasuk').value = currentDateTime;
  });

  // Update estimasi saat tanggal berubah
  document.getElementById('tanggalMasuk').addEventListener('change', function() {
    document.querySelectorAll('input[name="estimasi[]"]').forEach(input => {
      input.value = hitungEstimasi();
    });
    updateHiddenInputs();
  });

  // Tambah layanan ke tabel
  layananSelect.addEventListener('change', function () {
    const selected = this.options[this.selectedIndex];
    if (!selected.value) return;

    layananCount++;
    const nama = selected.getAttribute('data-nama');
    const harga = parseFloat(selected.getAttribute('data-harga'));
    const tipe = selected.getAttribute('data-tipe');
    
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${layananCount}</td>
      <td><input type="text" class="form-control estimasi-input" value="${hitungEstimasi()}" readonly></td>
      <td><input type="text" class="form-control servis-input" value="${nama}" readonly></td>
      <td>Kilo</td>
      <td><input type="number" class="form-control berat-input" value="1" min="0.1" step="0.1" required></td>
      <td><input type="number" class="form-control harga-input" value="${harga}" readonly></td>
      <td><input type="number" class="form-control total-input" value="${harga}" readonly></td>
      <td><button type="button" class="btn btn-sm btn-danger" onclick="hapusLayanan(this)">Hapus</button></td>
    `;
    
    layananTableBody.appendChild(row);
    
    // Reset select
    this.value = '';
    
    updateTotal();
    updateHiddenInputs();
  });

  // Event listener untuk perubahan berat
  document.addEventListener('input', function (e) {
    if (e.target.classList.contains('berat-input')) {
      const tr = e.target.closest('tr');
      const berat = parseFloat(e.target.value) || 0;
      const harga = parseFloat(tr.querySelector('.harga-input').value);
      const total = berat * harga;
      tr.querySelector('.total-input').value = total.toFixed(2);
      updateTotal();
      updateHiddenInputs();
    }
  });

  // Hapus layanan
  function hapusLayanan(button) {
    button.closest('tr').remove();
    updateTotal();
    updateHiddenInputs();
    
    // Update nomor urut
    const rows = layananTableBody.querySelectorAll('tr');
    rows.forEach((row, index) => {
      row.querySelector('td:first-child').textContent = index + 1;
    });
    layananCount = rows.length;
  }

  // Update total harga
  function updateTotal() {
    const totalInputs = document.querySelectorAll('.total-input');
    let total = 0;
    totalInputs.forEach(input => {
      total += parseFloat(input.value || 0);
    });
    
    const diskon = parseFloat(document.getElementById('diskon').value || 0);
    const finalTotal = total - diskon;
    
    document.getElementById('totalHarga').value = finalTotal.toFixed(2);
  }

  // Update hidden inputs untuk form submission
  function updateHiddenInputs() {
    hiddenInputsDiv.innerHTML = '';
    
    const estimasiInputs = document.querySelectorAll('.estimasi-input');
    const servisInputs = document.querySelectorAll('.servis-input');
    const beratInputs = document.querySelectorAll('.berat-input');
    
    estimasiInputs.forEach((input, index) => {
      const hiddenEstimasi = document.createElement('input');
      hiddenEstimasi.type = 'hidden';
      hiddenEstimasi.name = 'estimasi[]';
      hiddenEstimasi.value = input.value;
      hiddenInputsDiv.appendChild(hiddenEstimasi);
    });
    
    servisInputs.forEach((input, index) => {
      const hiddenServis = document.createElement('input');
      hiddenServis.type = 'hidden';
      hiddenServis.name = 'servis[]';
      hiddenServis.value = input.value;
      hiddenInputsDiv.appendChild(hiddenServis);
    });
    
    beratInputs.forEach((input, index) => {
      const hiddenBerat = document.createElement('input');
      hiddenBerat.type = 'hidden';
      hiddenBerat.name = 'berat[]';
      hiddenBerat.value = input.value;
      hiddenInputsDiv.appendChild(hiddenBerat);
    });
  }

  // Toggle form pelanggan
  document.getElementById('statusPelanggan').addEventListener('change', function () {
    const status = this.value;
    const pelangganLamaForm = document.getElementById('pelangganLamaForm');
    const pelangganBaruForm = document.getElementById('pelangganBaruForm');
    
    if (status === 'lama') {
      pelangganLamaForm.style.display = 'block';
      pelangganBaruForm.style.display = 'none';
      
      // Set required untuk pelanggan lama
      document.getElementById('namaLama').required = true;
      document.getElementById('nama_baru').required = false;
      document.getElementById('telepon').required = false;
      document.getElementById('alamat').required = false;
    } else {
      pelangganLamaForm.style.display = 'none';
      pelangganBaruForm.style.display = 'block';
      
      // Set required untuk pelanggan baru
      document.getElementById('namaLama').required = false;
      document.getElementById('nama_baru').required = true;
      document.getElementById('telepon').required = true;
      document.getElementById('alamat').required = true;
    }
  });

  // Hitung estimasi pengambilan (2 hari dari tanggal masuk)
  function hitungEstimasi() {
    const tglMasuk = document.getElementById('tanggalMasuk').value;
    if (!tglMasuk) return '';
    
    const date = new Date(tglMasuk);
    date.setDate(date.getDate() + 2);
    
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    
    return `${year}-${month}-${day}T${hours}:${minutes}`;
  }

  // Auto-fill ID pelanggan untuk pelanggan lama
  document.getElementById('namaLama').addEventListener('input', function() {
    const option = document.querySelector(`#listPelanggan option[value="${this.value}"]`);
    if (option) {
      document.getElementById('id_pelanggan').value = option.getAttribute('data-id');
    } else {
      document.getElementById('id_pelanggan').value = '';
    }
  });

  // Update total saat diskon berubah
  document.getElementById('diskon').addEventListener('input', updateTotal);

  // Validasi form sebelum submit
  document.getElementById('penjualanForm').addEventListener('submit', function(e) {
    const layananRows = layananTableBody.querySelectorAll('tr');
    if (layananRows.length === 0) {
      e.preventDefault();
      alert('Pilih minimal satu layanan!');
      return false;
    }
    
    updateHiddenInputs();
  });
</script>

<?php require_once '../layout/_bottom.php'; ?>