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
        #jenis_mobil,
        #transactions {
            max-width: 100%;
            max-height: 27rem;
        }

        #status_mobil {
            max-width: 50%;
            max-height: 30rem;
            margin-left: 0rem;
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

    if (isset($page) && $page !== 'index') :
        require $page . ".php";

    elseif ($page == 'index') : ?>
        <div class="container-fluid text-center px-5">
            <h2 style="text-align: center; margin-bottom: 1.5rem; margin-top: 1rem;"><strong>Business Stats</strong></h2>

            <div class="row mb-4">
                <div class="col">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h5 class="fw-bold d-inline">Jenis Kendaraan </h5><i class="fa-solid fa-car fa-xl"></i>
                        </div>

                        <div class="card-body">
                            <div id="charts-container" style="display: flex; flex-wrap: wrap; justify-content: center;">
                                <canvas id="jenis_mobil"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h5 class="fw-bold d-inline">Status Kendaraan </h5><i class="fa-solid fa-warehouse fa-xl"></i>
                        </div>

                        <div class="card-body">
                            <div id="charts-container" style="display: flex; flex-wrap: wrap; justify-content: center;">
                                <canvas id="status_mobil"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


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
                            legend: {
                                labels: {
                                    color: "white"
                                }
                            },
                            title: {
                                display: false,
                                text: "Jenis Mobil",
                                color: "white",
                                font: {
                                    size: 25
                                }
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
                        scales: {
                            y: {
                                ticks: {
                                    color: 'white'
                                },
                                grid: {
                                    color: 'white'
                                }
                            },
                            x: {
                                ticks: {
                                    color: 'white'
                                },
                                grid: {
                                    color: 'white'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false,
                                labels: {
                                    color: "black"
                                }
                            },
                            title: {
                                display: false,
                                text: "Status Kendaraan",
                                color: "white",
                                font: {
                                    size: 25
                                }
                            }
                        }
                    }
                });
            </script>

            <!-- TRANSACTIONS -->
            <div class="row mb-4">
                <div class="col-5">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h5 class="fw-bold d-inline">Transactions </h5><i class="fa-solid fa-money-bill-transfer fa-xl"></i>
                        </div>

                        <div class="card-body">
                            <div id="charts-container" style="display: flex; flex-wrap: wrap; justify-content: center;">
                                <canvas id="transactions"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h5 class="fw-bold d-inline">Employee Login Activity </h5><i class="fa-solid fa-briefcase fa-xl"></i>
                        </div>

                        <div class="card-body">
                            <div id="charts-container" style="display: flex; flex-wrap: wrap; justify-content: center;">
                                <canvas id="emp_login_act"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                
            <?php
            $xArray = ["Active", "Cancelled", "Completed", "Pending"];
            $yArray = array();
            $yArray[] = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM view_transaksi_sewa_aktif"))[0];
            $yArray[] = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM view_transaksi_sewa_cancel"))[0];
            $yArray[] = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM view_transaksi_sewa_complete"))[0];
            $yArray[] = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM view_transaksi_sewa_pending"))[0];
            ?>

            <script>
                var ctx = document.getElementById("transactions");

                var jenis = <?= json_encode($xArray) ?>;
                var count = <?= json_encode($yArray) ?>;
                var barColors = ["blue", "red", "green", "yellow"];
                new Chart(ctx, {
                    type: "polarArea",
                    data: {
                        labels: jenis,
                        datasets: [{
                            data: count,
                            backgroundColor: barColors
                        }],
                    },
                    options: {
                        plugins: {
                            legend: {
                                labels: {
                                    color: "white"
                                }
                            },
                            title: {
                                display: false,
                                text: "Transactions",
                                color: "white",
                                font: {
                                    size: 25
                                }
                            }
                        }
                    }
                });
            </script>

            <?php
                $xArray = array();
                $yArray = array();
                $query = "SELECT P.username ,P.login_activity FROM pegawai P WHERE P.id_pegawai > 1 LIMIT 10";
                $result = mysqli_fetch_all(mysqli_query($koneksi, $query));

                foreach ($result as $row) {
                    $xArray[] = $row[0];
                    $yArray[] = $row[1];
                }
            ?>

            <script>
                var ctx = document.getElementById("emp_login_act");

                var username = <?= json_encode($xArray) ?>;
                var activity = <?= json_encode($yArray) ?>;
                // var barColors = ["blue", "red", "green", "yellow"];

                new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: username,
                        datasets: [{
                            label: "Login Activity",
                            data: activity,
                            fill: false,
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                        }],
                    },
                    options: {
                        scales: {
                            y: {
                                ticks: {
                                    color: 'white'
                                },
                                title: {
                                    display: true,
                                    text: "Login Frequency",
                                    color: "white",
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            x: {
                                ticks: {
                                    color: 'white'
                                },
                                title: {
                                    display: true,
                                    text: "Employee Username",
                                    color: "white",
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: "white"
                                }
                            },
                            title: {
                                display: false,
                                text: "Transactions",
                                color: "white",
                                font: {
                                    size: 25
                                }
                            }
                        }
                    }
                });
            </script>

        </div>

    <?php endif ?>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> -->
</body>

</html>