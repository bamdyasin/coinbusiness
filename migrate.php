<?php
include 'includes/db.php';

/**
 * Professional Database Migration Script
 * Consolidates all table creations and schema updates.
 */

echo "<h2>🚀 CoinStore.bd Database Migration</h2>";
echo "<hr>";

// --- 1. Tables Creation ---

$tables = [
    "users" => "CREATE TABLE IF NOT EXISTS users (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        phone VARCHAR(20) NOT NULL UNIQUE,
        email VARCHAR(100),
        password VARCHAR(255) NOT NULL,
        referral_code VARCHAR(20) UNIQUE,
        referred_by VARCHAR(20),
        balance DECIMAL(10,2) DEFAULT 0.00,
        referral_clicks INT(11) DEFAULT 0,
        status VARCHAR(50) DEFAULT 'Verified User',
        payment_status ENUM('Unpaid', 'Paid') DEFAULT 'Unpaid',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    
    "admins" => "CREATE TABLE IF NOT EXISTS admins (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    
    "otp_requests" => "CREATE TABLE IF NOT EXISTS otp_requests (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        phone VARCHAR(20) NOT NULL,
        otp_code VARCHAR(10) NOT NULL,
        status ENUM('pending', 'verified', 'expired') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        expires_at TIMESTAMP NULL
    )",

    "premium_requests" => "CREATE TABLE IF NOT EXISTS premium_requests (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        user_id INT(11) NOT NULL,
        method VARCHAR(50) NOT NULL,
        sender_number VARCHAR(20) NOT NULL,
        trxid VARCHAR(50) NOT NULL UNIQUE,
        status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )",

    "site_settings" => "CREATE TABLE IF NOT EXISTS site_settings (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        setting_key VARCHAR(50) NOT NULL UNIQUE,
        setting_value TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )"
];

foreach ($tables as $name => $sql) {
    if (mysqli_query($conn, $sql)) {
        echo "✅ Table '$name' is ready.<br>";
    } else {
        echo "❌ Error creating table '$name': " . mysqli_error($conn) . "<br>";
    }
}

// --- 2. Schema Updates (ALTER Statements) ---

$alterations = [
    "ALTER TABLE users ADD COLUMN IF NOT EXISTS referral_code VARCHAR(20) UNIQUE AFTER password",
    "ALTER TABLE users ADD COLUMN IF NOT EXISTS referred_by VARCHAR(20) AFTER referral_code",
    "ALTER TABLE users ADD COLUMN IF NOT EXISTS balance DECIMAL(10,2) DEFAULT 0.00 AFTER referred_by",
    "ALTER TABLE users ADD COLUMN IF NOT EXISTS referral_clicks INT(11) DEFAULT 0 AFTER balance",
    "ALTER TABLE users ADD COLUMN IF NOT EXISTS status VARCHAR(50) DEFAULT 'Verified User' AFTER referral_clicks",
    "ALTER TABLE users ADD COLUMN IF NOT EXISTS payment_status ENUM('Unpaid', 'Paid') DEFAULT 'Unpaid' AFTER status"
];

echo "<h3>Updating Columns...</h3>";
foreach ($alterations as $sql) {
    if (mysqli_query($conn, $sql)) {
        // Success (either added or already exists)
    } else {
        echo "⚠️ Alteration failed/already applied: " . mysqli_error($conn) . "<br>";
    }
}
echo "✅ All columns checked/updated.<br>";

// --- 3. Default Settings ---
$default_settings = [
    'bkash_number' => '০১৭XXXXXXXX',
    'bkash_type' => 'Personal',
    'nagad_number' => '০১৭XXXXXXXX',
    'nagad_type' => 'Personal',
    'rocket_number' => '০১৮XXXXXXXX',
    'rocket_type' => 'Personal',
    'payment_instruction' => 'বিকাশ, নগদ অথবা রকেট অ্যাপ থেকে "Send Money" করুন।',
    'whatsapp_support' => 'https://wa.me/8801700000000'
];

echo "<h3>Initializing Settings...</h3>";
foreach ($default_settings as $key => $val) {
    $check_setting = mysqli_query($conn, "SELECT * FROM site_settings WHERE setting_key='$key'");
    if (mysqli_num_rows($check_setting) == 0) {
        mysqli_query($conn, "INSERT INTO site_settings (setting_key, setting_value) VALUES ('$key', '$val')");
        echo "✅ Setting '$key' initialized.<br>";
    }
}

// --- 4. Default Data (Admin) ---

$check_admin = mysqli_query($conn, "SELECT * FROM admins WHERE username='admin'");
if (mysqli_num_rows($check_admin) == 0) {
    $user = 'admin';
    $pass = password_hash('admin123', PASSWORD_DEFAULT);
    $insert_admin = "INSERT INTO admins (username, password) VALUES ('$user', '$pass')";
    if (mysqli_query($conn, $insert_admin)) {
        echo "✨ Default admin created: <b>admin</b> / <b>admin123</b><br>";
    }
} else {
    echo "ℹ️ Default admin already exists.<br>";
}

echo "<hr>";
echo "<b>Migration Complete!</b><br>";
echo "<a href='index.php' class='btn btn-primary'>Go to Home</a> | <a href='admin/login.php'>Admin Login</a>";

mysqli_close($conn);
?>
