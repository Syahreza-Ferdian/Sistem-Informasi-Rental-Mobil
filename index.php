<?php 
    include "nav.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://kit.fontawesome.com/54ae9d808b.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
        #jenis_mobil {
            max-width: 25%;
            max-height: 30rem;
        }

        #status_mobil {
            max-width: 25%; 
            max-height: 30rem;
            margin-left: 13rem;
        }

        @media screen and (max-width: 768px) {
            #charts-container {
                flex-direction: column;
            }

            #jenis_mobil,
            #status_mobil {
                margin-left: 0;
                max-width: 100%;
                margin-bottom: 2rem;
            }
        }
    </style>
</head>

<body>
    <?php
        $page = $_GET['page'] ?? "index";
        $opr = $_GET['opr'] ?? "";

        if(isset($page) && $page !== 'index'):
            require $page.".php";

        elseif ($page == 'index'): ?>
            <div class="container-fluid">
                <h2 style="text-align: center; margin-bottom: 1.5rem; margin-top: 1rem;"><strong>Business Stats</strong></h2>

                <div class="card">
                    <div class="card-header">
                        <h5 class="fw-bold">ASET: Kendaraan</h5>
                    </div>
                    <div class="card-body container-fluid">

                        <div id="charts-container" style="display: flex; flex-wrap: wrap; justify-content: center;">
                            <canvas id="jenis_mobil"></canvas>
                            <canvas id="status_mobil"></canvas>
                        </div>


                        <!-- JENIS MOBIL PHP AND JS -->
                        <?php
                        $query = "SELECT jenis FROM jenis_mobil";
                        $result = mysqli_query($koneksi, $query);
                        $xArray = array();
                        $yArray = array();

                        while ($row = mysqli_fetch_assoc($result)) {
                            $xArray[] = $row['jenis'];
                            $query = "SELECT COUNT(*) AS HITUNG FROM view_mobil_" . strtolower($row['jenis']);
                            $yArray[] = mysqli_fetch_assoc(mysqli_query($koneksi, $query))['HITUNG'];
                        }
                        ?>

                        <script>
                            var ctx = document.getElementById("jenis_mobil");

                            var jenis_mobil = <?= json_encode($xArray) ?>;
                            var count_jenis_mobil = <?= json_encode($yArray) ?>;
                            var barColors = ["#b91d47", "#00aba9", "#2b5797", "#e8c3b9", "#1e7145"];
                            new Chart(ctx, {
                                type: "pie",
                                data: {
                                    labels: jenis_mobil,
                                    datasets: [{
                                        data: count_jenis_mobil,
                                        backgroundColor: barColors
                                    }],
                                },
                                options: {
                                    plugins: {
                                        title: {
                                            display: true,
                                            text: "Jenis Mobil"
                                        }
                                    }
                                }
                            });
                        </script>


                        <!-- STATUS MOBIL PHP AND JS -->
                        <?php
                        $result = mysqli_query($koneksi, "SELECT COUNT(*) AS HITUNG FROM view_mobil_tersedia");
                        $ready = mysqli_fetch_assoc($result)['HITUNG'];

                        $result = mysqli_query($koneksi, "SELECT COUNT(*) AS HITUNG FROM view_mobil_sedang_dipakai");
                        $not_ready = mysqli_fetch_assoc($result)['HITUNG'];
                        ?>

                        <script>
                            var ctx = document.getElementById("status_mobil");

                            var stars = <?= json_encode(array($ready, $not_ready)) ?>;
                            var frameworks = ["Ready", "Not Ready"];

                            var color = ["green", "red"];

                            var status_mobil = new Chart(ctx, {
                                type: "bar",
                                data: {
                                    labels: frameworks,
                                    datasets: [{
                                        data: stars,
                                        backgroundColor: color
                                    }]
                                },
                                options: {
                                    plugins: {
                                        legend: {
                                            display: false
                                        },
                                        title: {
                                            display: true,
                                            text: "Status Kendaraan"
                                        }
                                    }
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>

        <?php endif ?>
    </div>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> -->
</body>
</html>