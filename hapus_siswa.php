<?php
include 'koneksi.php';

$nis = $_GET['nis'];
mysqli_query($koneksi, "DELETE FROM siswa WHERE nis = '$nis'");

echo "<script>alert('Data siswa berhasil dihapus'); window.location='index.php';</script>";
?>
