<?php
include 'config.php';

$kode_pesanan = isset($_GET['kode_pesanan']) ? $_GET['kode_pesanan'] : '';
$pesanan = [];
$total = 0;

if ($kode_pesanan) {
    $stmt = $conn->prepare(
        "SELECT d.jumlah, m.nama_menu, m.harga 
         FROM detail_pesanan AS d 
         JOIN menu AS m ON m.id_menu = d.id_menu 
         WHERE d.id_pesanan = ?"
    );
    $stmt->bind_param("s", $kode_pesanan);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $pesanan[] = $row;
        $total += $row['jumlah'] * $row['harga'];
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu Cetak Bukti</title>
  <link rel="stylesheet" href="StrukCashless.css">
</head>
<body>
  <div class="receipt-container">
    <div class="receipt">
      <h2 class="store-name">Warung Kebumen</h2>
      <p class="store-address">Jln. Tirtayasa No 18</p>

      <h3 class="order-title">ORDER: <?= htmlspecialchars($kode_pesanan) ?></h3>
      <div class="order-info">
        <span><?= date('d/m/Y') ?></span>
        <br>
        <span>Kode Pemesanan <strong><?= htmlspecialchars($kode_pesanan) ?></strong></span>
      </div>

      <?php if (count($pesanan) > 0): ?>
      <table class="item-table">
        <thead>
          <tr>
            <th>Qty</th>
            <th>Item</th>
            <th>Price</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pesanan as $item): ?>
          <tr>
            <td><?= $item['jumlah'] ?></td>
            <td><?= htmlspecialchars($item['nama_menu']) ?></td>
            <td>IDR <?= number_format($item['harga'], 0, ',', '.') ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div class="totals">
        <p><strong>SUBTOTAL</strong> <span>IDR <?= number_format($total, 0, ',', '.') ?></span></p>
        <p><strong>TOTAL</strong> <span>IDR <?= number_format($total, 0, ',', '.') ?></span></p>
        <p><strong>CASHLESS</strong> <span>IDR <?= number_format($total, 0, ',', '.') ?></span></p>
      </div>
      <?php else: ?>
        <p class="no-items">Tidak ada item untuk pesanan ini.</p>
      <?php endif; ?>

      <div class="barcode">
        <img src="https://barcode.tec-it.com/barcode.ashx?data=<?= urlencode($kode_pesanan) ?>&code=Code128&translate-esc=false" alt="barcode">
        <p class="barcode-number"><?= htmlspecialchars($kode_pesanan) ?></p>
      </div>

      <p class="thank-you">Silahkan Tunggu Pesanan Dibuat<br>Terimakasih</p>

      <button class="back-button" id="backButton" onclick="window.location.href='index.php'">BACK TO MENU</button>
    </div>
  </div>
</body>
</html>