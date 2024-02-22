<?php

include '../koneksi.php';

session_start();
if (!isset($_SESSION['loginpa'])) {
    header("Location: loginpetugas.php");
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
    <link rel="stylesheet" href="../asset/css/datatables.min.css">
    <link rel="stylesheet" href="../asset/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="../asset/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../asset/css/select2.css">
    <link rel="stylesheet" href="../asset/css/select2.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Aplikasi Perpustakaan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="dashboard_pa.php">Dashboard</a>
                    </li>
                    <?php
                    if ($_SESSION['level'] == 'admin') {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="kelola_rak.php">Rak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kategori.php">Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kelola_buku.php">Buku</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kelola_pinjam.php">Kelola Pinjam</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kelola_kembali.php">Kelola Kembali</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kelola_petugas.php">Kelola Petugas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="laporan.php">Laporan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logoutpa.php">Logout</a>
                    </li>
                    <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="kelola_rak.php">Rak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kategori.php">Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kelola_buku.php">Buku</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kelola_pinjam.php">Kelola Pinjam</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kelola_kembali.php">Kelola Kembali</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logoutpa.php">Logout</a>
                    </li>
                    <?php } ?>
                </ul>
                <div class="nav-item text-right">
                    <a class="nav-link"><?php echo $_SESSION['nama_petugas']; ?> | <?php echo $_SESSION['level']; ?></a>
                </div>
            </div>
        </div>
    </nav>
    <br>
    <br>
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary text-white">Form Ubah Peminjaman</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-3"></div>
                    <div class="col-6">
                        <?php 
                                        $id = $_GET['id'];
                                        $query = mysqli_query($koneksi, "SELECT peminjaman.*, buku.judul, petugas.nama_petugas, 
                                        pengguna.nama_pengguna FROM peminjaman
                                        INNER JOIN buku ON peminjaman.id_buku = buku.id
                                        INNER JOIN petugas ON peminjaman.id_petugas = petugas.id
                                        INNER JOIN pengguna ON peminjaman.id_pengguna = pengguna.id
                                        WHERE peminjaman.id ='$id'");
                                        while ($data = mysqli_fetch_assoc($query)) {
                                        ?>
                        <form action="crud_pinjam.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                            <div class="mb-3">
                                <label for="">Nama Pengguna</label>
                                <select name="nama_pengguna" class="js-example-basic-single form-select" id="">
                                    <option value="">Pilih Nama Pengguna</option>
                                    <?php 
                                                        $querypeng = mysqli_query($koneksi, "SELECT * FROM pengguna");
                                                        while($datapeng = mysqli_fetch_assoc($querypeng)) :
                                                        $selected ="";
                                                        if($datapeng['id'] == $data['id_pengguna']){
                                                        $selected ="selected";
                                                         }
                                                        ?>

                                    <?php
                                                        $a = $datapeng['id'];
                                                        $b = $datapeng['nama_pengguna'];

                                                        echo "<option value='". $a. "'".$selected.">".$b."</option>"
                                                                            ?>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="">Judul</label>
                                <select name="judul" class="js-example-basic-single form-select" id="">
                                    <option value="">Pilih Judul Buku</option>
                                    <?php 
                                                        $querybuku = mysqli_query($koneksi, "SELECT * FROM buku");
                                                        while($databuku = mysqli_fetch_assoc($querybuku)) :
                                                        $selected ="";
                                                        if($databuku['id'] == $data['id_buku']){
                                                        $selected ="selected";
                                                         }
                                                        ?>

                                    <?php
                                                        $a = $databuku['id'];
                                                        $b = $databuku['judul'];

                                                        echo "<option value='". $a. "'".$selected.">".$b."</option>"
                                                                            ?>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="float-end">
                                <a class="btn btn-danger" type="reset">Batal</a>
                                <button class="btn btn-primary" type="submit" name="btnUbah">Ubah</button>
                            </div>
                        </form>
                        <?php } ?>


                    </div>
                    <div class="col-3"></div>
                </div>
            </div>
        </div>
    </div>




    <script src="../asset/js/bootstrap.min.js"></script>
    <script src="../asset/js/jquery.min.js"></script>
    <script src="../asset/js/datatables.min.js"></script>
    <script src="../asset/js/dataTables.responsive.min.js"></script>
    <script src="../asset/js/jquery.dataTables.min.js"></script>
    <script src="../asset/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.js-example-basic-single').select2();
        });
    </script>
</body>

</html>
