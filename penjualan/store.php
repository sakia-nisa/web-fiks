<?php
session_start();
require_once '../helper/connection.php';

$id = $_POST['id'];
$nim = $_POST['nim'];
$kode_matkul = $_POST['kode_matkul'];
$semester = $_POST['semester'];
$nilai = $_POST['nilai'];

$query = mysqli_query($connection, "insert into nilai(id, nim, kode_matkul, semester, nilai) 
value('$id', '$nim', '$kode_matkul', '$semester', '$nilai')");
if ($query) {
  $_SESSION['info'] = [
    'status' => 'success',
    'message' => 'Berhasil menambah data'
  ];
  header('Location: ./index.php');
                                            } else {
                                              $_SESSION['info'] = [
                                                'status' => 'failed',
                                                'message' => mysqli_error($connection)
                                              ];
                                              header('Location: ./index.php');
                                            }
