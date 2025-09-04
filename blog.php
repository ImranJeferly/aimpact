<?php
require_once 'config/firebase.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: blogs.php');
    exit();
}

// Fetch the blog post from Firebase (with fallback)
if ($firebaseHelper) {
    $blog = $firebaseHelper->getBlogById($id);
    
    if (!$blog || (isset($blog['status']) && $blog['status'] !== 'published')) {
        header('Location: blogs.php');
        exit();
    }
    
    // Update view count only if Firebase is connected (skip for fallback data)
    if ($firebaseHelper->isConnected()) {
        $currentViews = isset($blog['views']) ? (int)$blog['views'] : 0;
        $firebaseHelper->updateBlog($id, ['views' => $currentViews + 1]);
    }
    
} else {
    // Firebase helper not available
    header('Location: blogs.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($blog['title']); ?> - AImpact</title>
    <link rel="icon" type="image/svg+xml" href="assets/icon.svg">
    <link rel="stylesheet" href="style.css">
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
    <aside class="toc-sidebar">
        <h4>Table of Contents</h4>
        <ul class="toc-list">
            <!-- Will be populated by JavaScript -->
        </ul>
    </aside>
    <div class="single-blog-container">
        <?php if($blog['image_url']): ?>
            <div class="blog-hero">
                <img src="<?php echo htmlspecialchars($blog['image_url']); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>">
            </div>
            
            <div class="blog-meta">
                <span class="author-info">
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
                    <img src="<?php echo $authorImage; ?>" alt="<?php echo htmlspecialchars($displayName); ?>" class="author-image">
                    <div class="author-details">
                        <span class="author-name"><?php echo htmlspecialchars($displayName); ?></span>
                        <small>Co-founder of AImpact</small>
                    </div>
                </span>
                <div class="meta-right">
                    <span><?php echo date('F j, Y', strtotime($blog['created_at'])); ?></span>
                    <span class="meta-separator">|</span>
                    <span><?php echo number_format($blog['views']); ?> views</span>
                </div>
            </div>
        <?php endif; ?>
        
        <article class="single-blog-content">
            <section class="blog-title-section">
                <h1><?php echo htmlspecialchars($blog['title']); ?></h1>
            </section>
            
            <div class="blog-content-body">
                <?php 
                    // Process content and replace <CTA> tag with the actual CTA section
                    $content = $blog['content'];
                    $cta_html = '
                    <section class="blog-cta">
                        <div class="blog-cta-content">
                            <p class="blog-cta-heading">Ready to Transform Your Business?</p>
                            <p>Take the first step towards AI-powered efficiency. Let\'s discuss how we can help automate and optimize your business processes.</p>
                            <a href="contact" class="blog-cta-btn">Get Started Today</a>
                        </div>
                    </section>';
                    
                    echo str_replace('<CTA>', $cta_html, $content);
                ?>
            </div>
        </article>

    </div>

    <section class="related-blogs">
        <h2>More Articles</h2>
        <div class="blog-grid">
            <?php
            // Fetch 3 other published blogs except current one
            $stmt = $pdo->prepare("
                SELECT b.* 
                FROM blogs b 
                WHERE b.status = 'published' 
                AND b.id != ? 
                ORDER BY b.created_at DESC 
                LIMIT 3
            ");
            $stmt->execute([$id]);
            $relatedBlogs = $stmt->fetchAll();

            foreach($relatedBlogs as $blog): ?>
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
                                        <span class="author-name"><?php echo htmlspecialchars($displayName); ?></span>
                                        <small>Co-founder of AImpact</small>
                                    </div>
                                </div>
                            </span>
                            <span><?php echo date('M d, Y', strtotime($blog['created_at'])); ?></span>
                        </div>
                        <p class="blog-preview"><?php 
                            $firstSentence = strtok(strip_tags($blog['content']), '.!?');
                            echo $firstSentence . '.'; 
                        ?></p>
                        <a href="blog?id=<?php echo $blog['id']; ?>" class="orange-btn blog-btn">Read More</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

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

    <script>
        // Initialize fade animations for related blogs
        document.addEventListener('DOMContentLoaded', function() {
            const fadeElements = document.querySelectorAll('.fade-hidden');
            fadeElements.forEach(element => {
                setTimeout(() => {
                    element.classList.add('fade-show');
                }, 100);
            });
        });

        // Update scroll event listener
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 100) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }

            // Check if related blogs are in viewport and animate them
            const relatedBlogs = document.querySelectorAll('.related-blogs .blog-card');
            relatedBlogs.forEach(blog => {
                if (isElementInViewport(blog) && !blog.classList.contains('fade-show')) {
                    blog.classList.add('fade-show');
                }
            });
        });

        function isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }

        // Add Table of Contents functionality
        function generateTableOfContents() {
            const content = document.querySelector('.blog-content-body');
            const tocList = document.querySelector('.toc-list');
            const headings = content.querySelectorAll('h2, h3');
            const blogId = new URLSearchParams(window.location.search).get('id');
            
            headings.forEach((heading, index) => {
                if (!heading.id) {
                    heading.id = `heading-${index}`;
                }
                
                // Add share button to heading
                const shareButton = document.createElement('button');
                shareButton.className = 'heading-share';
                shareButton.innerHTML = `<svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.5835 16.9597C13.2098 17.7978 14.0087 18.4912 14.9263 18.993C15.8438 19.4948 16.8584 19.7931 17.9012 19.8679C18.944 19.9427 19.9907 19.792 20.9703 19.4263C21.9499 19.0605 22.8394 18.4881 23.5786 17.7479L27.9533 13.3688C29.2814 11.9923 30.0163 10.1487 29.9997 8.23507C29.9831 6.32143 29.2163 4.49088 27.8645 3.13768C26.5126 1.78448 24.6839 1.0169 22.7722 1.00028C20.8605 0.983647 19.0187 1.71929 17.6436 3.04877L15.1354 5.54486M18.4165 14.0403C17.7902 13.2022 16.9912 12.5088 16.0737 12.007C15.1562 11.5052 14.1416 11.2069 13.0988 11.1321C12.056 11.0573 11.0093 11.208 10.0297 11.5737C9.05009 11.9395 8.16056 12.5119 7.4214 13.2521L3.04671 17.6312C1.71857 19.0077 0.983663 20.8513 1.00028 22.7649C1.01689 24.6786 1.78369 26.5091 3.13553 27.8623C4.48737 29.2155 6.31608 29.9831 8.2278 29.9997C10.1395 30.0164 11.9813 29.2807 13.3564 27.9512L15.85 25.4551" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>`;
                shareButton.onclick = (e) => {
                    e.preventDefault();
                    // Include both blog ID and heading ID in the URL
                    const url = `${window.location.origin}${window.location.pathname}?id=${blogId}#${heading.id}`;
                    navigator.clipboard.writeText(url).then(() => {
                        showToast('Link copied to clipboard!');
                    });
                };
                heading.appendChild(shareButton);
                
                // Create TOC link with both blog ID and heading ID
                const listItem = document.createElement('li');
                const link = document.createElement('a');
                
                link.href = `?id=${blogId}#${heading.id}`;
                link.textContent = heading.textContent;
                
                if (heading.tagName === 'H3') {
                    link.classList.add('toc-h3');
                }
                
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const y = heading.getBoundingClientRect().top + window.pageYOffset - 200;
                    window.scrollTo({top: y, behavior: 'smooth'});
                    // Update URL without reloading the page
                    history.pushState(null, '', `?id=${blogId}#${heading.id}`);
                    highlightHeading();
                });
                
                listItem.appendChild(link);
                tocList.appendChild(listItem);
            });
        }

        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.textContent = message;
            document.body.appendChild(toast);
            
            // Trigger reflow
            toast.offsetHeight;
            
            // Show toast
            toast.classList.add('show');
            
            // Hide and remove toast
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 2000);
        }

        // Call the function when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            generateTableOfContents();

            // Add this function to handle hash changes
            function highlightHeading() {
                // Remove any existing highlights
                document.querySelectorAll('.highlight-heading').forEach(el => {
                    el.classList.remove('highlight-heading');
                });

                // If there's a hash in the URL
                if (window.location.hash) {
                    const heading = document.querySelector(window.location.hash);
                    if (heading) {
                        heading.classList.add('highlight-heading');
                        setTimeout(() => {
                            heading.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }, 100);
                    }
                }
            }

            // Call on initial load and when hash changes
            highlightHeading();
            window.addEventListener('hashchange', highlightHeading);
        });
    </script>
</body>
</html>
