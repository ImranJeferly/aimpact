<?php
require_once 'config/firebase_rest.php';
require_once 'config/fallback_data.php';

echo "<!DOCTYPE html><html><head><title>Firebase Data Migration</title>";
echo "<style>body{font-family:Arial;margin:40px;background:#f5f5f5;} .container{background:white;padding:30px;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,0.1);} .success{color:#28a745;background:#d4edda;padding:10px;border-radius:5px;margin:10px 0;} .error{color:#dc3545;background:#f8d7da;padding:10px;border-radius:5px;margin:10px 0;} .warning{color:#856404;background:#fff3cd;padding:10px;border-radius:5px;margin:10px 0;}</style>";
echo "</head><body><div class='container'>";

echo "<h1>🔥 Firebase Data Migration Tool</h1>";

if (!$firebaseRestHelper || !$firebaseRestHelper->isConnected()) {
    echo "<div class='error'>❌ Firebase not connected. Please check your configuration.</div>";
    echo "<p><a href='test_firebase_rest.php'>← Test Firebase Connection</a></p>";
    echo "</div></body></html>";
    exit;
}

echo "<div class='warning'>";
echo "⚠️ <strong>Important:</strong> This will add sample data to your Firestore database.<br>";
echo "Only run this ONCE after setting up your Firestore database.<br>";
echo "Make sure you have set up proper security rules first.";
echo "</div>";

// Check if we should actually run the migration
$runMigration = isset($_GET['confirm']) && $_GET['confirm'] === 'yes';

if (!$runMigration) {
    echo "<h2>Ready to Migrate Sample Data</h2>";
    echo "<p>This will add the following to your Firebase:</p>";
    echo "<ul>";
    echo "<li><strong>3 Blog Posts:</strong> Professional articles about AI and business automation</li>";
    echo "<li><strong>3 Testimonials:</strong> Customer reviews from Sarah Johnson, Michael Chen, and Emma Rodriguez</li>";
    echo "</ul>";
    
    echo "<div style='text-align: center; margin: 30px 0;'>";
    echo "<a href='?confirm=yes' style='display:inline-block;padding:15px 30px;background:#28a745;color:white;text-decoration:none;border-radius:5px;font-size:16px;'>✅ Yes, Migrate Data to Firebase</a>";
    echo "</div>";
    
    echo "<div style='text-align: center;'>";
    echo "<a href='test_firebase_rest.php'>← Back to Test Page</a>";
    echo "</div>";
    
    echo "</div></body></html>";
    exit;
}

// Run the actual migration
echo "<h2>🚀 Running Data Migration...</h2>";

$success = 0;
$errors = 0;

// Migrate blog posts
echo "<h3>Migrating Blog Posts:</h3>";
$sampleBlogs = FallbackData::getSampleBlogs();

foreach ($sampleBlogs as $blog) {
    // Remove the ID since Firebase will generate it
    unset($blog['id']);
    
    echo "<p>Adding blog: <strong>" . htmlspecialchars($blog['title']) . "</strong>... ";
    
    $blogId = $firebaseRestHelper->addBlog($blog);
    
    if ($blogId) {
        echo "<span style='color: green;'>✅ Success (ID: $blogId)</span></p>";
        $success++;
    } else {
        echo "<span style='color: red;'>❌ Failed</span></p>";
        $errors++;
    }
}

// Migrate testimonials
echo "<h3>Migrating Testimonials:</h3>";
$sampleTestimonials = FallbackData::getSampleTestimonials();

foreach ($sampleTestimonials as $testimonial) {
    // Remove the ID since Firebase will generate it
    unset($testimonial['id']);
    
    echo "<p>Adding testimonial: <strong>" . htmlspecialchars($testimonial['client_name']) . "</strong>... ";
    
    $testimonialId = $firebaseRestHelper->addTestimonial($testimonial);
    
    if ($testimonialId) {
        echo "<span style='color: green;'>✅ Success (ID: $testimonialId)</span></p>";
        $success++;
    } else {
        echo "<span style='color: red;'>❌ Failed</span></p>";
        $errors++;
    }
}

// Show results
echo "<h2>📊 Migration Results</h2>";

if ($success > 0) {
    echo "<div class='success'>✅ Successfully migrated $success items to Firebase!</div>";
}

if ($errors > 0) {
    echo "<div class='error'>❌ $errors items failed to migrate.</div>";
    echo "<p>Common causes:</p>";
    echo "<ul>";
    echo "<li>Firestore database not created yet</li>";
    echo "<li>Security rules too restrictive</li>";
    echo "<li>Network connectivity issues</li>";
    echo "</ul>";
}

if ($success > 0 && $errors === 0) {
    echo "<div class='success'>";
    echo "<h3>🎉 Migration Complete!</h3>";
    echo "<p>Your Firebase database now contains professional sample data.</p>";
    echo "<p>Your website will now display this data from Firebase instead of fallback data.</p>";
    echo "</div>";
    
    echo "<h3>Next Steps:</h3>";
    echo "<ol>";
    echo "<li><strong>Test your website:</strong> <a href='index.php'>Homepage</a> | <a href='blogs.php'>Blog Page</a></li>";
    echo "<li><strong>Update security rules:</strong> Apply production rules from firestore-rules.txt</li>";
    echo "<li><strong>Use admin system:</strong> Add, edit, or remove content as needed</li>";
    echo "</ol>";
}

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='test_firebase_rest.php' style='display:inline-block;padding:10px 20px;background:#007bff;color:white;text-decoration:none;border-radius:5px;'>Test Firebase Connection</a> ";
echo "<a href='website_status.php' style='display:inline-block;padding:10px 20px;background:#17a2b8;color:white;text-decoration:none;border-radius:5px;'>Website Status</a> ";
echo "<a href='index.php' style='display:inline-block;padding:10px 20px;background:#28a745;color:white;text-decoration:none;border-radius:5px;'>View Website</a>";
echo "</div>";

echo "</div></body></html>";
?>