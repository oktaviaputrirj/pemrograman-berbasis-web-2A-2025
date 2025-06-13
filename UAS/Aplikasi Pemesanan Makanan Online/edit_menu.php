<?php
session_start();
require 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$success = false;
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];
    $gambar_lama = $_POST['gambar_lama'];
    $gambar_final = $gambar_lama;

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $gambar_tmp = $_FILES['gambar']['tmp_name'];
        $gambar_name = basename($_FILES['gambar']['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . time() . "_" . $gambar_name;

        if (move_uploaded_file($gambar_tmp, $target_file)) {
            $gambar_final = basename($target_file);
            if (!empty($gambar_lama) && file_exists("uploads/$gambar_lama")) {
                unlink("uploads/$gambar_lama");
            }
        } else {
            $error = "Gagal mengunggah gambar baru.";
        }
    }

    $stmt = $conn->prepare("UPDATE menu SET nama = ?, harga = ?, kategori = ?, gambar = ? WHERE id = ?");
    $stmt->bind_param("sissi", $nama, $harga, $kategori, $gambar_final, $id);
    if ($stmt->execute()) {
        header("Location: edit_menu.php?id=" . $id . "&success=1");
        exit();
    } else {
        $error = "Gagal menyimpan perubahan.";
    }
}

if (!isset($_GET['id']) && !isset($_POST['id'])) {
    echo "ID menu tidak ditemukan!";
    exit();
}

$id = $_GET['id'] ?? $_POST['id'];

$stmt = $conn->prepare("SELECT * FROM menu WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Menu tidak ditemukan!";
    exit();
}

$row = $result->fetch_assoc();

if (isset($_GET['success']) && $_GET['success'] == 1) {
    $success = true;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Menu - TANÉVA</title>
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
            <a href="kelola_minuman.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-yellow-50 transition">
                <i class="fas fa-glass-martini-alt w-5"></i> Menu Minuman
            </a>
        </nav>
        <div class="p-6 mt-auto">
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

    <main class="flex-1 p-4 md:p-10 mt-10 md:mt-0">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg">
            <h2 class="text-2xl font-bold mb-6">📝 Edit Menu TANÉVA</h2>

            <?php if ($success): ?>
                <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-700 rounded-lg shadow-md">
                    ✅ Perubahan berhasil disimpan!
                </div>
            <?php elseif (!empty($error)): ?>
                <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg shadow-md">
                    ⚠️ <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data" class="space-y-5">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <input type="hidden" name="gambar_lama" value="<?= $row['gambar'] ?>">

                <div>
                    <label class="block mb-2 font-semibold">Nama Menu</label>
                    <input type="text" name="nama" value="<?= htmlspecialchars($row['nama']) ?>" required class="w-full p-3 border border-gray-300 rounded-lg" />
                </div>

                <div>
                    <label class="block mb-2 font-semibold">Harga (Rp)</label>
                    <input type="number" name="harga" value="<?= $row['harga'] ?>" required class="w-full p-3 border border-gray-300 rounded-lg" />
                </div>

                <div>
                    <label class="block mb-2 font-semibold">Kategori</label>
                    <select name="kategori" required class="w-full p-3 border border-gray-300 rounded-lg">
                        <option value="">Pilih Kategori</option>
                        <option value="makanan" <?= $row['kategori'] === 'makanan' ? 'selected' : '' ?>>Makanan</option>
                        <option value="minuman" <?= $row['kategori'] === 'minuman' ? 'selected' : '' ?>>Minuman</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 font-semibold">Gambar Saat Ini</label>
                    <?php if (!empty($row['gambar'])): ?>
                        <img src="uploads/<?= $row['gambar'] ?>" class="w-32 h-32 object-cover rounded shadow mt-2">
                    <?php else: ?>
                        <p class="text-sm italic text-gray-500 mt-2">Tidak ada gambar.</p>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block mb-2 font-semibold">Upload Gambar Baru (Opsional)</label>
                    <input type="file" name="gambar" accept="image/*" class="w-full p-3 border border-gray-300 rounded-lg" />
                </div>

                <div class="text-right">
                    <button type="submit" class="bg-gradient-to-r from-[#d2a679] to-[#8b5e3c] text-white font-semibold px-6 py-2 rounded-full hover:opacity-90 transition">
                        <i class="fas fa-save mr-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>
