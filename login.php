<?php
session_start();
require_once 'db.php';
$errors = [];
$usernameOrPhone = ""; // Foydalanuvchi kiritgan qiymatni saqlash uchun o'zgaruvchi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameOrPhone = trim($_POST['usernameOrPhone'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($usernameOrPhone)) {
        $errors[] = "Parol noto'g'ri";
    }
    if (empty($password)) {
        $errors[] = "Parol kiritilishi kerak.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE (username = ? OR phone = ?)");
        $stmt->bind_param("ss", $usernameOrPhone, $usernameOrPhone);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($userId, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $userId;
                header("Location: dashboard.php");
                exit;
            } else {
                $errors[] = "Parol noto'g'ri.";
            }
        } else {
            $errors[] = "Foydalanuvchi mavjud emas.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirish</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <div class="page-toolbar">
    <a class="back-link" href="register.php">← <span data-i18n="back">Orqaga</span></a>
    <div class="preferences">
        <label for="languageSelect" data-i18n="language">Til</label>
        <select id="languageSelect" aria-label="Tilni tanlang">
            <option value="uz">UZ</option><option value="ru">RU</option><option value="en">EN</option>
        </select>
        <button type="button" id="themeToggle" class="theme-toggle" aria-label="Mavzuni almashtirish">☾</button>
    </div>
    </div>
    <h2 data-i18n="loginTitle">Tizimga kirish</h2>

    <!-- Xatoliklar ro'yxati -->
    <?php if (!empty($errors)): ?>
        <div style="color: red; margin-bottom: 10px;">
            <?php foreach ($errors as $error): ?>
                <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="usernameOrPhone" data-i18n="usernameOrPhone">Foydalanuvchi nomi yoki telefon raqami</label>
            <input type="text" id="usernameOrPhone" name="usernameOrPhone" value="<?php echo isset($_POST['usernameOrPhone']) ? htmlspecialchars($_POST['usernameOrPhone'], ENT_QUOTES, 'UTF-8') : ''; ?>" maxlength="50" autocomplete="username" required>
        </div>
        <div class="form-group">
            <label for="password" data-i18n="password">Parol:</label>
            <input type="password" id="password" name="password" maxlength="72" autocomplete="current-password" required>
        </div>
        <button type="submit" class="btn" data-i18n="login">Kirish</button>
    </form>
    <p><span data-i18n="registerPrompt">Akkauntingiz yo'qmi?</span> <a href="register.php" data-i18n="registerLink">Ro'yxatdan o'tish</a></p>
</div>
    <script src="app.js"></script>
</body>
</html>