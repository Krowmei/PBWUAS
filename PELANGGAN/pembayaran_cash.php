<?php
session_start();
include 'config.php';

if (!isset($_SESSION['id_pesanan'])) {
    // jika tidak ada id_pesanan, redirect ke halaman index
    header('Location: index.php');
    exit;
}

$id_pesanan = $_SESSION['id_pesanan'];

$pesanan = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT total,tanggal FROM pesanan WHERE id_pesanan=$id_pesanan")
);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Cash</title>
    <link rel="stylesheet" href="pembayaran_cash.css">
</head>
<body>

<div class="header">
    <a href="index.php" class="back-button">←</a>
    PEMBAYARAN CASH
</div>

<div class="container">
    <div class="success-icon"><div class="checkmark">✓</div></div>

    <div class="success-message">Pesanan Anda Berhasil Dibuat</div>

    <!-- nomor pesanan -->
    <div class="order-code">
        Nomor Pesanan&nbsp;: <strong><?= htmlspecialchars($id_pesanan) ?></strong>
    </div>

    <div class="instructions">
        Pastikan Anda mengambil struk berisi Nomor Pesanan tersebut lalu lakukan pembayaran di kasir.
    </div>
</div>

</body>
</html>
