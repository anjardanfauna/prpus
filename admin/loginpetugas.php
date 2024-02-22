<?php

include '../koneksi.php';

session_start();
if (isset($_SESSION['loginpa'])) {
    header("Location: dashboard_pa.php");
}

if (isset($_POST['btnMasuk'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $data = mysqli_query($koneksi, "SELECT * FROM petugas WHERE username = '$username'");

    if (mysqli_num_rows($data) === 1) {
        $baris = mysqli_fetch_assoc($data);
        if ($password == $baris['password']) {

            header("Location: dashboard_pa.php");
            $_SESSION['id'] = $baris['id'];
            $_SESSION['loginpa'] = true;
            $_SESSION['nama_petugas'] = $baris['nama_petugas'];
            $_SESSION['alamat'] = $baris['alamat'];
            $_SESSION['level'] = $baris['level'];
            exit;
        } else {
            echo "<script>alert('Username atau Password anda salah!')</script>";
        }
        
    } else {
        echo "<script>alert('Username atau Password anda salah!')</script>";
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
                <div class="card-header bg-primary text-white">Form Login</div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="">Username</label>
                            <input type="text" class="form-control" name="username">
                        </div>
                        <div class="mb-3">
                            <label for="">Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <button type="submit" name="btnMasuk" class="btn btn-success float-end">Masuk</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../asset/js/bootstrap.min.js"></script>
    <script src="../asset/js/jquery.min.js"></script>

</body>

</html>
