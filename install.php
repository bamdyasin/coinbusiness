<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "coinstorebd";

// 1. Connection to MySQL
$conn = mysqli_connect($host, $user, $pass);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "<h3>CoinStore.bd Database Setup</h3>";

// 2. Create Database
$sql_db = "CREATE DATABASE IF NOT EXISTS $dbname";
if (mysqli_query($conn, $sql_db)) {
    echo "✅ Database '$dbname' ready hoyeche.<br>";
} else {
    echo "❌ Database toiri korte somossya: " . mysqli_error($conn) . "<br>";
}

// 3. Select Database
mysqli_select_db($conn, $dbname);

// 4. Create Users Table (Updated for Referral System)
$sql_table = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(100),
    password VARCHAR(255) NOT NULL,
    referral_code VARCHAR(20) UNIQUE,
    referred_by VARCHAR(20),
    balance DECIMAL(10,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql_table)) {
    echo "✅ 'users' table ready hoyeche.<br>";
} else {
    echo "❌ Table toiri korte somossya: " . mysqli_error($conn) . "<br>";
}

echo "<br><a href='user/register.php'>Registration Page-e jan</a>";

mysqli_close($conn);
?>
