<?php
require_once 'config/firebase.php';
require_once 'config/cache.php';

$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';

// Create cache key based on search parameters
$cacheKey = 'blogs_' . md5($search . '_' . $category);

// Try to get from cache first (only if no search/filter)
if (empty($search) && empty($category)) {
    $blogs = $cache->get($cacheKey);
    if ($blogs !== null) {
        // Use cached data
        goto skip_query;
    }
}

// Get blogs from Firebase (with fallback data)
if ($firebaseHelper) {
    if ($search || $category) {
        $blogs = $firebaseHelper->searchBlogs($search, $category);
    } else {
        $blogs = $firebaseHelper->getAllBlogs('published');
        
        // Cache the results if no search/filter (cache for 5 minutes)
        if (!empty($blogs)) {
            $cache->set($cacheKey, $blogs, 300);
        }
    }
} else {
    $blogs = [];
    error_log("Firebase helper not available in blogs.php");
}

skip_query:

// Categories are not implemented in this Firebase migration yet
// For now, we'll use an empty array
$categories = [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - AImpact</title>
    <link rel="stylesheet" href="style.css">
    <script src="js/animations.js"></script>
    <link rel="icon" type="image/svg+xml" href="assets/icon.svg">
</head>
<body>
    <nav style="top: 20px;">
        <img src="assets/logo.svg" alt="">
        <ul>
            <li><a href="index#home" class="white-btn">Home</a></li>
            <li><a href="index#whatweoffer" class="white-btn">What we offer</a></li>
            <li><a href="index#howitworks" class="white-btn">How it works</a></li>
            <li><a href="index#contact" class="white-btn">Contact</a></li>
            <li><a href="index#pricing" class="white-btn">Pricing</a></li>
            <li><a href="blogs" class="white-btn">Blog</a></li>
            <li><a href="index#faq" class="white-btn">FAQ</a></li>
        </ul>
        <a href="contact" class="orange-btn">Contact</a>
    </nav>
    
    <div class="blog-glow"></div>
    <div class="blog-container">
        <div class="blog-header">
            <h1 class="fade-hidden fade-from-bottom">Our Insights</h1>
            <p class="blog-subtitle fade-hidden fade-from-bottom delay-short">Discover the latest trends and insights about AI technology and business automation</p>
            <div class="blog-search">
                <div class="search-form">
                    <input type="text" id="searchInput" placeholder="Search blogs..." autocomplete="off">
                </div>
            </div>
        </div>

        <div class="blog-grid" id="blogGrid">
            <?php foreach($blogs as $blog): ?>
                <article class="blog-card fade-hidden fade-from-bottom delay-medium">
                    <?php if($blog['image_url']): ?>
                        <img src="<?php echo htmlspecialchars($blog['image_url']); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>" class="blog-image">
                    <?php endif; ?>
                    <div class="blog-content">
                        <h2><?php echo htmlspecialchars($blog['title']); ?></h2>
                        <div class="blog-meta">
                            <span>
                                <?php 
                                    $displayName = match($blog['author']) {
                                        'Imran' => 'Ron',
                                        'Huseyn' => 'Hudson',
                                        'Kamran' => 'Cameron',
                                        default => $blog['author']
                                    };
                                    $authorImage = match($blog['author']) {
                                        'Imran' => 'assets/authors/imran.png',
                                        'Huseyn' => 'assets/authors/huseyn.png',
                                        'Kamran' => 'assets/authors/kamran.png',
                                        default => 'assets/authors/default.png'
                                    };
                                ?>
                                <div class="author-info">
                                    <img src="<?php echo $authorImage; ?>" alt="<?php echo htmlspecialchars($displayName); ?>" class="author-image">
                                    <div class="author-details">
                                        <?php echo htmlspecialchars($displayName); ?>
                                        <br>
                                        <small style="color: #848484; font-size: 0.8em;">Co-founder of AImpact</small>
                                    </div>
                                </div>
                            </span>
                            <span><?php 
                                // Handle Firebase DateTime object or string
                                if (isset($blog['created_at'])) {
                                    if ($blog['created_at'] instanceof DateTime) {
                                        echo $blog['created_at']->format('M d, Y');
                                    } else {
                                        echo date('M d, Y', strtotime($blog['created_at']));
                                    }
                                } else {
                                    echo 'Recent';
                                }
                            ?></span>
                        </div>
                        <p class="blog-excerpt"><?php echo substr(strip_tags($blog['content']), 0, 150) . '...'; ?></p>
                        <p class="blog-preview"><?php 
                            $firstSentence = strtok(strip_tags($blog['content']), '.!?');
                            echo $firstSentence . '.'; 
                        ?></p>
                        <a href="blog?id=<?php echo $blog['id']; ?>" class="orange-btn blog-btn">Read More</a>
                    </div>
                </article>
            <?php endforeach; ?>
            <?php if(empty($blogs)): ?>
                <div class="no-results">
                    <p>No blog posts found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    
    <footer class="white-section">
        <div class="footer-content">
            <img src="assets/logo.svg" alt="AImpact Logo" class="footer-logo">
            <div class="footer-links">
                <a href="#about">About</a>
                <a href="#services">Services</a>
                <a href="#contact">Contact</a>
                <a href="#privacy">Privacy Policy</a>
                <a href="#terms">Terms of Service</a>
            </div>
            <p class="footer-text">&copy; 2024 AImpact. All rights reserved.</p>
        </div>
    </footer>
    <script src="js/animations.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            let searchTimeout;

            searchInput.addEventListener('input', function(e) {
                clearTimeout(searchTimeout);
                const searchTerm = e.target.value;
                
                searchTimeout = setTimeout(() => {
                    if (searchTerm === '') {
                        // If search is empty, reload the page to show all blogs
                        window.location.reload();
                        return;
                    }
                    
                    fetch(`search_blogs.php?search=${encodeURIComponent(searchTerm)}`)
                        .then(response => response.text())
                        .then(html => {
                            const blogGrid = document.getElementById('blogGrid');
                            blogGrid.innerHTML = html;
                            
                            // Re-initialize animations for new content
                            const newElements = blogGrid.getElementsByClassName('fade-hidden');
                            Array.from(newElements).forEach(element => {
                                setTimeout(() => {
                                    element.classList.add('fade-show');
                                }, 100);
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error searching blogs');
                        });
                }, 300);
            });
        });

        // Updated scroll event listener
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 100) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
