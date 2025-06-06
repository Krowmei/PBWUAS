<?php
include 'config.php';

if (isset($_POST['id_pesanan'])) {
    $id_pesanan = $_POST['id_pesanan'];

    // Ambil data total dan metode dari pesanan
    $query = mysqli_query($conn, "SELECT total, metode_pembayaran FROM pesanan WHERE id_pesanan = '$id_pesanan'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $total_asli = $data['total'];
        $metode = $data['metode_pembayaran'];

        // Hitung diskon 30% untuk cashless (berdasarkan metode pembayaran)
        $total_bayar = $total_asli;
        if (strtolower($metode) == 'cashless') {
            $diskon = $total_asli * 0.20;
            $total_bayar = $total_asli - $diskon;
        }

        // Update status dan total di pesanan jadi "Lunas" dengan total setelah diskon
        $update = mysqli_query($conn, 
            "UPDATE pesanan SET status = 'Lunas', total = $total_bayar WHERE id_pesanan = '$id_pesanan'"
        );

        if ($update) {
            // Insert ke tabel transaksi
            $insert = mysqli_query($conn, 
                "INSERT INTO transaksi (id_pesanan, total_harga, status_pembayaran, metode_pembayaran)
                 VALUES ('$id_pesanan', $total_bayar, 'Lunas', '$metode')"
            );

            if ($insert) {
                // Kurangi stok menu sesuai pesanan
                $detail_query = mysqli_query($conn, 
                    "SELECT id_menu, jumlah FROM detail_pesanan WHERE id_pesanan = '$id_pesanan'"
                );

                while ($detail = mysqli_fetch_assoc($detail_query)) {
                    $id_menu = $detail['id_menu'];
                    $jumlah_pesan = $detail['jumlah'];
                    
                    // Update stok menu dan status otomatis
                    mysqli_query($conn, 
                        "UPDATE menu SET 
                         jumlah = jumlah - $jumlah_pesan,
                         status = CASE 
                                   WHEN (jumlah - $jumlah_pesan) <= 0 THEN 'Habis'
                                   ELSE 'Tersedia'
                                 END
                         WHERE id_menu = '$id_menu'"
                    );
                }

                header("Location: BayarBerhasil.php?kode_pesanan=" . urlencode($id_pesanan));
                exit();
            } else {
                echo "Gagal memasukkan ke tabel transaksi.";
            }
        } else {
            echo "Gagal mengupdate status pesanan.";
        }
    } else {
        echo "Data pesanan tidak ditemukan.";
    }
} else {
    echo "ID pesanan tidak ditemukan.";
}
?>