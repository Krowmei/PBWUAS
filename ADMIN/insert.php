<?php
include 'connect.php';

$data = json_decode(file_get_contents("php://input"));

$id = $data->id_menu;
$nama = $data->nama_menu;
$harga = $data->harga;
$kategori = $data->kategori;
$jumlah = $data->jumlah;
$deskripsi = $data->deskripsi;

$sql = "INSERT INTO menu (id_menu, nama_menu, harga, kategori, jumlah, deskripsi)
        VALUES ('$id', '$nama', $harga, '$kategori', $jumlah, '$deskripsi')";

if ($conn->query($sql)) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}
?>
