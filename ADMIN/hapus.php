<?php
include 'config.php';
$id = $_GET['id_menu'];
mysqli_query($conn, "DELETE FROM menu WHERE id_menu=$id");
header("Location: dashboard.php");
?>
