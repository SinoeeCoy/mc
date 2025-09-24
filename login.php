<?php
session_start();

require 'koneksi.php';

if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

// Registrasi
if (isset($_POST['register'])) {
    $username = $_POST['username_reg'];
    $email = $_POST['email_reg'];
    $password = $_POST['password_reg'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $userCheckQuery = mysqli_query($conn, "SELECT * FROM login_user WHERE username='$username' OR email='$email'");
    if (mysqli_num_rows($userCheckQuery) > 0) {
        echo '<script>alert("Error: Username atau email sudah digunakan."); location.href="signup.php";</script>';
    } else {
        $query = "INSERT INTO login_user (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        if (mysqli_query($conn, $query)) {
            echo '<script>alert("Registrasi berhasil! Silakan login."); location.href="login.php";</script>';
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    mysqli_close($conn);
}

// Login
if (isset($_POST['login'])) {
    $username = $_POST['username_login'];
    $password = $_POST['password_login'];

    $userCheckQuery = mysqli_query($conn, "SELECT * FROM login_user WHERE username='$username' OR email='$username'");
    if (mysqli_num_rows($userCheckQuery) > 0) {
        $data = mysqli_fetch_array($userCheckQuery);
        if (password_verify($password, $data['password'])) {
            $_SESSION['user'] = $data;
            echo '<script>alert("Selamat datang, '.$data['username'].'"); location.href="dashboard.php";</script>';
        } else {
            echo '<script>alert("Error: Password tidak sesuai."); location.href="login.php";</script>';
        }
    } else {
        echo '<script>alert("Error: Username atau email tidak ditemukan."); location.href="login.php";</script>';
    }
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/style02.css" />
    <title>Sign in & Sign up Form</title>
</head>
<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <!-- Form Login -->
                <form action="" method="POST" class="sign-in-form">
                    <h2 class="title">Sign in</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username_login" placeholder="Username or Email" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password_login" placeholder="Password" required />
                    </div>
                    <input type="submit" name="login" value="Login" class="btn solid" />
                    <p class="social-text">Or Sign in with social platforms</p>
                    <div class="social-media">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-google"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </form>
                
                <!-- Form Registrasi -->
                <form action="" method="POST" class="sign-up-form">
                    <h2 class="title">Sign up</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username_reg" placeholder="Username" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email_reg" placeholder="Email" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password_reg" placeholder="Password" required />
                    </div>
                    <input type="submit" name="register" class="btn" value="Sign up" />
                    <p class="social-text">Or Sign up with social platforms</p>
                    <div class="social-media">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-google"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Baru disini?</h3>
                    <p>Selamat datang di SIMABANG, tempat terbaik untuk menemukan solusi berkualitas untuk semua kebutuhan proyek Anda!</p>
                    <button class="btn transparent" id="sign-up-btn">Sign up</button>
                </div>
                <img src="img/log.svg" class="image" alt="" />
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>Salah satu dari kita?</h3>
                    <p>Senang sekali menyambut Anda kembali di SIMABANG, siap untuk menemukan inspirasi baru untuk proyek Anda?</p>
                    <button class="btn transparent" id="sign-in-btn">Sign in</button>
                </div>
                <img src="img/register.svg" class="image" alt="" />
            </div>
        </div>
    </div>
    <script src="app.js"></script>
</body>
</html>
