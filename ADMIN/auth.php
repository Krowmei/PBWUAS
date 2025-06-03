<?php
session_start();
include 'config.php'; // koneksi ke database

// LOGIN
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Ambil data admin dari DB
    $query = "SELECT * FROM admin WHERE username='$username' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $admin = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id_admin'];
            $_SESSION['username'] = $admin['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            // Password salah
            header("Location: index.php?error=login");
            exit();
        }
    } else {
        // Username tidak ditemukan
        header("Location: index.php?error=login");
        exit();
    }
}

// REGISTER
if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi

    // Cek apakah username sudah ada
    $check = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        // Username sudah digunakan
        header("Location: index.php?error=exist");
        exit();
    }

    // Simpan user baru
    $query = "INSERT INTO admin (username, password) VALUES ('$username', '$password')";
    if (mysqli_query($conn, $query)) {
        header("Location: index.php?register=success");
        exit();
    } else {
        echo "Gagal registrasi: " . mysqli_error($conn);
    }
}
?>
