<?php
session_start();
require_once 'db.php';

// Foydalanuvchi tizimga kirmagan bo'lsa, login sahifasiga yo'naltirish
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$errors = [];
$successMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = trim($_POST['productName'] ?? '');
    $price = filter_var($_POST['price'] ?? null, FILTER_VALIDATE_INT);
    $quantity = filter_var($_POST['quantity'] ?? null, FILTER_VALIDATE_INT);

    // Maydonlarni tekshirish
    if (empty($productName)) {
        $errors[] = "Dori nomi kiritilishi kerak.";
    }
    if ($price === false || $price <= 0) {
        $errors[] = "Narxi kiritilishi kerak va raqam bo'lishi kerak.";
    } elseif ($price > 1000000000) {
        $errors[] = "Narx 1 000 000 000 so'mdan oshmasligi kerak.";
    }
    if ($quantity === false || $quantity <= 0) {
        $errors[] = "Miqdori kiritilishi kerak va raqam bo'lishi kerak.";
    } elseif ($quantity > 1000000) {
        $errors[] = "Miqdor 1 000 000 donadan oshmasligi kerak.";
    }

    // Xatoliklar bo'lmasa, dori bazada bormi deb tekshirish
    if (empty($errors)) {
        // Dori nomi bazada mavjudligini tekshirish
        $stmt = $conn->prepare("SELECT id, quantity FROM products WHERE name = ?");
        $stmt->bind_param("s", $productName);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($productId, $existingQuantity);
        $stmt->fetch();

        // Agar dori bazada mavjud bo'lsa, miqdorini yangilaymiz
        if ($stmt->num_rows > 0) {
            // Yangi miqdorni eski miqdor bilan qo'shamiz
            $newQuantity = $existingQuantity + (int) $quantity;

            // Miqdorni yangilash
            $updateStmt = $conn->prepare("UPDATE products SET quantity = ? WHERE id = ?");
            $updateStmt->bind_param("ii", $newQuantity, $productId);

            if ($updateStmt->execute()) {
                $successMessage = "Miqdor muvaffaqiyatli yangilandi!";
            } else {
                $errors[] = "Miqdor yangilanishda xatolik yuz berdi.";
            }

            $updateStmt->close();
        } else {
            // Agar dori bazada mavjud bo'lmasa, yangi dori qo'shish
            $insertStmt = $conn->prepare("INSERT INTO products (name, price, quantity) VALUES (?, ?, ?)");
            $insertStmt->bind_param("sii", $productName, $price, $quantity);

            if ($insertStmt->execute()) {
                $successMessage = "Dori muvaffaqiyatli qo'shildi!";
            } else {
                $errors[] = "Ma'lumotlarni saqlashda xatolik yuz berdi.";
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
    <title>Dori Qo'shish</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .error {
            color: red;
            margin-bottom: 10px;
        }
        .success {
            color: green;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="page-toolbar">
    <a class="back-link" href="dashboard.php">← <span data-i18n="back">Orqaga</span></a>
    <div class="preferences">
        <label for="languageSelect" data-i18n="language">Til</label>
        <select id="languageSelect" aria-label="Tilni tanlang"><option value="uz">UZ</option><option value="ru">RU</option><option value="en">EN</option></select>
        <button type="button" id="themeToggle" class="theme-toggle" aria-label="Mavzuni almashtirish">☾</button>
    </div>
    </div>
    <h2 data-i18n="addTitle">Dori qo'shish</h2>

    <!-- Xatoliklar ro'yxati -->
    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $error): ?>
                <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Muvaffaqiyatli xabar -->
    <?php if (!empty($successMessage)): ?>
        <div class="success">
            <p><?php echo htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
    <?php endif; ?>

    <form action="add_product.php" method="POST">
        <div class="form-group">
            <label for="productName" data-i18n="name">Dori nomi</label>
            <input type="text" id="productName" name="productName" value="<?php echo isset($_POST['productName']) ? htmlspecialchars($_POST['productName']) : ''; ?>" required>
            </div>
        <div class="form-group">
            <label for="price" data-i18n="priceLabel">Narxi (so'm)</label>
            <input type="number" id="price" name="price" value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price'], ENT_QUOTES, 'UTF-8') : ''; ?>" min="1" max="1000000000" step="1" inputmode="numeric" required>
        </div>
        <div class="form-group">
            <label for="quantity" data-i18n="quantityLabel">Miqdori</label>
            <input type="number" id="quantity" name="quantity" value="<?php echo isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity'], ENT_QUOTES, 'UTF-8') : ''; ?>" min="1" max="1000000" step="1" inputmode="numeric" required>
        </div>
        <button type="submit" class="btn" data-i18n="addButton">Qo'shish</button>
    </form>
</div>
<script src="app.js"></script>
</body>
</html>