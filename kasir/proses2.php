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
    $statusPelanggan = $_POST['statusPelanggan'] ?? '';
    $tanggal_masuk = $_POST['tanggal_masuk'] ?? '';
    $jumlah_pakaian = intval($_POST['jumlah_pakaian'] ?? 0);
    $pembayaran = $_POST['pembayaran'] ?? '';
    $sub_pembayaran = $_POST['sub_pembayaran'] ?? '';
    $diskon = floatval($_POST['diskon'] ?? 0);
    $cash = floatval($_POST['cash'] ?? 0);
    $total = floatval($_POST['total'] ?? 0);

    $estimasi = $_POST['estimasi'] ?? [];
    $servis = $_POST['servis'] ?? [];
    $berat = $_POST['berat'] ?? [];

    if (!$cabang || !$tanggal_masuk || $jumlah_pakaian <= 0 || !$servis || !$pembayaran || !$sub_pembayaran) {
        throw new Exception('Data tidak lengkap!');
    }

    // === STATUS PELANGGAN: LAMA ===
    if ($statusPelanggan === 'lama') {
        $nama = mysqli_real_escape_string($connection, trim($_POST['namaLama'] ?? ''));
        $id_pelanggan = intval($_POST['id_pelanggan'] ?? 0);

        if ($id_pelanggan <= 0 || empty($nama)) {
            throw new Exception('Data pelanggan lama tidak valid!');
        }

        $checkPelanggan = mysqli_query($connection, "SELECT id_pelanggan FROM pelanggan WHERE id_pelanggan = '$id_pelanggan' AND nama = '$nama'");
        if (mysqli_num_rows($checkPelanggan) === 0) {
            throw new Exception('Pelanggan tidak ditemukan!');
        }

        // === CEK DAN POTONG DEPOSIT ===
        if ($sub_pembayaran === 'deposit') {
            $queryDeposit = mysqli_query($connection, "
                SELECT 
                    IFNULL(SUM(deposit_masuk), 0) AS masuk, 
                    IFNULL(SUM(deposit_keluar), 0) AS keluar 
                FROM deposit 
                WHERE id_pelanggan = '$id_pelanggan'
            ");
            $dataDeposit = mysqli_fetch_assoc($queryDeposit);
            $sisaDeposit = floatval($dataDeposit['masuk']) - floatval($dataDeposit['keluar']);

            if ($sisaDeposit < $total) {
                throw new Exception('Deposit tidak mencukupi! Saldo: Rp ' . number_format($sisaDeposit, 0, ',', '.'));
            }

            $insertKeluar = mysqli_query($connection, "
                INSERT INTO deposit (id_pelanggan, deposit_masuk, deposit_keluar) 
                VALUES ('$id_pelanggan', 0, '$total')
            ");
            if (!$insertKeluar) {
                throw new Exception('Gagal mengurangi deposit: ' . mysqli_error($connection));
            }
        }

    } else {
        // === STATUS PELANGGAN: BARU ===
        $nama = mysqli_real_escape_string($connection, trim($_POST['nama_baru'] ?? ''));
        $telepon = mysqli_real_escape_string($connection, trim($_POST['telepon'] ?? ''));
        $email = mysqli_real_escape_string($connection, trim($_POST['email'] ?? ''));
        $alamat = mysqli_real_escape_string($connection, trim($_POST['alamat'] ?? ''));
        $catatan = mysqli_real_escape_string($connection, trim($_POST['catatan'] ?? ''));

        if (!$nama || !$telepon || !$alamat) {
            throw new Exception('Data pelanggan baru tidak lengkap!');
        }

        $checkTelepon = mysqli_query($connection, "SELECT id_pelanggan FROM pelanggan WHERE nomor_telepon = '$telepon'");
        if (mysqli_num_rows($checkTelepon) > 0) {
            throw new Exception('Nomor telepon sudah terdaftar!');
        }

        $insertPelanggan = mysqli_query($connection, "
            INSERT INTO pelanggan (nama, nomor_telepon, email, alamat, catatan) 
            VALUES ('$nama', '$telepon', '$email', '$alamat', '$catatan')
        ");
        if (!$insertPelanggan) {
            throw new Exception('Gagal menyimpan data pelanggan: ' . mysqli_error($connection));
        }

        $id_pelanggan = mysqli_insert_id($connection);
    }

    // === INSERT PENJUALAN ===
    $insertPenjualan = mysqli_query($connection, "
        INSERT INTO penjualan (
            id_pelanggan, cabang, tanggal_masuk, jumlah_pakaian, 
            pembayaran, sub_pembayaran, diskon, cash, total, id_user
        ) VALUES (
            '$id_pelanggan', '$cabang', '$tanggal_masuk', '$jumlah_pakaian',
            '$pembayaran', '$sub_pembayaran', '$diskon', '$cash', '$total', '$id_user'
        )
    ");
    if (!$insertPenjualan) {
        throw new Exception('Gagal menyimpan penjualan: ' . mysqli_error($connection));
    }

    $id_penjualan = mysqli_insert_id($connection);

    // === INSERT DETAIL PENJUALAN ===
    if (count($servis) !== count($berat) || count($servis) !== count($estimasi)) {
        throw new Exception('Data layanan tidak konsisten!');
    }

    for ($i = 0; $i < count($servis); $i++) {
        if (empty($servis[$i])) continue;

        $layanan = mysqli_real_escape_string($connection, trim($servis[$i]));
        $beratKg = floatval($berat[$i]);
        $estimasi_pengambilan = mysqli_real_escape_string($connection, $estimasi[$i]);

        if ($beratKg <= 0) throw new Exception('Berat layanan harus lebih dari 0!');

        $insertDetail = mysqli_query($connection, "
            INSERT INTO penjualan_detail (id_penjualan, layanan, berat, estimasi_pengambilan) 
            VALUES ('$id_penjualan', '$layanan', '$beratKg', '$estimasi_pengambilan')
        ");
        if (!$insertDetail) {
            throw new Exception('Gagal menyimpan detail layanan: ' . mysqli_error($connection));
        }
    }

    // === FINAL: COMMIT SEMUA ===
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
