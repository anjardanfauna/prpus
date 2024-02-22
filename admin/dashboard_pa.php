<?php

include '../koneksi.php';

session_start();
if (!isset($_SESSION['loginpa'])) {
    header("Location: loginpetugas.php");
}

$data1 = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE status = 'pinjam' AND id_petugas != 0");
$jmlpinjam = mysqli_num_rows($data1);

$data2 = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE status = 'kembali'");
$jmlkembali = mysqli_num_rows($data2);

$data3 = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE status = 'hilang'");
$jmlhilang = mysqli_num_rows($data3);

$data4 = mysqli_query($koneksi, "SELECT * FROM buku");
$jmlbuku = mysqli_num_rows($data4);
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
                        <a class="nav-link active" aria-current="page" 
                        href="dashboard_pa.php">Dashboard</a>
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
            </div>
            <div class="nav-item text-right">
                <a class="nav-link"><?php echo $_SESSION['nama_petugas']; ?> | <?php echo $_SESSION['level']; ?></a>
            </div>
        </div>
    </nav>
    <br>
    <br>

    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="card bg-warning text-white text-center">
                    <div class="card-body">
                        <h5><?php echo $jmlpinjam; ?></h5>
                    </div>
                    <div class="card-footer">
                        <h6>Jumlah Peminjaman</h6>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card bg-secondary text-white text-center">
                    <div class="card-body">
                        <h5><?php echo $jmlkembali; ?></h5>
                    </div>
                    <div class="card-footer">
                        <h6>Jumlah Pengembalian</h6>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card bg-success text-white text-center">
                    <div class="card-body">
                        <h5><?php echo $jmlhilang; ?></h5>
                    </div>
                    <div class="card-footer">
                        <h6>Jumlah Buku Hilang</h6>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card bg-danger text-white text-center">
                    <div class="card-body">
                        <h5><?php echo $jmlbuku; ?></h5>
                    </div>
                    <div class="card-footer">
                        <h6>Jumlah Buku</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    <br>
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary text-white">Data Booking</div>
            <div class="card-body">
                
                <table id="dataBooking" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pengguna</th>
                            <th>Judul Buku</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($koneksi, "SELECT peminjaman.*, buku.judul, pengguna.nama_pengguna FROM peminjaman
                        INNER JOIN buku ON peminjaman.id_buku = buku.id
                        INNER JOIN pengguna ON peminjaman.id_pengguna = pengguna.id WHERE peminjaman.status = 'pinjam' AND peminjaman.id_petugas = 0
                        ORDER BY peminjaman.id DESC");
                        while ($data = mysqli_fetch_assoc($query)) :
                        ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $data['nama_pengguna']; ?></td>
                                <td><?php echo $data['judul']; ?></td>
                                <td>
                                    <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalVerifBooking<?php echo $data['id']; ?>">Verif</a>
                                    <a href="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusBooking<?php echo $data['id']; ?>">Hapus</a>
                                </td>
                            </tr>
                            <!-- Modal Hapus Booking -->
                            <div class="modal modal-lg fade" id="modalHapusBooking<?php echo $data['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Rak</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="crud_booking.php" method="post">
                                                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                                                <h5 class="text-center"> Apa anda yakin akan menghapus Booking Milik : ?
                                                    <span class="text-danger"><?php echo $data['nama_pengguna']; ?></span>
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

                            <!-- Modal Verif Booking -->
                            <div class="modal modal-lg fade" id="modalVerifBooking<?php echo $data['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Verifikasi Booking</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="crud_booking.php" method="post">
                                                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                                                <h5 class="text-center"> Apa anda yakin akan Memverifikasi Peminjaman : ?
                                                    <span class="text-danger"><?php echo $data['judul']; ?></span>
                                                </h5>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="btnVerif" class="btn btn-danger">Verif</button>
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




    <script src="../asset/js/bootstrap.min.js"></script>
    <script src="../asset/js/jquery.min.js"></script>
    <script src="../asset/js/datatables.min.js"></script>
    <script src="../asset/js/dataTables.responsive.min.js"></script>
    <script src="../asset/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function(){
            $('#dataBooking').DataTable({
                responsive: true
            });
        });
    </script>
</body>

</html>
