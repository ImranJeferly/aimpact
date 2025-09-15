<?php
require_once '../../config/firebase.php';
require_once '../../config/firebase_storage.php';
require_once 'firebase_auth_helper.php';

// Verify Firebase Authentication token
requireFirebaseAuth();

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'add':
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $status = $_POST['status'] ?? 'draft';
        $author = $_POST['author'] ?? '';
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        
        // Handle image upload to Firebase Storage
        $image_url = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $storageHelper = new FirebaseStorageHelper(FIREBASE_PROJECT_ID);
            $uploadResult = $storageHelper->uploadFile($_FILES['image'], 'blogs', 'blog');
            
            if ($uploadResult['success']) {
                $image_url = $uploadResult['downloadUrl'];
            } else {
                echo json_encode(['success' => false, 'message' => 'Image upload failed: ' . $uploadResult['message']]);
                exit;
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
        
        // Handle image upload to Firebase Storage
        $image_url = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $storageHelper = new FirebaseStorageHelper(FIREBASE_PROJECT_ID);
            $uploadResult = $storageHelper->uploadFile($_FILES['image'], 'blogs', 'blog');
            
            if ($uploadResult['success']) {
                $image_url = $uploadResult['downloadUrl'];
            } else {
                echo json_encode(['success' => false, 'message' => 'Image upload failed: ' . $uploadResult['message']]);
                exit;
            }
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
