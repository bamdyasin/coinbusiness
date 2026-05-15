<?php
session_start();
include '../includes/db.php';

// If already logged in, redirect to payment
if (isset($_SESSION['user_id'])) {
    header("Location: payment.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = mysqli_real_escape_string($conn, $_POST['identifier']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE phone='$identifier' OR email='$identifier'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "<div class='alert alert-danger'>Password vul!</div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>Ei email/phone e kono account nei!</div>";
    }
}

$page_title = "Login - coinstore.bd";
include 'header.php';
?>

<div class="auth-body">
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="auth-card">
                    <div class="text-center mb-4">
                        <a href="../index.php" class="auth-logo">🚀 CoinStore.bd</a>
                        <h3 class="fw-bold mt-3 text-white">লগইন করুন</h3>
                        <p class="text-white-50">আপনার একাউন্টে প্রবেশ করুন</p>
                    </div>

                    <?php echo $message; ?>

                    <form action="login.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label text-white-50">ইমেইল অথবা ফোন</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="identifier" class="form-control" placeholder="example@mail.com" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white-50">পাসওয়ার্ড</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="******" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember">
                                <label class="form-check-label text-white-50" for="remember">মনে রাখুন</label>
                            </div>
                            <a href="forgot_password.php" class="text-decoration-none main-color">পাসওয়ার্ড ভুলে গেছেন?</a>
                        </div>

                        <button type="submit" class="btn btn-main w-100 py-2 fs-5">লগইন</button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-white-50">একাউন্ট নেই? <a href="register.php" class="main-color text-decoration-none fw-bold">নতুন একাউন্ট খুলুন</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<?php include 'footer.php'; ?>
