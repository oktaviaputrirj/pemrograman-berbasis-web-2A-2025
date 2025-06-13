<?php
session_start();
require 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit();
}

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();

  header("Location: pesanan.php");
  exit();
} else {
  echo "ID pesanan tidak valid.";
}
?>
