<?php
// URL Helper for both localhost and Railway deployment compatibility

function getBaseUrl() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    
    // Handle Railway deployment URLs
    if (strpos($host, 'railway.app') !== false || strpos($host, 'up.railway.app') !== false) {
        return $protocol . '://' . $host;
    }
    
    // Handle localhost
    if ($host === 'localhost' || strpos($host, 'localhost:') === 0) {
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        return $protocol . '://' . $host . ($scriptName !== '/' ? $scriptName : '');
    }
    
    // Default handling
    return $protocol . '://' . $host . dirname($_SERVER['SCRIPT_NAME']);
}

function url($path = '') {
    $baseUrl = getBaseUrl();
    
    // Remove leading slash if present
    $path = ltrim($path, '/');
    
    // For Railway, we might need to preserve .php extensions in some cases
    // But our .htaccess should handle this
    
    return $baseUrl . '/' . $path;
}

function redirect($path) {
    header('Location: ' . url($path));
    exit();
}

function isRailway() {
    return strpos($_SERVER['HTTP_HOST'], 'railway.app') !== false || 
           strpos($_SERVER['HTTP_HOST'], 'up.railway.app') !== false;
}

function isLocalhost() {
    return $_SERVER['HTTP_HOST'] === 'localhost' || 
           strpos($_SERVER['HTTP_HOST'], 'localhost:') === 0 ||
           $_SERVER['HTTP_HOST'] === '127.0.0.1' ||
           strpos($_SERVER['HTTP_HOST'], '127.0.0.1:') === 0;
}

// Asset URL helper for images, CSS, JS
function asset($path) {
    return url($path);
}

// Blog URL helper
function blogUrl($id) {
    return url("blog?id=" . urlencode($id));
}

// Navigation URL helper
function navUrl($page) {
    $cleanPages = [
        'home' => '',
        'index' => '',
        'blogs' => 'blogs',
        'contact' => 'contact',
        'thank_you' => 'thank_you',
        'search_blogs' => 'search_blogs'
    ];
    
    return url($cleanPages[$page] ?? $page);
}
?>