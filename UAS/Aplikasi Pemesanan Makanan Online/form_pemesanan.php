<?php
require 'config.php';

$pesanan_berhasil = false;
$pesan_feedback = "";
$riwayat_pesanan = [];
$total_harga = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pemesan = htmlspecialchars(trim($_POST['nama_pemesan']));
    $alamat = htmlspecialchars(trim($_POST['alamat']));
    $menu_ids = $_POST['menu_id'] ?? [];
    $jumlah_data = $_POST['jumlah'] ?? [];

    if (!$nama_pemesan || !$alamat) {
        $pesan_feedback = "Nama dan alamat wajib diisi.";
    } elseif (count($menu_ids) === 0) {
        $pesan_feedback = "Pilih minimal satu menu.";
    } else {
        $tanggal_pesan = date('Y-m-d H:i:s');
        $stmt = $conn->prepare("INSERT INTO orders (menu_id, nama_pemesan, alamat, jumlah, tanggal_pesan) VALUES (?, ?, ?, ?, ?)");

        foreach ($menu_ids as $id_menu) {
            $id_menu = (int)$id_menu;
            $qty = isset($jumlah_data[$id_menu]) ? (int)$jumlah_data[$id_menu] : 1;
            if ($qty < 1) $qty = 1;

            $stmt->bind_param("issis", $id_menu, $nama_pemesan, $alamat, $qty, $tanggal_pesan);
            $stmt->execute();
        }
        $stmt->close();
        $pesanan_berhasil = true;

        $getRiwayat = $conn->prepare("
            SELECT m.nama AS nama_menu, m.kategori, o.jumlah, m.harga 
            FROM orders o 
            JOIN menu m ON o.menu_id = m.id 
            WHERE o.nama_pemesan = ? AND o.tanggal_pesan = ? 
        ");
        $getRiwayat->bind_param("ss", $nama_pemesan, $tanggal_pesan);
        $getRiwayat->execute();
        $result = $getRiwayat->get_result();
        while ($row = $result->fetch_assoc()) {
            $riwayat_pesanan[] = $row;
            $total_harga += $row['harga'] * $row['jumlah'];
        }
        $getRiwayat->close();
    }
}

$makanan = $conn->query("SELECT * FROM menu WHERE kategori='makanan' ORDER BY nama ASC");
$minuman = $conn->query("SELECT * FROM menu WHERE kategori='minuman' ORDER BY nama ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pemesanan | TANÉVA</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body { 
      font-family: 'Inter', sans-serif; 
      background-color: #fffdfa; 
      color: #3e2b1e; 
    }
    h1, h2, h3, label { 
      font-family: 'Playfair Display', serif; 
      color: rgb(106, 64, 33); 
    }
    .btn-primary {
      background: linear-gradient(135deg, #d2a679, #8b5e3c); 
      color: white;
      padding: 0.75rem 1.5rem; 
      border-radius: 9999px; 
      font-weight: 600;
      transition: all 0.3s ease;
    }
    .btn-primary:hover { 
      filter: brightness(1.1); 
      transform: scale(1.05); 
    }
    .section-box {
       background-color: #fffefc; 
       box-shadow: 0 8px 24px rgba(139, 94, 60, 0.1); 
       border: 1px solid #e7dcd2;
    }
  </style>
</head>
<body>

<header class="sticky top-0 z-50 bg-white bg-opacity-95 shadow-md px-6 sm:px-10 flex justify-between items-center text-[#3e2b1e]">
  <div class="flex items-center">
    <img src="logo.png" alt="Logo TANÉVA" class="h-12 w-12 sm:h-16 sm:w-16"> 
    <h1 class="text-3xl sm:text-4xl text-[#5b3a29] font-bold ml-2">TA<span class="text-yellow-500">NÉVA</span></h1>
  </div>
  <a href="index.php" class="btn-primary text-sm sm:text-base">Halaman Utama</a>
</header>

<section class="min-h-screen px-4 sm:px-6 py-10 sm:py-16 flex justify-center">
  <div class="w-full max-w-4xl section-box rounded-2xl p-6 sm:p-10 bg-white">
    <?php if ($pesanan_berhasil): ?>
      <div class="text-center space-y-8 sm:space-y-10">
        <h2 class="text-3xl sm:text-4xl font-bold text-yellow-500">Pesanan Sukses!</h2>
        <p class="text-base sm:text-lg text-gray-700">Terima kasih telah memesan di <strong class="text-[#5b3a29]">TA<span class="text-yellow-500">NÉVA</span></strong>. Berikut detail pesananmu:</p>
        <div class="text-left bg-white p-4 sm:p-6 rounded-xl border border-gray-200">
          <h3 class="text-xl sm:text-2xl font-semibold text-[#3e2b1e] mb-4">🧾 Ringkasan</h3>
          <ul class="list-disc pl-5 space-y-2 text-gray-800 text-sm sm:text-[17px]">
            <?php foreach ($riwayat_pesanan as $item): ?>
              <li>
                <span class="font-medium"><?= htmlspecialchars($item['nama_menu']) ?></span> 
                <strong><?= $item['jumlah'] ?> porsi</strong> -> Rp<?= number_format($item['harga'],0,',','.') ?>
              </li>
            <?php endforeach; ?>
          </ul>
          <div class="mt-4 sm:mt-6 text-lg sm:text-xl font-bold text-right">
            Total: Rp<?= number_format($total_harga, 0, ',', '.') ?>
          </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-center gap-4 sm:gap-5 pt-4 sm:pt-6">
          <a href="form_pemesanan.php" class="btn-primary">Pesan Lagi</a>
          <a href="index.php" class="btn-primary bg-[#3e2b1e] hover:bg-[#2a1d14]">Kembali ke Beranda</a>
        </div>
      </div>

    <?php else: ?>
      <h1 class="text-2xl sm:text-3xl font-bold text-center mb-6">Form Pemesanan</h1>
      <?php if ($pesan_feedback): ?>
        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-md text-sm sm:text-base"><?= $pesan_feedback ?></div>
      <?php endif; ?>

      <form method="POST" class="space-y-6">
        <div>
          <label class="block mb-2 font-semibold">Nama Pemesan</label>
          <input type="text" name="nama_pemesan" required class="w-full p-3 border border-gray-300 rounded-md" placeholder="Nama lengkap Anda">
        </div>

        <div>
          <label class="block mb-2 font-semibold">Alamat Pengiriman</label>
          <textarea name="alamat" rows="3" required class="w-full p-3 border border-gray-300 rounded-md" placeholder="Alamat lengkap pengiriman"></textarea>
        </div>

        <div class="flex flex-col md:flex-row gap-6 sm:gap-10">

          <div class="w-full md:w-1/2">
            <label class="block text-lg font-bold mb-2">Makanan</label>
            <?php $makanan->data_seek(0); while($row = $makanan->fetch_assoc()): ?>
              <div class="flex items-center gap-4 mb-2">
                <input type="checkbox" name="menu_id[]" value="<?= $row['id'] ?>" id="menu<?= $row['id'] ?>" class="w-5 h-5">
                <label for="menu<?= $row['id'] ?>" class="flex-1 text-sm sm:text-base"><?= htmlspecialchars($row['nama']) ?> - Rp<?= number_format($row['harga'],0,',','.') ?></label>
                <input type="number" name="jumlah[<?= $row['id'] ?>]" min="1" value="1" class="w-20 border border-gray-300 rounded-md p-2" disabled>
              </div>
            <?php endwhile; ?>
          </div>

          <div class="w-full md:w-1/2">
            <label class="block text-lg font-bold mb-2">Minuman</label>
            <?php $minuman->data_seek(0); while($row = $minuman->fetch_assoc()): ?>
              <div class="flex items-center gap-4 mb-2">
                <input type="checkbox" name="menu_id[]" value="<?= $row['id'] ?>" id="menu<?= $row['id'] ?>" class="w-5 h-5">
                <label for="menu<?= $row['id'] ?>" class="flex-1 text-sm sm:text-base"><?= htmlspecialchars($row['nama']) ?> - Rp<?= number_format($row['harga'],0,',','.') ?></label>
                <input type="number" name="jumlah[<?= $row['id'] ?>]" min="1" value="1" class="w-20 border border-gray-300 rounded-md p-2" disabled>
              </div>
            <?php endwhile; ?>
          </div>

        </div>

        <div class="text-center mt-8">
          <button type="submit" class="btn-primary">Kirim Pesanan</button>
        </div>

      </form>
      
    <?php endif; ?>
  </div>
</section>

<script>
  document.querySelectorAll('input[type=checkbox][name="menu_id[]"]').forEach((checkbox) => {
    checkbox.addEventListener('change', () => {
      const inputJumlah = document.querySelector('input[name="jumlah[' + checkbox.value + ']"]');
      if (inputJumlah) {
        inputJumlah.disabled = !checkbox.checked;
        if (!checkbox.checked) inputJumlah.value = 1;
      }
    });
  });
</script>

</body>
</html>