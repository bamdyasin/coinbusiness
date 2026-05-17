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

// Fetch Site Settings
$settings = [];
$s_res = mysqli_query($conn, "SELECT * FROM site_settings");
while ($s_row = mysqli_fetch_assoc($s_res)) {
    $settings[$s_row['setting_key']] = $s_row['setting_value'];
}

$message = "";

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $sender_number = mysqli_real_escape_string($conn, $_POST['sender_number']);
    $trxid = mysqli_real_escape_string($conn, $_POST['trxid']);

    // Check if TrxID already exists
    $check_trx = mysqli_query($conn, "SELECT * FROM premium_requests WHERE trxid='$trxid'");
    if (mysqli_num_rows($check_trx) > 0) {
        $message = "<div class='alert alert-danger'>Ei TrxID-ti diye ager ekta request ache!</div>";
    } else {
        $sql = "INSERT INTO premium_requests (user_id, method, sender_number, trxid) VALUES ('$user_id', '$method', '$sender_number', '$trxid')";
        if (mysqli_query($conn, $sql)) {
            $message = "<div class='alert alert-success'>আপনার পেমেন্ট রিকোয়েস্ট জমা হয়েছে! এডমিন ভেরিফাই করলে আপনার একাউন্ট প্রিমিয়াম হয়ে যাবে।</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
        }
    }
}

$page_title = "Payment - coinstore.bd";

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
    
    /* Payment Specific Styles */
    .step-count {
        width: 25px;
        height: 25px;
        background: #3b82f6;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.8rem;
        flex-shrink: 0;
        margin-right: 12px;
    }
    .method-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 12px;
        margin-bottom: 10px;
    }
    .form-control, .form-select {
        background-color: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff;
    }
    /* Custom Dropdown Arrow */
    .form-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 16 16\'%3e%3cpath fill=\'none\' stroke=\'%233b82f6\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'m2 5 6 6 6-6\'/%3e%3c/svg%3e");
        background-size: 1.2em;
    }
    .form-control:focus, .form-select:focus {
        background-color: rgba(255, 255, 255, 0.08);
        border-color: #3b82f6;
        box-shadow: none;
        color: #fff;
    }
    .form-select option {
        background-color: #1e293b;
        color: #fff;
    }
    .btn-main {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 12px;
    }

    @media (max-width: 991px) {
        .sidebar-col { display: none; }
    }
    @media (max-width: 576px) {
        body { padding-top: 60px; }
        .app-card { padding: 15px; }
    }
</style>
';

$root_path = '../';
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row g-4">
        <!-- Desktop Sidebar -->
        <div class="col-lg-3 sidebar-col">
            <div class="app-card p-3">
                <a href="dashboard.php" class="sidebar-link">
                    <i class="bi bi-speedometer2"></i> ড্যাশবোর্ড
                </a>
                <a href="profile.php" class="sidebar-link">
                    <i class="bi bi-person-circle"></i> প্রোফাইল
                </a>
                <a href="../referral/index.php" class="sidebar-link">
                    <i class="bi bi-gift"></i> এফিলিয়েট সিস্টেম
                </a>
                <a href="premiumfiles.php" class="sidebar-link">
                    <i class="bi bi-cloud-arrow-down"></i> প্রিমিয়াম ফাইল
                </a>
                <a href="../landing/index.php" class="sidebar-link" target="_blank">
                    <i class="bi bi-browser-safari"></i> ল্যান্ডিং পেজ
                </a>
                <a href="payment.php" class="sidebar-link active">
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
            
            <?php if ($user['payment_status'] == 'Paid'): ?>
                <!-- SUCCESS VIEW -->
                <div class="app-card text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                    </div>
                    <h2 class="fw-bold text-success mb-3">পেমেন্ট সফল হয়েছে!</h2>
                    <p class="lead mb-4 px-lg-5">
                        অভিনন্দন! আপনার পেমেন্টটি সফলভাবে ভেরিফাই করা হয়েছে। আপনি এখন আমাদের একজন <span class="text-warning fw-bold">Premium User</span>.
                    </p>
                    
                    <div class="motivation-card mx-auto mb-5 shadow" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 20px; padding: 30px; max-width: 600px;">
                        <h4 class="fw-bold text-white mb-3">"সফলতা মানেই শেষ নয়, ব্যর্থতা মানেই মৃত্যু নয়; আসল হলো এগিয়ে যাওয়ার সাহস ধরে রাখা।"</h4>
                        <p class="mb-0 text-white-50 small">- উইনস্টন চার্চিল</p>
                    </div>

                    <div class="d-flex justify-content-center gap-3">
                        <a href="dashboard.php" class="btn btn-primary rounded-pill px-4">ড্যাশবোর্ডে যান</a>
                        <a href="../referral/index.php" class="btn btn-outline-light rounded-pill px-4">বন্ধুদের রেফার করুন</a>
                    </div>
                </div>

            <?php else: ?>
                <!-- PAYMENT FORM VIEW -->
                <div class="mb-4 text-center">
                    <h3 class="fw-bold mb-1">পেমেন্ট ভেরিফিকেশন</h3>
                    <p class="text-white-50 mb-0">নিচের যেকোনো একটি মাধ্যমে পেমেন্ট করে তথ্য সাবমিট করুন</p>
                </div>

                <?php echo $message; ?>

                <div class="row">
                    <div class="col-lg-7 mx-auto">
                        <div class="app-card shadow-lg">
                            <h5 class="fw-bold mb-4 text-center"><i class="bi bi-wallet2 text-primary me-2"></i> পেমেন্ট ফর্ম</h5>
                            
                            <form action="payment.php" method="POST">
                                <div class="mb-4">
                                    <label class="small text-white-50 mb-2"><i class="bi bi-chevron-right me-1 text-primary"></i> পেমেন্ট মাধ্যম সিলেক্ট করুন</label>
                                    <select class="form-select" name="method" id="method-select" onchange="updatePaymentUI()" required>
                                        <option value="" disabled selected>নির্বাচন করুন</option>
                                        <option value="bKash">বিকাশ (bKash)</option>
                                        <option value="Nagad">নগদ (Nagad)</option>
                                        <option value="Rocket">রকেট (Rocket)</option>
                                    </select>

                                    <!-- Dynamic Detail Area -->
                                    <div id="method-details-box" class="mt-3 p-3 bg-primary bg-opacity-10 rounded-4 border border-primary border-opacity-25 d-none">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <div id="selected-type" class="extra-small text-info fw-bold mb-1" style="font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.5px;">Personal Transfer</div>
                                                <h4 id="display-payment-number" class="fw-bold mb-0 text-white"></h4>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-primary rounded-pill px-3" onclick="copyPaymentNumber()">
                                                <i class="bi bi-clipboard me-1"></i> Copy
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="small text-white-50 mb-2"><i class="bi bi-chevron-right me-1 text-primary"></i> আপনার ফোন নম্বর</label>
                                        <input type="text" class="form-control" name="sender_number" placeholder="যে নাম্বার থেকে টাকা পাঠিয়েছেন..." required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-white-50 mb-2"><i class="bi bi-chevron-right me-1 text-primary"></i> ট্রানজেকশন আইডি (TrxID)</label>
                                        <input type="text" class="form-control" name="trxid" placeholder="8N72KL9X" required>
                                        <div class="extra-small text-white-50 mt-1" style="font-size: 0.7rem;"><i class="bi bi-arrow-return-right me-1"></i> টাকা পাঠানোর পর মেসেজে TrxID পাবেন।</div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-main w-100 py-3 fw-bold fs-6">
                                    পেমেন্ট রিকোয়েস্ট সাবমিট করুন <i class="bi bi-arrow-right-circle ms-2"></i>
                                </button>
                            </form>

                            <div class="text-center mt-4 pt-3 border-top border-white border-opacity-10">
                                <a href="<?php echo $settings['whatsapp_support'] ?? '#'; ?>" target="_blank" class="text-decoration-none small text-white-50">
                                    <i class="bi bi-whatsapp text-success me-1"></i> পেমেন্টে সমস্যা হলে এখানে ক্লিক করুন
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Extra spacer for mobile bottom nav -->
            <div class="d-lg-none" style="height: 50px;"></div>
        </div>
    </div>
</div>

<script>
    const paymentData = {
        'bKash': {
            'number': '<?php echo $settings['bkash_number'] ?? ''; ?>',
            'type': '<?php echo $settings['bkash_type'] ?? 'Personal'; ?>'
        },
        'Nagad': {
            'number': '<?php echo $settings['nagad_number'] ?? ''; ?>',
            'type': '<?php echo $settings['nagad_type'] ?? 'Personal'; ?>'
        },
        'Rocket': {
            'number': '<?php echo $settings['rocket_number'] ?? ''; ?>',
            'type': '<?php echo $settings['rocket_type'] ?? 'Personal'; ?>'
        }
    };

    function updatePaymentUI() {
        const select = document.getElementById('method-select');
        const method = select.value;
        const displayNum = document.getElementById('display-payment-number');
        const displayType = document.getElementById('selected-type');
        const detailsBox = document.getElementById('method-details-box');
        
        if(paymentData[method]) {
            displayNum.innerText = paymentData[method].number || 'Not Set';
            displayType.innerText = paymentData[method].type;
            detailsBox.classList.remove('d-none');
            
            // Subtle animation
            detailsBox.style.animation = 'none';
            detailsBox.offsetHeight; // trigger reflow
            detailsBox.style.animation = 'fadeInUp 0.3s ease-out forwards';
        }
    }

    function copyPaymentNumber() {
        const num = document.getElementById('display-payment-number').innerText;
        navigator.clipboard.writeText(num).then(() => {
            alert('Number Copied: ' + num);
        });
    }
</script>

<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<?php include 'footer.php'; ?>
