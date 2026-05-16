<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['reset_phone'])) {
    header("Location: forgot_password.php");
    exit();
}

$message = "";
$phone = $_SESSION['reset_phone'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp_input = mysqli_real_escape_string($conn, $_POST['otp']);

    // Check OTP in database
    $sql = "SELECT * FROM otp_requests WHERE phone='$phone' AND otp_code='$otp_input' AND status='pending' AND expires_at > NOW() ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Mark OTP as verified
        mysqli_query($conn, "UPDATE otp_requests SET status='verified' WHERE id=".$row['id']);
        $_SESSION['otp_verified'] = true;
        header("Location: reset_password.php");
        exit();
    } else {
        $message = "<div class='alert alert-danger'>Invalid or Expired OTP!</div>";
    }
}

$page_title = "Verify OTP - coinstore.bd";
$root_path = '../';
include '../includes/header.php';
?>

<div class="auth-body">
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="auth-card">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-white">Verify OTP</h3>
                        <p class="text-white-50">Enter the 6-digit code sent to <?php echo $phone; ?></p>
                    </div>

                    <?php echo $message; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label text-white-50">OTP Code</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                <input type="text" name="otp" class="form-control" placeholder="123456" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-main w-100 py-2 fs-5">Verify</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php include 'footer.php'; ?>
