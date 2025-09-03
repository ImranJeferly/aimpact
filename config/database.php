<?php
// Load environment variables
require_once __DIR__ . '/env.php';

// Check if Railway MYSQL_PUBLIC_URL is available (preferred method for external connections)
if (isset($_ENV['MYSQL_PUBLIC_URL'])) {
    // Parse Railway MySQL Public URL: mysql://user:password@host:port/database
    $url = parse_url($_ENV['MYSQL_PUBLIC_URL']);
    $host = $url['host'];
    $dbname = ltrim($url['path'], '/');
    $username = $url['user'];
    $password = $url['pass'];
    $port = $url['port'] ?? 3306;
    
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
} else {
    // Fallback to individual environment variables (local development)
    $host = $_ENV['DB_HOST'] ?? 'localhost';
    $dbname = $_ENV['DB_NAME'] ?? 'aimpact';
    $username = $_ENV['DB_USER'] ?? 'root';
    $password = $_ENV['DB_PASSWORD'] ?? '';
    
    $dsn = "mysql:host=$host;dbname=$dbname";
}

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Update blogs table structure to use author instead of author_id
    $pdo->exec("ALTER TABLE blogs 
    DROP FOREIGN KEY IF EXISTS blogs_ibfk_1,
    DROP COLUMN IF EXISTS author_id,
    ADD COLUMN IF NOT EXISTS author VARCHAR(100) AFTER content");
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    // Set $pdo to null so other files can handle the error gracefully
    $pdo = null;
}
