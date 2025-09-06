<?php
require_once '../config/env.php';

echo "<h2>Firebase Environment Variables Debug</h2>";
echo "<pre>";
echo "FIREBASE_API_KEY: " . ($_ENV['FIREBASE_API_KEY'] ?? 'NOT SET') . "\n";
echo "FIREBASE_AUTH_DOMAIN: " . ($_ENV['FIREBASE_AUTH_DOMAIN'] ?? 'NOT SET') . "\n";
echo "FIREBASE_DATABASE_URL: " . ($_ENV['FIREBASE_DATABASE_URL'] ?? 'NOT SET') . "\n";
echo "FIREBASE_PROJECT_ID: " . ($_ENV['FIREBASE_PROJECT_ID'] ?? 'NOT SET') . "\n";
echo "FIREBASE_STORAGE_BUCKET: " . ($_ENV['FIREBASE_STORAGE_BUCKET'] ?? 'NOT SET') . "\n";
echo "FIREBASE_MESSAGING_SENDER_ID: " . ($_ENV['FIREBASE_MESSAGING_SENDER_ID'] ?? 'NOT SET') . "\n";
echo "FIREBASE_APP_ID: " . ($_ENV['FIREBASE_APP_ID'] ?? 'NOT SET') . "\n";
echo "FIREBASE_MEASUREMENT_ID: " . ($_ENV['FIREBASE_MEASUREMENT_ID'] ?? 'NOT SET') . "\n";
echo "</pre>";

echo "<h3>Generated JavaScript Config:</h3>";
echo "<pre>";
?>
const firebaseConfig = {
    apiKey: "<?php echo $_ENV['FIREBASE_API_KEY'] ?? 'undefined'; ?>",
    authDomain: "<?php echo $_ENV['FIREBASE_AUTH_DOMAIN'] ?? 'undefined'; ?>",
    databaseURL: "<?php echo $_ENV['FIREBASE_DATABASE_URL'] ?? 'undefined'; ?>",
    projectId: "<?php echo $_ENV['FIREBASE_PROJECT_ID'] ?? 'undefined'; ?>",
    storageBucket: "<?php echo $_ENV['FIREBASE_STORAGE_BUCKET'] ?? 'undefined'; ?>",
    messagingSenderId: "<?php echo $_ENV['FIREBASE_MESSAGING_SENDER_ID'] ?? 'undefined'; ?>",
    appId: "<?php echo $_ENV['FIREBASE_APP_ID'] ?? 'undefined'; ?>",
    measurementId: "<?php echo $_ENV['FIREBASE_MEASUREMENT_ID'] ?? 'undefined'; ?>"
};
<?php
echo "</pre>";
?>