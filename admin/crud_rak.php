<?php
session_start();
include '../koneksi.php';

if(isset($_POST['btnSimpan'])){
    $nama_rak = $_POST['nama_rak'];

    $simpan = mysqli_query($koneksi, "INSERT INTO rak (id, nama_rak) VALUES ('','$nama_rak')");

      if($simpan){
        echo "<script>alert('Data Berhasil Disimpan'); document.location='kelola_rak.php'</script>";
    } else {
        echo "<script>alert('Data Gagal Disimpan'); document.location='kelola_rak.php'</script>";
    }

}
if(isset($_POST['btnUbah'])){
    $id = $_POST['id'];
    $nama_rak = $_POST['nama_rak'];

    $ubah = mysqli_query($koneksi, "UPDATE rak SET nama_rak = '$nama_rak' WHERE id = '$id'");

    if($ubah){
        echo "<script>alert('Data Rak Berhasil Diubah'); document.location='kelola_rak.php'</script>";
    } else {
        echo "<script>alert('Data Rak Gagal Diubah'); document.location='kelola_rak.php'</script>";
    }
    
}

if(isset($_POST['btnHapus'])){
    $id = $_POST['id'];
    $hapus = mysqli_query($koneksi, "DELETE FROM rak WHERE id = '$id'");

    if($hapus){
        echo "<script>alert('Data Rak berhasil dihapus'); document.location='kelola_rak.php'</script>";
    } else {
        echo "<script>alert('Data Rak gagal dihapus'); document.location='kelola_rak.php'</script>";
    }
}

?>