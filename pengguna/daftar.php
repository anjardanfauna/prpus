<?php
include '../koneksi.php';

if (isset($_POST['btnDaftar'])) {
    $nama_pengguna = $_POST['nama_pengguna'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    // inisialisasi variabel dengan inputan form

    $cek_email = mysqli_query($koneksi, "SELECT email FROM pengguna WHERE email = '$email'");

    $cek_username = mysqli_query($koneksi, "SELECT email FROM pengguna WHERE username = '$username'");

    if (mysqli_fetch_assoc($cek_email)) {
        echo "<script>alert('Email sudah digunakan')</script>";
    } else if (mysqli_fetch_assoc($cek_username)) {
        echo "<script>alert('Username sudah digunakan')</script>";
        // melakukan validasi email yang sama dan password yang tidak sama
    } else if ($password != $password2) {
        echo "<script>alert('Password tidak sama')</script>";
        // melakukan validasi eamail yang sama dan password yang tidak sama
    } else {
       

        $simpan = mysqli_query($koneksi, "INSERT INTO pengguna VALUES ('', '$nama_pengguna', '$alamat','$email', '$username', '$password')");

        if ($simpan) {
            echo "<script>alert('Data Akun Berhasil Dibuat');
        document.location='../index.php';
        </script>";
        } else {
            echo "<script>alert('Data Akun Gagal Dibuat');
        </script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Perpustakaan</title>
    <link rel="stylesheet" href="../asset/css/bootstrap.min.css">
</head>

<body>

    <div class="row">
        <div class="col-7"></div>
        <div class="col-5 d-flex justify-content-center align-items-center">
            <div class="card">
                <div class="card-header bg-primary text-white">Form Pendaftaran Akun</div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="">Nama Pengguna</label>
                                    <input type="text" class="form-control" name="nama_pengguna">
                                </div>
                                <div class="mb-3">
                                    <label for="">Alamat</label>
                                    <textarea name="alamat" id="" rows="2" class="form-control"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="">Email</label>
                                     <input type="text" class="form-control" name="email">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="">Username</label>
                                    <input type="text" class="form-control" name="username">
                                </div>
                                <div class="mb-3">
                                    <label for="">Password</label>
                                    <input type="password" class="form-control" name="password">
                                </div>
                                <div class="mb-3">
                                    <label for="">Ulangi Password</label>
                                    <input type="password" class="form-control" name="password2">
                                </div>
                                <a href="../index.php" class="btn btn-danger">Batal</a>
                                <button class="btn btn-success" type="submit" name="btnDaftar">Daftar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <script src="../asset/js/bootstrap.min.js"></script>
    <script src="../asset/js/jquery.min.js"></script>

</body>

</html>