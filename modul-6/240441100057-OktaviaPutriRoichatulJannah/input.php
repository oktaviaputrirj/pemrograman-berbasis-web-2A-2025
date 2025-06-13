<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require 'config.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nip = trim($_POST['nip']);
    $nama = trim($_POST['nama']);
    $umur = (int)$_POST['umur'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $departemen = trim($_POST['departemen']);
    $jabatan = trim($_POST['jabatan']);
    $kota_asal = trim($_POST['kota_asal']);
    $tanggal_absensi = $_POST['tanggal_absensi'];
    $jam_masuk = $_POST['jam_masuk'];
    $jam_pulang = $_POST['jam_pulang'];

    // Validasi input
    if (empty($nip)) $errors[] = "NIP harus diisi.";
    if (empty($nama)) $errors[] = "Nama harus diisi.";
    if ($umur <= 0) $errors[] = "Umur harus lebih dari 0.";
    if (!in_array($jenis_kelamin, ['L', 'P'])) $errors[] = "Jenis kelamin tidak valid.";
    if (empty($departemen)) $errors[] = "Departemen harus diisi.";
    if (empty($jabatan)) $errors[] = "Jabatan harus diisi.";
    if (empty($kota_asal)) $errors[] = "Kota asal harus diisi.";
    if (empty($tanggal_absensi)) $errors[] = "Tanggal absensi harus diisi.";
    if (empty($jam_masuk)) $errors[] = "Jam masuk harus diisi.";
    if (empty($jam_pulang)) $errors[] = "Jam pulang harus diisi.";
    if ($jam_masuk >= $jam_pulang) $errors[] = "Jam masuk harus lebih awal dari jam pulang.";

    if (!$errors) {
        $stmt = $conn->prepare("INSERT INTO karyawan_absensi (nip, nama, umur, jenis_kelamin, departemen, jabatan, kota_asal, tanggal_absensi, jam_masuk, jam_pulang) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisssssss", $nip, $nama, $umur, $jenis_kelamin, $departemen, $jabatan, $kota_asal, $tanggal_absensi, $jam_masuk, $jam_pulang);
        if ($stmt->execute()) {
            $success = "Data berhasil disimpan!";
            $_POST = [];
        } else {
            $errors[] = "Gagal menyimpan data: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id" >
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Input Data Karyawan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-purple-50 via-indigo-50 to-gray-100 min-h-screen flex items-center justify-center p-6">

  <div class="max-w-3xl w-full bg-white rounded-3xl shadow-lg p-10">
    <header class="flex justify-between items-center mb-8">
      <h1 class="text-3xl font-extrabold text-indigo-700">Form Input Karyawan & Absensi</h1>
      <a href="dashboard.php" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl shadow transition">← Dashboard</a>
    </header>

    <?php if ($errors): ?>
      <div class="bg-red-100 border border-red-300 text-red-800 p-4 rounded mb-6 shadow-sm">
        <ul class="list-disc list-inside space-y-1">
          <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="bg-green-100 border border-green-300 text-green-800 p-4 rounded mb-6 shadow-sm">
        <?= htmlspecialchars($success) ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">

      <div class="flex flex-col">
        <label for="nip" class="mb-2 font-semibold text-gray-700">NIP</label>
        <input id="nip" type="text" name="nip" required value="<?= htmlspecialchars($_POST['nip'] ?? '') ?>" class="border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" />
      </div>

      <div class="flex flex-col">
        <label for="nama" class="mb-2 font-semibold text-gray-700">Nama</label>
        <input id="nama" type="text" name="nama" required value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>" class="border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" />
      </div>

      <div class="flex flex-col">
        <label for="umur" class="mb-2 font-semibold text-gray-700">Umur</label>
        <input id="umur" type="number" min="1" name="umur" required value="<?= htmlspecialchars($_POST['umur'] ?? '') ?>" class="border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" />
      </div>

      <div class="flex flex-col">
        <label for="jenis_kelamin" class="mb-2 font-semibold text-gray-700">Jenis Kelamin</label>
        <select id="jenis_kelamin" name="jenis_kelamin" required class="border border-gray-300 rounded-lg p-3 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
          <option value="" disabled <?= (empty($_POST['jenis_kelamin'])) ? 'selected' : '' ?>>-- Pilih --</option>
          <option value="L" <?= (($_POST['jenis_kelamin'] ?? '') === 'L') ? 'selected' : '' ?>>Laki-laki</option>
          <option value="P" <?= (($_POST['jenis_kelamin'] ?? '') === 'P') ? 'selected' : '' ?>>Perempuan</option>
        </select>
      </div>

      <div class="flex flex-col">
        <label for="departemen" class="mb-2 font-semibold text-gray-700">Departemen</label>
        <input id="departemen" type="text" name="departemen" required value="<?= htmlspecialchars($_POST['departemen'] ?? '') ?>" class="border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" />
      </div>

      <div class="flex flex-col">
        <label for="jabatan" class="mb-2 font-semibold text-gray-700">Jabatan</label>
        <input id="jabatan" type="text" name="jabatan" required value="<?= htmlspecialchars($_POST['jabatan'] ?? '') ?>" class="border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" />
      </div>

      <div class="flex flex-col">
        <label for="kota_asal" class="mb-2 font-semibold text-gray-700">Kota Asal</label>
        <input id="kota_asal" type="text" name="kota_asal" required value="<?= htmlspecialchars($_POST['kota_asal'] ?? '') ?>" class="border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" />
      </div>

      <div class="flex flex-col">
        <label for="tanggal_absensi" class="mb-2 font-semibold text-gray-700">Tanggal Absensi</label>
        <input id="tanggal_absensi" type="date" name="tanggal_absensi" required value="<?= htmlspecialchars($_POST['tanggal_absensi'] ?? '') ?>" class="border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" />
      </div>

      <div class="flex flex-col">
        <label for="jam_masuk" class="mb-2 font-semibold text-gray-700">Jam Masuk</label>
        <input id="jam_masuk" type="time" name="jam_masuk" required value="<?= htmlspecialchars($_POST['jam_masuk'] ?? '') ?>" class="border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" />
      </div>

      <div class="flex flex-col">
        <label for="jam_pulang" class="mb-2 font-semibold text-gray-700">Jam Pulang</label>
        <input id="jam_pulang" type="time" name="jam_pulang" required value="<?= htmlspecialchars($_POST['jam_pulang'] ?? '') ?>" class="border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" />
      </div>

      <div class="md:col-span-2 text-right">
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-xl shadow-lg transition">Simpan</button>
      </div>

    </form>
  </div>

</body>
</html>
