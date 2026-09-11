<?php
require_once 'db.php';

if (isset($_GET['query'])) {
    $query = trim($_GET['query']);
    $stmt = $conn->prepare("SELECT id, name, price, quantity FROM products WHERE name LIKE CONCAT('%', ?, '%') ORDER BY name");
    $stmt->bind_param('s', $query);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='product-item'>";
            echo '<span>' . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . ' (' . (int) $row['quantity'] . " ta mavjud) - Narxi: " . number_format((int) $row['price'], 0, '.', ' ') . " so'm</span>";
            echo "<input type='number' name='products[" . (int) $row['id'] . "]' placeholder='Soni' min='0' max='" . (int) $row['quantity'] . "'>";
            echo "</div>";
        }
    } else {
        echo "<p>Bunday dori mavjud emas.</p>";
    }
}
?>
