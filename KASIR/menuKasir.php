<?php
include 'config.php'; 

$selectedKode = '';
$resultDetail = null;
$total = 0;

if (isset($_POST['submit'])) {
    $selectedKode = $_POST['kode_pesanan'];

    $resultDetail = mysqli_query($conn, 
        "SELECT d.id_menu, m.nama_menu, d.jumlah, d.harga 
         FROM detail_pesanan AS d 
         JOIN menu AS m ON m.id_menu = d.id_menu 
         WHERE d.id_pesanan = '$selectedKode'"
    );
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kasir - Detail Pesanan</title>
    <link rel="stylesheet" href="styleKasir.css">
</head>
<body>
    <div class="top-bar">
        <h1>Kasir</h1>
        <div class="top-actions">
            <a href="logout.php" class="logout-btn" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
        <i class="icon-inline">🚪</i>Logout
</a></div>
    </div>

    <div class="main-wrapper">
        <div class="transaksi-section">
            <div class="section-title">Detail Transaksi</div>

            <form method="post" class="search-form">
                <div class="form-group">
                    <label for="kode_pesanan">Masukkan Nomor Pesanan:</label>
                    <div class="input-wrapper">
                        <input type="text" name="kode_pesanan" id="kode_pesanan" required placeholder="Contoh: 001, 002" class="text-input">
                        <button type="submit" name="submit" class="search-btn">Tampilkan</button>
                    </div>
                </div>
            </form>

            <?php if ($selectedKode && $resultDetail && mysqli_num_rows($resultDetail) > 0): ?>
                <div class="kode-pemesanan">
                    Kode Pesanan: <span class="kode-box"><?= $selectedKode ?></span>
                </div>

                <div class="list-pesanan-header">
                    <span class="icon-cart">🛒</span> Daftar Menu
                </div>

                <table class="order-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Menu</th>
                            <th>Qty</th>
                            <th>Harga (pcs)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($resultDetail)) {
                            $nama = $row['nama_menu'];
                            $jumlah = $row['jumlah'];
                            $harga = $row['harga'];
                            // Menghitung subtotal untuk total, tapi tidak menampilkan di tabel
                            $subtotal = $jumlah * $harga;
                            $total += $subtotal;

                            echo "<tr class='row-" . ($no % 2 == 0 ? 'dark' : 'light') . "'>
                                    <td>{$no}</td>
                                    <td>{$nama}</td>
                                    <td class='qty-cell'>
                                        <input type='number' value='{$jumlah}' class='qty-input' readonly />
                                    </td>
                                    <td>Rp " . number_format($harga, 0, ',', '.') . "</td>
                                  </tr>";
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>

                <div class="total-payment">
                    <div class="total">Total: Rp <?= number_format($total, 0, ',', '.') ?></div>
                        <form action="prosesPembayaran.php" method="post">
                            <input type="hidden" name="id_pesanan" value="<?= $selectedKode ?>">
                            <input type="hidden" name="total" value="<?= $total ?>">
                            <button type="submit" class="confirm-btn">Konfirmasi Pembayaran</button>
                        </form>
                    </div>
            <?php elseif ($selectedKode): ?>
                <div class="not-found-message">
                    Pesanan dengan ID <?= $selectedKode ?> tidak ditemukan.
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        // Fungsi untuk update total jika ada perubahan quantity
        function updateTotal() {
          let rows = document.querySelectorAll('.order-table tbody tr');
          let total = 0;

          rows.forEach(row => {
            const input = row.querySelector('.qty-input');
            const hargaCell = row.children[3]; // kolom harga
            if (input && hargaCell) {
              const qty = parseInt(input.value);
              const hargaText = hargaCell.innerText.replace(/[^\d]/g, '');
              const harga = parseInt(hargaText);
              total += qty * harga;
            }
          });

          const totalDisplay = document.querySelector('.total');
          if (totalDisplay) {
            totalDisplay.innerText = 'Total: Rp ' + total.toLocaleString('id-ID');
          }
        }

        // Konfirmasi pembayaran
        const confirmBtn = document.getElementById("confirmBtn");
        if (confirmBtn) {
          confirmBtn.addEventListener("click", function () {
            window.location.href = "prosespembayaran.php";
          });
        }
      });
    </script>
</body>
</html>