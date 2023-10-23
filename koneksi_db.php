<?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $db_name = "rental_mobil";

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $koneksi = mysqli_connect($host, $user, $password, $db_name) or die("Terjadi error" .mysqli_connect_error());