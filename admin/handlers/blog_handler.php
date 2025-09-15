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
        
        // Handle image upload with Firebase Storage and local fallback
        $image_url = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Try Firebase Storage first
            try {
                if (defined('FIREBASE_PROJECT_ID') && !empty(FIREBASE_PROJECT_ID)) {
                    $storageHelper = new FirebaseStorageHelper(
                        FIREBASE_PROJECT_ID,
                        defined('FIREBASE_STORAGE_BUCKET') ? FIREBASE_STORAGE_BUCKET : null,
                        defined('FIREBASE_API_KEY') ? FIREBASE_API_KEY : null
                    );
                    $uploadResult = $storageHelper->uploadFile($_FILES['image'], 'blogs', 'blog');
                    
                    if ($uploadResult['success']) {
                        $image_url = $uploadResult['downloadUrl'];
                        error_log("✅ Successfully uploaded to Firebase Storage: " . $image_url);
                    } else {
                        throw new Exception('Firebase Storage failed: ' . $uploadResult['message']);
                    }
                } else {
                    throw new Exception('Firebase configuration missing');
                }
            } catch (Exception $e) {
                // Fallback to local storage
                error_log('⚠️  Firebase Storage failed, using local storage: ' . $e->getMessage());
                
                $upload_dir = '../../uploads/blogs/';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                // Validate file type
                $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($finfo, $_FILES['image']['tmp_name']);
                finfo_close($finfo);
                
                if (!in_array($mime_type, $allowed_types)) {
                    echo json_encode(['success' => false, 'message' => 'Invalid file type. Only images allowed.']);
                    exit;
                }
                
                // Validate file size (5MB max)
                if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
                    echo json_encode(['success' => false, 'message' => 'File too large. Maximum 5MB allowed.']);
                    exit;
                }
                
                $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $file_name = 'blog_' . uniqid() . '.' . strtolower($file_extension);
                $upload_path = $upload_dir . $file_name;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                    chmod($upload_path, 0644);
                    $image_url = 'uploads/blogs/' . $file_name;
                    error_log("📁 Fallback: Successfully uploaded to local storage: " . $image_url);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to upload image']);
                    exit;
                }
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
        
        // Handle image upload with Firebase Storage and local fallback
        $image_url = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Try Firebase Storage first
            try {
                if (defined('FIREBASE_PROJECT_ID') && !empty(FIREBASE_PROJECT_ID)) {
                    $storageHelper = new FirebaseStorageHelper(
                        FIREBASE_PROJECT_ID,
                        defined('FIREBASE_STORAGE_BUCKET') ? FIREBASE_STORAGE_BUCKET : null,
                        defined('FIREBASE_API_KEY') ? FIREBASE_API_KEY : null
                    );
                    $uploadResult = $storageHelper->uploadFile($_FILES['image'], 'blogs', 'blog');
                    
                    if ($uploadResult['success']) {
                        $image_url = $uploadResult['downloadUrl'];
                        error_log("✅ Successfully uploaded to Firebase Storage: " . $image_url);
                    } else {
                        throw new Exception('Firebase Storage failed: ' . $uploadResult['message']);
                    }
                } else {
                    throw new Exception('Firebase configuration missing');
                }
            } catch (Exception $e) {
                // Fallback to local storage
                error_log('⚠️  Firebase Storage failed, using local storage: ' . $e->getMessage());
                
                $upload_dir = '../../uploads/blogs/';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                // Validate file type
                $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($finfo, $_FILES['image']['tmp_name']);
                finfo_close($finfo);
                
                if (!in_array($mime_type, $allowed_types)) {
                    echo json_encode(['success' => false, 'message' => 'Invalid file type. Only images allowed.']);
                    exit;
                }
                
                // Validate file size (5MB max)
                if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
                    echo json_encode(['success' => false, 'message' => 'File too large. Maximum 5MB allowed.']);
                    exit;
                }
                
                $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $file_name = 'blog_' . uniqid() . '.' . strtolower($file_extension);
                $upload_path = $upload_dir . $file_name;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                    chmod($upload_path, 0644);
                    $image_url = 'uploads/blogs/' . $file_name;
                    error_log("📁 Fallback: Successfully uploaded to local storage: " . $image_url);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to upload image']);
                    exit;
                }
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
