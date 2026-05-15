<?php
// Set Timezone
date_default_timezone_set('Asia/Dhaka');

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "coinstorebd";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set MySQL Timezone
mysqli_query($conn, "SET time_zone = '+06:00'");
?>
