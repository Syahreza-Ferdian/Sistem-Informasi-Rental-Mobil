<?php
include_once 'koneksi_db.php';
@session_start();

if (!isset($_SESSION['password']) && !isset($_SESSION['username'])) {
    @header("Location: login.php");
} else {
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

                        foreach ($result as $row) {
                            $statusLabel;
                            if ($row[4] == 'pending') :
                                $statusLabel = 'warning';
                            elseif ($row[4] == 'cancelled') :
                                $statusLabel = 'danger';
                            elseif ($row[4] == 'on rent') :
                                $statusLabel = 'primary';
                            elseif ($row[4] == 'completed') :
                                $statusLabel = 'success';
                            endif;

                            echo "<tr><td>" . ++$count . "</td>";
                            echo "<td>" . $row[0] . "</td>";
                            echo "<td>" . $row[1] . "</td>";
                            echo "<td>" . $row[2] . "</td>";
                            echo "<td>" . $row[3] . "</td>";
                            // echo "<td>" .$row[4] . "</td>";
                            echo '<td><span class="badge text-bg-' . $statusLabel . '">' . ucwords($row[4]) . '</span></td>';

                            echo '<form action="" method="post">';
                            echo '<input type="text" name="id_transaksi_to_show" value="' . $row[0] . '" style="display: none;">';
                            echo '<td><button type="submit" class="btn btn-primary btn-sm" name="details">Details</button></td>';
                        }
                        ?>
                    </tbody>
                </table>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#form-input-nama-pelanggan"><strong>Tambah transaksi baru</strong> <i class="fa-solid fa-plus fa-lg"></i> </button>

                <form action="" method="POST">
                    <div class="modal fade" id="form-input-nama-pelanggan" tabindex="-1" aria-labelledby="form-input-nama-pelanggan" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="formTambahMobil">Masukkan Data Pelanggan</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
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
                                    <br>
                                    <div class="form-floating">
                                        <input type="number" name="nik_customer" id="nik_customer" class="form-control" placeholder="NIK" required>
                                        <label for="nik_customer">NIK (Nomor Induk Kependudukan)</label>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancel">Batal</button>
                                    <button class="btn btn-primary" type="button" data-bs-target="#form-tambah-transaksi" data-bs-toggle="modal">Next</button> <!-- NEXT = KE FORM TAMBAH TRANSAKSI -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="form-tambah-transaksi" tabindex="-1" aria-labelledby="form-tambah-transaksi" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="formTambahMobil">Masukkan Data Transaksi</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="form-floating">
                                        <select class="form-select" id="car-select" aria-label="Car select" name="car_select">
                                            <option selected>Select One</option>

                                            <?php
                                            $query = "SELECT * FROM view_mobil_tersedia";
                                            $result = mysqli_fetch_all(mysqli_query($koneksi, $query));

                                            foreach ($result as $row) {
                                                echo '<option value="' . $row[0] . '">' . $row[1] . ' - ' . $row[3] . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <label for="car-select">Pilih mobil yang akan disewa</label>
                                    </div>
                                    <br>
                                    <div class="form-floating">
                                        <input type="number" name="durasi_sewa" id="rent-duration" class="form-control" placeholder="Durasi" required>
                                        <label for="rent-duration">Durasi Sewa</label>
                                    </div>
                                    <br>
                                    <div class="form-floating">
                                        <input type="datetime-local" name="tanggal_sewa" id="tgl-sewa" class="form-control" placeholder="Tanggal Sewa" required>
                                        <label for="tgl-sewa">Tanggal Mulai Sewa</label>
                                    </div>
                                    <br>
                                    <fieldset class="row mb-3">
                                        <legend class="col-form-label col-sm-3 pt-0">Status Pengambilan</legend>
                                        <div class="col-sm-5">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status_pengambilan" id="flexRadioDefault1" value="ambil di tempat">
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    Ambil di Tempat
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status_pengambilan" id="flexRadioDefault2" value="diantar">
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                    Diantar
                                                </label>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <br>
                                    <fieldset class="row mb-3">
                                        <legend class="col-form-label col-sm-3 pt-0">Status Lepas Kunci</legend>
                                        <div class="col-sm-5" id="check">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status_lepas_kunci" id="flexRadioDefault3" value="lepas kunci">
                                                <label class="form-check-label" for="flexRadioDefault3">
                                                    Lepas Kunci
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status_lepas_kunci" id="flexRadioDefault4" value="dengan driver">
                                                <label class="form-check-label" for="flexRadioDefault4">
                                                    Dengan Driver
                                                </label>
                                            </div>
                                            <p id="assign"></p>
                                        </div>
                                    </fieldset>

                                    <input type="hidden" name="driver_id" id="driver_id_hidden">
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancel">Batal</button>
                                    <button class="btn btn-primary" type="submit" id="save" value="simpan">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        <?php
            $query = "SELECT * from view_driver_tersedia";
            $result = mysqli_fetch_all(mysqli_query($koneksi, $query));
            $id = array();
            $name = array();
            foreach ($result as $row) {
                $id[] = $row[0];
                $name[$row[0]] = $row[1];
            }
        ?>

        function randomAssignDriver() {
            const ids = <?= json_encode($id) ?>;
            const random_id = Math.floor(Math.random() * ids.length);
            return ids[random_id].toString();
        }

        document.getElementById("check").addEventListener("change", () => {
            const radio1 = document.getElementById("flexRadioDefault3");
            const radio2 = document.getElementById("flexRadioDefault4");
            const driver_id_hidden_input = document.getElementById("driver_id_hidden");
            const assignParagraph = document.getElementById('assign');
            
            if (radio1.checked) {
                assignParagraph.textContent = "";
                driver_id_hidden_input.value = 1;
            }
            if (radio2.checked) {
                const randomDriverID = randomAssignDriver();
                const driverName = <?= json_encode($name) ?>[randomDriverID];

                assignParagraph.textContent = "Automatically assign driver ID: " + randomDriverID + " - " + driverName;
                driver_id_hidden_input.value = parseInt(randomDriverID);
            } 
        });
    </script>
</body>

</html>