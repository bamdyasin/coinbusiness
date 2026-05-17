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

// Styles
$extra_css = '
    <style>
        body {
            background-color: #0f172a;
            color: white;
            padding-bottom: 80px; 
            padding-top: 70px;
        }
        .app-card {
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 25px;
            backdrop-filter: blur(10px);
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-radius: 12px;
            margin-bottom: 5px;
            transition: 0.3s;
        }
        .sidebar-link:hover, .sidebar-link.active {
            background: rgba(59, 130, 246, 0.15);
            color: #3b82f6;
        }
        .sidebar-link i { margin-right: 15px; font-size: 1.2rem; }

        /* Premium Item Design */
        .premium-item-card {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.9) 0%, rgba(15, 23, 42, 0.9) 100%);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 24px;
            padding: 30px;
            position: relative;
            overflow: hidden;
        }
        .premium-icon-box {
            width: 80px; height: 80px;
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 2.5rem;
            margin-bottom: 20px;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .video-container {
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            background: #000;
        }
        .video-container iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }

        .locked-section { position: relative; overflow: hidden; }
        .locked-blur { filter: blur(10px); pointer-events: none; user-select: none; opacity: 0.5; }
        .lock-overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            background: rgba(15, 23, 42, 0.5); z-index: 10; border-radius: 24px; text-align: center; padding: 20px;
        }

        @media (max-width: 991px) { .sidebar-col { display: none; } }
    </style>';

$root_path = '../';
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-lg-3 sidebar-col">
            <div class="app-card p-3 shadow">
                <a href="dashboard.php" class="sidebar-link">
                    <i class="bi bi-speedometer2"></i> ড্যাশবোর্ড
                </a>
                <a href="profile.php" class="sidebar-link">
                    <i class="bi bi-person-circle"></i> প্রোফাইল
                </a>
                <a href="../referral/index.php" class="sidebar-link">
                    <i class="bi bi-gift"></i> এফিলিয়েট সিস্টেম
                </a>
                <a href="premiumfiles.php" class="sidebar-link active">
                    <i class="bi bi-cloud-arrow-down"></i> প্রিমিয়াম ফাইল
                </a>
                <a href="../landing/index.php" class="sidebar-link" target="_blank">
                    <i class="bi bi-browser-safari"></i> ল্যান্ডিং পেজ
                </a>
                <a href="payment.php" class="sidebar-link">
                    <i class="bi bi-wallet2"></i> পেমেন্ট হিস্ট্রি
                </a>
                <hr class="border-secondary">
                <a href="logout.php" class="sidebar-link text-danger">
                    <i class="bi bi-box-arrow-right"></i> লগআউট
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <h2 class="fw-bold mb-4">প্রিমিয়াম রিসোর্স</h2>

            <!-- Training Video Section (Moved to Top) -->
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
                    <!-- App Header: Side by Side -->
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

            <!-- Extra spacer for mobile bottom nav -->
            <div class="d-lg-none" style="height: 50px;"></div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
