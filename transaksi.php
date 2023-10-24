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
    <div class="container text-center">
        <!-- <hr>
        <h1>This Page Under Development</h1>
        <img src="https://i.postimg.cc/k5NJmHZG/image.png" alt="" srcset="">
        <hr> -->

        <div class="card" style="margin-top: 1rem;">
            <div class="card-header">
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
            </div>
        </div>
    </div>
</body>

</html>