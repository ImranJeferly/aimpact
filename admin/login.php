<?php
session_start();
require_once '../config/firebase.php';

if (isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $user['id'];
        header('Location: index.php');
        exit();
    } else {
        $error = 'Invalid credentials';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - AImpact</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="adm-container">
        <div class="adm-login">
            <form method="POST" class="adm-login-form">
                <h2 class="adm-login-title">Admin Login</h2>
                <?php if ($error): ?>
                    <div class="adm-error"><?php echo $error; ?></div>
                <?php endif; ?>
                <div class="adm-form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="adm-input" required>
                </div>
                <div class="adm-form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="adm-input" required>
                </div>
                <button type="submit" class="adm-btn adm-btn-primary adm-login-btn">Login</button>
                <a href="../index.php" class="adm-back-link">Back to Website</a>
            </form>
        </div>
    </div>
</body>
</html>
