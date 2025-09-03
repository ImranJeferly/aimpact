<?php
/**
 * Website Performance Diagnostic Tool
 */

$startTime = microtime(true);

echo "<h2>Website Performance Diagnostic</h2>";
echo "<pre>";

echo "=== Performance Analysis ===\n";

// Test 1: Database Connection Time
echo "1. Testing Database Connection Speed...\n";
$dbStart = microtime(true);

try {
    require_once 'config/env.php';
    
    if (!isset($_ENV['MYSQL_PUBLIC_URL'])) {
        echo "❌ MYSQL_PUBLIC_URL not set - using fallback\n";
    }
    
    include 'config/database.php';
    
    if ($pdo) {
        $dbTime = round((microtime(true) - $dbStart) * 1000, 2);
        echo "✅ Database connected in: {$dbTime}ms\n";
        
        // Test query performance
        $queryStart = microtime(true);
        $result = $pdo->query("SELECT COUNT(*) as count FROM blogs")->fetch();
        $queryTime = round((microtime(true) - $queryStart) * 1000, 2);
        echo "✅ Simple query executed in: {$queryTime}ms\n";
        echo "📊 Found {$result['count']} blogs\n";
        
    } else {
        echo "❌ Database connection failed\n";
    }
} catch (Exception $e) {
    $dbTime = round((microtime(true) - $dbStart) * 1000, 2);
    echo "❌ Database error ({$dbTime}ms): " . $e->getMessage() . "\n";
}

// Test 2: Check for problematic queries
echo "\n2. Checking for Performance Issues...\n";

if ($pdo) {
    // Test complex blog query
    $complexStart = microtime(true);
    try {
        $stmt = $pdo->prepare("SELECT * FROM blogs WHERE status = 'published' ORDER BY created_at DESC LIMIT 10");
        $stmt->execute();
        $blogs = $stmt->fetchAll();
        $complexTime = round((microtime(true) - $complexStart) * 1000, 2);
        echo "✅ Blog listing query: {$complexTime}ms\n";
    } catch (Exception $e) {
        echo "❌ Blog query failed: " . $e->getMessage() . "\n";
    }
    
    // Check if indexes exist
    try {
        $indexes = $pdo->query("SHOW INDEX FROM blogs")->fetchAll();
        echo "📋 Blog table indexes: " . count($indexes) . " found\n";
        foreach ($indexes as $index) {
            echo "   - {$index['Key_name']} on {$index['Column_name']}\n";
        }
    } catch (Exception $e) {
        echo "⚠️ Could not check indexes: " . $e->getMessage() . "\n";
    }
}

// Test 3: Check file system performance
echo "\n3. Testing File System Performance...\n";
$fileStart = microtime(true);
$testFile = 'performance_test.tmp';
file_put_contents($testFile, 'test');
$content = file_get_contents($testFile);
unlink($testFile);
$fileTime = round((microtime(true) - $fileStart) * 1000, 2);
echo "✅ File I/O test: {$fileTime}ms\n";

// Test 4: Check for large files
echo "\n4. Checking Asset Sizes...\n";
$largeFiles = [];
$totalSize = 0;

$directories = ['assets', 'uploads', 'js'];
foreach ($directories as $dir) {
    if (is_dir($dir)) {
        $files = glob($dir . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                $size = filesize($file);
                $totalSize += $size;
                if ($size > 1024 * 1024) { // > 1MB
                    $largeFiles[] = $file . ' (' . round($size / 1024 / 1024, 2) . 'MB)';
                }
            }
        }
    }
}

echo "📁 Total asset size: " . round($totalSize / 1024 / 1024, 2) . "MB\n";
if (!empty($largeFiles)) {
    echo "⚠️  Large files found:\n";
    foreach ($largeFiles as $file) {
        echo "   - $file\n";
    }
} else {
    echo "✅ No unusually large files found\n";
}

// Test 5: Memory usage
echo "\n5. Memory Usage...\n";
$memoryUsed = memory_get_usage(true) / 1024 / 1024;
$memoryPeak = memory_get_peak_usage(true) / 1024 / 1024;
echo "📊 Current memory: " . round($memoryUsed, 2) . "MB\n";
echo "📊 Peak memory: " . round($memoryPeak, 2) . "MB\n";

$totalTime = round((microtime(true) - $startTime) * 1000, 2);
echo "\n⏱️  Total diagnostic time: {$totalTime}ms\n";

echo "\n=== Recommendations ===\n";
if ($dbTime > 1000) {
    echo "⚠️  Database connection is slow (>{$dbTime}ms) - check Railway MySQL location\n";
}
if ($complexTime > 500) {
    echo "⚠️  Database queries are slow - consider adding indexes\n";
}
if (!empty($largeFiles)) {
    echo "⚠️  Large files detected - consider compression or CDN\n";
}
if ($memoryPeak > 64) {
    echo "⚠️  High memory usage - optimize code or increase limits\n";
}

echo "</pre>";
?>