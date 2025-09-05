<?php
// Firebase Authentication handles access control
require_once '../config/firebase.php';

// Fetch submissions from Firebase
$submissions = [];
if ($firebaseHelper && $firebaseHelper->isConnected()) {
    try {
        $submissions = $firebaseHelper->getAllSubmissions();
    } catch (Exception $e) {
        error_log("Error fetching submissions: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - AImpact</title>
    <link rel="stylesheet" href="css/admin.css">
    <style>
        .loading-spinner { display: none; text-align: center; padding: 50px; }
        .auth-protected { display: none; }
    </style>
</head>
<body>
    <div class="loading-spinner">
        <h2>Loading...</h2>
    </div>
    <div class="adm-container auth-protected">
        <nav class="adm-navbar">
            <h1>AImpact Admin</h1>
            <div class="adm-nav-links">
                <a href="blogs.php" class="adm-btn">Blogs</a>
                <a href="testimonials.php" class="adm-btn">Testimonials</a>
                <a href="../index.php" class="adm-btn">View Site</a>
                <a href="logout.php" class="adm-btn adm-btn-primary">Logout</a>
            </div>
        </nav>
        <div class="adm-content">
            <h2 class="adm-section-title">Form Submissions</h2>
            <div class="adm-table-container">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Business Name</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Tasks</th>
                            <th>Budget</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($submissions as $submission): ?>
                        <tr>
                            <td><?php echo date('Y-m-d H:i', strtotime($submission['created_at'])); ?></td>
                            <td><?php echo htmlspecialchars($submission['business_name']); ?></td>
                            <td><?php echo htmlspecialchars($submission['contact_name']); ?></td>
                            <td><?php echo htmlspecialchars($submission['email']); ?></td>
                            <td><?php echo htmlspecialchars($submission['tasks']); ?></td>
                            <td><?php echo htmlspecialchars($submission['budget']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script type="module" src="firebase-config.php"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loadingSpinner = document.querySelector('.loading-spinner');
            const authProtected = document.querySelector('.auth-protected');
            
            // Show loading initially
            loadingSpinner.style.display = 'block';
            
            // Wait for Firebase auth to initialize
            setTimeout(() => {
                if (window.adminAuth && window.adminAuth.getCurrentUser()) {
                    // User is authenticated, show content
                    loadingSpinner.style.display = 'none';
                    authProtected.style.display = 'block';
                } else {
                    // User not authenticated, redirect to login
                    window.location.href = 'login.php';
                }
            }, 1000);

            // Update logout functionality
            const logoutBtn = document.querySelector('a[href="logout.php"]');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', async (e) => {
                    e.preventDefault();
                    if (window.adminAuth) {
                        await window.adminAuth.signOut();
                        window.location.href = 'login.php';
                    }
                });
            }
        });
    </script>
</body>
</html>
