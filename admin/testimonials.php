<?php
// Firebase Authentication handles access control
require_once '../config/firebase.php';

// Fetch testimonials from Firebase
$testimonials = [];
if ($firebaseHelper && $firebaseHelper->isConnected()) {
    $testimonials = $firebaseHelper->getAllTestimonials(null); // Get all testimonials including pending
} else {
    $testimonials = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Testimonials - AImpact</title>
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
            <h1>Manage Testimonials</h1>
            <div class="adm-nav-links">
                <button onclick="showAddForm()" class="adm-btn">Add New Testimonial</button>
                <a href="index.php" class="adm-btn">Dashboard</a>
                <a href="logout.php" class="adm-btn adm-btn-primary">Logout</a>
            </div>
        </nav>

        <div class="admin-content">
            <!-- Add/Edit Form -->
            <div id="testimonialForm" class="adm-form" style="display: none;">
                <form id="saveTestimonialForm" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="testimonial_id">
                    
                    <div class="adm-form-group">
                        <label>Client Name:</label>
                        <input type="text" name="client_name" class="adm-input" required>
                    </div>

                    <div class="adm-form-group">
                        <label>Company:</label>
                        <input type="text" name="company_name" class="adm-input">
                    </div>

                    <div class="adm-form-group">
                        <label>Position:</label>
                        <input type="text" name="position" class="adm-input">
                    </div>

                    <div class="adm-form-group">
                        <label>Content:</label>
                        <textarea name="content" class="adm-editor" required></textarea>
                    </div>

                    <div class="adm-form-group">
                        <label>Rating:</label>
                        <select name="rating" class="adm-select" required>
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?> Stars</option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="adm-form-group">
                        <label>Client Photo:</label>
                        <input type="file" name="image" accept="image/*" class="adm-input">
                    </div>

                    <div class="adm-form-group">
                        <label class="adm-checkbox-label">
                            <input type="checkbox" name="featured" value="1">
                            Featured Testimonial
                        </label>
                    </div>

                    <button type="submit" class="adm-btn adm-btn-primary">Save Testimonial</button>
                    <button type="button" onclick="hideForm()" class="adm-btn">Cancel</button>
                </form>
            </div>

            <!-- Testimonials List -->
            <div class="adm-table-container">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Company</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($testimonials as $testimonial): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($testimonial['client_name']); ?></td>
                            <td><?php echo htmlspecialchars($testimonial['company_name']); ?></td>
                            <td><span class="adm-rating"><?php echo str_repeat('★', $testimonial['rating']); ?></span></td>
                            <td><span class="adm-status adm-status-<?php echo $testimonial['status']; ?>"><?php echo ucfirst($testimonial['status']); ?></span></td>
                            <td><?php echo $testimonial['featured'] ? '<span class="adm-status adm-status-published">Yes</span>' : 'No'; ?></td>
                            <td>
                                <div class="adm-action-buttons">
                                    <button onclick="editTestimonial(<?php echo $testimonial['id']; ?>)" class="adm-btn-edit">Edit</button>
                                    <button onclick="deleteTestimonial(<?php echo $testimonial['id']; ?>)" class="adm-btn-delete">Delete</button>
                                    <?php if($testimonial['status'] === 'pending'): ?>
                                        <button onclick="approveTestimonial(<?php echo $testimonial['id']; ?>)" class="adm-btn-approve">Approve</button>
                                    <?php endif; ?>
                                    <a href="../testimonials.php#testimonial-<?php echo $testimonial['id']; ?>" target="_blank" class="adm-btn-view">View</a>
                                </div>
                            </td>
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
    <script src="js/admin.js"></script>
    <script src="js/firebase-admin.js"></script>
</body>
</html>