<?php
$result = $data['semuaMobil'];
// print_r($data['detail']);
if ($_SESSION['isOwner'] == 1) {
    $hiddenFromPegawai = false;
} else {
    $hiddenFromPegawai = true;
}
?>

<head>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">

</head>

<body>
    <div class="card">
        <div class="card-header">
            <h2>Daftar Kendaraan</h2>
            <div class="float-lg-end mb-3">
                <form action="<?= base_url; ?>/mobil/cari" method="get">
                    <div class="input-group input-group">
                        <!-- <input type="hidden" name="page" value="daftar_mobil"> -->
                        <input type="search" class="form-control" id="cari_mobil" placeholder="Cari" name="cari_mobil" required value="<?= $_GET['cari_mobil'] ?? '' ?>">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass fa"></i></button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body table-responsive">
            <?php if (isset($data['searchParam']) && !$data['semuaMobil']) : ?>
                <div class="container text-center">Data tidak ditemukan</div>

            <?php elseif (isset($data['searchParam'])) : ?>
                <div class="container-fluid fs-5 mb-4"><strong>Hasil pencarian untuk '<?= $data['searchParam'] ?>' :</strong></div>

            <?php endif ?>

            <?php if ($data['semuaMobil']) : ?>

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
                            <th style="width: 4%;" <?php echo $hiddenFromPegawai ? 'hidden' : '' ?>></th>
                            <th style="width: 5%;" <?php echo $hiddenFromPegawai ? 'hidden' : '' ?>></th>
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
                            echo '<form action="" method="post" id="control_form">';
                            echo '<input type="text" name="manipulate_id_mobil" value="' . $row[0] . '" style="display: none;">';
                            echo '<td><button type="submit" class="btn btn-primary btn-sm" name="details">Details</button></td>';
                            echo '<td><button type="submit" class="btn btn-warning btn-sm" name="edit" ', $hiddenFromPegawai ? 'hidden' : '', '><i class="fa-solid fa-pen fa-2xs"></i> Edit</button></td>';
                            echo '<td><button type="submit" class="btn btn-danger btn-sm" name="delete" ', $hiddenFromPegawai ? 'hidden' : '', '><i class="fa-solid fa-trash-can fa-2xs"></i> Delete</button></td>';
                            echo '</form></tr>';
                        }
                        ?>
                    </tbody>
                </table>

                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#formTambahMobil" <?php echo isset($data['searchParam']) || $hiddenFromPegawai ? 'hidden' : '' ?>><strong>Tambah Mobil</strong> <i class="fa-solid fa-plus fa-lg" style="margin-left: 0.2rem;"></i></button>


                <!-- MODAL TAMBAH MOBIL -->
                <div class="modal fade" id="formTambahMobil" tabindex="-1" aria-labelledby="formTambahMobilLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="formTambahMobil">Masukkan Data Mobil Baru</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <form action="<?= base_url ?>/mobil/tambah" method="POST" id="tambahForm">
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

                <!-- SCRIPT TAMBAH MOBIL -->
                <script>
                    document.getElementById("tambahForm").addEventListener("submit", function(e) {
                        e.preventDefault();

                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Data Mobil Berhasil Ditambahkan',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                sendPostRequest();
                                window.location.href = "<?= base_url ?>/mobil";
                            }
                        });

                        function sendPostRequest() {
                            var xhr = new XMLHttpRequest();
                            var formData = new FormData(document.getElementById("tambahForm"));

                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === XMLHttpRequest.DONE) {
                                    if (xhr.status === 200) {
                                        console.log('XHR successful'); //untuk ngetest
                                    } else {
                                        console.error('XHR error');
                                    }
                                }
                            };

                            xhr.open("POST", "<?= base_url ?>/mobil/tambah", true);
                            xhr.send(formData);
                        }
                    });
                </script>

                <?php
                if (isset($_POST['details'])) :
                    $c = new MobilController();
                    $out = $c->showDetail();
                ?>
                    <script>
                        window.onload = function() {
                            var detail_mobil_modal = new bootstrap.Modal(document.getElementById('carDetails'));
                            detail_mobil_modal.show();
                        }
                    </script>
                <?php endif;
                ?>
                <!-- MODAL DETAILS -->
                <div class="modal fade" id="carDetails" tabindex="-1" aria-labelledby="detailsLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="formTambahMobil">Detail Mobil</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    Nama Mobil: <?= $out['detail']['data_detail_mobil']['nama_mobil'] ?>
                                </div>
                                <div class="mb-3">
                                    Diorder Sebanyak: <?= $out['detail']['diorder_brp_kali']['HITUNG'] ?>
                                </div>
                                <!-- <div class="mb-3">
                                    <?= $data['nama_mobil'] ?>
                                </div> -->
                            </div>

                            <div class="modal-footer">
                                <a href=""><button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="close">Tutup</button></a>
                                <!-- <button class="btn btn-primary" type="submit" name="submit" value="Submit" id="oke">Ok</button> -->
                            </div>
                        </div>
                    </div>
                </div>

                
                <?php
                if (isset($_POST['edit'])) :
                    $c = new MobilController();
                    $dataEditMobil = $c->show_mobil_prop_to_edit();
                ?>
                    <script>
                        window.onload = function() {
                            var edit_mobil_modal = new bootstrap.Modal(document.getElementById('formEditMobil'));
                            edit_mobil_modal.show();
                        }
                    </script>
                <?php endif;
                ?>
                <!-- MODAL EDIT -->
                <div class="modal fade" id="formEditMobil" tabindex="-1" aria-labelledby="formEditMobilLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="formEditMobil">Edit Data Mobil</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <form action="" method="post" id="edit_mobil">
                                    <input type="hidden" name="edit_id_mobil" value="<?= $dataEditMobil[0] ?>">
                                    
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
                                        <a href=""><button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancel">Batal</button></a>
                                        <button class="btn btn-primary" type="submit" name="saveEdit" value="saveEdit" id="edit">Edit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <script>
                    document.getElementById("edit_mobil").addEventListener("submit", function(e) {
                        e.preventDefault();

                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Data Mobil Berhasil Diupdate',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                sendPostRequest();
                                window.location.assign("<?= base_url ?>/mobil");
                            }
                        });

                        function sendPostRequest() {
                            var xhr = new XMLHttpRequest();
                            var formData = new FormData(document.getElementById("edit_mobil"));

                            // xhr.onreadystatechange = function() {
                            //     if (xhr.readyState === XMLHttpRequest.DONE) {
                            //         if (xhr.status === 200) {
                            //             console.log('XHR successful'); //untuk ngetest
                            //         } else {
                            //             console.error('XHR error');
                            //         }
                            //     }
                            // };

                            xhr.open("POST", "<?= base_url ?>/mobil/edit_then_update", true);
                            xhr.send(formData);
                        }
                    });
                </script>

        </div>

    <?php endif; ?>
    </div>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> -->
</body>