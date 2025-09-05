<?php
// Firebase Authentication Helper for Admin Handlers

function verifyFirebaseToken() {
    // Get token from Authorization header or POST data
    $token = null;
    
    // Check Authorization header first
    $headers = getallheaders();
    if (isset($headers['Authorization'])) {
        $authHeader = $headers['Authorization'];
        if (preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches)) {
            $token = $matches[1];
        }
    }
    
    // Fallback to POST data
    if (!$token && isset($_POST['token'])) {
        $token = $_POST['token'];
    }
    
    // For now, since we're using REST API without server-side token verification,
    // we'll implement a basic check. In production, you should verify the JWT token properly.
    if (!$token) {
        return false;
    }
    
    // Basic validation - in production, verify the JWT token with Firebase Admin SDK
    // For now, just check if token exists and is not empty
    if (strlen($token) > 10) {
        return true;
    }
    
    return false;
}

function requireFirebaseAuth() {
    if (!verifyFirebaseToken()) {
        http_response_code(401);
        die(json_encode(['success' => false, 'message' => 'Unauthorized - Firebase token required']));
    }
}
?>