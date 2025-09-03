<?php
// Debug environment variables
require_once 'config/env.php';

echo "<h2>Database Environment Variables Debug</h2>";
echo "<pre>";

echo "=== Railway Environment Variables ===\n";
echo "MYSQL_PUBLIC_URL: " . ($_ENV['MYSQL_PUBLIC_URL'] ?? 'NOT SET') . "\n";
echo "MYSQL_URL: " . ($_ENV['MYSQL_URL'] ?? 'NOT SET') . "\n";
echo "MYSQLHOST: " . ($_ENV['MYSQLHOST'] ?? 'NOT SET') . "\n";
echo "MYSQLDATABASE: " . ($_ENV['MYSQLDATABASE'] ?? 'NOT SET') . "\n";
echo "MYSQL_DATABASE: " . ($_ENV['MYSQL_DATABASE'] ?? 'NOT SET') . "\n";
echo "MYSQLUSER: " . ($_ENV['MYSQLUSER'] ?? 'NOT SET') . "\n";
echo "MYSQLPASSWORD: " . (isset($_ENV['MYSQLPASSWORD']) ? '[SET]' : 'NOT SET') . "\n";
echo "MYSQL_ROOT_PASSWORD: " . (isset($_ENV['MYSQL_ROOT_PASSWORD']) ? '[SET]' : 'NOT SET') . "\n";

echo "\n=== Local Development Variables ===\n";
echo "DB_HOST: " . ($_ENV['DB_HOST'] ?? 'NOT SET') . "\n";
echo "DB_NAME: " . ($_ENV['DB_NAME'] ?? 'NOT SET') . "\n";
echo "DB_USER: " . ($_ENV['DB_USER'] ?? 'NOT SET') . "\n";
echo "DB_PASSWORD: " . (isset($_ENV['DB_PASSWORD']) ? '[SET]' : 'NOT SET') . "\n";

echo "\n=== Connection Decision ===\n";
if (isset($_ENV['MYSQL_PUBLIC_URL'])) {
    echo "✅ Using MYSQL_PUBLIC_URL (Railway Public Connection)\n";
    $url = parse_url($_ENV['MYSQL_PUBLIC_URL']);
    echo "Host: " . $url['host'] . "\n";
    echo "Port: " . ($url['port'] ?? 3306) . "\n";
    echo "Database: " . ltrim($url['path'], '/') . "\n";
} elseif (isset($_ENV['MYSQL_URL'])) {
    echo "⚠️ Using MYSQL_URL (Railway Private Connection)\n";
    $url = parse_url($_ENV['MYSQL_URL']);
    echo "Host: " . $url['host'] . "\n";
} elseif (isset($_ENV['MYSQLHOST'])) {
    echo "📋 Using Railway Individual Variables\n";
    echo "Host: " . $_ENV['MYSQLHOST'] . "\n";
} else {
    echo "🏠 Using Local Development Variables\n";
    echo "Host: " . ($_ENV['DB_HOST'] ?? 'localhost') . "\n";
}

echo "\n=== Testing Database Connection ===\n";
try {
    include 'config/database.php';
    if ($pdo) {
        echo "✅ Database connection successful!\n";
        $result = $pdo->query("SELECT COUNT(*) as count FROM blogs")->fetch();
        echo "Found " . $result['count'] . " blogs in database\n";
    } else {
        echo "❌ Database connection failed\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "</pre>";
?>