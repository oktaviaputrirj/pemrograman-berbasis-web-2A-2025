<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require 'config.php';

$sql = "SELECT * FROM karyawan_absensi ORDER BY tanggal_absensi DESC, nip ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Data Karyawan & Absensi</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans antialiased">
  <div class="min-h-screen px-6 py-10 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
      <h1 class="text-3xl font-bold text-indigo-700">📋 Data Karyawan & Absensi</h1>
      <div class="flex gap-3">
        <a href="dashboard.php" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition shadow-sm">← Dashboard</a>
        <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition shadow-sm">Logout</a>
      </div>
    </div>

    <!-- Flash Message -->
    <?php if (isset($_SESSION['pesan'])): ?>
    <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow">
      <?= $_SESSION['pesan']; unset($_SESSION['pesan']); ?>
    </div>
    <?php endif; ?>

    <div class="bg-white border border-gray-200 rounded-xl shadow overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-indigo-100 text-indigo-800">
          <tr>
            <?php
            $headers = ['NIP', 'Nama', 'Umur', 'Jenis Kelamin', 'Departemen', 'Jabatan', 'Kota Asal', 'Tanggal Absensi', 'Jam Masuk', 'Jam Pulang', 'Aksi'];
            foreach ($headers as $head) {
              echo "<th class='px-4 py-3 text-sm font-semibold text-left whitespace-nowrap'>{$head}</th>";
            }
            ?>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 bg-white">
          <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td class="px-4 py-2 text-sm"><?= htmlspecialchars($row['nip']) ?></td>
                <td class="px-4 py-2 text-sm"><?= htmlspecialchars($row['nama']) ?></td>
                <td class="px-4 py-2 text-sm"><?= htmlspecialchars($row['umur']) ?></td>
                <td class="px-4 py-2 text-sm"><?= $row['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                <td class="px-4 py-2 text-sm"><?= htmlspecialchars($row['departemen']) ?></td>
                <td class="px-4 py-2 text-sm"><?= htmlspecialchars($row['jabatan']) ?></td>
                <td class="px-4 py-2 text-sm"><?= htmlspecialchars($row['kota_asal']) ?></td>
                <td class="px-4 py-2 text-sm"><?= date("d/m/Y", strtotime($row['tanggal_absensi'])) ?></td>
                <td class="px-4 py-2 text-sm"><?= htmlspecialchars($row['jam_masuk']) ?></td>
                <td class="px-4 py-2 text-sm"><?= htmlspecialchars($row['jam_pulang']) ?></td>
                <td class="px-4 py-2 text-sm text-center whitespace-nowrap space-x-2">
                  <a href="update.php?id=<?= urlencode($row['id']) ?>" class="text-indigo-600 hover:text-indigo-800 underline">Edit</a>
                  <a href="delete.php?id=<?= urlencode($row['id']) ?>" class="text-red-600 hover:text-red-800 underline">Hapus</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="11" class="text-center py-6 text-gray-500">Belum ada data karyawan dan absensi.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
