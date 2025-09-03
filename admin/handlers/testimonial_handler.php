<?php
session_start();
require_once '../../config/database.php';

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

        try {
            if ($action === 'add') {
                $stmt = $pdo->prepare("INSERT INTO testimonials (client_name, company_name, position, content, rating, image_url, featured, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
                $stmt->execute([$client_name, $company_name, $position, $content, $rating, $image_url, $featured]);
            } else {
                $sql = "UPDATE testimonials SET client_name = ?, company_name = ?, position = ?, content = ?, rating = ?, featured = ?";
                $params = [$client_name, $company_name, $position, $content, $rating, $featured];
                
                if ($image_url) {
                    $sql .= ", image_url = ?";
                    $params[] = $image_url;
                }
                
                $sql .= " WHERE id = ?";
                $params[] = $id;
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute($params);
            }
            
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;

    case 'delete':
        $id = $_POST['id'] ?? null;
        try {
            $stmt = $pdo->prepare("DELETE FROM testimonials WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;

    case 'approve':
        $id = $_POST['id'] ?? null;
        try {
            $stmt = $pdo->prepare("UPDATE testimonials SET status = 'approved', approved_at = NOW() WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;

    case 'get':
        $id = $_POST['id'] ?? null;
        try {
            $stmt = $pdo->prepare("SELECT * FROM testimonials WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['success' => true, 'data' => $stmt->fetch(PDO::FETCH_ASSOC)]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;
}
