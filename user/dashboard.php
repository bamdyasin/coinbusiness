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

// Count total referrals
$my_code = $user['referral_code'];
$ref_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE referred_by='$my_code'");
$ref_data = mysqli_fetch_assoc($ref_query);
$total_referrals = $ref_data['total'];

$page_title = "Dashboard - coinstore.bd";

// Specific CSS for dashboard
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
        }
        .motivation-card {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 20px;
            padding: 30px;
            position: relative;
            overflow: hidden;
        }
        .video-container {
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            background: #000;
        }
        .video-container iframe {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
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
        .balance-card {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 15px;
            padding: 20px;
        }
        .referral-box {
            background: rgba(255, 255, 255, 0.05);
            border: 1px dashed #3b82f6;
            border-radius: 12px;
            padding: 20px;
        }
        @media (max-width: 991px) {
            .sidebar-col { display: none; }
            .motivation-card h2 { font-size: 1.4rem; }
            .motivation-card p { font-size: 0.9rem; }
        }
        @media (max-width: 576px) {
            body { padding-top: 60px; }
            .app-card { padding: 15px; }
            .motivation-card { padding: 20px; }
        }

        /* Locked Section Styles */
        .locked-section {
            position: relative;
            overflow: hidden;
        }
        .locked-blur {
            filter: blur(8px);
            pointer-events: none;
            user-select: none;
            opacity: 0.6;
        }
        .lock-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(15, 23, 42, 0.4);
            z-index: 10;
            border-radius: 20px;
            text-align: center;
            padding: 20px;
        }
    </style>';

include 'header.php';
?>

<div class="container mt-4">
    <div class="row g-4">
        <!-- Desktop Sidebar -->
        <div class="col-lg-3 sidebar-col">
            <div class="app-card p-3">
                <a href="dashboard.php" class="sidebar-link active">
                    <i class="bi bi-speedometer2"></i> ড্যাশবোর্ড
                </a>
                <a href="profile.php" class="sidebar-link">
                    <i class="bi bi-person-circle"></i> প্রোফাইল
                </a>
                <a href="../referral/index.php" class="sidebar-link">
                    <i class="bi bi-gift"></i> এফিলিয়েট সিস্টেম
                </a>
                <a href="payment.php" class="sidebar-link">
                    <i class="bi bi-wallet2"></i> পেমেন্ট হিস্ট্রি
                </a>
                <hr class="border-secondary">
                <a href="logout.php" class="sidebar-link text-danger">
                    <i class="bi bi-box-arrow-right"></i> লগআউট
                </a>
            </div>
            
            <div class="app-card mt-4 <?php echo ($user['payment_status'] == 'Unpaid') ? 'locked-section' : ''; ?>">
                <?php if ($user['payment_status'] == 'Unpaid'): ?>
                    <div class="lock-overlay">
                        <i class="bi bi-lock-fill fs-2 text-warning mb-2"></i>
                        <small class="fw-bold">পেমেন্ট করুন</small>
                    </div>
                <?php endif; ?>
                <div class="<?php echo ($user['payment_status'] == 'Unpaid') ? 'locked-blur' : ''; ?> p-1">
                    <div class="text-center mb-3">
                        <i class="bi bi-qr-code-scan text-primary" style="font-size: 3rem;"></i>
                        <h6 class="fw-bold mt-2 mb-1">Screen QR Scanner</h6>
                        <span class="badge bg-primary bg-opacity-10 text-primary small rounded-pill">Mobile & Tablet Support</span>
                    </div>
                    
                    <div class="text-start mb-3 border-top border-white border-opacity-10 pt-3">
                        <p class="small text-white-75 mb-2" style="font-size: 0.75rem;">
                            <i class="bi bi-check2-circle text-success me-1"></i> স্ক্রিন স্ক্যান করে লিঙ্ক বের করুন
                        </p>
                        <p class="small text-white-75 mb-2" style="font-size: 0.75rem;">
                            <i class="bi bi-check2-circle text-success me-1"></i> QR কোড থেকে দ্রুত এক্সেস
                        </p>
                        <p class="small text-white-75 mb-0" style="font-size: 0.75rem;">
                            <i class="bi bi-check2-circle text-success me-1"></i> স্মার্টফোন ও ট্যাবলেটে ব্যবহারযোগ্য
                        </p>
                    </div>

                    <p class="text-white-50 extra-small mb-3" style="font-size: 0.7rem; line-height: 1.4;">
                        যেকোনো মোবাইলের স্ক্রিন স্ক্যান করে সরাসরি লিঙ্ক জেনারেট করতে এই অ্যাপটি ব্যবহার করুন। এটি মোবাইল এবং ট্যাবলেট উভয় ডিভাইসেই স্মুথলি কাজ করে।
                    </p>

                    <a href="#" class="btn btn-primary btn-sm w-100 rounded-pill py-2 fw-bold shadow-sm">
                        <i class="bi bi-cloud-download me-1"></i> এখনই ডাউনলোড করুন
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            
            <!-- OVERVIEW VIEW -->
            <div class="motivation-card mb-4 shadow">
                <h2 class="fw-bold">সফলতার সিঁড়িতে আপনার প্রথম পদক্ষেপ!</h2>
                <p class="mb-0">আপনার প্রতিদিনের পরিশ্রমই আপনাকে বড় বিজনেসের দিকে নিয়ে যাবে। لگے থাকুন, সফলতা নিশ্চিত।</p>
            </div>

            <!-- Quick Stats -->
            <div class="row g-3 mb-4 text-center">
                <div class="col-6 col-md-4">
                    <div class="app-card h-100 py-3">
                        <h3 class="fw-bold text-primary mb-0">৳<?php echo number_format($user['balance'], 0); ?></h3>
                        <small class="text-white-50">মোট আয়</small>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="app-card h-100 py-3">
                        <h3 class="fw-bold text-primary mb-0"><?php echo $total_referrals; ?></h3>
                        <small class="text-white-50">মোট রেফারেল</small>
                    </div>
                </div>
                <div class="col-12 col-md-4 d-none d-md-block">
                    <div class="app-card h-100 py-3">
                        <?php 
                            if ($user['payment_status'] == 'Paid') {
                                $display_status = 'Premium User';
                                $status_color = 'text-warning';
                            } else {
                                $display_status = 'Verified User';
                                $status_color = 'text-success';
                            }
                        ?>
                        <h3 class="fw-bold <?php echo $status_color; ?> mb-0"><?php echo $display_status; ?></h3>
                        <small class="text-white-50">একাউন্ট স্ট্যাটাস</small>
                    </div>
                </div>
            </div>

            <!-- Video Section -->
            <div class="app-card mb-4 locked-section">
                <?php if ($user['payment_status'] == 'Unpaid'): ?>
                    <div class="lock-overlay">
                        <i class="bi bi-lock-fill display-4 text-warning mb-3"></i>
                        <h4 class="fw-bold text-white">ভিডিওটি লক করা আছে</h4>
                        <p class="text-white-50 mb-3 px-md-5">এই ট্রেনিং ভিডিওটি দেখতে এবং ডাউনলোড করতে আপনার একাউন্টটি এক্টিভ করুন।</p>
                        <a href="payment.php" class="btn btn-warning rounded-pill px-4 fw-bold">একাউন্ট এক্টিভ করুন</a>
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

            <!-- App Download (Mobile only quick link) -->
            <div class="d-lg-none mb-4 locked-section">
                <?php if ($user['payment_status'] == 'Unpaid'): ?>
                    <div class="lock-overlay" style="padding: 10px;">
                        <i class="bi bi-lock-fill text-warning fs-3 mb-2"></i>
                        <h6 class="fw-bold">পেমেন্ট করে অ্যাপ এক্সেস করুন</h6>
                        <a href="payment.php" class="btn btn-warning btn-sm rounded-pill px-3 mt-2 fw-bold">Active Account</a>
                    </div>
                <?php endif; ?>
                
                <div class="app-card border-primary border-opacity-25 <?php echo ($user['payment_status'] == 'Unpaid') ? 'locked-blur' : ''; ?>">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                            <i class="bi bi-qr-code-scan text-primary fs-2"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Screen QR Scanner</h5>
                            <span class="badge bg-primary bg-opacity-10 text-primary small rounded-pill">Mobile & Tablet Support</span>
                        </div>
                    </div>

                    <div class="row g-2 mb-3 text-start">
                        <div class="col-12">
                            <small class="text-white-75 d-block"><i class="bi bi-check2 text-success me-1"></i> স্ক্রিন স্ক্যান করে লিঙ্ক বের করুন</small>
                        </div>
                        <div class="col-12">
                            <small class="text-white-75 d-block"><i class="bi bi-check2 text-success me-1"></i> QR কোড থেকে দ্রুত এক্সেস</small>
                        </div>
                        <div class="col-12">
                            <small class="text-white-75 d-block"><i class="bi bi-check2 text-success me-1"></i> স্মার্টফোন ও ট্যাবলেটে ব্যবহারযোগ্য</small>
                        </div>
                    </div>

                    <p class="text-white-50 small mb-3">যেকোনো মোবাইলের স্ক্রিন স্ক্যান করে সরাসরি লিঙ্ক জেনারেট করতে এই অ্যাপটি ব্যবহার করুন। এটি মোবাইল এবং ট্যাবলেট উভয় ডিভাইসেই স্মুথলি কাজ করে।</p>

                    <a href="#" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm">
                        <i class="bi bi-cloud-download me-2"></i> এখনই ডাউনলোড করুন
                    </a>
                </div>
            </div>

            <!-- Extra spacer for mobile bottom nav -->
            <div class="d-lg-none" style="height: 50px;"></div>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>