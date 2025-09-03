<?php
// Simple database connection for debugging
$pdo = null;

try {
    // Only try to connect if environment variables are set
    if (isset($_ENV['MYSQL_PUBLIC_URL'])) {
        $url = parse_url($_ENV['MYSQL_PUBLIC_URL']);
        $host = $url['host'];
        $dbname = ltrim($url['path'], '/');
        $username = $url['user'];
        $password = $url['pass'];
        $port = $url['port'] ?? 3306;
        
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 5
        ]);
    }
} catch (Exception $e) {
    // Silently fail - don't crash the app
    error_log("Database connection failed: " . $e->getMessage());
    $pdo = null;
}
?>