<?php
require 'config.php';

$username = 'admin';
$password = password_hash('admin123', PASSWORD_DEFAULT); // bikin hash dari password
$role = 'admin';

$stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $password, $role);

if ($stmt->execute()) {
  echo "User admin berhasil dibuat!<br>Username: admin<br>Password: admin123";
} else {
  echo "Gagal membuat user admin: " . $stmt->error;
}
?>
