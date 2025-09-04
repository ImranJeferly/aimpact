<?php
session_start();
require_once '../config/firebase.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Fetch submissions
$stmt = $pdo->query("SELECT * FROM submissions ORDER BY submission_date DESC");
$submissions = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - AImpact</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="adm-container">
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
                            <td><?php echo date('Y-m-d H:i', strtotime($submission['submission_date'])); ?></td>
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
</body>
</html>
