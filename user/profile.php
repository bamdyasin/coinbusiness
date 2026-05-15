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

$page_title = "Profile - coinstore.bd";

// Specific CSS for profile (Exactly same as dashboard)
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
        }
        @media (max-width: 576px) {
            body { padding-top: 60px; }
            .app-card { padding: 15px; }
        }
    </style>';

include 'header.php';
?>

<div class="container mt-4">
    <div class="row g-4">
        <!-- Desktop Sidebar -->
        <div class="col-lg-3 sidebar-col">
            <div class="app-card p-3">
                <a href="dashboard.php" class="sidebar-link">
                    <i class="bi bi-speedometer2"></i> ড্যাশবোর্ড
                </a>
                <a href="profile.php" class="sidebar-link active">
                    <i class="bi bi-person-circle"></i> প্রোফাইল
                </a>
                <a href="../referral/index.php" class="sidebar-link">
                    <i class="bi bi-gift"></i> রেফারেল সিস্টেম
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
            
            <!-- User Header Card -->
            <div class="app-card mb-4 text-center">
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['name']); ?>&background=3b82f6&color=fff&size=80" class="rounded-circle shadow mb-3" alt="Avatar">
                <h3 class="fw-bold mb-1"><?php echo $user['name']; ?></h3>
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <?php 
                        // Logic: Paid hole Premium User, nahole Verified User
                        if ($user['payment_status'] == 'Paid') {
                            $display_status = 'Premium User';
                            $status_class = 'bg-warning text-dark';
                            $status_icon = 'bi-star-fill';
                        } else {
                            $display_status = 'Verified User';
                            $status_class = 'bg-success';
                            $status_icon = 'bi-patch-check-fill';
                        }
                    ?>
                    <span class="badge <?php echo $status_class; ?> rounded-pill px-3">
                        <i class="bi <?php echo $status_icon; ?> me-1"></i> <?php echo $display_status; ?>
                    </span> 
                </div>
            </div>

            <!-- Stats Row -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="balance-card h-100">
                        <small class="opacity-75">বর্তমান ব্যালেন্স</small>
                        <h2 class="fw-bold mb-0">৳<?php echo number_format($user['balance'], 2); ?></h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="referral-box h-100">
                        <small class="text-white-50">আপনার রেফার কোড</small>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <h4 class="fw-bold mb-0 text-primary"><?php echo $user['referral_code']; ?></h4>
                            <button class="btn btn-sm btn-dark" onclick="copyRefCode()">Copy</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Details Card -->
            <div class="app-card">
                <h5 class="fw-bold mb-4 border-bottom border-white border-opacity-10 pb-2">একাউন্ট ডিটেইলস</h5>
                <div class="mb-3 d-flex justify-content-between">
                    <span class="text-white-50">ফোন নম্বর</span>
                    <span><?php echo $user['phone']; ?></span>
                </div>
                <div class="mb-3 d-flex justify-content-between">
                    <span class="text-white-50">ইমেইল</span>
                    <span><?php echo !empty($user['email']) ? $user['email'] : 'Not set'; ?></span>
                </div>
                <div class="mb-4 d-flex justify-content-between">
                    <span class="text-white-50">মেম্বারশিপ শুরু</span>
                    <span><?php echo date('d M, Y', strtotime($user['created_at'])); ?></span>
                </div>
                <div class="mb-4 d-flex justify-content-between">
                    <span class="text-white-50">পেমেন্ট স্ট্যাটাস</span>
                    <?php 
                        $pay_status_class = ($user['payment_status'] == 'Paid') ? 'text-success fw-bold' : 'text-danger fw-bold';
                    ?>
                    <span class="<?php echo $pay_status_class; ?>"><?php echo $user['payment_status']; ?></span>
                </div>

                <div class="d-grid mt-4">
                    <a href="logout.php" class="btn btn-outline-danger py-2 rounded-3">লগআউট করুন</a>
                </div>
            </div>

            <!-- Extra spacer for mobile bottom nav -->
            <div class="d-lg-none" style="height: 50px;"></div>
        </div>
    </div>
</div>

<script>
function copyRefCode() {
    var code = "<?php echo $user['referral_code']; ?>";
    navigator.clipboard.writeText(code).then(function() {
        alert("Referral code copied!");
    });
}
</script>

<?php include 'footer.php'; ?>
