<?php
require_once 'config/firebase_rest.php';

echo "<!DOCTYPE html><html><head><title>Firebase REST API Test</title></head><body>";
echo "<h1>Firebase REST API Connection Test</h1>";

if ($firebaseRestHelper && $firebaseRestHelper->isConnected()) {
    echo "<p style='color: green;'>✅ Firebase REST client initialized successfully!</p>";
    
    // Test connection
    echo "<h2>Testing Connection</h2>";
    $connectionTest = $firebaseRestHelper->testConnection();
    if ($connectionTest) {
        echo "<p style='color: green;'>✅ Firebase connection successful!</p>";
    } else {
        echo "<p style='color: red;'>❌ Firebase connection failed - but this might be due to security rules</p>";
        echo "<p style='color: blue;'>ℹ️ This is normal if Firestore database hasn't been set up yet.</p>";
    }
    
    // Test reading existing data (if any)
    echo "<h2>Testing Data Retrieval</h2>";
    
    echo "<h3>Blogs Collection:</h3>";
    $blogs = $firebaseRestHelper->getAllBlogs();
    echo "<p>Found " . count($blogs) . " blogs</p>";
    if (!empty($blogs)) {
        echo "<ul>";
        foreach ($blogs as $blog) {
            echo "<li><strong>" . htmlspecialchars($blog['title'] ?? 'No Title') . "</strong></li>";
        }
        echo "</ul>";
    } else {
        echo "<p style='color: blue;'>ℹ️ No blogs found in Firestore. This is expected if you haven't added any data yet.</p>";
    }
    
    echo "<h3>Testimonials Collection:</h3>";
    $testimonials = $firebaseRestHelper->getAllTestimonials();
    echo "<p>Found " . count($testimonials) . " testimonials</p>";
    if (!empty($testimonials)) {
        echo "<ul>";
        foreach ($testimonials as $testimonial) {
            echo "<li><strong>" . htmlspecialchars($testimonial['client_name'] ?? 'No Name') . "</strong></li>";
        }
        echo "</ul>";
    } else {
        echo "<p style='color: blue;'>ℹ️ No testimonials found in Firestore. This is expected if you haven't added any data yet.</p>";
    }
    
    // Test writing data (optional)
    echo "<h2>Testing Data Writing</h2>";
    echo "<p style='color: blue;'>ℹ️ Skipping write test to avoid adding test data. Enable this in production setup.</p>";
    
    /*
    // Uncomment to test writing (only do this once you've set up Firestore rules)
    $testBlog = [
        'title' => 'Test Blog Post via REST API',
        'slug' => 'test-blog-post-rest',
        'content' => 'This is a test blog post created via Firebase REST API.',
        'status' => 'published',
        'author' => 'API Test'
    ];
    
    $blogId = $firebaseRestHelper->addBlog($testBlog);
    if ($blogId) {
        echo "<p style='color: green;'>✅ Successfully created test blog with ID: $blogId</p>";
        
        // Clean up - delete the test blog
        if ($firebaseRestHelper->deleteBlog($blogId)) {
            echo "<p style='color: green;'>✅ Successfully cleaned up test blog</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Failed to create test blog</p>";
    }
    */
    
} else {
    echo "<p style='color: red;'>❌ Firebase REST client initialization failed!</p>";
    echo "<p>Please check your .env file configuration:</p>";
    echo "<ul>";
    echo "<li>FIREBASE_PROJECT_ID should be set to: aimpact-22bcb</li>";
    echo "</ul>";
}

echo "<h2>Next Steps</h2>";
echo "<div style='background: #e3f2fd; padding: 15px; border-radius: 5px;'>";
echo "<h3>To Complete Firebase Setup:</h3>";
echo "<ol>";
echo "<li><strong>Go to Firebase Console:</strong> <a href='https://console.firebase.google.com/project/aimpact-22bcb' target='_blank'>https://console.firebase.google.com/project/aimpact-22bcb</a></li>";
echo "<li><strong>Create Firestore Database:</strong> Go to Firestore Database → Create database → Start in test mode</li>";
echo "<li><strong>Apply Security Rules:</strong> Use the rules from firestore-rules.txt</li>";
echo "<li><strong>Add Initial Data:</strong> Use your admin system to add blogs and testimonials</li>";
echo "</ol>";
echo "</div>";

echo "<p><a href='index.php'>← Back to Website</a> | <a href='website_status.php'>Website Status</a></p>";
echo "</body></html>";
?>