<?php 
include '../koneksi.php';
session_start();
if(isset($_POST['btnSimpan'])){
    $id_petugas = $_SESSION['id'];
    $id_pengguna = $_POST['nama_pengguna'];
    $id_buku = $_POST['judul'];
    $tanggal_pinjam = date('Y-m-d');
    $status_peminjaman = 'pinjam';

    $query = mysqli_query($koneksi, "INSERT INTO peminjaman (id, id_pengguna, id_petugas, id_buku, tanggal_pinjam, status) 
    VALUES ('', '$id_pengguna', '$id_petugas', '$id_buku', '$tanggal_pinjam', '$status_peminjaman')");

    if($query){
        echo "<script>alert('Data peminjaman buku berhasil disimpan'); document.location='kelola_pinjam.php';</script>";
    } else {
        echo "<script>alert('Data peminjaman buku gagal disimpan'); document.location='kelola_pinjam.php';</script>";
    }


}

if(isset($_POST['btnUbah'])){
    $id_pinjam = $_POST['id'];
    $id_petugas = $_SESSION['id'];
    $id_pengguna = $_POST['nama_pengguna'];
    $id_buku = $_POST['judul'];
    $tanggal_pinjam = date('Y-m-d');
    $status_peminjaman = 'pinjam';

    $query = mysqli_query($koneksi, "UPDATE peminjaman SET id_petugas = '$id_petugas', id_pengguna = '$id_pengguna', id_buku = '$id_buku', 
    tanggal_pinjam = '$tanggal_pinjam', status = '$status_peminjaman' WHERE id = '$id_pinjam'");

    if($query){
        echo "<script>alert('Data peminjaman buku berhasil diubah'); document.location='kelola_pinjam.php';</script>";
    } else {
        echo "<script>alert('Data peminjaman buku gagal diubah'); document.location='kelola_pinjam.php';</script>";
    }

}

if(isset($_POST['btnHapus'])){
    $id = $_POST['id'];

    $hapus = mysqli_query($koneksi, "DELETE FROM peminjaman WHERE id = '$id'");
    if($hapus){
        echo "<script>alert('Data peminjaman buku berhasil dihapus'); document.location='kelola_pinjam.php';</script>";
    } else {
        echo "<script>alert('Data peminjaman buku gagal dihapus'); document.location='kelola_pinjam.php';</script>";
    }
}
