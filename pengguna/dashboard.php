<?php

include '../koneksi.php';

session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../index.php");
}

$id_pengguna_ses = $_SESSION['id'];

$data1 = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id_pengguna = '$id_pengguna_ses' AND status = 'pinjam'");
$jmlpinjam = mysqli_num_rows($data1);

$data2 = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id_pengguna = '$id_pengguna_ses' AND status = 'kembali'");
$jmlkembali = mysqli_num_rows($data2);

$data3 = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id_pengguna = '$id_pengguna_ses' AND status = 'hilang'");
$jmlhilang = mysqli_num_rows($data3);

$data4 = mysqli_query($koneksi, "SELECT * FROM koleksi_pribadi WHERE id_pengguna = '$id_pengguna_ses'");
$jmlkoleksi = mysqli_num_rows($data4);

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
                        <a class="nav-link active" aria-current="page" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="buku.php">Buku</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="koleksi.php">Koleksi Buku</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ulasan.php">Ulasan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="riwayat.php">Riwayat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
            <div class="nav-item text-right">
                <a class="nav-link"><?php echo $_SESSION['nama_pengguna']; ?> | <?php echo $_SESSION['email']; ?> | <?php echo $_SESSION['id']; ?> </a>
            </div>
        </div>
    </nav>
    <br>
    <br>

    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="card bg-primary text-white text-center">
                    <div class="card-body">
                        <h5><?php echo $jmlpinjam; ?></h5>
                    </div>
                    <div class="card-footer">
                        <h6>Jumlah Pinjam</h6>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card bg-secondary text-white text-center">
                    <div class="card-body">
                        <h5><?php echo $jmlkembali ?></h5>
                    </div>
                    <div class="card-footer">
                        <h6>Jumlah Kembali</h6>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card bg-success text-white text-center">
                    <div class="card-body">
                        <h5><?php echo $jmlhilang ?></h5>
                    </div>
                    <div class="card-footer">
                        <h6>Jumlah Buku Hilang</h6>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card bg-danger text-white text-center">
                    <div class="card-body">
                        <h5><?php echo $jmlkoleksi ?></h5>
                    </div>
                    <div class="card-footer">
                        <h6>Jumlah Koleksi</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    <br>
    
    <div class="row">
          <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
              <div class="card-header">
                <h5>Data Peminjaman</h5>
              </div>
              <div class="card-body">
                <table id="dataPeminjaman" class="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Judul Buku</th>
                      <th>Tanggal Pinjam</th>
                      <th>Nama Petugas</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                        $no = 1;
                        $id_pengguna_sess = $_SESSION['id'];
                        $query = mysqli_query($koneksi, "SELECT peminjaman.*, buku.judul, buku.gambar, rak.nama_rak, kategori.nama_kategori, petugas.nama_petugas, pengguna.nama_pengguna FROM peminjaman
                        INNER JOIN buku ON peminjaman.id_buku = buku.id
                        INNER JOIN rak ON buku.id_rak = rak.id
                        INNER JOIN kategori ON buku.id_kategori = kategori.id
                        INNER JOIN petugas ON peminjaman.id_petugas = petugas.id
                        INNER JOIN pengguna ON peminjaman.id_pengguna = pengguna.id WHERE peminjaman.status = 'pinjam' AND peminjaman.id_pengguna = '$id_pengguna_sess'
                        ORDER BY peminjaman.id DESC");
                        while ($data = mysqli_fetch_assoc($query)) :
                    ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><?php echo $data['judul']; ?></td>
                      <td><?php echo $data['tanggal_pinjam']?></td>
                      <td><?php echo $data['nama_petugas']?></td>
                      <td>
                        <a href="" class="btn btn-success" data-bs-toggle="modal"
                          data-bs-target="#modalDetailPinjam<?php echo $data['id']; ?>">Detail
                        </a>
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="container">
                              <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                  <div class="col-12">
                                    <h5>Informasi Buku</h4>
                                      <br>
                                      <div class="mb-3">
                                        <label for="">Judul</label>
                                        <input type="text" disabled class="form-control" name="judul"
                                          value="<?php echo $data['judul']; ?>">
                                      </div>
                                      <div class="mb-3">
                                        <label for="">Gambar</label>
                                        <br>
                                        <a href="../asset/gambar/<?php echo $data['gambar']; ?>" target="_blank">
                                          <img src="../asset/gambar/<?php echo $data['gambar']; ?>" width="80" height="80"
                                            alt="">
                                        </a>
                                      </div>
                                      <div class="mb-3">
                                        <label for="">Kategori</label>
                                        <input type="text" disabled class="form-control" name="nama_kategori"
                                          value="<?php echo $data['nama_kategori']; ?>">
                                      </div>
                                      <div class="mb-3">
                                        <label for="">Nama Rak</label>
                                        <input type="text" disabled class="form-control" name="nama_rak"
                                          value="<?php echo $data['nama_rak']; ?>">
                                      </div>

                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                </div>
                              </form>
                            </div>
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

          <div class="col-5 grid-margin stretch-card ">
            <div class="card">
              <div class="card-header">
                <h5>Data Booking Buku</h5>
              </div>
              <div class="card-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Judul Buku</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                        $query = mysqli_query($koneksi, "SELECT peminjaman.*, buku.judul, pengguna.nama_pengguna FROM peminjaman
                        INNER JOIN buku ON peminjaman.id_buku = buku.id
                        INNER JOIN pengguna ON peminjaman.id_pengguna = pengguna.id WHERE peminjaman.status = 'pinjam' AND peminjaman.id_petugas = 0 AND pengguna.id = '$id_pengguna_ses'
                        ORDER BY peminjaman.id DESC");
                                        while ($data = mysqli_fetch_assoc($query)) :
                                        ?>
                      <tr>
                   
                      <td><?php echo $data['judul']; ?></td>
                      <td>
                        <a href="" class="btn btn-danger" data-bs-toggle="modal"
                          data-bs-target="#modalHapusBooking<?php echo $data['id']; ?>">Hapus</a>
                      </td>
                    </tr>

                    <!-- Modal Hapus Booking-->
                    <div class="modal modal-lg" id="modalHapusBooking<?php echo $data['id']; ?>"
                      data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                      aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus
                              Peminjaman</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form action="crud_booking.php" method="post">
                              <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                              <div class="text-center">
                                <span>
                                  Anda Yakin Akan Menghapus Booking Buku : <div class="text-danger">
                                    <?php echo $data['judul']; ?>
                                  </div>
                                </span>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" name="btnHapus" class="btn btn-danger">Hapus</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal Verif Booking-->
                    <div class="modal modal-lg" id="modalVerifBooking<?php echo $data['id']; ?>"
                      data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                      aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Verifikasi Booking</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form action="crud_booking.php" method="post">
                              <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                              <div class="text-center">
                                <span>
                                  Anda Yakin Akan Memverifikasi Peminjaman : <div class="text-danger">
                                    <?php echo $data['judul']; ?>
                                  </div>
                                </span>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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
        </div>

    <script src="../asset/js/bootstrap.min.js"></script>
    <script src="../asset/js/jquery.min.js"></script>
    <script src="../asset/js/datatables.min.js"></script>
    <script src="../asset/js/dataTables.responsive.min.js"></script>
    <script src="../asset/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#dataPeminjaman').DataTable({
                responsive: true
            });
        });
    </script>

</body>

</html>
