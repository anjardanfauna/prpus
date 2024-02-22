<?php 
include '../koneksi.php';
session_start();
if(isset($_POST['btnVerif'])){
    $id_peminjaman = $_POST['id'];
    $id_petugas = $_SESSION['id'];
    $tanggal_kembali = date('Y-m-d');
    $status_peminjaman = $_POST['status_peminjaman'];

    $query = mysqli_query($koneksi, "INSERT INTO pengembalian (id, id_peminjaman, id_petugas, tanggal_kembali) 
    VALUES ('', '$id_peminjaman', '$id_petugas', '$tanggal_kembali')");

    $query = mysqli_query($koneksi, "UPDATE peminjaman SET status = '$status_peminjaman' WHERE id = '$id_peminjaman'");

    if($query){
        echo "<script>alert('Data pengembalian buku berhasil disimpan'); document.location='kelola_kembali.php';</script>";
    } else {
        echo "<script>alert('Data pengembalian buku gagal disimpan'); document.location='kelola_kembali.php';</script>";
    }

}
