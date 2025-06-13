<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: read.php");
    exit;
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT nip, nama FROM karyawan_absensi WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['pesan'] = "Data tidak ditemukan.";
    header("Location: read.php");
    exit;
}

$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "DELETE FROM karyawan_absensi WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['pesan'] = "Data berhasil dihapus.";
    } else {
        $_SESSION['pesan'] = "Gagal menghapus data.";
    }
    header("Location: read.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Konfirmasi Hapus Data</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-purple-50 via-indigo-50 to-gray-100 min-h-screen flex items-center justify-center p-6">

    <div class="max-w-xl w-full bg-white rounded-3xl shadow-lg p-10 text-center">
        <h1 class="text-3xl font-extrabold text-indigo-700 mb-6">Konfirmasi Hapus Data</h1>
        <p class="mb-6 text-gray-700">Apakah Anda yakin ingin menghapus data karyawan berikut ini?</p>
        <div class="mb-8 p-4 bg-indigo-50 rounded-lg text-indigo-800 font-semibold">
            <p><strong>NIP:</strong> <?= htmlspecialchars($data['nip']) ?></p>
            <p><strong>Nama:</strong> <?= htmlspecialchars($data['nama']) ?></p>
        </div>
        <form method="POST" class="flex justify-center gap-6">
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-8 rounded-xl shadow-lg transition">Hapus</button>
            <a href="read.php" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-3 px-8 rounded-xl shadow-lg transition">Batal</a>
        </form>
    </div>

</body>
</html>
