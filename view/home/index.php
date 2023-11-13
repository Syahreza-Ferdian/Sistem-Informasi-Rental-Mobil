<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                $xArray = $data['jenis'];
                $yArray = $data['countJenis'];
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
                                display: true,
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
                $ready = $data['countMobilReady'];
                $not_ready = $data['countMobilNotReady'];
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
                                display: true,
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
        </div>
    </div>
</div>