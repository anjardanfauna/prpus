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
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Aplikasi Perpustakaan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
            <div class="card-header bg-primary text-white">Data Rak</div>
            <div class="card-body">
                <div class="text-left">
                    <a href="" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tambahRak">Tambah Data</a>
                </div>
                <table id="dataRak" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Rak</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $tampil = mysqli_query($koneksi, "SELECT * FROM rak ORDER BY id DESC");
                        while ($data = mysqli_fetch_assoc($tampil)) :
                        ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $data['nama_rak']; ?></td>
                                <td>
                                    <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ubahRak<?php echo $data['id']; ?>">Ubah</a>
                                    <a href="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusRak<?php echo $data['id']; ?>">Hapus</a>
                                </td>
                            </tr>
                            <!-- Modal Hapus Rak -->
                            <div class="modal modal-lg fade" id="hapusRak<?php echo $data['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Rak</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="crud_rak.php" method="post">
                                                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                                                <h5 class="text-center"> Apa anda yakin akan menghapus data ?
                                                    <span class="text-danger"><?php echo $data['nama_rak']; ?></span>
                                                </h5>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="btnHapus" class="btn btn-danger">Hapus</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Ubah Rak -->
                            <div class="modal modal-lg fade" id="ubahRak<?php echo $data['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Ubah Rak</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="crud_rak.php" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                                                <div class="mb-3">
                                                    <label for="">Nama Rak</label>
                                                    <input type="text" class="form-control" name="nama_rak" value="<?php echo $data['nama_rak']; ?>">
                                                </div>
                        
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="btnUbah" class="btn btn-primary">Ubah</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>


    <!-- Modal Tambah Rak -->
    <div class="modal modal-lg fade" id="tambahRak" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Form Rak</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="crud_rak.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="">Nama Rak</label>
                            <input type="text" class="form-control" name="nama_rak">
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="btnSimpan" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../asset/js/bootstrap.min.js"></script>
    <script src="../asset/js/jquery.min.js"></script>
    <script src="../asset/js/datatables.min.js"></script>
    <script src="../asset/js/dataTables.responsive.min.js"></script>
    <script src="../asset/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataRak').DataTable({
                responsive: true
            });

        });
    </script>
</body>

</html>