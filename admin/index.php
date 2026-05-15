<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$page_title = "Admin Dashboard - CoinStore.bd";
include 'header.php';
?>

<!-- Welcome Banner -->
<div class="motivation-card shadow">
    <h3 class="fw-bold text-white mb-2">এডমিন ড্যাশবোর্ডে স্বাগতম!</h3>
    <p class="mb-0 text-white-50">এখান থেকে আপনি ইউজার, পেমেন্ট এবং ওটিপি রিকোয়েস্টগুলো ম্যানেজ করতে পারবেন।</p>
</div>

<!-- Quick Stats -->
<div class="row g-3 mb-4 text-center">
    <div class="col-6 col-md-4">
        <div class="app-card py-3">
            <?php 
                $u_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
                $u_total = ($u_res) ? mysqli_fetch_assoc($u_res)['total'] : 0;
            ?>
            <h3 class="fw-bold text-primary mb-0"><?php echo $u_total; ?></h3>
            <small class="text-white-50">মোট ইউজার</small>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <a href="premium_requests.php" class="text-decoration-none">
            <div class="app-card py-3">
                <?php 
                    $p_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM premium_requests WHERE status='pending'");
                    $p_total = ($p_res) ? mysqli_fetch_assoc($p_res)['total'] : 0;
                ?>
                <h3 class="fw-bold text-warning mb-0"><?php echo $p_total; ?></h3>
                <small class="text-white-50">পেন্ডিং পেমেন্ট</small>
            </div>
        </a>
    </div>
    <div class="col-12 col-md-4">
        <a href="otp_requests.php" class="text-decoration-none">
            <div class="app-card py-3">
                <?php 
                    $o_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM otp_requests WHERE status='pending'");
                    $o_total = ($o_res) ? mysqli_fetch_assoc($o_res)['total'] : 0;
                ?>
                <h3 class="fw-bold text-info mb-0"><?php echo $o_total; ?></h3>
                <small class="text-white-50">পেন্ডিং ওটিপি</small>
            </div>
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="app-card h-100">
            <h5 class="fw-bold mb-3"><i class="bi bi-star-fill text-warning me-2"></i> Membership</h5>
            <p class="text-white-50 small mb-4">View and manage all premium upgrade requests from users.</p>
            <a href="premium_requests.php" class="btn btn-primary rounded-pill w-100 fw-bold">Manage Requests</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="app-card h-100">
            <h5 class="fw-bold mb-3"><i class="bi bi-shield-lock-fill text-info me-2"></i> OTP Requests</h5>
            <p class="text-white-50 small mb-4">Monitor recent OTP generation and verification activities.</p>
            <a href="otp_requests.php" class="btn btn-info text-white rounded-pill w-100 fw-bold">Monitor OTPs</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="app-card h-100">
            <h5 class="fw-bold mb-3"><i class="bi bi-gear-fill text-secondary me-2"></i> Course Payment</h5>
            <p class="text-white-50 small mb-4">Update payment numbers, instructions, and support links.</p>
            <a href="settings.php" class="btn btn-secondary text-white rounded-pill w-100 fw-bold">Open Settings</a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>