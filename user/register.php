<?php
include '../includes/db.php';

session_start();
// If already logged in, redirect to payment
if (isset($_SESSION['user_id'])) {
    header("Location: payment.php");
    exit();
}

$message = "";

// Track referral clicks
$session_ref = isset($_SESSION['ref']) ? $_SESSION['ref'] : '';
$cookie_ref = isset($_COOKIE['ref_code']) ? $_COOKIE['ref_code'] : '';
$url_ref = isset($_GET['ref']) ? $_GET['ref'] : '';

// Priority: URL > Session > Cookie
$active_ref = "";
if (!empty($url_ref)) {
    $active_ref = $url_ref;
} elseif (!empty($session_ref)) {
    $active_ref = $session_ref;
} elseif (!empty($cookie_ref)) {
    $active_ref = $cookie_ref;
}

if (!empty($url_ref)) {
    $ref_code = mysqli_real_escape_string($conn, $url_ref);
    // Check if we already counted this click in this session to prevent spam
    if (!isset($_SESSION['counted_ref_' . $ref_code])) {
        mysqli_query($conn, "UPDATE users SET referral_clicks = referral_clicks + 1 WHERE referral_code = '$ref_code'");
        $_SESSION['counted_ref_' . $ref_code] = true;
        $_SESSION['ref'] = $ref_code; // Sync with session
        setcookie('ref_code', $ref_code, time() + (86400 * 30), "/"); // Sync with cookie
    }
} elseif (!empty($active_ref) && empty($_SESSION['ref'])) {
    $_SESSION['ref'] = $active_ref; // Ensure session is populated from cookie/other
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $ref_by = mysqli_real_escape_string($conn, $_POST['referral_code_input']);

    if ($password !== $confirm_password) {
        $message = "<div class='alert alert-danger'>Password match kare ni!</div>";
    } else {
        // Check if phone already exists
        $check = mysqli_query($conn, "SELECT * FROM users WHERE phone='$phone'");
        if (mysqli_num_rows($check) > 0) {
            $message = "<div class='alert alert-danger'>Ei phone number diye ager ekta account ache!</div>";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Generate unique referral code for this user
            $my_referral_code = strtoupper(substr(md5($phone . time()), 0, 8));

            // Check if referral code is valid
            $referred_by_id = "";
            if (!empty($ref_by)) {
                $ref_check = mysqli_query($conn, "SELECT referral_code FROM users WHERE referral_code='$ref_by'");
                if (mysqli_num_rows($ref_check) > 0) {
                    $referred_by_id = $ref_by;
                    // Commission logic removed from here, should be handled when payment_status becomes 'Paid'
                } else {
                    $message = "<div class='alert alert-warning'>Referral code-ti vul! Tobe account toiri hobe.</div>";
                }
            }

            $sql = "INSERT INTO users (name, phone, email, password, referral_code, referred_by) VALUES ('$name', '$phone', '$email', '$hashed_password', '$my_referral_code', '$referred_by_id')";
            
            if (mysqli_query($conn, $sql)) {
                $message = "<div class='alert alert-success'>Account successfully toiri hoyeche! <a href='login.php' class='text-primary fw-bold'>Login korun</a></div>";
            } else {
                $message = "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
            }
        }
    }
}

$page_title = "Register - coinstore.bd";
$root_path = '../';
include '../includes/header.php';
?>

<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="auth-card">
                    <div class="text-center mb-4">
                        <a href="../all-services.php" class="auth-logo">🚀 CoinStore.bd</a>
                        <h3 class="fw-bold mt-3 text-white">নতুন একাউন্ট</h3>
                        <p class="text-white-50">সঠিক তথ্য দিয়ে একাউন্ট তৈরি করুন</p>
                    </div>

                    <?php echo $message; ?>

                    <form action="register.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white-50">পুরো নাম</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white-50">ফোন নম্বর</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                    <input type="text" name="phone" class="form-control" placeholder="017XXXXXXXX" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white-50">ইমেইল (ঐচ্ছিক)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="example@mail.com">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white-50">রেফার কোড (ঐচ্ছিক)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-gift"></i></span>
                                <input type="text" name="referral_code_input" class="form-control" placeholder="ABC12345" value="<?php echo htmlspecialchars($active_ref); ?>" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white-50">পাসওয়ার্ড</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="******" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white-50">কনফার্ম পাসওয়ার্ড</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                    <input type="password" name="confirm_password" class="form-control" placeholder="******" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-check mb-4">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label text-white-50" for="terms">আমি সকল <a href="#" class="main-color">শর্তাবলী</a> মেনে নিচ্ছি</label>
                        </div>

                        <button type="submit" class="btn btn-main w-100 py-2 fs-5">একাউন্ট তৈরি করুন</button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-white-50">ইতিমধ্যেই একাউন্ট আছে? <a href="login.php" class="main-color text-decoration-none fw-bold">লগইন করুন</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<?php include 'footer.php'; ?> 