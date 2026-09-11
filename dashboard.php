<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userStmt = $conn->prepare('SELECT username FROM users WHERE id = ?');
$userStmt->bind_param('i', $_SESSION['user_id']);
$userStmt->execute();
$user = $userStmt->get_result()->fetch_assoc();
$userStmt->close();

$summary = $conn->query('SELECT COUNT(*) AS product_count, COALESCE(SUM(quantity), 0) AS stock_count, COALESCE(SUM(price * quantity), 0) AS inventory_value FROM products')->fetch_assoc();
$lowStock = $conn->query('SELECT name, quantity, price FROM products WHERE quantity <= 20 ORDER BY quantity ASC, name ASC LIMIT 5');
$latestProducts = $conn->query('SELECT name, quantity, price FROM products ORDER BY id DESC LIMIT 5');
$displayName = $user ? $user['username'] : 'Foydalanuvchi';
?>
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0f766e">
    <title>Dashboard | PharmaFlow</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="app-body">
<div class="app-shell">
    <aside class="sidebar" id="sidebar">
        <div class="brand"><span class="brand-mark">P</span><span><strong>Pharma</strong><small>FLOW</small></span></div>
        <div class="sidebar-label">Boshqaruv</div>
        <nav class="main-nav" aria-label="Asosiy navigatsiya">
            <a class="nav-link active" href="dashboard.php"><span class="nav-icon">⌂</span>Umumiy ko'rinish</a>
            <a class="nav-link" href="view_products.php"><span class="nav-icon">▦</span>Inventar</a>
            <a class="nav-link" href="add_product.php"><span class="nav-icon">＋</span>Mahsulot qo'shish</a>
            <a class="nav-link" href="sell_products.php"><span class="nav-icon">↗</span>Sotuv oynasi</a>
        </nav>
        <div class="sidebar-footer"><div class="sidebar-label">Hisob</div><a class="nav-link" href="logout.php"><span class="nav-icon">↪</span>Chiqish</a></div>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <button class="icon-button nav-toggle" id="navToggle" type="button" aria-label="Menyuni ochish">☰</button>
            <div class="topbar-copy"><span class="eyebrow">Dorixona boshqaruvi</span><h1>Assalomu alaykum, <?php echo htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8'); ?></h1></div>
            <div class="topbar-actions">
                <div class="preferences compact-preferences"><label for="languageSelect">Til</label><select id="languageSelect" aria-label="Tilni tanlang"><option value="uz">UZ</option><option value="ru">RU</option><option value="en">EN</option></select><button type="button" id="themeToggle" class="theme-toggle" aria-label="Qurilma mavzusidan foydalanish">☾</button></div>
                <div class="avatar" title="Profil"><?php echo strtoupper(substr($displayName, 0, 1)); ?></div>
            </div>
        </header>

        <section class="welcome-strip"><div><span class="eyebrow light-eyebrow">Bugungi nazorat</span><h2>Inventaringiz qo'lingizda.</h2><p>Qoldiqni kuzating, yangi mahsulot qo'shing va sotuvni tez yakunlang.</p></div><a class="primary-action" href="sell_products.php"><span>↗</span> Yangi sotuv</a></section>

        <section class="stats-grid" aria-label="Asosiy ko'rsatkichlar">
            <article class="stat-card"><div class="stat-heading"><span class="stat-icon teal">▦</span><span class="trend up">Faol</span></div><strong><?php echo (int) $summary['product_count']; ?></strong><span class="stat-label">Turdagi mahsulotlar</span></article>
            <article class="stat-card"><div class="stat-heading"><span class="stat-icon amber">◫</span><span class="trend neutral">Jami</span></div><strong><?php echo number_format((int) $summary['stock_count'], 0, '.', ' '); ?></strong><span class="stat-label">Ombordagi birliklar</span></article>
            <article class="stat-card"><div class="stat-heading"><span class="stat-icon coral">!</span><span class="trend warning">E'tibor</span></div><strong><?php echo $lowStock->num_rows; ?></strong><span class="stat-label">Kam qolgan mahsulotlar</span></article>
            <article class="stat-card"><div class="stat-heading"><span class="stat-icon blue">₸</span><span class="trend up">Baholangan</span></div><strong><?php echo number_format((int) $summary['inventory_value'], 0, '.', ' '); ?></strong><span class="stat-label">Inventar qiymati, so'm</span></article>
        </section>

        <section class="content-grid">
            <article class="panel inventory-panel"><div class="panel-header"><div><span class="eyebrow">Tezkor nazorat</span><h2>Kam qolgan mahsulotlar</h2></div><a class="text-link" href="view_products.php">Barchasini ko'rish →</a></div>
                <?php if ($lowStock->num_rows > 0): ?><div class="product-list"><?php while ($product = $lowStock->fetch_assoc()): ?><div class="product-row"><span class="product-avatar"><?php echo strtoupper(substr($product['name'], 0, 1)); ?></span><div class="product-info"><strong><?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?></strong><span><?php echo number_format((int) $product['price'], 0, '.', ' '); ?> so'm / birlik</span></div><span class="stock-pill <?php echo (int) $product['quantity'] <= 5 ? 'critical' : ''; ?>"><?php echo (int) $product['quantity']; ?> qoldi</span></div><?php endwhile; ?></div><?php else: ?><div class="empty-state"><span>✓</span><strong>Hammasi joyida</strong><p>Kam qolgan mahsulotlar mavjud emas.</p></div><?php endif; ?>
            </article>
            <article class="panel quick-panel"><div class="panel-header"><div><span class="eyebrow">Ish jarayoni</span><h2>Tezkor amallar</h2></div></div><div class="quick-actions"><a href="add_product.php" class="quick-action"><span class="action-icon teal">＋</span><span><strong>Mahsulot qo'shish</strong><small>Omborni to'ldiring</small></span><span class="arrow">→</span></a><a href="sell_products.php" class="quick-action"><span class="action-icon coral">↗</span><span><strong>Sotuvni boshlash</strong><small>Buyurtmani rasmiylashtiring</small></span><span class="arrow">→</span></a><a href="view_products.php" class="quick-action"><span class="action-icon blue">▦</span><span><strong>Inventarni ko'rish</strong><small>Barcha qoldiqni tekshiring</small></span><span class="arrow">→</span></a></div></article>
        </section>

        <section class="panel recent-panel"><div class="panel-header"><div><span class="eyebrow">Inventar</span><h2>So'nggi qo'shilgan mahsulotlar</h2></div><a class="text-link" href="add_product.php">+ Yangi mahsulot</a></div><div class="table-wrap"><table class="modern-table"><thead><tr><th>Mahsulot nomi</th><th>Holat</th><th>Narx</th><th>Qoldiq</th></tr></thead><tbody><?php while ($product = $latestProducts->fetch_assoc()): ?><tr><td><strong><?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?></strong></td><td><span class="status-dot"><i></i><?php echo (int) $product['quantity'] > 20 ? 'Mavjud' : 'Kam qoldi'; ?></span></td><td><?php echo number_format((int) $product['price'], 0, '.', ' '); ?> so'm</td><td><?php echo (int) $product['quantity']; ?> dona</td></tr><?php endwhile; ?></tbody></table></div></section>
        <footer class="page-footer">PharmaFlow · Dorixona boshqaruvi</footer>
    </main>
</div>
<script src="app.js"></script>
</body>
</html>
