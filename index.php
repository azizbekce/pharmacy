<?php
session_start();

// Agar foydalanuvchi tizimga kirgan bo'lsa, dashboard.php sahifasiga yo'naltirish
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
} else {
    // Foydalanuvchi tizimga kirmagan bo'lsa, login.php sahifasiga yo'naltirish
    header("Location: login.php");
    exit;
}
?>