<?php
session_start();
include '../includes/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    // Check if user exists
    $check_user = mysqli_query($conn, "SELECT * FROM users WHERE phone='$phone'");
    if (mysqli_num_rows($check_user) > 0) {
        // Generate 6-digit OTP
        $otp = rand(100000, 999999);
        $expires_at = date("Y-m-d H:i:s", strtotime("+10 minutes"));

        // Store OTP in database
        $sql = "INSERT INTO otp_requests (phone, otp_code, status, expires_at) VALUES ('$phone', '$otp', 'pending', '$expires_at')";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['reset_phone'] = $phone;
            // In a real scenario, you would call an SMS API here.
            $message = "<div class='alert alert-success'>OTP has been sent to your phone! Please check your messages.</div>";
            header("refresh:2;url=verify_otp.php");
        } else {
            $message = "<div class='alert alert-danger'>Something went wrong!</div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>No account found with this phone number!</div>";
    }
}

$page_title = "Forgot Password - coinstore.bd";
include 'header.php';
?>

<div class="auth-body">
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="auth-card">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-white">Forgot Password</h3>
                        <p class="text-white-50">Enter your phone number to receive OTP</p>
                    </div>

                    <?php echo $message; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label text-white-50">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                <input type="text" name="phone" class="form-control" placeholder="017XXXXXXXX" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-main w-100 py-2 fs-5">Send OTP</button>
                    </form>

                    <div class="text-center mt-4">
                        <a href="login.php" class="main-color text-decoration-none fw-bold">Back to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php include 'footer.php'; ?>
