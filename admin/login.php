<?php
// Firebase Authentication handles login now
// No server-side session needed
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - AImpact</title>
    <link rel="stylesheet" href="css/admin.css">
    <style>
        .loading { display: none; }
        .error-message { color: #dc3545; background: #f8d7da; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .success-message { color: #155724; background: #d4edda; padding: 10px; border-radius: 5px; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="adm-container">
        <div class="adm-login">
            <form id="loginForm" class="adm-login-form">
                <h2 class="adm-login-title">Admin Login</h2>
                <div id="loginMessage"></div>
                <div class="adm-form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="adm-input" required placeholder="admin@aimpact.com">
                </div>
                <div class="adm-form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="adm-input" required>
                </div>
                <button type="submit" class="adm-btn adm-btn-primary adm-login-btn">
                    <span id="loginText">Login</span>
                    <span id="loginLoading" class="loading">Logging in...</span>
                </button>
                <a href="../index.php" class="adm-back-link">Back to Website</a>
            </form>
        </div>
    </div>

    <script type="module" src="firebase-config.php"></script>
    <script>
        // Wait for Firebase config to load
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const messageDiv = document.getElementById('loginMessage');
            const loginText = document.getElementById('loginText');
            const loginLoading = document.getElementById('loginLoading');
            
            // Show loading state
            loginText.style.display = 'none';
            loginLoading.style.display = 'inline';
            
            try {
                const result = await window.adminAuth.signIn(email, password);
                
                if (result.success) {
                    messageDiv.innerHTML = '<div class="success-message">Login successful! Redirecting...</div>';
                    setTimeout(() => {
                        window.location.href = 'index.php';
                    }, 1000);
                } else {
                    throw new Error(result.error);
                }
            } catch (error) {
                messageDiv.innerHTML = `<div class="error-message">${error.message}</div>`;
            } finally {
                // Reset loading state
                loginText.style.display = 'inline';
                loginLoading.style.display = 'none';
            }
            });
        });
    </script>
</body>
</html>
