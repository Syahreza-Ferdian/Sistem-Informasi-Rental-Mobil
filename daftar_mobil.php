<?php
include 'koneksi_db.php';
@session_start();

if (!isset($_SESSION['password']) && !isset($_SESSION['username'])) {
    @header("Location: login.php");
} else {
    @header("Location: index.php?page=daftar_mobil");
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
        if (isset($_GET['confirmDelete'])) :
            $id_mobil = $_GET['idMobil'];
            $query = "DELETE FROM mobil WHERE id_mobil='$id_mobil'";
            $deletionRes = mysqli_query($koneksi, $query);
        ?>
        ?>

            ?>

            <script>
                window.location.href = "index.php?page=daftar_mobil";
            </script>

    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h2>Daftar Kendaraan</h2>
            <div class="float-end w-25 mb-3">
                <form action="" method="get">
                    <div class="input-group input-group">
                        <input type="hidden" name="page" value="daftar_mobil">
                        <input type="search" class="form-control" id="cari_mobil" placeholder="Cari" name="cari_mobil" required value="<?=$_GET['cari_mobil'] ?? '' ?>">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass fa"></i></button>
                    </div>
                </form>
            </div>
        </div>

        <?php
            if (isset($_GET['cari_mobil'])):
                $searchParam = $_GET['cari_mobil'];

                $query = "SELECT M.id_mobil, M.nama_mobil, M.tahun, M.transmisi, M.plat_nomor, JM.jenis, M.kapasitas_penumpang, M.harga_sewa, M.status
                FROM mobil M
                INNER JOIN jenis_mobil JM ON M.id_jenis = JM.id_jenis
                WHERE M.nama_mobil LIKE CONCAT('%', '$searchParam', '%')
                OR M.plat_nomor LIKE CONCAT('%', '$searchParam', '%')
                ORDER BY M.id_mobil";

                $searchResult = mysqli_query($koneksi, $query);
                $result = mysqli_fetch_all($searchResult);
                // mysqli_free_result($searchResult);
            else:
                $query = "SELECT * FROM view_semua_mobil";
                $result = mysqli_fetch_all(mysqli_query($koneksi, $query));
            endif;
        ?>

        <div class="card-body">
            <?php
                if (!$result): ?>
                    <div class="container text-center">Data tidak ditemukan</div>

            <?php elseif ($_GET['cari_mobil'] ?? false): ?>
                <div class="container-fluid fs-5 mb-4"><strong>Hasil pencarian untuk '<?=$_GET['cari_mobil'] ?>' :</strong></div>
            <?php endif; ?>

            <?php if ($result): ?>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mobil</th>
                        <th>Tahun</th>
                        <th>Transmisi</th>
                        <th>Plat Nomor</th>
                        <th>Jenis Mobil</th>
                        <th style="width: 12%;">Kapasitas Penumpang</th>
                        <th>Harga Sewa</th>
                        <th>Status</th>
                        <th style="width: 4%;"></th>
                        <th style="width: 4%;"></th>
                        <th style="width: 5%;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;

                    foreach ($result as $row) {
                        echo "<tr><td>" . ++$count . "</td>";
                        echo "<td>" . $row[1] . "</td>";
                        echo "<td>" . $row[2] . "</td>";
                        echo "<td>" . ucwords($row[3]) . "</td>";
                        echo "<td>" . $row[4] . "</td>";
                        echo "<td>" . $row[5] . "</td>";
                        echo "<td>" . $row[6] . "</td>";
                        echo "<td>" . $row[7] . "</td>";
                        echo "<td>" . ucwords($row[8]) . "</td>";
                        echo '<form action="" method="post">';
                        echo '<input type="text" name="manipulate_id_mobil" value="' . $row[0] . '" style="display: none;">';
                        echo '<td><button type="submit" class="btn btn-primary btn-sm" name="details">Details</button></td>';
                        echo '<td><button type="submit" class="btn btn-warning btn-sm" name="edit"><i class="fa-solid fa-pen fa-2xs"></i> Edit</button></td>';
                        echo '<td><button type="submit" class="btn btn-danger btn-sm" name="delete"><i class="fa-solid fa-trash-can fa-2xs"></i> Delete</button></td>';
                        echo '</form></tr>';
                    }
                    ?>
                </tbody>
            </table>
            <?php endif; ?>

            <!-- MODAL TAMBAH MOBIL -->
            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#formTambahMobil" <?php echo isset($_GET['cari_mobil']) ? 'hidden' : '' ?> ><strong>Tambah Mobil</strong> <i class="fa-solid fa-plus fa-lg" style="margin-left: 0.2rem;"></i></button>
            <div class="modal fade" id="formTambahMobil" tabindex="-1" aria-labelledby="formTambahMobilLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="formTambahMobil">Masukkan Data Mobil Baru</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form action="" method="POST">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="car_name" placeholder="Nama Mobil" name="nama_mobil" required>
                                    <label for="car_name">Nama Mobil</label>
                                </div>
                                <br>
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="year" placeholder="Tahun Perakitan" name="tahun" required>
                                    <label for="year">Tahun Perakitan</label>
                                </div>
                                <br>
                                <div class="mb-3">
                                    <label for="selTransmisi" class="form-label">Jenis Transmis</label>
                                    <select class="form-select" aria-label="Default select example" id="selTransmisi" name="transmisi" required>
                                        <option selected>Pilih jenis transmisi</option>
                                        <option value="automatic">Automatic</option>
                                        <option value="manual">Manual</option>
                                    </select>
                                </div>
                                <br>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="plat" placeholder="Plat Nomor" name="plat_nomor" required>
                                    <label for="plat">Plat Nomor</label>
                                </div>
                                <br>
                                <div class="mb-3">
                                    <label for="selJenisMobil" class="form-label">Jenis Mobil</label>
                                    <select class="form-select" aria-label="Default select example" id="selJenisMobil" name="jenis_mobil" required>
                                        <option selected>Pilih jenis mobil</option>
                                        <option value="MPV">MPV</option>
                                        <option value="LMPV">LMPV</option>
                                        <option value="SUV">SUV</option>
                                        <option value="Sedan">Sedan</option>
                                        <option value="LCGC">LCGC</option>
                                    </select>
                                </div>
                                <br>
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="kapasitasPnp" placeholder="Kapasitas Penumpang" name="kapasitas_pnp" required>
                                    <label for="kapasitasPnp">Kapasitas Penumpang</label>
                                </div>
                                <br>
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="hargaSewa" placeholder="Harga Sewa" name="harga_sewa" required>
                                    <label for="hargaSewa">Harga Sewa</label>
                                </div>
                                <br>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status Mobil</label>
                                    <select class="form-select" aria-label="Default select example" id="status" name="status_mobil" required>
                                        <option selected>Pilih Status</option>
                                        <option value="ready">Ready</option>
                                        <option value="not ready">Not Ready</option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancel">Batal</button>
                                    <button class="btn btn-primary" type="submit" name="submit" value="Submit" id="save">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL EDIT MOBIL -->
            <?php
            if (isset($_POST['edit'])) :
                $id_mobil = $_POST['manipulate_id_mobil'];
                $query = "CALL ShowMobilByID('$id_mobil')";
                $editRes = mysqli_query($koneksi, $query);
                $dataEditMobil = mysqli_fetch_row($editRes);
            ?>
                <script>
                    window.onload = function() {
                        var editMobilModal = new bootstrap.Modal(document.getElementById('formEditMobil'));
                        editMobilModal.show();
                    }
                </script>
            <?php endif ?>


            <div class="modal fade" id="formEditMobil" tabindex="-1" aria-labelledby="formEditMobilLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="formEditMobil">Edit Data Mobil</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form action="" method="post">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="car_name" placeholder="Nama Mobil" name="nama_mobil" value="<?= $dataEditMobil[1] ?>">
                                    <label for="car_name">Nama Mobil</label>
                                </div>
                                <br>
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="year" placeholder="Tahun Perakitan" name="tahun" value="<?= (int)$dataEditMobil[2] ?>">
                                    <label for="year">Tahun Perakitan</label>
                                </div>
                                <br>
                                <div class="mb-3">
                                    <label for="selTransmisi" class="form-label">Jenis Transmis</label>
                                    <select class="form-select" aria-label="Default select example" id="selTransmisi" name="transmisi" required>
                                        <option>Pilih jenis transmisi</option>
                                        <option value="automatic" <?php echo $dataEditMobil[3] == 'automatic' ? 'selected' : ''; ?>>Automatic</option>
                                        <option value="manual" <?php echo $dataEditMobil[3] == 'manual' ? 'selected' : ''; ?>>Manual</option>
                                    </select>
                                </div>
                                <br>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="plat" placeholder="Plat Nomor" name="plat_nomor" value="<?= $dataEditMobil[4] ?>">
                                    <label for="plat">Plat Nomor</label>
                                </div>
                                <br>
                                <div class="mb-3">
                                    <label for="selJenisMobil" class="form-label">Jenis Mobil</label>
                                    <select class="form-select" aria-label="Default select example" id="selJenisMobil" name="jenis_mobil" required>
                                        <option>Pilih jenis mobil</option>
                                        <option value="MPV" <?php echo $dataEditMobil[5] == 'MPV' ? 'selected' : ''; ?>>MPV</option>
                                        <option value="LMPV" <?php echo $dataEditMobil[5] == 'LMPV' ? 'selected' : ''; ?>>LMPV</option>
                                        <option value="SUV" <?php echo $dataEditMobil[5] == 'SUV' ? 'selected' : ''; ?>>SUV</option>
                                        <option value="Sedan" <?php echo $dataEditMobil[5] == 'Sedan' ? 'selected' : ''; ?>>Sedan</option>
                                        <option value="LCGC" <?php echo $dataEditMobil[5] == 'LCGC' ? 'selected' : ''; ?>>LCGC</option>
                                    </select>
                                </div>
                                <br>
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="kapasitasPnp" placeholder="Kapasitas Penumpang" name="kapasitas_pnp" value="<?= $dataEditMobil[6] ?>">
                                    <label for="kapasitasPnp">Kapasitas Penumpang</label>
                                </div>
                                <br>
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="hargaSewa" placeholder="Harga Sewa" name="harga_sewa" value="<?= $dataEditMobil[7] ?>">
                                    <label for="hargaSewa">Harga Sewa</label>
                                </div>
                                <br>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status Mobil</label>
                                    <select class="form-select" aria-label="Default select example" id="status" name="status_mobil" required>
                                        <option>Pilih Status</option>
                                        <option value="ready" <?php echo $dataEditMobil[8] == 'ready' ? 'selected' : ''; ?>>Ready</option>
                                        <option value="not ready" <?php echo $dataEditMobil[8] == 'not ready' ? 'selected' : ''; ?>>Not Ready</option>
                                    </select>
                                </div>

                                <div class="modal-footer">
                                    <input type="text" name="edit_id_mobil" value="<?= $id_mobil ?>" style="display: none;">
                                    <a href=""><button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancel">Batal</button></a>
                                    <button class="btn btn-primary" type="submit" name="saveEdit" value="saveEdit" id="edit">Edit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- DETAILS MODAL -->
            <?php
            if (isset($_POST['details'])) :
                $id_mobil_detail = $_POST['manipulate_id_mobil'];
                $query = "SELECT * FROM mobil WHERE id_mobil =" . $id_mobil_detail;
                $data_detail_mobil = mysqli_fetch_assoc(mysqli_query($koneksi, $query));
                $query = "SELECT getCountOrderMobil ('$id_mobil_detail') as HITUNG";
                $diorder_brp_kali = mysqli_fetch_assoc(mysqli_query($koneksi, $query));

            ?>
                <script>
                    window.onload = function() {
                        var detail_mobil_modal = new bootstrap.Modal(document.getElementById('carDetails'));
                        detail_mobil_modal.show();
                    }
                </script>

            <?php endif; ?>

            <div class="modal fade" id="carDetails" tabindex="-1" aria-labelledby="detailsLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="formTambahMobil">Detail Mobil</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                Nama Mobil: <?= $data_detail_mobil['nama_mobil'] ?>
                            </div>
                            <div class="mb-3">
                                Diorder Sebanyak: <?= $diorder_brp_kali['HITUNG'] ?>
                            </div>
                            <!-- <div class="mb-3">
                                    <?= $data_detail_mobil['nama_mobil'] ?>
                                </div> -->
                        </div>

                        <div class="modal-footer">
                            <a href=""><button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="close">Tutup</button></a>
                            <!-- <button class="btn btn-primary" type="submit" name="submit" value="Submit" id="oke">Ok</button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
    if (isset($_POST['submit'])) :
        $namaMobil = $_POST['nama_mobil'];
        $tahun = $_POST['tahun'];
        $transmisi = $_POST['transmisi'];
        $platNomor = $_POST['plat_nomor'];
        $jenisMobil = $_POST['jenis_mobil'];
        $kapasitasPenumpang = $_POST['kapasitas_pnp'];
        $hargaSewa = $_POST['harga_sewa'];
        $status = $_POST['status_mobil'];

        // echo $transmisi;
        $query = "CALL TambahMobilBaru('$namaMobil', '$tahun', '$platNomor', '$jenisMobil', '$kapasitasPenumpang', '$hargaSewa', '-', '$status', '$transmisi')";
        $result = mysqli_query($koneksi, $query);
    ?>
        <!-- SWEETALERT Berhasil Menambahkan Data -->
        <script>
            Swal.fire({
                title: 'Berhasil',
                text: 'Data Mobil Berhasil Ditambahkan',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "index.php?page=daftar_mobil";
                }
            })
        </script>
    <?php endif; ?>

    <?php
    if (isset($_POST['saveEdit'])) :
        $namaMobil = $_POST['nama_mobil'];
        $tahun = $_POST['tahun'];
        $transmisi = $_POST['transmisi'];
        $platNomor = $_POST['plat_nomor'];
        $jenisMobil = $_POST['jenis_mobil'];
        $kapasitasPenumpang = $_POST['kapasitas_pnp'];
        $hargaSewa = $_POST['harga_sewa'];
        $status = $_POST['status_mobil'];

        $id_mobil_to_edit = $_POST['edit_id_mobil'];
        $query = "CALL UpdateDataMobil ('$id_mobil_to_edit', '$namaMobil', '$tahun', '$transmisi', '$platNomor', '$jenisMobil', '$kapasitasPenumpang', '$hargaSewa', '$status')";
        $result = mysqli_query($koneksi, $query);

    ?>
        <script>
            Swal.fire({
                title: 'Berhasil',
                text: 'Data Mobil Berhasil Diupdate',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "index.php?page=daftar_mobil";
                }
            })
        </script>
    <?php endif; ?>

    <?php
    if (isset($_POST['delete'])) :
        $manipulate_id_mobil = $_POST['manipulate_id_mobil'];
    ?>
        <script>
            window.onload = function() {
                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    text: "Apakah Anda yakin ingin menghapus data mobil ini?",
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
                            text: 'Data Mobil Berhasil Dihapus',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "index.php?page=daftar_mobil&confirmDelete=true&idMobil=<?= $manipulate_id_mobil ?>";
                            }
                        })
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        window.location.href = "index.php?page=daftar_mobil";
                    }
                })
            }
        </script>

    <?php endif; ?>

</body>

</html>