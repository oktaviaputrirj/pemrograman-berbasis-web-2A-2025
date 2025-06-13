<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
require 'config.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - TANÉVA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3 {
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>
<body class="bg-[#fffdfa] text-[#3e2b1e] min-h-screen flex flex-col md:flex-row">

  <aside id="sidebar" class="bg-white w-full md:w-64 md:h-screen shadow-lg z-40 fixed md:relative top-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
    <div class="flex items-center gap-3 p-6 border-b border-[#eee3d3]">
      <img src="logo.png" alt="Logo" class="w-12 h-12">
      <h1 class="text-2xl font-bold text-[#8b5e3c]">TAN<span class="text-yellow-500">ÉVA</span></h1>
    </div>
    <nav class="px-4 mt-4 space-y-1">
      <a href="dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-yellow-50 text-[#8b5e3c] font-semibold">
        <i class="fas fa-home w-5"></i> Dashboard
      </a>
      <a href="pesanan.php" class="flex items-center gap-3 px-4 py-3 ===rounded-lg hover:bg-yellow-50 transition">
        <i class="fas fa-clipboard-list w-5"></i> Data Pemesanan
      </a>
      <a href="tambah_menu.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-yellow-50 transition">
        <i class="fas fa-plus-circle w-5"></i> Tambah Menu
      </a>
      <a href="kelola_makanan.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-yellow-50 transition">
        <i class="fas fa-utensils w-5"></i> Menu Makanan
      </a>
      <a href="kelola_minuman.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-yellow-50 transition">
        <i class="fas fa-glass-martini-alt w-5"></i> Menu Minuman
      </a>
    </nav>

    <div class="p-6">
      <a href="logout.php" class="bg-gradient-to-r from-yellow-400 to-[#8b5e3c] text-white font-semibold py-2 px-4 rounded-full w-full block text-center hover:opacity-90 transition">
        <i class="fas fa-sign-out-alt mr-2"></i> Logout
      </a>
    </div>
  </aside>

  <header class="flex items-center justify-between p-4 bg-white shadow md:hidden z-50">
    <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')" class="text-2xl text-[#8b5e3c] focus:outline-none">
      <i class="fas fa-bars"></i>
    </button>
    <h1 class="text-xl font-bold text-[#8b5e3c]">TAN<span class="text-yellow-500">ÉVA</span> Admin</h1>
  </header>

    <main class="flex-1 p-6 mt-16 md:mt-0">
        <h2 class="text-2xl font-bold mb-6">Selamat datang, <span class="text-yellow-700"><?= htmlspecialchars($_SESSION['username']) ?></span>!</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div onclick="window.location='pesanan.php'" class="cursor-pointer bg-white rounded-xl p-6 shadow hover:shadow-md transition hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold"><i class="fas fa-clipboard-list text-yellow-600 mr-2"></i> Data Pemesanan</h3>
                    <span class="text-sm text-yellow-700">Lihat &raquo;</span>
                </div>
                <p class="mt-2 text-sm text-[#5c4a3d]">Pantau dan proses pesanan pelanggan yang masuk.</p>
            </div>

            <div onclick="window.location='tambah_menu.php'" class="cursor-pointer bg-white rounded-xl p-6 shadow hover:shadow-md transition hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold"><i class="fas fa-plus-circle text-yellow-600 mr-2"></i> Tambah Menu</h3>
                    <span class="text-sm text-yellow-700">Input &raquo;</span>
                </div>
                <p class="mt-2 text-sm text-[#5c4a3d]">Tambah makanan atau minuman ke dalam menu TANÉVA.</p>
            </div>

            <div onclick="window.location='kelola_makanan.php'" class="cursor-pointer bg-white rounded-xl p-6 shadow hover:shadow-md transition hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold"><i class="fas fa-utensils text-yellow-600 mr-2"></i> Menu Makanan</h3>
                    <span class="text-sm text-yellow-700">Kelola &raquo;</span>
                </div>
                <p class="mt-2 text-sm text-[#5c4a3d]">Lihat dan atur daftar makanan yang tersedia.</p>
            </div>

            <div onclick="window.location='kelola_minuman.php'" class="cursor-pointer bg-white rounded-xl p-6 shadow hover:shadow-md transition hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold"><i class="fas fa-glass-martini-alt text-yellow-600 mr-2"></i> Menu Minuman</h3>
                    <span class="text-sm text-yellow-700">Kelola &raquo;</span>
                </div>
                <p class="mt-2 text-sm text-[#5c4a3d]">Kelola minuman khas Nusantara TANÉVA dengan mudah.</p>
            </div>
        </div>
    </main>

</body>
</html>
