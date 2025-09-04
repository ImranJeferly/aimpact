<?php
require_once 'config/firebase.php';

echo "<h1>Blog Debug Test</h1>";

$blogs = $firebaseHelper->getAllBlogs('published');

echo "<h2>Number of blogs found: " . count($blogs) . "</h2>";

if (!empty($blogs)) {
    echo "<h2>Blog data:</h2>";
    echo "<pre>";
    foreach ($blogs as $blog) {
        echo "Title: " . ($blog['title'] ?? 'NO TITLE') . "\n";
        echo "Status: " . ($blog['status'] ?? 'NO STATUS') . "\n";
        echo "ID: " . ($blog['id'] ?? 'NO ID') . "\n";
        echo "---\n";
    }
    echo "</pre>";
} else {
    echo "<p>No blogs found. Testing fallback data directly...</p>";
    
    require_once 'config/fallback_data.php';
    $fallbackBlogs = FallbackData::getSampleBlogs();
    
    echo "<h2>Fallback data count: " . count($fallbackBlogs) . "</h2>";
    if (!empty($fallbackBlogs)) {
        echo "<pre>";
        foreach ($fallbackBlogs as $blog) {
            echo "Title: " . ($blog['title'] ?? 'NO TITLE') . "\n";
            echo "Status: " . ($blog['status'] ?? 'NO STATUS') . "\n";
            echo "ID: " . ($blog['id'] ?? 'NO ID') . "\n";
            echo "---\n";
        }
        echo "</pre>";
    }
}
?>