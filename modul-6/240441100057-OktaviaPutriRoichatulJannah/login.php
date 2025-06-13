<?php
session_start();
require 'config.php';

$loginError = '';
$registerError = '';
$registerSuccess = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $formType = $_POST['form_type'];
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  if ($formType === 'login') {
    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
      if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit;
      } else {
        $loginError = "Password salah!";
      }
    } else {
      $loginError = "Akun tidak ditemukan!";
    }
  }

  if ($formType === 'register') {
    $confirm = trim($_POST['confirm_password']);

    if ($password !== $confirm) {
      $registerError = "Password tidak cocok!";
    } else {
      $check = $conn->prepare("SELECT id FROM users WHERE username=?");
      $check->bind_param("s", $username);
      $check->execute();
      $check->store_result();

      if ($check->num_rows > 0) {
        $registerError = "Username sudah digunakan!";
      } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $insert = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $insert->bind_param("ss", $username, $hash);
        if ($insert->execute()) {
          $registerSuccess = "Registrasi berhasil! Silakan login.";
        } else {
          $registerError = "Registrasi gagal: " . $conn->error;
        }
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login & Registrasi</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>


<body class="min-h-screen flex items-center justify-center bg-slate-100 font-sans">
  <div class="w-full max-w-4xl bg-white rounded-xl shadow-lg overflow-hidden grid md:grid-cols-2">

    <!-- Kiri -->
    <div class="hidden md:flex items-center justify-center bg-indigo-500 p-8">
      <div class="text-center text-white">
        <img src="3.png" alt="Ilustrasi" class="w-64 mx-auto mb-4 drop-shadow-lg" />
        <h1 class="text-3xl font-bold">Selamat Datang</h1>
        <p class="mt-2 text-sm opacity-90">Gabung dan kelola akun Anda dengan mudah.</p>
      </div>
    </div>

    <!-- Kanan  -->
    <div class="p-8 md:p-10">
      <div class="flex justify-center mb-6 space-x-4">
        <button onclick="showForm('login')" id="loginTab" class="tab-btn px-4 py-2 font-semibold text-indigo-600 border-b-2 border-indigo-600">Login</button>
        <button onclick="showForm('register')" id="registerTab" class="tab-btn px-4 py-2 font-semibold text-slate-500 hover:text-indigo-600">Registrasi</button>
      </div>

      <!-- Login Form -->
      <form id="loginForm" method="POST" class="space-y-5">
        <input type="hidden" name="form_type" value="login" />
        <?php if ($loginError): ?>
          <div class="bg-red-100 text-red-600 text-sm p-2 rounded"><?= $loginError ?></div>
        <?php endif; ?>
        <input name="username" type="text" placeholder="Username" required class="w-full border border-slate-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-400" />
        <input name="password" type="password" placeholder="Password" required class="w-full border border-slate-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-400" />
        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-md transition">Masuk</button>
      </form>

      <!-- Register Form -->
      <form id="registerForm" method="POST" class="hidden space-y-5">
        <input type="hidden" name="form_type" value="register" />
        <?php if ($registerError): ?>
          <div class="bg-red-100 text-red-600 text-sm p-2 rounded"><?= $registerError ?></div>
        <?php elseif ($registerSuccess): ?>
          <div class="bg-green-100 text-green-600 text-sm p-2 rounded"><?= $registerSuccess ?></div>
        <?php endif; ?>
        <input name="username" type="text" placeholder="Username" required class="w-full border border-slate-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-400" />
        <input name="password" type="password" placeholder="Password" required class="w-full border border-slate-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-400" />
        <input name="confirm_password" type="password" placeholder="Konfirmasi Password" required class="w-full border border-slate-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-400" />
        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-md transition">Daftar</button>
      </form>
    </div>
  </div>

  <script>
    function showForm(form) {
      const login = document.getElementById('loginForm');
      const register = document.getElementById('registerForm');
      const loginTab = document.getElementById('loginTab');
      const registerTab = document.getElementById('registerTab');

      if (form === 'login') {
        login.style.display = 'block';
        register.style.display = 'none';
        loginTab.classList.add('text-indigo-600', 'border-b-2', 'border-indigo-600');
        registerTab.classList.remove('text-indigo-600', 'border-b-2', 'border-indigo-600');
        registerTab.classList.add('text-slate-500');
      } else {
        login.style.display = 'none';
        register.style.display = 'block';
        registerTab.classList.add('text-indigo-600', 'border-b-2', 'border-indigo-600');
        loginTab.classList.remove('text-indigo-600', 'border-b-2', 'border-indigo-600');
        loginTab.classList.add('text-slate-500');
      }
    }

    <?php if ($registerError || $registerSuccess): ?>
      showForm('register');
    <?php else: ?>
      showForm('login');
    <?php endif; ?>
  </script>
</body>

</html>
