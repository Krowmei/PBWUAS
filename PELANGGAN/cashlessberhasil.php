<?php
session_start();
$id_pesanan = $_SESSION['id_pesanan']; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Berhasil</title>
    <link rel="stylesheet" href="cashlessberhasil.css">
</head>
<body>
    <div class="overlay">
        <div class="payment-success-popup">
            <div class="success-icon">
                <svg viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="25" cy="25" r="25" fill="#2ecc71" />
                    <path d="M14.6 29.1L22.5 37l12.9-12.9" stroke="white" stroke-width="3" fill="none" />
                </svg>
            </div>
            <h2>Pembayaran Berhasil</h2>
            <button class="print-receipt-btn" id="printBtn">CETAK BUKTI PEMBAYARAN</button>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const confirmBtn = document.getElementById("printBtn");
            confirmBtn.addEventListener("click", function () {
                const kodePesanan = "<?= urlencode($id_pesanan) ?>";
                window.location.href = "StrukCashless.php?kode_pesanan=" + kodePesanan;
            });
        });
    </script>
</body>
</html>
