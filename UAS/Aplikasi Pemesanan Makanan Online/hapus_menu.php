<?php
session_start();
require 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID tidak valid!";
    exit();
}

$id = $_GET['id'];

$cek = $conn->query("SELECT kategori, gambar FROM menu WHERE id = $id");
if ($cek->num_rows === 0) {
    echo "Menu tidak ditemukan!";
    exit();
}

$data = $cek->fetch_assoc();
$kategori = $data['kategori'];
$gambar = $data['gambar'];

$check = mysqli_query($conn, "SELECT * FROM orders WHERE menu_id = '$id'");
if (mysqli_num_rows($check) > 0) {
    echo "<script>
        alert('Menu ini tidak bisa dihapus karena sedang digunakan dalam pesanan.');
        window.location.href = '" . ($kategori === 'makanan' ? 'kelola_makanan.php' : 'kelola_minuman.php') . "';
    </script>";
    exit();
}

$conn->query("DELETE FROM menu WHERE id = $id");

echo "<script>
    alert('Menu berhasil dihapus.');
    window.location.href = '" . ($kategori === 'makanan' ? 'kelola_makanan.php' : 'kelola_minuman.php') . "';
</script>";
exit();
?>
