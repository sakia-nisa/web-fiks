<?php
$dbhost = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "laundry";

$connection = mysqli_connect($dbhost, $dbusername, $dbpassword,  $dbname);
if (!$connection) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>
