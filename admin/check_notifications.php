<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    exit(json_encode(['error' => 'Unauthorized']));
}

$pending_premium = mysqli_query($conn, "SELECT COUNT(*) as total FROM premium_requests WHERE status='pending'");
$premium_count = mysqli_fetch_assoc($pending_premium)['total'];

$pending_otp = mysqli_query($conn, "SELECT COUNT(*) as total FROM otp_requests WHERE status='pending'");
$otp_count = mysqli_fetch_assoc($pending_otp)['total'];

echo json_encode([
    'premium' => (int)$premium_count,
    'otp' => (int)$otp_count
]);
