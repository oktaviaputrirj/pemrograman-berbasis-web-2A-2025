<?php
session_start();
require 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit();
}

$sql = "SELECT orders.*, menu.nama AS nama_menu FROM orders 
        LEFT JOIN menu ON orders.menu_id = menu.id 
        ORDER BY tanggal_pesan DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Pemesanan - TANÉVA</title>
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
      <a href="pesanan.php" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-yellow-50 text-[#8b5e3c] font-semibold">
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

  <main class="flex-1 p-4 mt-16 md:mt-0">
    <h2 class="text-2xl md:text-3xl font-bold mb-6">📋 Daftar Pesanan Masuk</h2>

    <div class="overflow-x-auto bg-white shadow-md rounded-xl">
      <table class="min-w-full text-sm text-left divide-y divide-gray-300">
        <thead class="bg-gradient-to-r from-[#d2a679] to-[#8b5e3c] text-white text-xs sm:text-sm uppercase">
          <tr>
            <th class="px-3 sm:px-6 py-4">No</th>
            <th class="px-3 sm:px-6 py-4">Nama Pemesan</th>
            <th class="px-3 sm:px-6 py-4">Menu</th>
            <th class="px-3 sm:px-6 py-4">Jumlah</th>
            <th class="px-3 sm:px-6 py-4">Alamat</th>
            <th class="px-3 sm:px-6 py-4">Tanggal</th>
            <th class="px-3 sm:px-6 py-4">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 text-xs sm:text-sm">
          <?php
          if ($result->num_rows > 0) {
              $no = 1;
              while ($row = $result->fetch_assoc()) {
                  echo "<tr class='hover:bg-yellow-50 transition'>";
                  echo "<td class='px-3 sm:px-6 py-4'>" . $no++ . "</td>";
                  echo "<td class='px-3 sm:px-6 py-4'>" . htmlspecialchars($row['nama_pemesan']) . "</td>";
                  echo "<td class='px-3 sm:px-6 py-4'>" . htmlspecialchars($row['nama_menu']) . "</td>";
                  echo "<td class='px-3 sm:px-6 py-4'>" . htmlspecialchars($row['jumlah']) . "</td>";
                  echo "<td class='px-3 sm:px-6 py-4'>" . htmlspecialchars($row['alamat']) . "</td>";
                  echo "<td class='px-3 sm:px-6 py-4'>" . date("d-m-Y", strtotime($row['tanggal_pesan'])) . "</td>";
                  echo "<td class='px-3 sm:px-6 py-4'>
                          <a href='hapus_pesanan.php?id=" . $row['id'] . "' 
                            onclick=\"return confirm('Yakin pesanan sudah selesai? (Data akan dihapus)');\" 
                            class='text-red-600 hover:text-red-800 font-semibold'>
                            ✅ Selesai
                          </a>
                        </td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='7' class='px-6 py-6 text-center text-gray-500 italic'>Belum ada pesanan</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>

</body>
</html>