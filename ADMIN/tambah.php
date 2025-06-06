<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<style>
    body{
    background-color: #96aa91 ;
    }
    .container h3{
     font-weight: 700 ;
    }
    .container{
        font-weight: 600;
    }
</style>


<div class="container mt-3">
    <a href="dashboard.php" class="btn btn-danger mb-3">← Kembali</a>
</div>

<div class="container mt-5">
    <h3 class="mb-4">Tambah Menu Baru</h3>
    <form method="POST" enctype="multipart/form-data" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Nama Menu</label>
            <input type="text" name="nama_menu" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Harga</label>
            <input type="number" name="harga" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Kategori</label>
            <select name="kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Makanan">Makanan</option>
                <option value="Minuman">Minuman</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" required>
        </div>
        <div class="col-12">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3"></textarea>
        </div>
        <div class="col-12">
            <label class="form-label">Upload Foto</label>
            <input type="file" name="gambar" class="form-control" required>
        </div>
        <div class="col-12">
            <button type="submit" name="submit" class="btn btn-success">Simpan</button>
            <a href="dashboard.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $nama = $_POST['nama_menu'];
        $harga = $_POST['harga'];
        $kategori = $_POST['kategori'];
        $jumlah = $_POST['jumlah'];
        $deskripsi = $_POST['deskripsi'];
        $gambar = $_FILES['gambar']['name'];
        $tmp  = $_FILES['gambar']['tmp_name'];

        move_uploaded_file($tmp, "../IMAGE/".$gambar);

        mysqli_query($conn, "INSERT INTO menu (nama_menu, harga, jumlah, kategori, deskripsi, gambar) 
                             VALUES ('$nama', '$harga', '$jumlah', '$kategori', '$deskripsi', '$gambar')");
        echo "<div class='alert alert-success mt-3'>Data berhasil disimpan! <a href='dashboard.php'>Kembali</a></div>";
    }
    ?>
</div>
</body>
</html>
