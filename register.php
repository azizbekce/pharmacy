<?php
session_start();
require_once 'db.php';
$errors = [];

// Agar formani yuborish tugmasi bosilsa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $phone = preg_replace('/\D+/', '', $_POST['phone'] ?? '');
    if (substr($phone, 0, 3) === '998' && strlen($phone) === 12) {
        $phone = substr($phone, 3);
    }
    $password = $_POST['password'] ?? '';

    // Ma'lumotlarni tekshirish
    if (empty($username)) {
        $errors[] = "Foydalanuvchi nomi kiritilishi kerak.";
    }
    if (empty($phone)) {
        $errors[] = "Telefon raqami kiritilishi kerak.";
    }
    if (empty($password)) {
        $errors[] = "Parol kiritilishi kerak.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Parol kamida 6 ta belgidan iborat bo'lishi kerak.";
    }
    if ($username !== '' && !preg_match('/^[\p{L}0-9_.-]{3,50}$/u', $username)) {
        $errors[] = "Foydalanuvchi nomi 3-50 ta harf, raqam yoki ._- belgilaridan iborat bo'lsin.";
    }
    if ($phone !== '' && !preg_match('/^[0-9]{9}$/', $phone)) {
        $errors[] = "Telefon raqami +998 dan keyin 9 ta raqamdan iborat bo'lishi kerak.";
    }

    // Agar hech qanday xatolik bo'lmasa
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE phone = ? OR username = ?");
        $stmt->bind_param("ss", $phone, $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = "Bu telefon raqami yoki foydalanuvchi nomi avval ro'yxatdan o'tgan.";
        } else {
            // Parolni himoyalash va foydalanuvchini bazaga qo'shish
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insertStmt = $conn->prepare("INSERT INTO users (username, phone, password) VALUES (?, ?, ?)");
            $insertStmt->bind_param("sss", $username, $phone, $hashed_password);

            if ($insertStmt->execute()) {
                header("Location: index.php");
                exit;
            } else {
                $errors[] = "Ro'yxatdan o'tishda xatolik yuz berdi.";
            }
        }
        
        $stmt->close();
        if (isset($insertStmt)) {
            $insertStmt->close();
        }
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ro'yxatdan o'tish</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <div class="page-toolbar">
    <a class="back-link" href="login.php">← <span data-i18n="back">Orqaga</span></a>
    <div class="preferences">
        <label for="languageSelect" data-i18n="language">Til</label>
        <select id="languageSelect" aria-label="Tilni tanlang">
            <option value="uz">UZ</option>
            <option value="ru">RU</option>
            <option value="en">EN</option>
        </select>
        <button type="button" id="themeToggle" class="theme-toggle" aria-label="Mavzuni almashtirish">☾</button>
    </div>
    </div>
    <h2 data-i18n="registerTitle">Ro'yxatdan o'tish</h2>

    <!-- Xatoliklar ro'yxati -->
    <?php if (!empty($errors)): ?>
        <div style="color: red; margin-bottom: 10px;">
            <?php foreach ($errors as $error): ?>
                <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="register.php" method="POST">
        <div class="form-group">
            <label for="username" data-i18n="username">Foydalanuvchi nomi:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username ?? '', ENT_QUOTES, 'UTF-8'); ?>" minlength="3" maxlength="50" autocomplete="username" required>
        </div>
        <div class="form-group">
            <label for="phone" data-i18n="phone">Telefon raqami:</label>
            <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone ?? '', ENT_QUOTES, 'UTF-8'); ?>" data-phone maxlength="17" inputmode="tel" placeholder="+998 90 123 45 67" autocomplete="tel" required>
            <small class="field-error" data-phone-error hidden></small>
        </div>
        <div class="form-group">
            <label for="password" data-i18n="password">Parol:</label>
            <input type="password" id="password" name="password" minlength="6" maxlength="72" autocomplete="new-password" required>
        </div>
        <button type="submit" class="btn" data-i18n="register">Ro'yxatdan o'tish</button>
    </form>
    <p><span data-i18n="loginPrompt">Akkauntingiz bormi?</span> <a href="index.php" data-i18n="loginLink">Kirish</a></p>
</div>
<script src="app.js"></script>
</body>
</html>