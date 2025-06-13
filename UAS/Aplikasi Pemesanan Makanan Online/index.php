<?php
require 'config.php';
$foods = $conn->query("SELECT * FROM menu WHERE kategori = 'makanan'");
$drinks = $conn->query("SELECT * FROM menu WHERE kategori = 'minuman'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TANÉVA </title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #fffdfa;
      color: #3e2b1e;
    }
    h1, h2, h3 {
      font-family: 'Playfair Display', serif;
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
    .card-glow {
      box-shadow: 0 8px 24px rgba(139, 94, 60, 0.1);
      transition: 0.3s ease;
    }
    .card-glow:hover {
      box-shadow: 0 12px 32px rgba(139, 94, 60, 0.45);
      transform: scale(1.05);
    }
  </style>
</head>
<body>

  <header class="sticky top-0 z-50 bg-white bg-opacity-95 shadow-md py-2 px-4 sm:px-10 flex flex-col sm:flex-row justify-between items-center ">
    <div class="flex items-center mb-3 sm:mb-0 header-logo-container">
      <img src="logo.png" alt="Logo TANÉVA" class="h-12 w-12 sm:h-16 sm:w-16">
      <h1 class="text-3xl sm:text-4xl font-bold ml-2">TA<span class="text-yellow-500">NÉVA</span></h1>
    </div>

    <nav class="flex flex-wrap justify-center items-center gap-x-4 gap-y-2 text-sm font-semibold">
      <a href="#menu" class="hover:text-yellow-600">Menu</a>
      <a href="#promo" class="hover:text-yellow-600">Promo</a>
      <a href="#testimoni" class="hover:text-yellow-600">Testimoni</a>
      <a href="form_pemesanan.php" class="hover:text-yellow-600">Pesan</a>
      <a href="login.php" class="btn-primary text-sm">Login Admin</a>
    </nav>
  </header>

  <section class="max-w-7xl mx-auto px-6 py-12 md:py-20 flex flex-col md:flex-row items-center gap-10 md:gap-14 text-center md:text-left">
    <div class="md:w-1/2">
      <h1 class="text-4xl sm:text-5xl font-bold mb-4 md:mb-6 leading-tight tracking-wide text-[#5b3a29]">
        Sajian Rasa Nusantara, <br class="hidden sm:inline"/> Hangat dan Menggugah Selera
      </h1>
      <p class="mb-6 md:mb-8 text-base md:text-lg max-w-xl mx-auto md:mx-0 text-[#5c4a3d] italic">
        Kuliner lokal yang menggoda kini bisa kamu pesan dalam genggaman. Cepat, praktis, dan penuh rasa!
      </p>
      <a href="form_pemesanan.php" class="btn-primary inline-block">Pesan Sekarang</a>
    </div>
    <div class="md:w-1/2">
      <img src="home.jpg" alt="Makanan Nusantara" class="rounded-3xl shadow-xl w-full" />
    </div>
  </section>

  <section id="menu" class="py-12 md:py-16 px-4 md:px-5 mx-20 max-w-7xl ">
    <h2 class="text-2xl sm:text-3xl text-center text-[#6a4e42] mb-10 md:mb-12">Makanan Favorit</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <?php while ($row = $foods->fetch_assoc()): ?>
        <div class="card-glow rounded-xl overflow-hidden">
          <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" alt="<?= htmlspecialchars($row['nama']) ?>" class="w-full h-40 object-cover">
          <div class="p-4">
            <h3 class="text-base font-bold"><?= htmlspecialchars($row['nama']) ?></h3>
            <p class="text-sm text-[#6b4e3d] mt-1">Rp<?= number_format($row['harga'], 0, ',', '.') ?></p>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </section>

  <section class="py-12 md:py-16 px-4 md:px-5 mx-20 max-w-7xl ">
    <h2 class="text-2xl sm:text-3xl text-center text-[#8b5e3c] mb-10 md:mb-12">Minuman Segar</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <?php while ($row = $drinks->fetch_assoc()): ?>
        <div class="card-glow rounded-xl overflow-hidden">
          <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" alt="<?= htmlspecialchars($row['nama']) ?>" class="w-full h-40 object-cover">
          <div class="p-4">
            <h3 class="text-base font-bold"><?= htmlspecialchars($row['nama']) ?></h3>
            <p class="text-sm text-[#6b4e3d] mt-1">Rp<?= number_format($row['harga'], 0, ',', '.') ?></p>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </section>

  <section id="promo" class="mx-4 sm:mx-5 rounded-xl shadow-xl relative bg-gradient-to-br from-[#6a4e42] to-[#d3b083] text-white py-16 md:py-24 px-6 overflow-hidden">
    <div class="max-w-5xl mx-auto text-center relative z-10">
      <h2 class="text-3xl sm:text-5xl font-extrabold mb-6 md:mb-10 leading-tight drop-shadow-xl">Pose Rempah Challenge</h2>
      <p class="text-sm sm:text-base mb-6 md:mb-8 leading-relaxed text-white/80 italic">
        Upload ekspresi terbaikmu saat menikmati rempah TANÉVA dan tag Instagram kami. Setiap minggu, 3 gaya terbaik akan memenangkan <strong class="text-amber-200">voucher makan gratis!</strong>
      </p>
      <a href="form_pemesanan.php" class="btn-primary inline-block">Pesan Sekarang</a>
    </div>
  </section>

  <section id="testimoni" class="py-16 md:py-20 px-4 sm:px-6 text-[#3e2b1e] bg-[#fffaf3]">
    <div class="max-w-6xl mx-auto">
      <h2 class="text-3xl sm:text-4xl font-bold text-center mb-10 md:mb-12">💬 Apa Kata Mereka?</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
        <div class="card-glow p-5 sm:p-6 rounded-xl">
          <p class="italic mb-3 sm:mb-4 text-sm sm:text-base">“Makanannya khas banget, dikemas modern. Suka tampilannya juga!”</p>
          <div class="font-semibold text-xs sm:text-sm">— Nia, Yogyakarta</div>
        </div>
        <div class="card-glow p-5 sm:p-6 rounded-xl">
          <p class="italic mb-3 sm:mb-4 text-sm sm:text-base">“Website-nya cantik, nuansa tradisional tapi tetap elegan.”</p>
          <div class="font-semibold text-xs sm:text-sm">— Bayu, Bali</div>
        </div>
        <div class="card-glow p-5 sm:p-6 rounded-xl">
          <p class="italic mb-3 sm:mb-4 text-sm sm:text-base">“Rekomendasi buat pecinta makanan lokal. Enak, cepet, mantap!”</p>
          <div class="font-semibold text-xs sm:text-sm">— Dira, Jakarta</div>
        </div>
      </div>
    </div>
  </section>

</body>
</html>