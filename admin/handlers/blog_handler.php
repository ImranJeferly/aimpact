<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['admin_logged_in'])) {
    die(json_encode(['success' => false, 'message' => 'Unauthorized']));
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'add':
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $status = $_POST['status'] ?? 'draft';
        $author = $_POST['author'] ?? '';
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        
        // Handle image upload
        $image_url = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $upload_dir = '../../uploads/blogs/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $file_name = uniqid() . '-' . $_FILES['image']['name'];
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $file_name)) {
                $image_url = 'uploads/blogs/' . $file_name;
            }
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO blogs (title, slug, content, image_url, status, author) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $slug, $content, $image_url, $status, $author]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;

    case 'edit':
        $id = $_POST['id'] ?? null;
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $status = $_POST['status'] ?? 'draft';
        $author = $_POST['author'] ?? '';
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        
        try {
            $pdo->beginTransaction();
            
            // Handle image upload
            $image_url = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $upload_dir = '../../uploads/blogs/';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                $file_name = uniqid() . '-' . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $file_name);
                $image_url = 'uploads/blogs/' . $file_name;
            }
            
            // Update blog post with author
            $sql = "UPDATE blogs SET title = ?, slug = ?, content = ?, status = ?, author = ?, updated_at = NOW()";
            $params = [$title, $slug, $content, $status, $author];
            
            if ($image_url) {
                $sql .= ", image_url = ?";
                $params[] = $image_url;
            }
            
            $sql .= " WHERE id = ?";
            $params[] = $id;
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            
            $pdo->commit();
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;

    case 'delete':
        $id = $_POST['id'] ?? null;
        try {
            $stmt = $pdo->prepare("DELETE FROM blogs WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;

    case 'get':
        $id = $_POST['id'] ?? null;
        try {
            $stmt = $pdo->prepare("SELECT title, content, status, author, image_url, id FROM blogs WHERE id = ?");
            $stmt->execute([$id]);
            $blog = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'data' => $blog]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;
}
