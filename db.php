<?php
$conn = new mysqli('localhost', 'root', '', 'pharmacy');

if ($conn->connect_error) {
    die('Ma\'lumotlar bazasiga ulanish amalga oshmadi.');
}

$conn->set_charset('utf8mb4');
?>