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
            <div class="card-header bg-primary text-white">Data Peminjaman</div>
            <div class="card-body">
                <table id="dataKembali" class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pengguna</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Nama Petugas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                        $no = 1;
                                        $query = mysqli_query($koneksi, "SELECT peminjaman.*, buku.judul, buku.gambar, petugas.nama_petugas, 
                                        pengguna.nama_pengguna, pengguna.alamat, pengguna.email, rak.nama_rak, kategori.nama_kategori 
                                        FROM peminjaman
                                        INNER JOIN buku ON peminjaman.id_buku = buku.id
                                        INNER JOIN petugas ON peminjaman.id_petugas = petugas.id
                                        INNER JOIN pengguna ON peminjaman.id_pengguna = pengguna.id 
                                        INNER JOIN kategori ON buku.id_kategori = kategori.id
                                        INNER JOIN rak ON buku.id_rak = rak.id
                                        WHERE peminjaman.status = 'pinjam'
                                        ORDER BY peminjaman.id DESC");
                                        while ($data = mysqli_fetch_assoc($query)) :
                                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data['nama_pengguna']?></td>
                            <td><?php echo $data['judul']; ?></td>
                            <td><?php echo $data['tanggal_pinjam']?></td>
                            <td><?php echo $data['nama_petugas']?></td>
                            <td>
                                <a href="" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalKembali<?php echo $data['id']; ?>">Verif</a>

                                <a href="" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#modalDetailPinjam<?php echo $data['id']; ?>">Detail</a>
                            </td>
                        </tr>

                        <!-- Modal Detail Buku -->
                        <div class="modal modal-lg" id="modalDetailPinjam<?php echo $data['id']; ?>"
                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail
                                            Pinjam</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container">
                                            <form action="" method="post" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h5>Informasi Buku</h4>
                                                            <br>
                                                            <div class="mb-3">
                                                                <label for="">Judul</label>
                                                                <input type="text" disabled class="form-control"
                                                                    name="judul" value="<?php echo $data['judul']; ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="">Gambar</label>
                                                                <br>
                                                                <a href="../asset/gambar/<?php echo $data['gambar']; ?>"
                                                                    target="_blank">
                                                                    <img src="../asset/gambar/<?php echo $data['gambar']; ?>"
                                                                        width="80" height="120" alt="">
                                                                </a>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="">Kategori</label>
                                                                <input type="text" disabled class="form-control"
                                                                    name="nama_kategori"
                                                                    value="<?php echo $data['nama_kategori']; ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="">Nama Rak</label>
                                                                <input type="text" disabled class="form-control"
                                                                    name="nama_rak"
                                                                    value="<?php echo $data['nama_rak']; ?>">
                                                            </div>

                                                    </div>
                                                    <div class="col-6">
                                                        <h5>Informasi Peminjam</h4>
                                                            <br>
                                                            <div class="mb-3">
                                                                <label for="">Petugas</label>
                                                                <input type="text" disabled class="form-control"
                                                                    name="pengguna"
                                                                    value="<?php echo $data['nama_petugas']; ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="">Pengguna</label>
                                                                <input type="text" disabled class="form-control"
                                                                    name="pengguna"
                                                                    value="<?php echo $data['nama_pengguna']; ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="">Email</label>
                                                                <input type="text" disabled class="form-control"
                                                                    name="email" value="<?php echo $data['email']; ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="">Alamat</label>
                                                                <textarea name="alamat" disabled class="form-control"
                                                                    rows="6"><?php echo $data['alamat']?></textarea>
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">Batal</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Modal Verif Pengembalian-->
                        <div class="modal modal-lg" id="modalKembali<?php echo $data['id']; ?>"
                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Verifikasi
                                            Pengembalian Buku</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="crud_kembali.php" method="post">
                                            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                                            <div class="mb-3">
                                                <label for="">Status Peminjaman</label>
                                                <select name="status_peminjaman" class="form-select" id="">
                                                    <option value="">Pilih Status Pinjam</option>
                                                    <option value="hilang">Hilang</option>
                                                    <option value="kembali">Kembali</option>
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" name="btnVerif"
                                                    class="btn btn-danger">Verif</button>
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
        $(document).ready(function () {
            $('#dataKembali').DataTable({
                responsive: true
            });

        });
    </script>
</body>

</html>