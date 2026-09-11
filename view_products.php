<?php
session_start();
require_once 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$result = $conn->query("SELECT name, price, quantity FROM products ORDER BY name");
?>

<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dorilar Ro'yxati</title>
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
    <h2 data-i18n="productsTitle">Dorilar ro'yxati</h2>
    <table>
        <tr>
            <th data-i18n="productHeader">Dori nomi</th>
            <th data-i18n="priceHeader">Narxi (so'm)</th>
            <th data-i18n="quantityHeader">Miqdori</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo number_format((int) $row['price'], 0, '.', ' '); ?></td>
                <td><?php echo $row['quantity']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
<script src="app.js"></script>
</body>
</html>
<?php $conn->close(); ?>