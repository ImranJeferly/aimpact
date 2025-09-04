<?php
// Use Firebase REST API instead of gRPC (works with XAMPP)
require_once __DIR__ . '/firebase_rest.php';

// For backward compatibility, use the REST helper directly
$firebaseHelper = $firebaseRestHelper;
$firestore = null; // Not used with REST API
$database = null;  // Not used with REST API
?>