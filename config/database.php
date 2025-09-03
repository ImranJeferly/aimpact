<?php
// Load environment variables
require_once __DIR__ . '/env.php';

// Priority order for Railway connections:
// 1. MYSQL_PUBLIC_URL (best for external connections)
// 2. MYSQL_URL (internal Railway connections) 
// 3. Individual Railway variables
// 4. Local development variables

if (isset($_ENV['MYSQL_PUBLIC_URL'])) {
    // Railway Public MySQL URL (preferred for external connections)
    $url = parse_url($_ENV['MYSQL_PUBLIC_URL']);
    $host = $url['host'];
    $dbname = ltrim($url['path'], '/');
    $username = $url['user'];
    $password = $url['pass'];
    $port = $url['port'] ?? 3306;
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
} elseif (isset($_ENV['MYSQL_URL'])) {
    // Railway Private MySQL URL
    $url = parse_url($_ENV['MYSQL_URL']);
    $host = $url['host'];
    $dbname = ltrim($url['path'], '/');
    $username = $url['user'];
    $password = $url['pass'];
    $port = $url['port'] ?? 3306;
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
} elseif (isset($_ENV['MYSQLHOST'])) {
    // Railway individual variables
    $host = $_ENV['MYSQLHOST'];
    $dbname = $_ENV['MYSQLDATABASE'] ?? $_ENV['MYSQL_DATABASE'] ?? 'railway';
    $username = $_ENV['MYSQLUSER'] ?? 'root';
    $password = $_ENV['MYSQLPASSWORD'] ?? $_ENV['MYSQL_ROOT_PASSWORD'] ?? '';
    $port = $_ENV['MYSQLPORT'] ?? 3306;
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
} else {
    // Local development fallback
    $host = $_ENV['DB_HOST'] ?? 'localhost';
    $dbname = $_ENV['DB_NAME'] ?? 'aimpact';
    $username = $_ENV['DB_USER'] ?? 'root';
    $password = $_ENV['DB_PASSWORD'] ?? '';
    $port = 3306;
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
}

try {
    // Add connection timeout and performance options
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_PERSISTENT => true,  // Use persistent connections
        PDO::ATTR_TIMEOUT => 5,       // Reduce timeout
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
        PDO::MYSQL_ATTR_COMPRESS => true,  // Enable compression
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
    ];
    
    $pdo = new PDO($dsn, $username, $password, $options);
} catch(PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    // Set $pdo to null so other files can handle the error gracefully
    $pdo = null;
}
