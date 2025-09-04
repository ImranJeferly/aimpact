<?php
session_start();
require_once '../../config/firebase.php';

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

        if ($firebaseHelper && $firebaseHelper->isConnected()) {
            $blogData = [
                'title' => $title,
                'slug' => $slug,
                'content' => $content,
                'image_url' => $image_url,
                'status' => $status,
                'author' => $author
            ];
            
            $blogId = $firebaseHelper->addBlog($blogData);
            if ($blogId) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add blog']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        }
        break;

    case 'edit':
        $id = $_POST['id'] ?? null;
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
            move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $file_name);
            $image_url = 'uploads/blogs/' . $file_name;
        }
        
        if ($firebaseHelper && $firebaseHelper->isConnected()) {
            $updateData = [
                'title' => $title,
                'slug' => $slug,
                'content' => $content,
                'status' => $status,
                'author' => $author
            ];
            
            if ($image_url) {
                $updateData['image_url'] = $image_url;
            }
            
            $success = $firebaseHelper->updateBlog($id, $updateData);
            if ($success) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update blog']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        }
        break;

    case 'delete':
        $id = $_POST['id'] ?? null;
        if ($firebaseHelper && $firebaseHelper->isConnected()) {
            $success = $firebaseHelper->deleteBlog($id);
            if ($success) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete blog']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        }
        break;

    case 'get':
        $id = $_POST['id'] ?? null;
        if ($firebaseHelper && $firebaseHelper->isConnected()) {
            $blog = $firebaseHelper->getBlogById($id);
            if ($blog) {
                echo json_encode(['success' => true, 'data' => $blog]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Blog not found']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        }
        break;
}
