<?php
session_start();
include '../koneksi.php';

if(isset($_POST['btnSimpan'])){
    $nama_kategori = $_POST['nama_kategori'];

    $simpan = mysqli_query($koneksi, "INSERT INTO kategori (id, nama_kategori) VALUES ('','$nama_kategori')");

      if($simpan){
        echo "<script>alert('Data Berhasil Disimpan'); document.location='kategori.php'</script>";
    } else {
        echo "<script>alert('Data Gagal Disimpan'); document.location='kategori.php'</script>";
    }

}
if(isset($_POST['btnUbah'])){
    $id = $_POST['id'];
    $nama_kategori = $_POST['nama_kategori'];

    $ubah = mysqli_query($koneksi, "UPDATE kategori SET nama_kategori = '$nama_kategori' WHERE id = '$id'");

    if($ubah){
        echo "<script>alert('Data Berhasil Diubah'); document.location='kategori.php'</script>";
    } else {
        echo "<script>alert('Data Gagal Diubah'); document.location='kategori.php'</script>";
    }
    
}

if(isset($_POST['btnHapus'])){
    $id = $_POST['id'];
    $hapus = mysqli_query($koneksi, "DELETE FROM kategori WHERE id = '$id'");

    if($hapus){
        echo "<script>alert('Data berhasil dihapus'); document.location='kategori.php'</script>";
    } else {
        echo "<script>alert('Data gagal dihapus'); document.location='kategori.php'</script>";
    }
}

?>