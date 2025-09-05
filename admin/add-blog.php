<?php
// Firebase Authentication handles access control
require_once '../config/firebase.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $status = $_POST['status'] ?? 'draft';
    $author = $_POST['author'] ?? 'Admin';
    
    // Generate slug from title
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    
    // Handle image upload if present
    $imageUrl = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/blogs/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid() . '.' . $fileExtension;
        $uploadPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            $imageUrl = 'uploads/blogs/' . $fileName;
        }
    }
    
    // Prepare blog data for Firebase
    $blogData = [
        'title' => $title,
        'slug' => $slug,
        'content' => $content,
        'status' => $status,
        'author' => $author,
        'image_url' => $imageUrl,
        'views' => 0,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    try {
        // Add blog to Firebase
        if ($firebaseHelper && $firebaseHelper->isConnected()) {
            $blogId = $firebaseHelper->addBlog($blogData);
            if ($blogId) {
                $message = 'Blog post created successfully! ID: ' . $blogId;
            } else {
                $message = 'Error: Failed to create blog post in Firebase';
            }
        } else {
            $message = 'Error: Firebase not connected';
        }
    } catch (Exception $e) {
        $message = 'Error: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Blog - AImpact</title>
    <link rel="stylesheet" href="css/admin.css">
    <style>
        .loading-spinner { display: none; text-align: center; padding: 50px; }
        .auth-protected { display: none; }
    </style>
</head>
<body>
    <div class="loading-spinner">
        <h2>Loading...</h2>
    </div>
    <div class="adm-container auth-protected">
        <nav class="adm-navbar">
            <h1>Add New Blog</h1>
            <div class="adm-nav-links">
                <a href="blogs.php" class="adm-btn">Back to Blogs</a>
                <a href="index.php" class="adm-btn">Dashboard</a>
                <a href="logout.php" class="adm-btn adm-btn-primary">Logout</a>
            </div>
        </nav>

        <div class="adm-content">
            <?php if ($message): ?>
                <div class="adm-message"><?php echo $message; ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" class="adm-form">
                <div class="adm-form-group">
                    <label>Title:</label>
                    <input type="text" name="title" class="adm-input" required>
                </div>

                <div class="adm-form-group">
                    <label>Content:</label>
                    <div class="editor-toolbar">
                        <button type="button" onclick="formatText('bold')" class="adm-btn">B</button>
                        <button type="button" onclick="formatText('italic')" class="adm-btn">I</button>
                        <button type="button" onclick="formatText('underline')" class="adm-btn">U</button>
                        <button type="button" onclick="addLink()" class="adm-btn">Link</button>
                    </div>
                    <textarea name="content" id="content" class="adm-editor" rows="15" required></textarea>
                </div>

                <div class="adm-form-group">
                    <label>Categories:</label>
                    <select name="categories[]" multiple class="adm-select">
                        <?php foreach($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>">
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="adm-form-group">
                    <label>Featured Image:</label>
                    <input type="file" name="image" accept="image/*" class="adm-input">
                </div>

                <div class="adm-form-group">
                    <label>Status:</label>
                    <select name="status" class="adm-select">
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                    </select>
                </div>

                <div class="adm-form-group">
                    <label>Author:</label>
                    <select name="author" class="adm-select">
                        <option value="Imran">Imran</option>
                        <option value="Huseyn">Huseyn</option>
                        <option value="Kamran">Kamran</option>
                        <option value="Admin" selected>Admin</option>
                    </select>
                </div>

                <button type="submit" class="adm-btn adm-btn-primary">Create Blog Post</button>
            </form>
        </div>
    </div>

    <script type="module" src="firebase-config.php"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loadingSpinner = document.querySelector('.loading-spinner');
            const authProtected = document.querySelector('.auth-protected');
            
            // Show loading initially
            loadingSpinner.style.display = 'block';
            
            // Wait for Firebase auth to initialize
            setTimeout(() => {
                if (window.adminAuth && window.adminAuth.getCurrentUser()) {
                    // User is authenticated, show content
                    loadingSpinner.style.display = 'none';
                    authProtected.style.display = 'block';
                } else {
                    // User not authenticated, redirect to login
                    window.location.href = 'login.php';
                }
            }, 1000);

            // Update logout functionality
            const logoutBtn = document.querySelector('a[href="logout.php"]');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', async (e) => {
                    e.preventDefault();
                    if (window.adminAuth) {
                        await window.adminAuth.signOut();
                        window.location.href = 'login.php';
                    }
                });
            }
        });
    </script>
    <script src="js/admin.js"></script>
    <script src="js/firebase-admin.js"></script>
</body>
</html>
