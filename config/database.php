<?php
$host = $_ENV['DB_HOST'] ?? 'localhost';
$dbname = $_ENV['DB_NAME'] ?? 'aimpact';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASSWORD'] ?? '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Update blogs table structure to use author instead of author_id
    $pdo->exec("ALTER TABLE blogs 
    DROP FOREIGN KEY IF EXISTS blogs_ibfk_1,
    DROP COLUMN IF EXISTS author_id,
    ADD COLUMN IF NOT EXISTS author VARCHAR(100) AFTER content");
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
