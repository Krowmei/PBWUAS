<?php include 'config.php'; ?>
<?php
$id_menu= $_GET['id_menu'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM menu WHERE id_menu=$id_menu"));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Menu</title>
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
    <h3 class="mb-4">Edit Menu</h3>
    <form method="POST" enctype="multipart/form-data" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Nama Menu</label>
            <input type="text" name="nama_menu" class="form-control" value="<?= $data['nama_menu'] ?>" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Harga</label>
            <input type="number" name="harga" class="form-control" value="<?= $data['harga'] ?>" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Kategori</label>
            <input type="text" name="kategori" class="form-control" value="<?= $data['kategori'] ?>" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="<?= $data['jumlah'] ?>" required>
        </div>
        <div class="col-12">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3"><?= $data['deskripsi'] ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Foto Lama</label><br>
            <img src="../IMAGE/<?= $data['gambar'] ?>" width="100">
        </div>
        <div class="col-md-6">
            <label class="form-label">Ganti Foto (opsional)</label>
            <input type="file" name="gambar" class="form-control">
        </div>
        <div class="col-12">
            <button type="submit" name="update" class="btn btn-primary">Update</button>
            <a href="dashboard.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>

    <?php
    if (isset($_POST['update'])) {
    $nama = $_POST['nama_menu'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];
    $jumlah = $_POST['jumlah'];
    $deskripsi = $_POST['deskripsi'];

    // Status otomatis tergantung jumlah
    $status = ($jumlah == 0) ? 'Habis' : 'Tersedia';

    if ($_FILES['gambar']['name'] != "") {
        $gambar = $_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], "upload/".$gambar);
        mysqli_query($conn, "UPDATE menu SET nama_menu='$nama', harga='$harga', kategori='$kategori', jumlah='$jumlah', deskripsi='$deskripsi', gambar='$gambar', status='$status' WHERE id_menu=$id_menu");
    } else {
        mysqli_query($conn, "UPDATE menu SET nama_menu='$nama', harga='$harga', kategori='$kategori', jumlah='$jumlah', deskripsi='$deskripsi', status='$status' WHERE id_menu=$id_menu");
    }

    echo "<div class='alert alert-success mt-3'>Data berhasil diupdate! <a href='dashboard.php'>Kembali</a></div>";
}

    ?>
</div>
</body>
</html>
