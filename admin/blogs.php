<?php
session_start();
require_once '../config/firebase.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Fetch blogs from Firebase
if ($firebaseHelper && $firebaseHelper->isConnected()) {
    $blogs = $firebaseHelper->getAllBlogs(); // Get all blogs including drafts
} else {
    $blogs = [];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blogs - AImpact</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="adm-container">
        <nav class="adm-navbar">
            <h1>Manage Blogs</h1>
            <div class="adm-nav-links">
                <button onclick="showAddForm()" class="adm-btn">Add New Blog</button>
                <a href="index.php" class="adm-btn">Dashboard</a>
                <a href="logout.php" class="adm-btn adm-btn-primary">Logout</a>
            </div>
        </nav>

        <div class="admin-content">
            <!-- Add/Edit Form -->
            <div id="blogForm" class="adm-form adm-blog-form" style="display: none;">
                <h2 class="adm-blog-title">Create New Blog Post</h2>
                <form id="saveBlogForm" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="blog_id">
                    
                    <div class="adm-form-group blog-title">
                        <label>Title:</label>
                        <input type="text" name="title" id="title" class="adm-input" required placeholder="Enter blog title...">
                    </div>

                    <div class="adm-form-group">
                        <label>Content:</label>
                        <div class="adm-blog-toolbar">
                            <button type="button" onclick="formatText('bold')" class="adm-btn" title="Bold"><strong>B</strong></button>
                            <button type="button" onclick="formatText('italic')" class="adm-btn" title="Italic"><em>I</em></button>
                            <button type="button" onclick="formatText('underline')" class="adm-btn" title="Underline"><u>U</u></button>
                            <button type="button" onclick="addLink()" class="adm-btn" title="Add Link">🔗</button>
                            <button type="button" onclick="addHeading()" class="adm-btn" title="Add Heading">H</button>
                            <button type="button" onclick="addList()" class="adm-btn" title="Add List">•</button>
                        </div>
                        <textarea name="content" id="content" class="adm-editor adm-blog-editor" required placeholder="Write your blog content here..."></textarea>
                    </div>

                    <div class="adm-blog-options">
                        <div class="adm-form-group">
                            <label>Featured Image:</label>
                            <div class="adm-image-upload" onclick="document.getElementById('blog-image').click()">
                                <input type="file" id="blog-image" name="image" accept="image/*" style="display: none" onchange="previewImage(this)">
                                <div class="adm-upload-placeholder">
                                    <p>Click to upload image or drag and drop</p>
                                    <span>Supports: JPG, PNG, GIF (Max 2MB)</span>
                                </div>
                                <img id="image-preview" class="adm-preview-image" style="display: none">
                            </div>
                        </div>
                    </div>

                    <div class="adm-form-group">
                        <label>Status:</label>
                        <select name="status" class="adm-select">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>

                    <!-- Add Author Selection -->
                    <div class="adm-form-group">
                        <label>Author:</label>
                        <select name="author" class="adm-select" required>
                            <option value="" disabled selected>Select an author</option>
                            <option value="Imran">Imran</option>
                            <option value="Huseyn">Huseyn</option>
                            <option value="Kamran">Kamran</option>
                        </select>
                    </div>

                    <div class="adm-form-actions">
                        <button type="button" onclick="hideForm()" class="adm-btn">Cancel</button>
                        <button type="submit" class="adm-btn adm-btn-primary">Save Blog</button>
                    </div>
                </form>
            </div>

            <!-- Blogs List -->
            <div class="adm-table-container">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($blogs as $blog): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($blog['title']); ?></td>
                            <td>
                                <div class="author-info">
                                    <?php 
                                        $displayName = match($blog['author']) {
                                            'Imran' => 'Ron',
                                            'Huseyn' => 'Hudson',
                                            'Kamran' => 'Cameron',
                                            default => $blog['author']
                                        };
                                        $authorImage = match($blog['author']) {
                                            'Imran' => '../assets/authors/imran.png',
                                            'Huseyn' => '../assets/authors/huseyn.png',
                                            'Kamran' => '../assets/authors/kamran.png',
                                            default => '../assets/authors/default.png'
                                        };
                                    ?>
                                    <img src="<?php echo $authorImage; ?>" alt="<?php echo htmlspecialchars($displayName); ?>" class="author-image">
                                    <div class="author-details">
                                        <?php echo htmlspecialchars($displayName); ?>
                                        <br>
                                        <small style="color: #848484; font-size: 0.8em;">Co-founder of AImpact</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="adm-status adm-status-<?php echo $blog['status']; ?>"><?php echo ucfirst($blog['status']); ?></span></td>
                            <td><?php echo date('Y-m-d', strtotime($blog['created_at'])); ?></td>
                            <td>
                                <div class="adm-action-buttons">
                                    <button onclick="editBlog(<?php echo $blog['id']; ?>)" class="adm-btn-edit">Edit</button>
                                    <button onclick="deleteBlog(<?php echo $blog['id']; ?>)" class="adm-btn-delete">Delete</button>
                                    <a href="../blog.php?id=<?php echo $blog['id']; ?>" target="_blank" class="adm-btn-view">View</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="js/admin.js"></script>
    <script>
        function formatText(command) {
            const textarea = document.getElementById('content');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const selectedText = textarea.value.substring(start, end);
            
            let formattedText;
            switch(command) {
                case 'bold':
                    formattedText = `<strong>${selectedText}</strong>`;
                    break;
                case 'italic':
                    formattedText = `<em>${selectedText}</em>`;
                    break;
                case 'underline':
                    formattedText = `<u>${selectedText}</u>`;
                    break;
            }
            
            textarea.value = textarea.value.substring(0, start) + formattedText + textarea.value.substring(end);
        }

        function addLink() {
            const textarea = document.getElementById('content');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const selectedText = textarea.value.substring(start, end);
            
            const url = prompt('Enter URL:', 'http://');
            if (url) {
                const link = `<a href="${url}">${selectedText || url}</a>`;
                textarea.value = textarea.value.substring(0, start) + link + textarea.value.substring(end);
            }
        }
    </script>
</body>
</html>
