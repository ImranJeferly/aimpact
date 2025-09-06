<?php
/**
 * Environment loader - works with both .env files (localhost) and system env vars (Railway)
 */

// First, ensure $_ENV is populated from system environment (for Railway)
if (function_exists('getenv')) {
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
        $value = getenv($var);
        if ($value !== false && !isset($_ENV[$var])) {
            $_ENV[$var] = $value;
            $_SERVER[$var] = $value;
        }
    }
}

function loadEnv($path) {
    if (!file_exists($path)) {
        return;
    }
    
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        
        // Only set from .env if not already set by system environment
        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

// Load .env file (for localhost development)
loadEnv(__DIR__ . '/../.env');
?>