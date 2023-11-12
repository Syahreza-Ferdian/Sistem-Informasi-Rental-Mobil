<?php
    include_once 'koneksi_db.php';
    @session_start();

    if (!isset($_SESSION['password']) && !isset($_SESSION['username'])) {
        @header("Location: login.php");
    }
    else {
        @header("Location: index.php?page=transaksi");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi</title>
</head>

<body>
    <div class="container">
        <!-- <hr>
        <h1>This Page Under Development</h1>
        <img src="https://i.postimg.cc/k5NJmHZG/image.png" alt="" srcset="">
        <hr> -->

        <div class="card" style="margin-top: 1rem;">
            <div class="card-header text-center">
                <h2>Daftar Transaksi</h2>
            </div>

            <div class="card-body">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Faktur</th>
                            <th>Nama Customer</th>
                            <th>Mobil</th>
                            <th>Tanggal Transaksi</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                        
                    <tbody>
                        <?php
                            $count = 0;
                            $query = "SELECT * FROM view_semua_transaksi";
                            $result = mysqli_fetch_all(mysqli_query($koneksi, $query));

                            foreach ($result as $row){
                                $statusLabel;
                                if ($row[4] == 'pending'):
                                    $statusLabel = 'warning';
                                elseif ($row[4] == 'cancelled'):
                                    $statusLabel = 'danger';
                                elseif ($row[4] == 'on rent'):
                                    $statusLabel = 'primary';
                                elseif ($row[4] == 'completed'):
                                    $statusLabel = 'success';
                                endif;

                                echo "<tr><td>" . ++$count . "</td>";
                                echo "<td>" .$row[0] . "</td>";
                                echo "<td>" .$row[1] . "</td>";
                                echo "<td>" .$row[2] . "</td>";
                                echo "<td>" .$row[3] . "</td>";
                                // echo "<td>" .$row[4] . "</td>";
                                echo '<td><span class="badge text-bg-' .$statusLabel .'">' .ucwords($row[4]) .'</span></td>';
                                
                                echo '<form action="" method="post">';
                                echo '<input type="text" name="id_transaksi_to_show" value="' .$row[0] .'" style="display: none;">';
                                echo '<td><button type="submit" class="btn btn-primary btn-sm" name="details">Details</button></td>';
                            }
                        ?>
                    </tbody>
                </table>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formTambahTransaksi"><strong>Tambah transaksi baru</strong> <i class="fa-solid fa-plus fa-lg"></i> </button>
                <div class="modal fade" id="formTambahTransaksi" tabindex="-1" aria-labelledby="formTambahTransaksi" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="formTambahMobil">Masukkan Data Transaksi Baru</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <form action="" method="POST">
                                    <div class="form-floating">
                                        <input type="text" name="nama_customer" id="customer_name" class="form-control" placeholder="Nama Customer" required>
                                        <label for="customer_name">Nama Customer</label>
                                    </div>
                                    <br>
                                    <div class="form-floating">
                                        <input type="text" name="alamat_customer" id="customer_address" class="form-control" placeholder="Alamat Customer" required>
                                        <label for="customer_address">Alamat Customer</label>
                                    </div>
                                    <br>
                                    <div class="form-floating">
                                        <input type="number" name="nomor_telp_customer" id="nomor_telp_customer" class="form-control" placeholder="Nomor Telepon" required>
                                        <label for="nomor_telp_customer">Nomor Telepon Customer</label>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancel">Batal</button>
                                        <button class="btn btn-primary" type="submit" name="submit" value="Submit" id="save">Simpan</button>  <!-- NEXT = KE FORM TAMBAH TRANSAKSI -->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>