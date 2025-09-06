<?php
echo "<h2>Railway Environment Debug</h2>";

echo "<h3>System Environment Check:</h3>";
echo "<pre>";
echo "getenv() function available: " . (function_exists('getenv') ? 'YES' : 'NO') . "\n";
echo "Environment type: " . (isset($_ENV['RAILWAY_ENVIRONMENT']) ? 'RAILWAY' : 'LOCALHOST') . "\n";
echo "</pre>";

echo "<h3>Direct getenv() calls:</h3>";
echo "<pre>";
$firebaseVars = [
    'FIREBASE_API_KEY',
    'FIREBASE_AUTH_DOMAIN', 
    'FIREBASE_DATABASE_URL',
    'FIREBASE_PROJECT_ID',
    'FIREBASE_STORAGE_BUCKET',
    'FIREBASE_MESSAGING_SENDER_ID',
    'FIREBASE_APP_ID',
    'FIREBASE_MEASUREMENT_ID'
];

foreach ($firebaseVars as $var) {
    $getenvValue = getenv($var);
    echo "$var (getenv): " . ($getenvValue !== false ? $getenvValue : 'NOT SET') . "\n";
}
echo "</pre>";

// Load environment
require_once '../config/env.php';

echo "<h3>After loading env.php:</h3>";
echo "<pre>";
foreach ($firebaseVars as $var) {
    echo "$var (\$_ENV): " . ($_ENV[$var] ?? 'NOT SET') . "\n";
}
echo "</pre>";

echo "<h3>Railway-specific variables:</h3>";
echo "<pre>";
$railwayVars = ['RAILWAY_ENVIRONMENT', 'PORT', 'NODE_ENV'];
foreach ($railwayVars as $var) {
    echo "$var: " . (getenv($var) ?: $_ENV[$var] ?? 'NOT SET') . "\n";
}
echo "</pre>";
?>