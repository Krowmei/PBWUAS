<?php
session_start();

// Pastikan keranjang sudah diinisialisasi
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = array();
}

// Hitung total harga
$total = 0;
foreach ($_SESSION['keranjang'] as $item) {
    $total += $item['harga'] * $item['jumlah'];
}

// Kirim total sebagai respons JSON
header('Content-Type: application/json');
echo json_encode([
    'total' => $total,
    'total_formatted' => number_format($total, 0, ',', '.')
]);
?>