<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <!-- <hr>
        <h1>This Page Under Development</h1>
        <img src="https://i.postimg.cc/k5NJmHZG/image.png" alt="" srcset="">
        <hr> -->

        <div class="card mt-3">
            <div class="card-header text-center">
                <h2 class="mt-1">Customers</h2>
                <div class="float-lg-end mb-3 w-25">
                    <form action="" method="get">
                        <div class="input-group input-group">
                            <input type="hidden" name="page" value="customer">
                            <input type="search" class="form-control" id="cari_customer" placeholder="Search" name="cari_customer" required value="">
                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass fa"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <?php
                if (isset($_GET['cari_customer'])):
                    $searchParam = $_GET['cari_customer'];

                    $query = "SELECT * FROM customer
                                WHERE nama LIKE CONCAT('%', '$searchParam', '%')
                                OR alamat LIKE CONCAT('%', '$searchParam', '%')
                                OR no_telepon LIKE CONCAT('%', '$searchParam', '%')
                                ORDER BY id_customer";
                    $searchResult = mysqli_query($koneksi, $query);
                    $result = mysqli_fetch_all($searchResult);
                else:
                    $query = "SELECT * FROM customer";
                    $result = mysqli_fetch_all(mysqli_query($koneksi, $query));
                endif;
            ?>
            
            <div class="card-body">
                <?php if (!$result): ?>
                    <div class="container text-center"><strong>Data tidak ditemukan</strong></div>

                <?php elseif ($_GET['cari_customer'] ?? false): ?>
                    <div class="container-fluid fs-5 mb-4"><strong>Hasil pencarian untuk '<?= $_GET['cari_customer'] ?>' :</strong></div>
                
                <?php endif; ?>
                
                <?php if ($result): ?>
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No Telepon</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                $count = 0;

                                foreach($result as $row) {
                                    echo "<tr><td>" .++$count . "</td>";
                                    echo "<td>" . $row[1] . "</td>";
                                    echo "<td>" . $row[2] . "</td>";
                                    echo "<td>" . $row[3] . "</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>