<?php
session_start();
require 'config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    if ($stmt === false) {
        error_log("Failed to prepare statement: " . $conn->error);
        $error = "Terjadi kesalahan sistem. Silakan coba lagi nanti.";
    } else {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Password salah. Silakan coba lagi.";
            }
        } else {
            $error = "Username tidak ditemukan. Silakan periksa kembali.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Login Admin - TANÉVA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to right, rgb(213, 170, 127), #8b5e3c);
            color: #3e2b1e;
        }
        h1, h2, label {
            font-family: 'Playfair Display', serif;
        }
        .btn-taneva {
            background: linear-gradient(135deg, #d2a679, #8b5e3c); /* Match primary button gradient */
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            font-weight: 600;
            transition: all 0.3s ease; 
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .btn-taneva:hover {
            filter: brightness(1.1);
            transform: scale(1.02); 
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }
        input:focus {
            outline: none;
            border-color: #a67c52; 
            box-shadow: 0 0 0 3px rgba(166, 124, 82, 0.25); 
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 sm:p-6 md:p-8">

    <div class="bg-white/90 shadow-2xl rounded-3xl overflow-hidden flex flex-col md:flex-row w-full max-w-sm sm:max-w-xl md:max-w-4xl border border-[#f0eae2]">

        <div class="hidden md:flex md:w-1/2 bg-[#f3e8dc] items-center justify-center p-4">
            <img src="login.png" alt="Tanéva Login" class="rounded-2xl w-full h-auto object-cover max-h-[400px]">
        </div>

        <div class="w-full md:w-1/2 p-6 sm:p-8 md:p-10">
            <h2 class="text-3xl sm:text-4xl font-bold text-center mb-6 sm:mb-8 text-[#6b4226]">Login Admin</h2>

            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm text-center animate-pulse">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-5 sm:space-y-6">
                <div>
                    <label for="username" class="block mb-2 font-medium text-[#6b4226]">Username</label>
                    <input type="text"name="username" id="username" required class="w-full border border-gray-300 rounded-full px-4 py-2 sm:px-5 sm:py-3 bg-white/50 text-[#3e2b1e]" placeholder="Masukkan username" autocomplete="username" />
                </div>
                <div>
                    <label for="password" class="block mb-2 font-medium text-[#6b4226]">Password</label>
                    <input type="password" name="password" id="password" required class="w-full border border-gray-300 rounded-full px-4 py-2 sm:px-5 sm:py-3 bg-white/50 text-[#3e2b1e]" placeholder="Masukkan password" autocomplete="current-password" />
                </div>
                <button type="submit" name="login" class="btn-taneva text-center w-full mt-6">Masuk</button>
                <p class="text-xs text-gray-500 text-center mt-3 opacity-80">Pastikan informasi login Anda benar dan aman.</p>
            </form>
        </div>

    </div>

</body>
</html>