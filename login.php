<?php
    session_start();
    include 'koneksi_db.php';
?>

<?php
    if (isset($_POST['login'])) {

        $p_username = $_POST['username'];
        $p_password = $_POST['password'];

        $query = "SELECT cekLoginPegawai('$p_username', '$p_password') AS cekLoginPegawai";

        $cek_kredensial = mysqli_query($koneksi, $query);
        $is_valid = mysqli_fetch_assoc($cek_kredensial);

        if ($cek_kredensial && $is_valid['cekLoginPegawai'] == 1) {
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['password'] = $_POST['password'];

            header("Location: index.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="css/login_page.css">

    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="form fadeInLeft">
            <form action="" method="POST">
                <h1>Masuk dengan Akun Anda</h1>
                <div class="err" style="display: <?php echo isset($_POST['login']) ? ($is_valid['cekLoginPegawai'] == 1 ? 'none' : 'block') : 'none'; ?>; color: red; float: left;">Username dan password salah</div>

                <div class="input-field">
                    <input type="text" name="username" placeholder="Username" required>
                    <label></label>
                </div>
                <div class="input-field">
                    <input type="password" name="password" placeholder="Password" required>
                    <label></label>
                </div>
                <a href="#" class="lupa-pass">Lupa Password?</a>
                <input type="submit" value="Login" name="login" class="btn-login">
            </form>
        </div>
        <div class="overlay fadeInRight">
            <h1>Selamat Datang Kembali!</h1>
            <p>Untuk melanjutkan, silakan login menggunakan akun pegawai Anda</p>
        </div>
    </div>
</body>

</html>