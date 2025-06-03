<?php
session_start();
include 'config.php';

if (!isset($_SESSION['keranjang']) || empty($_SESSION['keranjang'])) {
    header('Location: pesanmenu.php');
    exit;
}

$total = 0;
foreach ($_SESSION['keranjang'] as $item) {
    $total += $item['harga'] * $item['jumlah'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $metode = $_POST['metode_pembayaran'] ?? '';

    if (empty($metode)) {
        $error = "Silakan pilih metode pembayaran.";
    } else {
        $tanggal = date('Y-m-d H:i:s');
        $status = 'Menunggu Pembayaran';

        $query = "INSERT INTO pesanan (tanggal, total, metode_pembayaran, status) 
                  VALUES ('$tanggal', $total, '$metode', '$status')";

        if (mysqli_query($conn, $query)) {
            $id_pesanan = mysqli_insert_id($conn);

            foreach ($_SESSION['keranjang'] as $item) {
                $id_menu = $item['id_menu'];
                $jumlah = $item['jumlah'];
                $harga = $item['harga'];
                $subtotal = $jumlah * $harga;

                $detail = "INSERT INTO detail_pesanan (id_pesanan, id_menu, jumlah, harga, subtotal)
                           VALUES ($id_pesanan, $id_menu, $jumlah, $harga, $subtotal)";
                mysqli_query($conn, $detail);
            }

            $_SESSION['keranjang'] = array();
            $_SESSION['id_pesanan'] = $id_pesanan;

            if ($metode == 'cash') {
                header('Location: pembayaran_cash.php');
            } else {
                header('Location: pembayaran_cashless.php');
            }
            exit;
        } else {
            $error = "Gagal menyimpan pesanan.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metode Pembayaran</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="pembayaran.css">
    <script>
        function cekMetodePembayaran() {
            var cashRadio = document.getElementById("cash");
            var cashlessRadio = document.getElementById("cashless");
            
            if (!cashRadio.checked && !cashlessRadio.checked) {
                alert("Silakan pilih metode pembayaran terlebih dahulu!");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="pesanmenu.php" class="back-button">←</a>
            <div class="header-title">METODE PEMBAYARAN</div>
        </div>
        
        <div class="total-box">
            <div class="total-title">TOTAL</div>
            <div class="total-amount">Rp <?= number_format($total, 0, ',', '.') ?></div>
        </div>
        
        <?php if (isset($error)): ?>
            <div class="error-message"><?= $error ?></div>
        <?php endif; ?>
        
        <div class="payment-title">PILIH METODE PEMBAYARAN</div>
        
        <form method="POST" action="" onsubmit="return cekMetodePembayaran()">
            <div class="payment-options">
                <div class="payment-option">
                    <input type="radio" id="cash" name="metode_pembayaran" value="cash">
                    <label for="cash">
                        <img src="../IMAGE/cash.jpg" alt="Cash" class="payment-icon">
                        <div class="payment-name">CASH</div>
                    </label>
                </div>
                
                <div class="payment-option">
                    <input type="radio" id="cashless" name="metode_pembayaran" value="cashless">
                    <label for="cashless">
                        <img src="../IMAGE/barcode2.jpeg" alt="Cashless" class="payment-icon">
                        <div class="payment-name">CASHLESS</div>
                    </label>
                </div>
            </div>
            
            <button type="submit" class="submit-button">LANJUTKAN PEMBAYARAN</button>
        </form>
    </div>
</body>
</html>