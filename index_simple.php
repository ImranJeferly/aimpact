<?php
// Simple test to check if PHP is working
echo "<h1>PHP is working!</h1>";
echo "<p>PHP Version: " . PHP_VERSION . "</p>";
echo "<p>Server Time: " . date('Y-m-d H:i:s') . "</p>";

// Test database connection
try {
    require_once 'config/database.php';
    if ($pdo) {
        echo "<p>✅ Database: Connected successfully!</p>";
        $count = $pdo->query("SELECT COUNT(*) FROM blogs")->fetchColumn();
        echo "<p>📊 Found $count blogs</p>";
    } else {
        echo "<p>❌ Database: Connection failed</p>";
    }
} catch (Exception $e) {
    echo "<p>❌ Database Error: " . $e->getMessage() . "</p>";
}
?>