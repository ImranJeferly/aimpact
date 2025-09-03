<?php
/**
 * Railway Health Check Endpoint
 */

header('Content-Type: application/json');
header('Cache-Control: no-cache');

$startTime = microtime(true);
$health = [
    'status' => 'ok',
    'timestamp' => date('Y-m-d H:i:s'),
    'checks' => []
];

try {
    // Check database connection
    $dbStart = microtime(true);
    require_once 'config/database.php';
    
    if ($pdo) {
        $health['checks']['database'] = [
            'status' => 'healthy',
            'response_time_ms' => round((microtime(true) - $dbStart) * 1000, 2)
        ];
        
        // Test query
        $count = $pdo->query("SELECT COUNT(*) FROM blogs")->fetchColumn();
        $health['checks']['database']['blog_count'] = (int)$count;
    } else {
        $health['checks']['database'] = [
            'status' => 'unhealthy',
            'error' => 'Connection failed'
        ];
        $health['status'] = 'degraded';
    }
} catch (Exception $e) {
    $health['checks']['database'] = [
        'status' => 'unhealthy',
        'error' => $e->getMessage()
    ];
    $health['status'] = 'degraded';
}

// Check file system
try {
    $testFile = 'health_test.tmp';
    file_put_contents($testFile, 'test');
    if (file_get_contents($testFile) === 'test') {
        $health['checks']['filesystem'] = ['status' => 'healthy'];
        unlink($testFile);
    } else {
        $health['checks']['filesystem'] = ['status' => 'unhealthy'];
        $health['status'] = 'degraded';
    }
} catch (Exception $e) {
    $health['checks']['filesystem'] = [
        'status' => 'unhealthy',
        'error' => $e->getMessage()
    ];
    $health['status'] = 'degraded';
}

// Add server info
$health['server'] = [
    'php_version' => PHP_VERSION,
    'memory_usage' => round(memory_get_usage(true) / 1024 / 1024, 2) . 'MB',
    'memory_peak' => round(memory_get_peak_usage(true) / 1024 / 1024, 2) . 'MB'
];

$health['response_time_ms'] = round((microtime(true) - $startTime) * 1000, 2);

// Set appropriate HTTP status code
http_response_code($health['status'] === 'ok' ? 200 : 503);

echo json_encode($health, JSON_PRETTY_PRINT);
?>