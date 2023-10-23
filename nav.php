<?php
    session_start();

    if(!(isset($_SESSION['username']) && isset($_SESSION['password']))):
        header("Location: login.php");
    else:
        include 'koneksi_db.php';

        if (isset($_GET['page'])):
            $pageTitle = $_GET['page'];
            $trim = str_replace("_", " ", $pageTitle);
            $pageTitle = ucwords($trim);
        endif
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$pageTitle?> | Toretto Rent Car</title>

    <script src="https://kit.fontawesome.com/54ae9d808b.js" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="d-xxl-flex" style="overflow-x: hidden;">
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <h3 class="offcanvas-title" id="offcanvasExampleLabel">Menu</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="list-group list-group-flush">
                        <a class="list-group-item list-group-item-action p-3" href="?page=index">Home</a>
                        <a class="list-group-item list-group-item-action p-3" href="?page=daftar_mobil">Daftar Mobil</a>
                        <a class="list-group-item list-group-item-action p-3" href="?page=transaksi">Transaksi</a>
                        <a class="list-group-item list-group-item-action p-3" href="?page=pegawai">Pegawai</a>
                        <a class="list-group-item list-group-item-action p-3" href="?page=customer">Customer Details</a>
                        <a class="list-group-item list-group-item-action p-3" href="logout.php">Logout</a>
                        <!-- <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Profile</a> -->
                        <!-- <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Status</a> -->
                    </div>
                </div>
                <div class="offcanvas-footer">
                    <hr>
                    <div class="text-center" style="margin-bottom: 1rem;">
                        <span class="fs-6">Developed by </span><a href="mailto:syahrezafistiferdian32@gmail.com" class="text-decoration-none">Syahreza Ferdian</a>
                    </div>
                </div>
            </div>

            <div class="page-content" style="min-width: 100vw;">
                        <nav class="navbar" style="background-color: #e3f2fd;">
                            <!-- Navbar content -->
                            <div class="container-fluid">
                                <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                                    <i class="fa-solid fa-bars fa-lg"></i>
                                </button>

                                <div class="user-name">
                                    <i class="fa-solid fa-user fa-xl"></i>
                                    <span style="font-weight: bold; margin-left: 0.5rem; margin-right: 0.5rem;"><?= $_SESSION['username'] ?></span>
                                </div>
                            </div>
                        </nav>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
<?php endif ?>