<?php
// Tangani notifikasi dari auth.php (jika login gagal atau sukses)
$notif = '';
if (isset($_GET['error']) && $_GET['error'] == 'login') {
    $notif = 'login_failed';
}
if (isset($_GET['register']) && $_GET['register'] == 'success') {
    $notif = 'register_success';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Login Admin - Warung Makan Kebumen</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      background-color: #c0d1b8;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .form-container {
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
      width: 100%;
      max-width: 400px;
    }
    .logo-icon {
      width: 50px;
      height: 50px;
      margin-bottom: 10px;
    }
    h2, h3 {
      text-align: center;
    }
  </style>
</head>
<body>

<!-- Login Form -->
<div class="form-container" id="login-form">
  <div class="text-center">
    <img src="../IMAGE/logo_nobg.png" alt="Logo" class="logo-icon">
    <h2>Warung Makan Kebumen</h2>
  </div>
  <h3 class="mt-3 mb-3">Login Admin</h3>
  <form action="auth.php" method="POST">
    <div class="mb-3">
      <label>Username</label>
      <input type="text" name="username" class="form-control" required placeholder="Masukkan Username">
    </div>
    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required placeholder="Masukkan Password">
    </div>
    <button type="submit" name="login" class="btn btn-success w-100">LOGIN</button>
    <p class="text-center mt-3">Belum punya akun? <a href="#" onclick="showForm('register-form')">Daftar</a></p>
  </form>
</div>

<!-- Register Form -->
<div class="form-container" id="register-form" style="display:none;">
  <div class="text-center">
    <img src="../IMAGE/logo_nobg.png" alt="Logo" class="logo-icon">
    <h2>Warung Makan Kebumen</h2>
  </div>
  <h3 class="mt-3 mb-3">Registrasi Admin</h3>
  <form action="auth.php" method="POST">
    <div class="mb-3">
      <label>Username</label>
      <input type="text" name="username" class="form-control" required placeholder="Masukkan Username">
    </div>
    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required placeholder="Masukkan Password">
    </div>
    <button type="submit" name="register" class="btn btn-primary w-100">DAFTAR</button>
    <p class="text-center mt-3">Sudah punya akun? <a href="#" onclick="showForm('login-form')">Login</a></p>
  </form>
</div>

<script>
  function showForm(id) {
    document.getElementById("login-form").style.display = "none";
    document.getElementById("register-form").style.display = "none";
    document.getElementById(id).style.display = "block";
  }

  // Notifikasi SweetAlert
  const notif = "<?= $notif ?>";
  if (notif === "login_failed") {
    Swal.fire({
      icon: 'error',
      title: 'Login Gagal',
      text: 'Username atau Password salah!',
      confirmButtonColor: '#d33'
    });
  } else if (notif === "register_success") {
    Swal.fire({
      icon: 'success',
      title: 'Registrasi Berhasil',
      text: 'Silakan login dengan akun Anda.',
      confirmButtonColor: '#28a745'
    });
  }
</script>

</body>
</html>
