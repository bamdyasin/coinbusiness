<?php
session_start();
include '../includes/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($query);

$page_title = "Premium Files - coinstore.bd";
$show_sidebar = true;
$extra_css = '<link rel="stylesheet" href="assets/css/premiumfiles.css">';

include 'user-header.php';
?>

<h2 class="fw-bold mb-4">প্রিমিয়াম রিসোর্স</h2>

<!-- Training Video Section -->
<div class="app-card mb-4 locked-section">
    <?php if ($user['payment_status'] == 'Unpaid'): ?>
        <div class="lock-overlay">
            <i class="bi bi-lock-fill display-4 text-warning mb-3"></i>
            <h4 class="fw-bold">ভিডিওটি লক করা আছে</h4>
            <p class="text-white-50 px-md-5 small">এই ট্রেনিং ভিডিওটি দেখতে আপনার একাউন্টটি এক্টিভ করুন।</p>
            <a href="payment.php" class="btn btn-warning rounded-pill px-4 fw-bold shadow-sm">একাউন্ট এক্টিভ করুন</a>
        </div>
    <?php endif; ?>

    <div class="<?php echo ($user['payment_status'] == 'Unpaid') ? 'locked-blur' : ''; ?>">
        <h5 class="fw-bold mb-3"><i class="bi bi-play-circle text-primary"></i> ট্রেনিং ভিডিও দেখুন</h5>
        <div class="video-container">
            <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" frameborder="0" allowfullscreen></iframe>
        </div>
        <p class="mt-3 text-white-50 small mb-0">
            ভিডিওটি মনোযোগ দিয়ে দেখে আপনার বিজনেস সেটআপ করুন। যেকোনো সমস্যায় সাপোর্টে যোগাযোগ করুন।
        </p>
    </div>
</div>

<!-- QR Scanner App Card -->
<div class="premium-item-card shadow-lg locked-section">
    <?php if ($user['payment_status'] == 'Unpaid'): ?>
        <div class="lock-overlay">
            <i class="bi bi-lock-fill display-4 text-warning mb-3"></i>
            <h4 class="fw-bold">এই ফাইলটি লক করা আছে</h4>
            <p class="text-white-50 px-md-5">এটি ডাউনলোড করতে আপনার একাউন্টটি প্রিমিয়াম এ আপডেট করুন।</p>
            <a href="payment.php" class="btn btn-warning rounded-pill px-4 fw-bold shadow-sm">একাউন্ট এক্টিভ করুন</a>
        </div>
    <?php endif; ?>

    <div class="<?php echo ($user['payment_status'] == 'Unpaid') ? 'locked-blur' : ''; ?>">
        <div class="d-flex align-items-center gap-3 mb-4">
            <div class="premium-icon-box mb-0">
                <i class="bi bi-qr-code-scan"></i>
            </div>
            <div>
                <h3 class="fw-bold mb-1">Screen QR Scanner</h3>
                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">Mobile & Tablet Support</span>
            </div>
        </div>

        <div class="row g-2 mb-4 text-start">
            <div class="col-12 col-md-6">
                <p class="mb-1 text-white-75 small"><i class="bi bi-check2-circle text-success me-2"></i> স্ক্রিন স্ক্যান করে লিঙ্ক বের করুন</p>
                <p class="mb-1 text-white-75 small"><i class="bi bi-check2-circle text-success me-2"></i> QR কোড থেকে দ্রুত এক্সেস</p>
            </div>
            <div class="col-12 col-md-6">
                <p class="mb-1 text-white-75 small"><i class="bi bi-check2-circle text-success me-2"></i> স্মার্টফোন ও ট্যাবলেটে ব্যবহারযোগ্য</p>
            </div>
        </div>

        <p class="text-white-50 mb-4 small">
            যেকোনো মোবাইলের স্ক্রিন স্ক্যান করে সরাসরি লিঙ্ক জেনারেট করতে এই অ্যাপটি ব্যবহার করুন। এটি মোবাইল এবং ট্যাবলেট উভয় ডিভাইসেই স্মুথলি কাজ করে।
        </p>

        <a href="#" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow-sm w-100 w-md-auto text-center">
            <i class="bi bi-download me-2"></i> এখনই ডাউনলোড করুন
        </a>
    </div>
</div>

<?php include 'user-footer.php'; ?>