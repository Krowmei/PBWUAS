<?php
include 'config.php';

if (isset($_POST['id_pesanan'])) {
    $id_pesanan = $_POST['id_pesanan'];

    // Ambil data total dan metode dari pesanan
    $query = mysqli_query($conn, "SELECT total, metode_pembayaran FROM pesanan WHERE id_pesanan = '$id_pesanan'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $total = $data['total'];
        $metode = $data['metode_pembayaran'];

        // Update status di pesanan jadi "Lunas"
        $update = mysqli_query($conn, 
            "UPDATE pesanan SET status = 'Lunas' WHERE id_pesanan = '$id_pesanan'"
        );

        if ($update) {
            // Insert ke tabel transaksi
            $insert = mysqli_query($conn, 
                "INSERT INTO transaksi (id_pesanan, total_harga, status_pembayaran, metode_pembayaran)
                 VALUES ('$id_pesanan', $total, 'Lunas', '$metode')"
            );

            if ($insert) {
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