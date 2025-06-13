<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require 'config.php';

$karyawan = $conn->query("SELECT COUNT(DISTINCT NIP) as total FROM karyawan_absensi");
$total_karyawan = $karyawan->fetch_assoc()['total'];

$hari_ini = date('Y-m-d');
$absensi = $conn->query("SELECT COUNT(*) as total FROM karyawan_absensi WHERE tanggal_absensi = '$hari_ini'");
$total_absen = $absensi->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      will-change: transform;
      border-radius: 1rem;
      background: #fff;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 20px rgba(99, 102, 241, 0.25);
    }
  </style>
</head>
<body class="bg-gradient-to-tr from-indigo-50 via-purple-50 to-white min-h-screen font-sans">

  <div class="max-w-7xl mx-auto flex flex-col md:flex-row min-h-screen p-8 gap-12">

    <!-- Kiri -->
    <div class="md:w-1/2 flex flex-col justify-center items-center text-center px-6">
      <img src="2.png" alt="Ilustrasi Karyawan" class="max-w-md mb-6"/>
      <h1 class="text-4xl font-extrabold text-indigo-700 mb-2">Manajemen Karyawan & Absensi</h1>
      <p class="text-indigo-600 max-w-md">Pantau kehadiran dan data karyawan dengan mudah dan cepat lewat dashboard ini.</p>
    </div>

    <!-- Kanan -->
    <div class="md:w-1/2 bg-white rounded-2xl shadow-xl p-10 flex flex-col justify-between">

      <div class="flex justify-between items-center mb-8">
        <div>
          <h2 class="text-2xl font-semibold text-gray-800">Halo, <span class="text-indigo-600"><?= htmlspecialchars($_SESSION['username']) ?></span> 👋</h2>
          <p class="text-gray-500">Selamat datang kembali!</p>
        </div>
        <form action="logout.php" method="POST" class="ml-4">
          <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 transition">Logout</button>
        </form>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-10">
        <div class="card p-8 text-center">
          <p class="text-sm text-gray-400 uppercase mb-2">Total Karyawan</p>
          <p class="text-5xl font-bold text-indigo-600"><?= $total_karyawan ?></p>
        </div>
        <div class="card p-8 text-center">
          <p class="text-sm text-gray-400 uppercase mb-2">Absensi Hari Ini</p>
          <p class="text-5xl font-bold text-indigo-600"><?= $total_absen ?></p>
        </div>
      </div>

      <div class="flex flex-col sm:flex-row gap-6">
        <a href="input.php" class="flex-1 bg-indigo-600 text-white text-center py-4 rounded-lg shadow hover:bg-indigo-700 transition font-semibold">Tambah Data & Absensi</a>
        <a href="read.php" class="flex-1 bg-purple-600 text-white text-center py-4 rounded-lg shadow hover:bg-purple-700 transition font-semibold">Kelola Data</a>
      </div>
      
    </div>

  </div>

</body>
</html>
