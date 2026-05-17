<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['reset_phone']) || !isset($_SESSION['otp_verified'])) {
    header("Location: forgot_password.php");
    exit();
}

$message = "";
$phone = $_SESSION['reset_phone'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    if ($password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_sql = "UPDATE users SET password='$hashed_password' WHERE phone='$phone'";
        if (mysqli_query($conn, $update_sql)) {
            unset($_SESSION['reset_phone']);
            unset($_SESSION['otp_verified']);
            $message = "<div class='alert alert-success'>Password changed successfully! Redirecting to login...</div>";
            header("refresh:3;url=login.php");
        } else {
            $message = "<div class='alert alert-danger'>Error updating password!</div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>Passwords do not match!</div>";
    }
}

$page_title = "Reset Password - coinstore.bd";
include 'user-header.php';
?>

<div class="auth-card shadow-lg">
    <div class="text-center mb-4">
        <h3 class="fw-bold text-white">New Password</h3>
        <p class="text-white-50">Set a strong password for your account</p>
    </div>

    <?php echo $message; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label text-white-50">New Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="******" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label text-white-50">Confirm Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="password" name="confirm_password" class="form-control" placeholder="******" required>
            </div>
        </div>
        <button type="submit" class="btn btn-main w-100 py-2 fs-5">Reset Password</button>
    </form>
</div>

<?php include 'user-footer.php'; ?>