<?php
include 'config.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Warung Makan Kebumen</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f7f3;
      font-family: 'Segoe UI', sans-serif;
    }
    .navbar {
      background-color: #4e7056;
    }
    .navbar-brand, .btn-logout {
      color: white !important;
      font-weight: 500;
    }
    .btn-logout:hover {
      background-color: #3e5945;
    }
    h4 {
      color: #374c3c;
      font-weight: 700;
    }
    .table thead {
      background-color: #d9ead3;
    }
    .table th, .table td {
      vertical-align: middle;
    }
    .btn-success {
      background-color: #5c8a63;
      border: none;
    }
    .btn-success:hover {
      background-color: #4c7653;
    }
    .btn-warning {
      background-color: #f0ad4e;
      border: none;
    }
    .btn-danger {
      background-color: #d9534f;
      border: none;
    }
    .btn-warning:hover {
      background-color: #ec9c3e;
    }
    .btn-danger:hover {
      background-color: #c9302c;
    }
  </style>
</head>
<body>

<nav class="navbar py-3">
  <div class="container-xl d-flex justify-content-between">
    <a class="navbar-brand" href="#">Warung Makan Kebumen</a>
    <a href="index.php" class="btn btn-logout btn-sm">Logout</a>
  </div>
</nav>

<div class="container mt-4">
  <?php if (isset($_GET['status']) && $_GET['status'] === 'deleted'): ?>
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
      ✅ Data berhasil dihapus!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
  <?php endif; ?>

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4>📋 Daftar Menu</h4>
    <a href="tambah.php" class="btn btn-success">+ Tambah Menu</a>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered text-center">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Harga</th>
          <th>Kategori</th>
          <th>Jumlah</th>
          <th>Deskripsi</th>
          <th>Gambar</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM menu");
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>
            <td>{$row['id_menu']}</td>
            <td>{$row['nama_menu']}</td>
            <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
            <td>{$row['kategori']}</td>
            <td>{$row['jumlah']}</td>
            <td>{$row['deskripsi']}</td>
            <td><img src='../IMAGE/{$row['gambar']}' width='60' height='60' style='object-fit:cover; border-radius:8px;'></td>
            <td>
              <a href='edit.php?id_menu={$row['id_menu']}' class='btn btn-warning btn-sm mb-1'>Edit</a>
              <a href='hapus.php?id_menu={$row['id_menu']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Hapus data?\")'>Hapus</a>
            </td>
          </tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
