<?php
include 'includes/db.php';

echo "<h3>Updating Database Schema...</h3>";

// 1. Add referral_code column
$sql1 = "ALTER TABLE users ADD COLUMN IF NOT EXISTS referral_code VARCHAR(20) UNIQUE AFTER password";
if (mysqli_query($conn, $sql1)) {
    echo "✅ 'referral_code' column checked/added.<br>";
} else {
    echo "❌ Error adding 'referral_code': " . mysqli_error($conn) . "<br>";
}

// 2. Add referred_by column
$sql2 = "ALTER TABLE users ADD COLUMN IF NOT EXISTS referred_by VARCHAR(20) AFTER referral_code";
if (mysqli_query($conn, $sql2)) {
    echo "✅ 'referred_by' column checked/added.<br>";
} else {
    echo "❌ Error adding 'referred_by': " . mysqli_error($conn) . "<br>";
}

// 3. Add balance column
$sql3 = "ALTER TABLE users ADD COLUMN IF NOT EXISTS balance DECIMAL(10,2) DEFAULT 0.00 AFTER referred_by";
if (mysqli_query($conn, $sql3)) {
    echo "✅ 'balance' column checked/added.<br>";
} else {
    echo "❌ Error adding 'balance': " . mysqli_error($conn) . "<br>";
}

// 4. Add referral_clicks column
$sql4 = "ALTER TABLE users ADD COLUMN IF NOT EXISTS referral_clicks INT(11) DEFAULT 0 AFTER balance";
if (mysqli_query($conn, $sql4)) {
    echo "✅ 'referral_clicks' column checked/added.<br>";
} else {
    echo "❌ Error adding 'referral_clicks': " . mysqli_error($conn) . "<br>";
}

// 5. Add status column
$sql5 = "ALTER TABLE users ADD COLUMN IF NOT EXISTS status VARCHAR(50) DEFAULT 'Verified User' AFTER referral_clicks";
if (mysqli_query($conn, $sql5)) {
    echo "✅ 'status' column checked/added.<br>";
} else {
    echo "❌ Error adding 'status': " . mysqli_error($conn) . "<br>";
}

// 6. Add/Modify payment_status column as ENUM
$sql6 = "ALTER TABLE users MODIFY COLUMN payment_status ENUM('Unpaid', 'Paid') DEFAULT 'Unpaid'";
// Note: If column doesn't exist, we should add it first. For safety in this script:
$sql6_check = "ALTER TABLE users ADD COLUMN IF NOT EXISTS payment_status ENUM('Unpaid', 'Paid') DEFAULT 'Unpaid' AFTER status";
mysqli_query($conn, $sql6_check); 

if (mysqli_query($conn, $sql6)) {
    echo "✅ 'payment_status' column set to ENUM('Unpaid', 'Paid').<br>";
} else {
    echo "❌ Error updating 'payment_status': " . mysqli_error($conn) . "<br>";
}

echo "<br><b>Database update sesh!</b> Ekhon Profile page check korun.";

mysqli_close($conn);
?>
