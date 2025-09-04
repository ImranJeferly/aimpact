<?php
session_start();
require_once '../../config/firebase.php';

if (!isset($_SESSION['admin_logged_in'])) {
    die(json_encode(['success' => false, 'message' => 'Unauthorized']));
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'add':
    case 'edit':
        $client_name = $_POST['client_name'] ?? '';
        $company_name = $_POST['company_name'] ?? '';
        $position = $_POST['position'] ?? '';
        $content = $_POST['content'] ?? '';
        $rating = $_POST['rating'] ?? 5;
        $featured = isset($_POST['featured']) ? 1 : 0;
        $id = $_POST['id'] ?? null;
        
        // Handle image upload
        $image_url = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $upload_dir = '../../uploads/testimonials/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $file_name = uniqid() . '-' . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $file_name);
            $image_url = 'uploads/testimonials/' . $file_name;
        }

        if ($firebaseHelper && $firebaseHelper->isConnected()) {
            if ($action === 'add') {
                $testimonialData = [
                    'client_name' => $client_name,
                    'company_name' => $company_name,
                    'position' => $position,
                    'content' => $content,
                    'rating' => $rating,
                    'image_url' => $image_url,
                    'featured' => $featured,
                    'status' => 'pending'
                ];
                
                $testimonialId = $firebaseHelper->addTestimonial($testimonialData);
                if ($testimonialId) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to add testimonial']);
                }
            } else {
                $updateData = [
                    'client_name' => $client_name,
                    'company_name' => $company_name,
                    'position' => $position,
                    'content' => $content,
                    'rating' => $rating,
                    'featured' => $featured
                ];
                
                if ($image_url) {
                    $updateData['image_url'] = $image_url;
                }
                
                $success = $firebaseHelper->updateTestimonial($id, $updateData);
                if ($success) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to update testimonial']);
                }
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        }
        break;

    case 'delete':
        $id = $_POST['id'] ?? null;
        if ($firebaseHelper && $firebaseHelper->isConnected()) {
            $success = $firebaseHelper->deleteTestimonial($id);
            if ($success) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete testimonial']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        }
        break;

    case 'approve':
        $id = $_POST['id'] ?? null;
        if ($firebaseHelper && $firebaseHelper->isConnected()) {
            $success = $firebaseHelper->updateTestimonial($id, ['status' => 'approved']);
            if ($success) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to approve testimonial']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        }
        break;

    case 'get':
        $id = $_POST['id'] ?? null;
        if ($firebaseHelper && $firebaseHelper->isConnected()) {
            $testimonial = $firebaseHelper->getTestimonialById($id);
            if ($testimonial) {
                echo json_encode(['success' => true, 'data' => $testimonial]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Testimonial not found']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        }
        break;
}
