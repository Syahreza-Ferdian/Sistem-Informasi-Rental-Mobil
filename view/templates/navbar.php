<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['pageTitle']; ?> | Toretto Rent Car</title>

    <script src="https://kit.fontawesome.com/54ae9d808b.js" crossorigin="anonymous"></script>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    
    <!-- <style>
        .offcanvas-body .list-group .list-group-item span {
            margin-left: 1rem;
        }
    </style> -->
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
                        <a class="list-group-item list-group-item-action p-3" href="<?= base_url; ?>/home"><div class="row"><div class="col-2"><i class="fa-solid fa-house fa-xl"></i></div><div class="col"><span>Home</span></div></div></a>
                        <a class="list-group-item list-group-item-action p-3" href="<?= base_url; ?>/mobil"><div class="row"><div class="col-2"><i class="fa-solid fa-car-side fa-xl"></i></div><div class="col"><span>Daftar Mobil</span></div></div></a>
                        <a class="list-group-item list-group-item-action p-3" href="?page=transaksi"><div class="row"><div class="col-2"><i class="fa-solid fa-sack-dollar fa-xl"></i></div><div class="col"><span>Transaksi</span></div></div></a>
                        <a class="list-group-item list-group-item-action p-3" href="?page=pegawai"><div class="row"><div class="col-2"><i class="fa-solid fa-briefcase fa-xl"></i></div><div class="col"><span>Pegawai</span></div></div></a>
                        <a class="list-group-item list-group-item-action p-3" href="?page=customer"><div class="row"><div class="col-2"><i class="fa-solid fa-users fa-xl"></i></div><div class="col"><span>Customer Details</span></div></div></a>
                        <a class="list-group-item list-group-item-action p-3" href="logout.php"><div class="row"><div class="col-2"><i class="fa-solid fa-right-from-bracket fa-xl"></i></div><div class="col"><span>Logout</span></div></div></a>
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
                        <nav class="navbar bg-body-secondary border-bottom border-body" data-bs-theme="dark">
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