<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$totalPrice = 0;
$errorMessage = '';
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedProducts = $_POST['products'] ?? [];
    $items = [];

    foreach ($selectedProducts as $productId => $requestedQuantity) {
        $quantity = filter_var($requestedQuantity, FILTER_VALIDATE_INT);
        if ($quantity === false || $quantity <= 0) {
            continue;
        }
        $items[(int) $productId] = $quantity;
    }

    if (!$items) {
        $errorMessage = 'Sotish uchun kamida bitta mahsulot miqdorini kiriting.';
    } else {
        $conn->begin_transaction();
        try {
            $selectStmt = $conn->prepare('SELECT name, price, quantity FROM products WHERE id = ? FOR UPDATE');
            $updateStmt = $conn->prepare('UPDATE products SET quantity = quantity - ? WHERE id = ?');

            foreach ($items as $productId => $quantity) {
                $selectStmt->bind_param('i', $productId);
                $selectStmt->execute();
                $product = $selectStmt->get_result()->fetch_assoc();

                if (!$product || $quantity > (int) $product['quantity']) {
                    $productName = $product ? $product['name'] : 'Tanlangan mahsulot';
                    throw new RuntimeException($productName . ' uchun yetarli qoldiq mavjud emas.');
                }

                $totalPrice += (int) $product['price'] * $quantity;
                $updateStmt->bind_param('ii', $quantity, $productId);
                $updateStmt->execute();
            }

            $conn->commit();
            $successMessage = 'Sotuv muvaffaqiyatli yakunlandi. Jami: ' . number_format($totalPrice, 0, '.', ' ') . " so'm";
            $selectStmt->close();
            $updateStmt->close();
        } catch (Throwable $exception) {
            $conn->rollback();
            $errorMessage = $exception->getMessage();
        }
    }
}

$productsResult = $conn->query('SELECT id, name, price, quantity FROM products ORDER BY name');
?>

<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dori Sotish</title>
    <link rel="stylesheet" href="styles.css">
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
        <h2 data-i18n="sellTitle">Dori sotish</h2>
        <?php if ($errorMessage): ?><p class="error"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></p><?php endif; ?>
        <?php if ($successMessage): ?><p class="total"><?php echo htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8'); ?></p><?php endif; ?>
        <form method="POST">
            <?php while ($row = $productsResult->fetch_assoc()): ?>
                <div class="product">
                    <label for="product-<?php echo (int) $row['id']; ?>"><?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?> (<?php echo (int) $row['quantity']; ?> ta mavjud) - Narxi: <?php echo number_format((int) $row['price'], 0, '.', ' '); ?> so'm</label>
                    <input id="product-<?php echo (int) $row['id']; ?>" type="number" name="products[<?php echo (int) $row['id']; ?>]" placeholder="Soni" min="0" max="<?php echo (int) $row['quantity']; ?>">
                </div>
            <?php endwhile; ?>
            <button type="submit" class="btn" data-i18n="sellButton">Sotish</button>
        </form>
    </div>
</body>
<script src="app.js"></script>
</html>