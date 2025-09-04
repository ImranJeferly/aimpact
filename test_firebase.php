<?php
require_once 'config/firebase.php';

echo "<!DOCTYPE html><html><head><title>Firebase Test</title></head><body>";
echo "<h1>Firebase Connection Test</h1>";

if ($firebaseHelper && $firebaseHelper->isConnected()) {
    echo "<p style='color: green;'>✅ Firebase connected successfully!</p>";
    
    // Test adding a sample blog post
    echo "<h2>Testing Blog Operations</h2>";
    
    $testBlog = [
        'title' => 'Test Blog Post',
        'slug' => 'test-blog-post',
        'content' => 'This is a test blog post created during Firebase migration.',
        'status' => 'published',
        'author' => 'System Test',
        'image_url' => null
    ];
    
    $blogId = $firebaseHelper->addBlog($testBlog);
    if ($blogId) {
        echo "<p style='color: green;'>✅ Test blog post created with ID: $blogId</p>";
        
        // Test fetching blogs
        $blogs = $firebaseHelper->getAllBlogs('published');
        echo "<p style='color: green;'>✅ Successfully fetched " . count($blogs) . " published blog(s)</p>";
        
        // Test updating the blog
        $updateResult = $firebaseHelper->updateBlog($blogId, ['title' => 'Updated Test Blog Post']);
        if ($updateResult) {
            echo "<p style='color: green;'>✅ Successfully updated blog post</p>";
        } else {
            echo "<p style='color: red;'>❌ Failed to update blog post</p>";
        }
        
        // Test deleting the blog (cleanup)
        $deleteResult = $firebaseHelper->deleteBlog($blogId);
        if ($deleteResult) {
            echo "<p style='color: green;'>✅ Successfully deleted test blog post</p>";
        } else {
            echo "<p style='color: red;'>❌ Failed to delete test blog post</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Failed to create test blog post</p>";
    }
    
    // Test testimonial operations
    echo "<h2>Testing Testimonial Operations</h2>";
    
    $testTestimonial = [
        'client_name' => 'Test Client',
        'company_name' => 'Test Company',
        'position' => 'CEO',
        'content' => 'This is a test testimonial.',
        'rating' => 5,
        'featured' => 1,
        'status' => 'approved',
        'image_url' => null
    ];
    
    $testimonialId = $firebaseHelper->addTestimonial($testTestimonial);
    if ($testimonialId) {
        echo "<p style='color: green;'>✅ Test testimonial created with ID: $testimonialId</p>";
        
        // Test fetching testimonials
        $testimonials = $firebaseHelper->getAllTestimonials('approved');
        echo "<p style='color: green;'>✅ Successfully fetched " . count($testimonials) . " approved testimonial(s)</p>";
        
        // Cleanup - delete test testimonial
        $deleteResult = $firebaseHelper->deleteTestimonial($testimonialId);
        if ($deleteResult) {
            echo "<p style='color: green;'>✅ Successfully deleted test testimonial</p>";
        } else {
            echo "<p style='color: red;'>❌ Failed to delete test testimonial</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Failed to create test testimonial</p>";
    }
    
} else {
    echo "<p style='color: red;'>❌ Firebase connection failed!</p>";
    echo "<p>Please check:</p>";
    echo "<ul>";
    echo "<li>Firebase project ID in .env file</li>";
    echo "<li>Firebase service account credentials</li>";
    echo "<li>Internet connection</li>";
    echo "<li>PHP error logs</li>";
    echo "</ul>";
}

echo "<p><a href='index.php'>← Back to Home</a></p>";
echo "</body></html>";
?>