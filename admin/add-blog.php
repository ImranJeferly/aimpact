<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

$categories = $pdo->query("SELECT * FROM blog_categories ORDER BY name")->fetchAll();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $status = $_POST['status'] ?? 'draft';
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    
    try {
        $pdo->beginTransaction();
        
        // Handle image upload
        $image_url = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $upload_dir = '../uploads/blogs/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $file_name = uniqid() . '-' . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $file_name);
            $image_url = 'uploads/blogs/' . $file_name;
        }
        
        // Insert blog post
        $stmt = $pdo->prepare("INSERT INTO blogs (title, slug, content, image_url, status, author_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $slug, $content, $image_url, $status, $_SESSION['admin_id']]);
        $blog_id = $pdo->lastInsertId();
        
        // Handle categories
        if (!empty($_POST['categories'])) {
            $stmt = $pdo->prepare("INSERT INTO blog_category_relations (blog_id, category_id) VALUES (?, ?)");
            foreach ($_POST['categories'] as $category_id) {
                $stmt->execute([$blog_id, $category_id]);
            }
        }
        
        $pdo->commit();
        $message = 'Blog post created successfully!';
    } catch (Exception $e) {
        $pdo->rollBack();
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
</head>
<body>
    <div class="adm-container">
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

                <button type="submit" class="adm-btn adm-btn-primary">Create Blog Post</button>
            </form>
        </div>
    </div>

    <script src="js/admin.js"></script>
</body>
</html>
