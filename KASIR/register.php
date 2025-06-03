<?php
session_start();
include 'config.php';

function clean_input($data) {
  $data = trim($data); 
  $data = stripslashes($data); 
  $data = htmlspecialchars($data); 
  return $data;
}

// Redirect jika sudah login
if (isset($_SESSION['user_id'])) {
    header("Location: menuKasir.php");
    exit();
}

// Proses register jika form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $nama = clean_input($_POST['nama']);
    $username = clean_input($_POST['username']);
    $password = clean_input($_POST['password']);
    $confirm_password = clean_input($_POST['confirm_password']);
    
    if (empty($nama) || empty($username) || empty($password) || empty($confirm_password)) {
        $error = "Silakan isi semua field!";
    } elseif ($password !== $confirm_password) {
        $error = "Password tidak sama!";
    } else {
        // Cek apakah username sudah ada di tabel kasir
        $stmt = $conn->prepare("SELECT id_kasir FROM kasir WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = "Username sudah digunakan!";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert ke tabel kasir
            $stmt = $conn->prepare("INSERT INTO kasir (nama_kasir, username, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nama, $username, $hashed_password);
            
            if ($stmt->execute()) {
                $success = "Pendaftaran berhasil! Silakan login.";
            } else {
                $error = "Terjadi kesalahan. Silakan coba lagi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Warung Kebumen</title>
    <link rel="stylesheet" href="login-style.css">
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <h1>Daftar Akun Kasir</h1>
            <p>Warung Makan Kebumen</p>
        </div>
        
        <?php if (isset($error)): ?>
            <div class="error-message"><?= $error ?></div>
        <?php endif; ?>
        
        <?php if (isset($success)): ?>
            <div class="success-message"><?= $success ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" required>
            </div>
            
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit" name="register" class="btn-login">Daftar</button>
        </form>
        
        <div class="register-link">
            Sudah punya akun? <a href="login.php">Login disini</a>
        </div>
    </div>
</body>
</html>