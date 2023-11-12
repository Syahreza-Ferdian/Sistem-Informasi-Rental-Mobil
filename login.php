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
            $user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT id_pegawai, username, isOwner FROM pegawai WHERE username = '$p_username'"));
            $resUser = $user['id_pegawai'];
            $isOwner = $user['isOwner'];

            $_SESSION['username'] = $user['username'];
            $_SESSION['password'] = $_POST['password'];
            $_SESSION['isOwner'] = $isOwner;

            header("Location: index.php?page=index");
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
                <h1>Login dengan akun Anda</h1>
                <div class="err" style="display: <?php echo isset($_POST['login']) ? ($is_valid['cekLoginPegawai'] == 1 ? 'none' : 'block') : 'none'; ?>; color: red; float: left;">Username atau password salah</div>

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