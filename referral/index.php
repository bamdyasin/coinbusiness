<?php
session_start();
include '../includes/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($query);

// Base URL construction (dynamic)
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$script_path = $_SERVER['PHP_SELF'];
$base_dir = str_replace('/referral/index.php', '', $script_path);
$full_base_url = $protocol . "://" . $host . $base_dir;

// Count total referrals
$my_code = $user['referral_code'];
$ref_query = mysqli_query($conn, "SELECT * FROM users WHERE referred_by='$my_code' ORDER BY created_at DESC");
$total_referrals = mysqli_num_rows($ref_query);

// Count paid referrals for bonus calculation
$paid_ref_query = mysqli_query($conn, "SELECT COUNT(*) as paid_total FROM users WHERE referred_by='$my_code' AND payment_status='Paid'");
$paid_data = mysqli_fetch_assoc($paid_ref_query);
$earned_bonus = $paid_data['paid_total'] * 50;

$page_title = "Affiliate Program - CoinStore.bd";

// Styling aligned with Dashboard
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
    
    /* Affiliate Specific Styles */
    .promo-banner {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border-radius: 24px;
        padding: 30px;
        margin-bottom: 30px;
    }
    .stat-box {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 15px;
        padding: 20px;
        text-align: center;
    }
    .ref-link-container {
        background: rgba(15, 23, 42, 0.5);
        border: 1px solid #3b82f6;
        border-radius: 16px;
        padding: 10px 10px 10px 20px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .ref-link-text {
        color: #3b82f6;
        font-family: monospace;
        font-size: 1rem;
        flex-grow: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .copy-btn {
        background: #3b82f6;
        border: none;
        border-radius: 12px;
        color: white;
        padding: 8px 20px;
        font-weight: 600;
        transition: 0.3s;
    }
    .table-custom {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
    }
    .table-custom tr {
        background: rgba(255, 255, 255, 0.03);
    }
    .table-custom td, .table-custom th {
        padding: 15px;
        vertical-align: middle;
    }
    .user-avatar {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        background: #3b82f6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    @media (max-width: 991px) {
        .sidebar-col { display: none; }
    }
    @media (max-width: 576px) {
        body { padding-top: 60px; }
        .app-card { padding: 15px; }
        .promo-banner h2 { font-size: 1.5rem; }
        .ref-link-text { font-size: 0.8rem; }
    }
</style>
';

include '../user/header.php';
?>

<div class="container mt-4">
    <div class="row g-4">
        <!-- Desktop Sidebar -->
        <div class="col-lg-3 sidebar-col">
            <div class="app-card p-3">
                <a href="../user/dashboard.php" class="sidebar-link">
                    <i class="bi bi-speedometer2"></i> ড্যাশবোর্ড
                </a>
                <a href="../user/profile.php" class="sidebar-link">
                    <i class="bi bi-person-circle"></i> প্রোফাইল
                </a>
                <a href="index.php" class="sidebar-link active">
                    <i class="bi bi-gift"></i> এফিলিয়েট সিস্টেম
                </a>
                <a href="../user/premiumfiles.php" class="sidebar-link">
                    <i class="bi bi-cloud-arrow-down"></i> প্রিমিয়াম ফাইল
                </a>
                <a href="../user/landingpage.php" class="sidebar-link" target="_blank">
                    <i class="bi bi-browser-safari"></i> ল্যান্ডিং পেজ
                </a>
                <a href="../user/payment.php" class="sidebar-link">
                    <i class="bi bi-wallet2"></i> পেমেন্ট হিস্ট্রি
                </a>
                <hr class="border-secondary">
                <a href="../user/logout.php" class="sidebar-link text-danger">
                    <i class="bi bi-box-arrow-right"></i> লগআউট
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            
            <!-- Header (Titles only, no button) -->
            <div class="mb-4">
                <h3 class="fw-bold mb-1">এফিলিয়েট প্রোগ্রাম</h3>
                <p class="text-white-50 mb-0">বন্ধুদের আমন্ত্রণ জানান এবং ইনকাম করুন</p>
            </div>

            <!-- Promo Banner -->
            <div class="promo-banner shadow-lg">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="fw-bold mb-3">প্রতি সফল রেফারে পান <span class="text-warning">৳৫০</span></h2>
                        <p class="text-white-80 mb-4 small">আপনার নেটওয়ার্ক ব্যবহার করে আয় বাড়ান। কোনো লিমিট নেই!</p>
                        <div class="d-flex gap-2">
                            <button class="btn btn-light btn-sm rounded-pill px-3 fw-bold text-primary copy-btn-banner" onclick="copyRefLink(this)">লিংক কপি</button>
                            <a href="https://wa.me/?text=Hi, join CoinStore.bd! Link: <?php echo $full_base_url; ?>/landing/landingpage.php?ref=<?php echo $user['referral_code']; ?>" target="_blank" class="btn btn-success btn-sm rounded-pill px-3 fw-bold">
                                <i class="bi bi-whatsapp me-1"></i>শেয়ার
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 d-none d-md-block text-center">
                        <i class="bi bi-gift-fill" style="font-size: 80px; opacity: 0.2;"></i>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="row g-3 mb-4 text-center">
                <div class="col-6 col-md-3">
                    <div class="app-card py-3">
                        <h3 class="fw-bold text-primary mb-0"><?php echo $total_referrals; ?></h3>
                        <small class="text-white-50">মোট রেফারেল</small>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="app-card py-3">
                        <h3 class="fw-bold text-info mb-0"><?php echo $paid_data['paid_total']; ?></h3>
                        <small class="text-white-50">এক্টিভ রেফারেল</small>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="app-card py-3">
                        <h3 class="fw-bold text-success mb-0">৳<?php echo number_format($earned_bonus, 0); ?></h3>
                        <small class="text-white-50">অর্জিত বোনাস</small>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="app-card py-3">
                        <h3 class="fw-bold text-warning mb-0"><?php echo number_format($user['referral_clicks'], 0); ?></h3>
                        <small class="text-white-50">লিংক ক্লিক</small>
                    </div>
                </div>
            </div>

            <!-- Link Box -->
            <div class="app-card mb-4">
                <h6 class="fw-bold mb-3">আপনার রেফারেল লিংক</h6>
                <div class="ref-link-container" style="cursor: pointer;" onclick="copyRefLink(this.querySelector('.copy-btn'))">
                    <span class="ref-link-text" id="refLinkText"><?php echo $full_base_url; ?>/landing/landingpage.php?ref=<?php echo $user['referral_code']; ?></span>
                    <button class="copy-btn btn-sm">
                        <i class="bi bi-copy"></i>
                    </button>
                </div>
                <small class="text-white-50 mt-2 d-block"><i class="bi bi-info-circle me-1"></i> বক্সে ক্লিক করে লিংক কপি করুন</small>
            </div>

            <!-- List -->
            <div class="app-card">
                <h6 class="fw-bold mb-3">সাম্প্রতিক রেফারেল</h6>
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr class="text-white-50 small">
                                <th>ইউজার</th>
                                <th>তারিখ</th>
                                <th>বোনাস</th>
                                <th>স্ট্যাটাস</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($total_referrals > 0): ?>
                                <?php mysqli_data_seek($ref_query, 0); while($row = mysqli_fetch_assoc($ref_query)): ?>
                                <tr class="small">
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="user-avatar"><?php echo strtoupper(substr($row['name'], 0, 1)); ?></div>
                                            <span><?php echo $row['name']; ?></span>
                                        </div>
                                    </td>
                                    <td><?php echo date('d M', strtotime($row['created_at'])); ?></td>
                                    <td>
                                        <?php if($row['payment_status'] == 'Paid'): ?>
                                            <span class="text-success fw-bold">৳৫০</span>
                                        <?php else: ?>
                                            <span class="text-white-50">৳৫০ (Pending)</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($row['payment_status'] == 'Paid'): ?>
                                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">সফল</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2">পেন্ডিং</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-white-50">এখনো কোনো রেফারেল নেই।</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Extra spacer for mobile bottom nav -->
            <div class="d-lg-none" style="height: 50px;"></div>
        </div>
    </div>
</div>

<script>
function copyRefLink(btnElement) {
    var copyText = document.getElementById("refLinkText").innerText;
    
    // Create a temporary textarea for better mobile compatibility if navigator.clipboard fails
    const textArea = document.createElement("textarea");
    textArea.value = copyText;
    document.body.appendChild(textArea);
    textArea.select();
    
    try {
        document.execCommand('copy');
        showFeedback(btnElement);
    } catch (err) {
        // Fallback to navigator.clipboard if execCommand fails
        navigator.clipboard.writeText(copyText).then(function() {
            showFeedback(btnElement);
        });
    }
    document.body.removeChild(textArea);
}

function showFeedback(btnElement) {
    const originalHtml = btnElement.innerHTML;
    const originalPadding = btnElement.style.padding;
    
    if (btnElement.classList.contains('copy-btn-banner')) {
        btnElement.innerText = "Copied!";
    } else {
        btnElement.innerHTML = '<i class="bi bi-check2"></i> Copied!';
        btnElement.style.background = "#10b981";
        btnElement.style.padding = "8px 15px";
    }
    
    setTimeout(() => {
        btnElement.innerHTML = originalHtml;
        btnElement.style.padding = originalPadding;
        if (!btnElement.classList.contains('copy-btn-banner')) {
            btnElement.style.background = "#3b82f6";
        }
    }, 2000);
}
</script>

<?php include '../user/footer.php'; ?>
