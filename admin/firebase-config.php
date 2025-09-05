<?php
require_once '../config/env.php';

header('Content-Type: application/javascript');
header('Cache-Control: no-cache, must-revalidate');
?>
// Firebase Configuration for Admin Authentication (from environment variables)
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.13.0/firebase-app.js";
import { getAuth, signInWithEmailAndPassword, signOut, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/10.13.0/firebase-auth.js";

// Firebase config loaded from server environment variables
const firebaseConfig = {
    apiKey: "<?php echo $_ENV['FIREBASE_API_KEY']; ?>",
    authDomain: "<?php echo $_ENV['FIREBASE_AUTH_DOMAIN']; ?>",
    databaseURL: "<?php echo $_ENV['FIREBASE_DATABASE_URL']; ?>",
    projectId: "<?php echo $_ENV['FIREBASE_PROJECT_ID']; ?>",
    storageBucket: "<?php echo $_ENV['FIREBASE_STORAGE_BUCKET']; ?>",
    messagingSenderId: "<?php echo $_ENV['FIREBASE_MESSAGING_SENDER_ID']; ?>",
    appId: "<?php echo $_ENV['FIREBASE_APP_ID']; ?>",
    measurementId: "<?php echo $_ENV['FIREBASE_MEASUREMENT_ID']; ?>"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);

// Admin Authentication Functions
window.adminAuth = {
    // Sign in admin user
    signIn: async function(email, password) {
        try {
            const userCredential = await signInWithEmailAndPassword(auth, email, password);
            const user = userCredential.user;
            
            // Get the ID token to verify admin status
            const idToken = await user.getIdToken();
            const idTokenResult = await user.getIdTokenResult();
            
            // Check if user has admin claim
            if (idTokenResult.claims.admin) {
                // Store token for API requests
                sessionStorage.setItem('adminToken', idToken);
                sessionStorage.setItem('adminUser', JSON.stringify({
                    uid: user.uid,
                    email: user.email
                }));
                
                return {
                    success: true,
                    user: user,
                    token: idToken,
                    message: 'Admin login successful'
                };
            } else {
                await signOut(auth);
                throw new Error('Access denied. Admin privileges required.');
            }
        } catch (error) {
            console.error('Admin login error:', error);
            return {
                success: false,
                error: error.message
            };
        }
    },

    // Sign out admin user
    signOut: async function() {
        try {
            await signOut(auth);
            sessionStorage.removeItem('adminToken');
            sessionStorage.removeItem('adminUser');
            return { success: true };
        } catch (error) {
            console.error('Sign out error:', error);
            return { success: false, error: error.message };
        }
    },

    // Check if user is authenticated
    getCurrentUser: function() {
        return auth.currentUser;
    },

    // Listen for authentication state changes
    onAuthStateChanged: function(callback) {
        return onAuthStateChanged(auth, callback);
    },

    // Get current user's ID token
    getIdToken: async function() {
        if (auth.currentUser) {
            const token = await auth.currentUser.getIdToken();
            sessionStorage.setItem('adminToken', token);
            return token;
        }
        return null;
    },

    // Get stored token
    getStoredToken: function() {
        return sessionStorage.getItem('adminToken');
    }
};

// Auto-redirect based on authentication state
window.adminAuth.onAuthStateChanged((user) => {
    const currentPage = window.location.pathname.split('/').pop();
    
    if (user) {
        // User is signed in, check admin claims
        user.getIdTokenResult().then((idTokenResult) => {
            if (idTokenResult.claims.admin) {
                // User is admin
                if (currentPage === 'login.php') {
                    window.location.href = 'index.php';
                }
            } else {
                // User is not admin, sign out
                signOut(auth);
                if (currentPage !== 'login.php') {
                    window.location.href = 'login.php';
                }
            }
        });
    } else {
        // User is signed out
        if (currentPage !== 'login.php') {
            window.location.href = 'login.php';
        }
    }
});