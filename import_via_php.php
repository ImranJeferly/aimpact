<?php
/**
 * Alternative database import using PHP and PDO
 * This bypasses the MySQL client authentication issues
 */

echo "<h2>Import Database via PHP</h2>";
echo "<pre>";

// Load environment variables
require_once 'config/env.php';

if (!isset($_ENV['MYSQL_PUBLIC_URL'])) {
    echo "❌ MYSQL_PUBLIC_URL not set in environment variables\n";
    exit;
}

echo "🔄 Connecting to Railway MySQL...\n";

try {
    // Parse Railway MySQL URL
    $url = parse_url($_ENV['MYSQL_PUBLIC_URL']);
    $host = $url['host'];
    $dbname = ltrim($url['path'], '/');
    $username = $url['user'];
    $password = $url['pass'];
    $port = $url['port'] ?? 3306;
    
    echo "Host: $host:$port\n";
    echo "Database: $dbname\n";
    
    // Connect using PDO
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Connected successfully!\n\n";
    
    // Read SQL file
    if (!file_exists('aimpact.sql')) {
        echo "❌ aimpact.sql file not found\n";
        exit;
    }
    
    $sql = file_get_contents('aimpact.sql');
    
    // Remove SQL comments but preserve the content
    $lines = explode("\n", $sql);
    $cleanLines = [];
    
    foreach ($lines as $line) {
        $line = trim($line);
        // Skip empty lines and comment lines
        if (empty($line) || strpos($line, '--') === 0 || strpos($line, '/*') === 0) {
            continue;
        }
        // Remove inline comments but preserve content
        if (strpos($line, '--') !== false) {
            $line = trim(substr($line, 0, strpos($line, '--')));
        }
        if (!empty($line)) {
            $cleanLines[] = $line;
        }
    }
    
    $cleanSql = implode("\n", $cleanLines);
    
    // Split into statements more carefully
    $statements = [];
    $currentStatement = '';
    $inString = false;
    $stringChar = '';
    
    for ($i = 0; $i < strlen($cleanSql); $i++) {
        $char = $cleanSql[$i];
        
        if (!$inString && ($char === '"' || $char === "'")) {
            $inString = true;
            $stringChar = $char;
        } elseif ($inString && $char === $stringChar) {
            // Check if it's escaped
            if ($i > 0 && $cleanSql[$i-1] !== '\\') {
                $inString = false;
                $stringChar = '';
            }
        }
        
        if ($char === ';' && !$inString) {
            $statement = trim($currentStatement);
            if (!empty($statement)) {
                $statements[] = $statement;
            }
            $currentStatement = '';
        } else {
            $currentStatement .= $char;
        }
    }
    
    // Add final statement if exists
    $statement = trim($currentStatement);
    if (!empty($statement)) {
        $statements[] = $statement;
    }
    
    echo "🔄 Executing " . count($statements) . " SQL statements...\n\n";
    
    $success = 0;
    $errors = 0;
    
    foreach ($statements as $statement) {
        if (empty($statement)) continue;
        
        try {
            $pdo->exec($statement);
            $success++;
            
            // Show progress for major operations
            if (strpos(strtoupper($statement), 'CREATE TABLE') === 0) {
                preg_match('/CREATE TABLE\s+`?(\w+)`?/i', $statement, $matches);
                $table = $matches[1] ?? 'unknown';
                echo "✅ Created table: $table\n";
            } elseif (strpos(strtoupper($statement), 'INSERT INTO') === 0) {
                preg_match('/INSERT INTO\s+`?(\w+)`?/i', $statement, $matches);
                $table = $matches[1] ?? 'unknown';
                echo "📝 Inserted data into: $table\n";
            }
        } catch (PDOException $e) {
            $errors++;
            echo "❌ Error: " . $e->getMessage() . "\n";
            echo "Statement: " . substr($statement, 0, 100) . "...\n";
        }
    }
    
    echo "\n🎉 Import completed!\n";
    echo "✅ Successful: $success statements\n";
    echo "❌ Errors: $errors statements\n";
    
    // Test the import
    echo "\n🔍 Testing import...\n";
    $result = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "Found tables: " . implode(', ', $result) . "\n";
    
    $blogCount = $pdo->query("SELECT COUNT(*) FROM blogs")->fetchColumn();
    echo "Blogs imported: $blogCount\n";
    
    $adminCount = $pdo->query("SELECT COUNT(*) FROM admins")->fetchColumn();
    echo "Admins imported: $adminCount\n";
    
} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage() . "\n";
}

echo "</pre>";
?>