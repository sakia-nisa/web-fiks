<?php
require_once '../helper/connection.php';

// Validasi input
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Akses tidak sah!');
}

// Ambil data dengan filter
$cabang           = mysqli_real_escape_string($connection, $_POST['cabang']);
$statusPelanggan  = mysqli_real_escape_string($connection, $_POST['statusPelanggan']);
$tanggal_masuk    = mysqli_real_escape_string($connection, $_POST['tanggal_masuk']);
$jumlah_pakaian   = intval($_POST['jumlah_pakaian']);
$pembayaran       = mysqli_real_escape_string($connection, $_POST['pembayaran']);
$sub_pembayaran   = mysqli_real_escape_string($connection, $_POST['sub_pembayaran']);
$diskon           = floatval($_POST['diskon']);
$cash             = floatval($_POST['cash']);
$total            = floatval($_POST['total']);
$estimasi         = $_POST['estimasi'] ?? [];
$servis           = $_POST['servis'] ?? [];
$berat            = $_POST['berat'] ?? [];
$id_pelanggan     = null;

// Validasi data penting
if (empty($cabang) || empty($tanggal_masuk) || empty($servis)) {
    die('Data penting tidak boleh kosong!');
}

// PROSES PELANGGAN
if ($statusPelanggan === 'lama') {
    $nama = mysqli_real_escape_string($connection, $_POST['namaLama']);
    $id_pelanggan = intval($_POST['id_pelanggan']);

    // Validasi pelanggan lama
    if (empty($id_pelanggan)) {
        die('Pelanggan tidak valid!');
    }

    // POTONG DEPOSIT
    if ($sub_pembayaran === 'deposit') {
        $get = mysqli_query($connection, "SELECT deposit FROM pelanggan WHERE id_pelanggan = '$id_pelanggan'");
        $pel = mysqli_fetch_assoc($get);
        $deposit = floatval($pel['deposit']);

        if ($deposit < $total) {
            die('Deposit tidak mencukupi!');
        }

        $new_deposit = $deposit - $total;
        mysqli_query($connection, "UPDATE pelanggan SET deposit = '$new_deposit' WHERE id_pelanggan = '$id_pelanggan'");
    }
} else {
    $nama    = mysqli_real_escape_string($connection, $_POST['nama_baru']);
    $telepon = mysqli_real_escape_string($connection, $_POST['telepon']);
    $email   = mysqli_real_escape_string($connection, $_POST['email']);
    $alamat  = mysqli_real_escape_string($connection, $_POST['alamat']);
    $catatan = mysqli_real_escape_string($connection, $_POST['catatan']);

    // Validasi input pelanggan baru
    if (empty($nama) || empty($telepon) || empty($alamat)) {
        die('Data pelanggan baru tidak lengkap!');
    }

    $query = "INSERT INTO pelanggan (nama, telepon, email, alamat, catatan) 
              VALUES ('$nama', '$telepon', '$email', '$alamat', '$catatan')";
    
    if (!mysqli_query($connection, $query)) {
        die('Error menyimpan pelanggan baru: ' . mysqli_error($connection));
    }

    $id_pelanggan = mysqli_insert_id($connection);
}

// SIMPAN PENJUALAN
$query = "INSERT INTO penjualan 
          (id_pelanggan, cabang, tanggal_masuk, jumlah_pakaian, pembayaran, sub_pembayaran, diskon, cash, total) 
          VALUES 
          ('$id_pelanggan', '$cabang', '$tanggal_masuk', '$jumlah_pakaian', '$pembayaran', '$sub_pembayaran', '$diskon', '$cash', '$total')";

if (!mysqli_query($connection, $query)) {
    die('Error menyimpan penjualan: ' . mysqli_error($connection));
}

$id_penjualan = mysqli_insert_id($connection);

// SIMPAN DETAIL LAYANAN
for ($i = 0; $i < count($servis); $i++) {
    $s = mysqli_real_escape_string($connection, $servis[$i]);
    $b = floatval($berat[$i]);
    $e = mysqli_real_escape_string($connection, $estimasi[$i]);

    $query = "INSERT INTO penjualan_detail (id_penjualan, layanan, berat, estimasi_pengambilan) 
              VALUES ('$id_penjualan', '$s', '$b', '$e')";
    
    if (!mysqli_query($connection, $query)) {
        die('Error menyimpan detail penjualan: ' . mysqli_error($connection));
    }
}

header('Location: kasir.php?success=1');
exit;