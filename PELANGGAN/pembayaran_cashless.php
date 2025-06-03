<?php
session_start();
include 'config.php';

if (!isset($_SESSION['id_pesanan'])) {
    header('Location: pesanmenu.php');
    exit;
}

$id_pesanan = $_SESSION['id_pesanan'];
$q  = mysqli_query($conn, "SELECT * FROM pesanan WHERE id_pesanan = $id_pesanan");
if (mysqli_num_rows($q) === 0) {
    header('Location: pesanmenu.php');
    exit;
}

$pesanan = mysqli_fetch_assoc($q);

// Generate Invoice ID
$random3 = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3);
$invoice_id = 'INV-' . $random3 . '-' . str_pad($id_pesanan, 6, '0', STR_PAD_LEFT);
/* -------------------------------------------------------------------- */

$nama_merchant = 'Warung Makan Sederhana';
if (isset($_POST['cek_status'])) {

    $cek_transaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_pesanan = '$id_pesanan'");

    if (mysqli_num_rows($cek_transaksi) > 0) {
        $_SESSION['pesan_sukses'] = 'Pembayaran berhasil!';
        header('Location: cashlessberhasil.php');
        exit;
    } else {
        $pesan_error = 'Pembayaran belum diverifikasi.';
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Cashless</title>
    <link rel="stylesheet" href="pembayaran_cashless.css">
</head>
<body>
<div class="container">
    <div class="header">
        <a href="pesanmenu.php" class="back-button">←</a>
        <div class="header-title">PEMBAYARAN CASHLESS</div>
    </div>

    <div class="support-text">We Are Support :</div>

    <div class="payment-logos">
        <img src="../IMAGE/ovo.png"       alt="OVO"        class="payment-logo">
        <img src="../IMAGE/dana.png"      alt="Dana"       class="payment-logo">
        <img src="../IMAGE/spay.png"      alt="ShopeePay"  class="payment-logo">
        <img src="../IMAGE/bca.jpeg"      alt="BCA"        class="payment-logo">
    </div>

    <div class="scan-title">SCAN QRIS</div>

    <div class="qr-container">
        <img src="../IMAGE/barcode2.jpeg" alt="QRIS Code" class="qr-code">
    </div>

    <div class="merchant-info">
        <div class="merchant-label">Nama Merchant</div>
        <div class="merchant-value"><?= $nama_merchant ?></div>

        <div class="merchant-label">INVOICE ID</div>
        <div class="merchant-value"><?= $invoice_id ?></div>

        <div class="merchant-label">NOMOR PESANAN</div>
        <div class="merchant-value"><?= $id_pesanan ?></div>
    </div>

    <?php if (isset($pesan_error)): ?>
        <div class="error-message"><?= $pesan_error ?></div>
    <?php endif; ?>

    <form method="POST">
        <button type="submit" name="cek_status" class="cek-status-btn">
            CEK STATUS PEMBAYARAN
        </button>
    </form>
</div>
</body>
</html>
