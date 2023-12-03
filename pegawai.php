<?php
    include_once 'koneksi_db.php';
    @session_start();

    if (!isset($_SESSION['password']) && !isset($_SESSION['username'])) {
        @header("Location: login.php");
    } else {
        @header("Location: index.php?page=pegawai");
    }
    if ($_SESSION['isOwner'] == 1) {
        $hiddenFromPegawai = false;
    }
    else {
        $hiddenFromPegawai = true;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
    <?php
        if (isset($_GET['confirmDelete'])):
            $emp_id = $_GET['emp_id'];
            $query = "DELETE FROM pegawai WHERE id_pegawai = '$emp_id'";
            mysqli_query($koneksi, $query); ?>

            <script>
                window.location.href = "index.php?page=pegawai";
            </script>

        <?php endif;
    ?>

    <?php
        if (isset($_GET['act'])):
            $param = $_GET['act'];
            if ($param == 'add_driver'):
                $emp_id = $_GET['emp_id'];
                $query = "CALL AssignAsDriver('$emp_id')";
                mysqli_query($koneksi, $query); ?>

                <script>
                    Swal.fire({
                        title: 'Berhasil',
                        text: 'Berhasil menambahkan pegawai menjadi driver',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "index.php?page=pegawai";
                        }
                    });
                </script>
            <?php
            elseif ($param == 'fired'): 
                $emp_id = $_GET['emp_id']; ?>
                <script>
                    window.onload = function() {
                        Swal.fire({
                            title: 'Konfirmasi Pemecatan Pegawai',
                            text: "Apakah Anda yakin ingin memecat pegawai ini?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Iya',
                            cancelButtonText: 'Tidak'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: 'Berhasil',
                                    text: 'Data Pegawai Tersebut Berhasil Dihapus',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "index.php?page=pegawai&confirmDelete=true&emp_id=<?= $emp_id ?>";
                                    }
                                })
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                window.location.href = "index.php?page=pegawai";
                            }
                        })
                    }
                </script>
            <?php elseif ($param == 'rem_driver'):
                $driver_id = $_GET['driver_id'];
                $query = "DELETE FROM driver WHERE id_pegawai=" .$driver_id;
                $result = mysqli_query($koneksi, $query);            
            endif;
        endif;
    ?>

    <div class="container">
        <div class="card mt-3">
            <div class="card-header text-center mb-0">
                <h2>Daftar Pegawai</h2>
            </div>

            <div class="card-body">
                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="driver-tab" data-bs-toggle="tab" data-bs-target="#driver-tab-pane" type="button" role="tab" aria-controls="driver-tab-pane" aria-selected="true">Driver</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="employee-tab" data-bs-toggle="tab" data-bs-target="#employee-tab-pane" type="button" role="tab" aria-controls="employee-tab-pane" aria-selected="false">Semua Pegawai</button>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade" id="driver-tab-pane" role="tabpanel" aria-labelledby="driver-tab" tabindex="0">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Nomor Telp</th>
                                    <th>Current Car</th>
                                    <th>Status</th>
                                    <?= $hiddenFromPegawai ? '' : '<th>Action</th>' ?>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    $count = 0;
                                    $query = "SELECT D.id_pegawai, P.nama, P.no_telepon, D.status
                                                FROM driver D
                                                INNER JOIN pegawai P ON D.id_pegawai = P.id_pegawai
                                                WHERE D.id_pegawai > 1
                                                ORDER BY D.id_pegawai";
                                    $drivers = mysqli_fetch_all(mysqli_query($koneksi, $query));

                                    foreach($drivers as $row) {
                                        $query = "SELECT getCurrentDriverCar('$row[0]')";
                                        $car = mysqli_fetch_row(mysqli_query($koneksi, $query));
                                        $badgeStatus;

                                        if ($row[3] == 'not ready') {
                                            $badgeStatus = 'warning';
                                        }
                                        elseif ($row[3] == 'ready') {
                                            $badgeStatus = 'success';
                                        }

                                        echo "<tr><td>" .++$count ."</td>";
                                        echo "<td>" .$row[1] . "</td>";
                                        echo "<td>" .$row[2] . "</td>";
                                        echo "<td>" .($car[0] ?? '-') . "</td>";
                                        echo '<td><span class="badge text-bg-' . $badgeStatus . '">' . ucwords($row[3]) . '</span></td>';
                                        echo '<form action="" method="POST">';
                                        echo '<input type="text" name="driver_id" value="' . $row[0] . '" style="display: none;">';
                                        echo $hiddenFromPegawai ? '' : '<td><button type="submit" name="driver_del" class="btn btn-danger btn-sm">Remove</button></td>';
                                        echo '</form>';
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>

                        <?php
                            if (isset($_POST['driver_del'])):
                                $driver_id = $_POST['driver_id']; ?>
                                
                                <script>
                                    window.onload = function() {
                                        Swal.fire({
                                            title: 'Konfirmasi Penghapusan',
                                            text: "Apakah Anda yakin ingin menghapus pegawai tersebut dari daftar Driver?",
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: 'Iya',
                                            cancelButtonText: 'Batal'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                Swal.fire({
                                                    title: 'Berhasil',
                                                    text: 'Data berhasil diupdate',
                                                    icon: 'success',
                                                    confirmButtonText: 'OK'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        window.location.href = "index.php?page=pegawai&act=rem_driver&driver_id=<?= $driver_id ?>";
                                                    }
                                                })
                                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                                window.location.href = "index.php?page=pegawai";
                                            }
                                        })
                                    }
                                </script>

                            <?php endif; 
                        ?>
                    </div>
                    <div class="tab-pane fade" id="employee-tab-pane" role="tabpanel" aria-labelledby="employee-tab" tabindex="0">
                        <table class="table table-hover table-striped">
                            <thead>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Nomor Telepon</th>
                                <th>Account Username</th>
                                <th>Last Login</th>
                                <th>Additional Role</th>
                                <?= $hiddenFromPegawai ? '': '<th></th>' ?>
                            </thead>

                            <tbody>
                                <?php
                                    $count = 0;
                                    $query = "SELECT * FROM pegawai WHERE id_pegawai > 1 ORDER BY id_pegawai";
                                    $pegawai = mysqli_fetch_all(mysqli_query($koneksi, $query));
                                    
                                    foreach($pegawai as $row) {
                                        $badgeStatus;
                                        $role_text;

                                        $query = "SELECT COUNT(*) FROM driver WHERE id_pegawai = " . $row[0];
                                        $cekDriver = mysqli_fetch_row(mysqli_query($koneksi, $query));

                                        if ($row[5] == 0) {
                                            $badgeStatus = 'secondary';
                                            $role_text = 'Pegawai Biasa';
                                        }
                                        else if ($row[5] == 1) {
                                            $badgeStatus = 'warning';
                                            $role_text = 'Owner';
                                        }

                                        if ($cekDriver[0] > 0) {
                                            $isDriver = true;
                                        } else {
                                            $isDriver = false;
                                        }

                                        echo "<tr><td>" .++$count ."</td>";
                                        echo "<td>" .$row[1] ."</td>";
                                        echo "<td>" .$row[4] ."</td>";
                                        echo "<td>" .$row[2] ."</td>";
                                        echo "<td>" .($row[6] ?? "<em>Tidak terdeteksi</em>")."</td>";
                                        echo '<td><span class="badge text-bg-' . $badgeStatus . '">' . $role_text . '</span>' .($isDriver ? ' <span class="badge text-bg-primary">Driver</span>' : '').'</td>';
                                        echo $hiddenFromPegawai ? '' : '
                                        <td><button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                                        <ul class="dropdown-menu">
                                        <li><a class="dropdown-item '. ($isDriver ? 'disabled' : '') .'" href="index.php?page=pegawai&act=add_driver&emp_id=' .$row[0] .'">Tugaskan Sebagai Driver</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="index.php?page=pegawai&act=fired&emp_id=' .$row[0] .'">Pecat Pegawai</a></li>
                                        </ul></td>
                                        ';
                                    }
                                ?>
                            </tbody>
                        </table>

                        <!-- MODAL TAMBAH PEGAWAI -->
                        <?= $hiddenFromPegawai ? '' : '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#form-tambah-pegawai"><strong>Tambah pegawai baru</strong> <i class="fa-solid fa-plus fa-lg"></i> </button>' ?>
                        <div class="modal fade" id="form-tambah-pegawai" tabindex="-1" aria-labelledby="form-tambah-pegawai" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="form-tambah-pegawai">Masukkan Data Pegawai</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <form action="" method="POST">
                                            <div class="form-floating">
                                                <input type="text" name="nama_pegawai" id="emp_name" class="form-control" placeholder="Nama Pegawai" required>
                                                <label for="emp_name">Nama Pegawai</label>
                                            </div>
                                            <br>
                                            <div class="form-floating">
                                                <input type="text" name="username" id="emp_username" class="form-control" placeholder="Username" required>
                                                <label for="emp_username">Nama Akun Pegawai</label>
                                            </div>
                                            <br>
                                            <div class="form-floating">
                                                <input type="password" name="account_password" id="acc_pass" class="form-control" placeholder="Password" required>
                                                <label for="acc_pass">Password Akun</label>
                                            </div>
                                            <br>
                                            <div class="form-floating">
                                                <input type="number" name="phone" id="phone_num" class="form-control" placeholder="Nomor Telepon" required>
                                                <label for="phone_num">Nomor Telepon</label>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancel">Batal</button>
                                                <button class="btn btn-primary" type="submit" name="add">Tambah</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                            $sweetalert = "";
                            if (isset($_POST['add'])) {
                                $nama_pegawai = $_POST['nama_pegawai'];
                                $username = $_POST['username'];
                                $account_password = $_POST['account_password'];
                                $phone = $_POST['phone'];

                                $query = "CALL TambahPegawai('$nama_pegawai', '$username', '$account_password', '$phone')";

                                try {
                                    $result = mysqli_query($koneksi, $query);
                                    
                                    $sweetalert = "
                                        Swal.fire({
                                            title: 'Berhasil',
                                            text: 'Berhasil menambahkan pegawai baru',
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = 'index.php?page=pegawai';
                                            }
                                        });
                                    ";
                                } catch (Exception $e) {
                                    $e->__construct("Username yang Anda inputkan sudah dipakai pegawai lain!");
                                    $sweetalert = "
                                        Swal.fire({
                                            title: 'Gagal',
                                            text: '{$e->getMessage()}',
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                
                                            }
                                        });
                                    ";
                                }
                            }
                            echo "<script>{$sweetalert}</script>";
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tabs = document.querySelectorAll('.nav-tabs .nav-link');

            var activeTabId = localStorage.getItem('activeTabId') || 'driver-tab';

            tabs.forEach(function (tab) {
                tab.addEventListener('click', function () {
                    var activeTabId = this.id;
                    localStorage.setItem('activeTabId', activeTabId);
                });
            });

            tabs.forEach(function (tab) {
                if (tab.id === activeTabId) {
                    tab.classList.add('active');
                    var activeTabContent = document.getElementById(activeTabId + '-pane');
                    activeTabContent.classList.add('show', 'active');
                } else {
                    tab.classList.remove('active');
                }
            });
        });
    </script>
</body>

</html>