<?php
session_start();
require 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit();
}

$minuman = $conn->query("SELECT * FROM menu WHERE kategori = 'minuman' ORDER BY nama ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Menu Minuman - TANÉVA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #fffdfa;
      color: #3e2b1e;
    }
    h1, h2, h3 {
      font-family: 'Playfair Display', serif;
    }
  </style>
</head>
<body class="min-h-screen flex flex-col md:flex-row">

  <aside id="sidebar" class="bg-white w-full md:w-64 md:h-screen shadow-lg z-40 fixed md:relative top-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
    <div class="flex items-center gap-3 p-6 border-b border-[#eee3d3]">
      <img src="logo.png" alt="Logo" class="w-12 h-12">
      <h1 class="text-2xl font-bold text-[#8b5e3c]">TAN<span class="text-yellow-500">ÉVA</span></h1>
    </div>
    <nav class="px-4 mt-4 space-y-1">
      <a href="dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-yellow-50 transition">
        <i class="fas fa-home w-5"></i> Dashboard
      </a>
      <a href="pesanan.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-yellow-50 transition">
        <i class="fas fa-clipboard-list w-5"></i> Data Pemesanan
      </a>
      <a href="tambah_menu.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-yellow-50 transition">
        <i class="fas fa-plus-circle w-5"></i> Tambah Menu
      </a>
      <a href="kelola_makanan.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-yellow-50 transition">
        <i class="fas fa-utensils w-5"></i> Menu Makanan
      </a>
      <a href="kelola_minuman.php" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-yellow-50 text-[#8b5e3c] font-semibold">
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
>
  <main class="flex-1 p-4 md:p-6 mt-16 md:mt-0">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 md:mb-6 gap-3">
      <h2 class="text-xl md:text-3xl font-bold">🥤 Daftar Menu Minuman</h2>
      <a href="tambah_menu.php" class="bg-gradient-to-r from-[#d2a679] to-[#8b5e3c] text-white font-semibold px-4 py-2 rounded-full hover:opacity-90 transition text-sm">+ Tambah Menu</a>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-xl">
      <table class="min-w-full text-sm text-left divide-y divide-gray-300">
        <thead class="bg-gradient-to-r from-[#d2a679] to-[#8b5e3c] text-white uppercase text-xs">
          <tr>
            <th class="px-4 py-3">No</th>
            <th class="px-4 py-3">Nama Menu</th>
            <th class="px-4 py-3">Harga</th>
            <th class="px-4 py-3">Gambar</th>
            <th class="px-4 py-3">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <?php if ($minuman->num_rows > 0): 
            $no = 1;
            while ($row = $minuman->fetch_assoc()):
              $gambar = $row['gambar'] ? 'uploads/' . $row['gambar'] : 'no-image.png';
              $nama = htmlspecialchars($row['nama']);
              $harga = number_format($row['harga'], 0, ',', '.');
          ?>
          <tr class="hover:bg-[#fff7ec] transition">
            <td class="px-4 py-3"><?= $no++; ?></td>
            <td class="px-4 py-3"><?= $nama; ?></td>
            <td class="px-4 py-3">Rp <?= $harga; ?></td>
            <td class="px-4 py-3">
              <img src="<?= $gambar; ?>" alt="Gambar" class="w-16 h-16 object-cover rounded border" onerror="this.onerror=null;this.src='no-image.png';">
            </td>
            <td class="px-4 py-3 space-x-2 whitespace-nowrap">
              <a href="edit_menu.php?id=<?= $row['id']; ?>" class="inline-block px-3 py-1 bg-blue-500 text-white rounded-full hover:bg-blue-600 text-xs font-semibold">Edit</a>
              <a href="hapus_menu.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus menu ini?');" class="inline-block px-3 py-1 bg-red-500 text-white rounded-full hover:bg-red-600 text-xs font-semibold">Hapus</a>
            </td>
          </tr>
          <?php endwhile; else: ?>
          <tr>
            <td colspan="5" class="px-4 py-6 text-center text-gray-500 italic">Belum ada data menu</td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>


</body>
</html>
