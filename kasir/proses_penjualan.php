<?php
session_start();
require_once '../helper/connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Akses tidak sah!');
}
$id_user = $_SESSION['id_user'] ?? null;
try {
    mysqli_autocommit($connection, false);
    $id_pelanggan = null;
    
    $cabang = mysqli_real_escape_string($connection, trim($_POST['cabang'] ?? ''));
    $statusPelanggan = mysqli_real_escape_string($connection, $_POST['statusPelanggan'] ?? '');
    $tanggal_masuk = mysqli_real_escape_string($connection, $_POST['tanggal_masuk'] ?? '');
    $jumlah_pakaian = intval($_POST['jumlah_pakaian'] ?? 0);
    $pembayaran = mysqli_real_escape_string($connection, $_POST['pembayaran'] ?? '');
    $sub_pembayaran = mysqli_real_escape_string($connection, $_POST['sub_pembayaran'] ?? '');
    $deposito = floatval($_POST['deposito'] ?? 0);
    $diskon = floatval($_POST['diskon'] ?? 0);
    $cash = floatval($_POST['cash'] ?? 0);
    $total = floatval($_POST['total'] ?? 0);

    $estimasi = $_POST['estimasi'] ?? [];
    $servis = $_POST['servis'] ?? [];
    $berat = $_POST['berat'] ?? [];

    if ($deposito > ($total + $diskon)) {throw new Exception('Deposito tidak boleh melebihi total harga!');}
    if (empty($cabang)) throw new Exception('Cabang tidak boleh kosong!');
    if (empty($tanggal_masuk)) throw new Exception('Tanggal masuk tidak boleh kosong!');
    if ($jumlah_pakaian <= 0) throw new Exception('Jumlah pakaian harus lebih dari 0!');
    if (empty($servis)) throw new Exception('Pilih minimal satu layanan!');
    if (empty($pembayaran) || empty($sub_pembayaran)) throw new Exception('Pilih metode pembayaran!');

        if ($statusPelanggan === 'lama') {
        $nama = mysqli_real_escape_string($connection, trim($_POST['namaLama'] ?? ''));
        $id_pelanggan = intval($_POST['id_pelanggan'] ?? 0);

        if ($id_pelanggan > 0 && !empty($nama)) {
            $checkPelanggan = mysqli_query($connection, "SELECT id_pelanggan, deposito FROM pelanggan WHERE id_pelanggan = '$id_pelanggan' AND nama = '$nama'");
            if (mysqli_num_rows($checkPelanggan) == 0) {
                throw new Exception('Pelanggan tidak ditemukan!');
            }

            $pelangganData = mysqli_fetch_assoc($checkPelanggan);
            $saldo_deposito = floatval($pelangganData['deposito'] ?? 0);
            
            // Hanya proses jika menggunakan deposit dan saldo mencukupi
            if ($sub_pembayaran === 'deposito') {
                if ($saldo_deposito <= 0) {
                    // Jika tidak ada deposit, anggap deposit yang digunakan = 0
                    $deposito = 0;
                } else {
                    // Gunakan deposit yang tersedia
                    $potongan = min($total, $saldo_deposito);
                    $deposito = $potongan;
                    $total -= $potongan;
                    
                    // Update saldo deposit pelanggan
                    $new_deposito = $saldo_deposito - $potongan;
                    $updateDeposito = mysqli_query($connection, "UPDATE pelanggan SET deposito = '$new_deposito' WHERE id_pelanggan = '$id_pelanggan'");
                    if (!$updateDeposito) {
                        throw new Exception('Gagal memperbarui deposito: ' . mysqli_error($connection));
                    }
                }
            }
        } else {
            $statusPelanggan = 'baru';
        }
    }

    if ($statusPelanggan === 'baru') {
        $nama = mysqli_real_escape_string($connection, trim($_POST['nama_baru'] ?? ''));
        $telepon = mysqli_real_escape_string($connection, trim($_POST['telepon'] ?? ''));
        $email = mysqli_real_escape_string($connection, trim($_POST['email'] ?? ''));
        $alamat = mysqli_real_escape_string($connection, trim($_POST['alamat'] ?? ''));
        $catatan = mysqli_real_escape_string($connection, trim($_POST['catatan'] ?? ''));

        if (empty($nama)) throw new Exception('Nama pelanggan tidak boleh kosong!');
        if (empty($telepon)) throw new Exception('Nomor telepon tidak boleh kosong!');
        if (empty($alamat)) throw new Exception('Alamat tidak boleh kosong!');

        $checkTelepon = mysqli_query($connection, "SELECT id_pelanggan FROM pelanggan WHERE nomor_telepon = '$telepon'");
        if (mysqli_num_rows($checkTelepon) > 0) {
            throw new Exception('Nomor telepon sudah terdaftar!');
        }

        $insertPelanggan = "INSERT INTO pelanggan (nama, nomor_telepon, email, alamat, catatan) 
                            VALUES ('$nama', '$telepon', '$email', '$alamat', '$catatan')";
        if (!mysqli_query($connection, $insertPelanggan)) {
            throw new Exception('Gagal menyimpan data pelanggan: ' . mysqli_error($connection));
        }

        $id_pelanggan = mysqli_insert_id($connection);
        if (!$id_pelanggan || $id_pelanggan <= 0) {
            throw new Exception('Gagal mendapatkan ID pelanggan baru!');
        }
    }

   // Memasukkan Orderan
    $insertPenjualan = "INSERT INTO penjualan (id_pelanggan, cabang, tanggal_masuk, jumlah_pakaian, pembayaran, sub_pembayaran, diskon, deposito, cash, total, id_user)
                        VALUES ('$id_pelanggan', '$cabang', '$tanggal_masuk', '$jumlah_pakaian', '$pembayaran', '$sub_pembayaran', '$diskon', '$deposito', '$cash', '$total', '$id_user')";

    if (!mysqli_query($connection, $insertPenjualan)) {
        throw new Exception('Gagal menyimpan data penjualan: ' . mysqli_error($connection));
    }

    $id_penjualan = mysqli_insert_id($connection);

    if (count($servis) != count($berat) || count($servis) != count($estimasi)) {
        throw new Exception('Data layanan tidak konsisten!');
    }

    for ($i = 0; $i < count($servis); $i++) {
        if (empty($servis[$i])) continue;

        $layanan = mysqli_real_escape_string($connection, trim($servis[$i]));
        $beratKg = floatval($berat[$i]);
        $estimasi_pengambilan = mysqli_real_escape_string($connection, $estimasi[$i]);

        if ($beratKg <= 0) throw new Exception('Berat layanan harus lebih dari 0!');

        // ✅ Jangan isi id_detail secara manual
        $insertDetail = "INSERT INTO penjualan_detail (id_penjualan, layanan, berat, estimasi_pengambilan) 
                         VALUES ('$id_penjualan', '$layanan', '$beratKg', '$estimasi_pengambilan')";
        if (!mysqli_query($connection, $insertDetail)) {
            throw new Exception('Gagal menyimpan detail layanan: ' . mysqli_error($connection));
        }
    }

    mysqli_commit($connection);
    mysqli_autocommit($connection, true);
    header('Location: struk.php?success=1&id=' . $id_penjualan);
    exit;

} catch (Exception $e) {
    mysqli_rollback($connection);
    mysqli_autocommit($connection, true);
    $errorMsg = urlencode($e->getMessage());
    header('Location: index.php?error=1&msg=' . $errorMsg);
    exit;
}
?>