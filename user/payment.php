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
    .form-control:focus, .form-select:focus {
        background-color: rgba(255, 255, 255, 0.08);
        border-color: #3b82f6;
        box-shadow: none;
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
                <a href="profile.php" class="sidebar-link">
                    <i class="bi bi-person-circle"></i> প্রোফাইল
                </a>
                <a href="../referral/index.php" class="sidebar-link">
                    <i class="bi bi-gift"></i> রেফারেল সিস্টেম
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
                <div class="mb-4">
                    <h3 class="fw-bold mb-1">পেমেন্ট ভেরিফিকেশন</h3>
                    <p class="text-white-50 mb-0">আপনার পেমেন্ট তথ্য সাবমিট করুন</p>
                </div>

                <?php echo $message; ?>

                <div class="row g-4">
                    <!-- Instructions -->
                    <div class="col-md-6">
                        <div class="app-card h-100">
                            <h5 class="fw-bold mb-4">পেমেন্ট করার নিয়ম</h5>
                            
                            <div class="d-flex mb-3">
                                <div class="step-count">১</div>
                                <p class="small text-white-50">বিকাশ, নগদ অথবা রকেট অ্যাপ থেকে <b>"Send Money"</b> করুন।</p>
                            </div>

                            <div class="d-flex mb-3">
                                <div class="step-count">২</div>
                                <div class="w-100">
                                    <p class="small text-white-50 mb-2">নিচের যেকোনো একটি নম্বরে টাকা পাঠান।</p>
                                    
                                    <div class="method-card">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="small fw-bold text-info">bKash / Nagad</span>
                                            <span class="badge bg-secondary opacity-50" style="font-size: 0.6rem;">Personal</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold">০১৭XXXXXXXX</span>
                                            <button class="btn btn-sm btn-outline-info py-0" onclick="alert('Copied!')" style="font-size: 0.7rem;">Copy</button>
                                        </div>
                                    </div>

                                    <div class="method-card">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="small fw-bold text-info">Rocket</span>
                                            <span class="badge bg-secondary opacity-50" style="font-size: 0.6rem;">Personal</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold">০১৮XXXXXXXX</span>
                                            <button class="btn btn-sm btn-outline-info py-0" onclick="alert('Copied!')" style="font-size: 0.7rem;">Copy</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="step-count">৩</div>
                                <p class="small text-white-50">পেমেন্টের পর TrxID দিয়ে সাবমিট করুন।</p>
                            </div>

                            <div class="mt-4 p-3 bg-primary bg-opacity-10 border border-primary border-opacity-25 rounded-3">
                                <p class="mb-0 small text-primary"><i class="bi bi-info-circle me-1"></i> ভেরিফাই হতে ৫-৩০ মিনিট সময় লাগতে পারে।</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form -->
                    <div class="col-md-6">
                        <div class="app-card h-100">
                            <h5 class="fw-bold mb-4">পেমেন্ট ফর্ম</h5>
                            <form action="payment.php" method="POST">
                                <div class="mb-3">
                                    <label class="small text-white-50 mb-1">পেমেন্ট মাধ্যম</label>
                                    <select class="form-select form-select-sm" name="method" required>
                                        <option value="bKash" selected>বিকাশ (bKash)</option>
                                        <option value="Nagad">নগদ (Nagad)</option>
                                        <option value="Rocket">রকেট (Rocket)</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="small text-white-50 mb-1">আপনার ফোন নম্বর</label>
                                    <input type="text" class="form-control form-control-sm" name="sender_number" placeholder="017XXXXXXXX" required>
                                </div>

                                <div class="mb-4">
                                    <label class="small text-white-50 mb-1">ট্রানজেকশন আইডি (TrxID)</label>
                                    <input type="text" class="form-control form-control-sm" name="trxid" placeholder="8N72KL9X" required>
                                </div>

                                <button type="submit" class="btn btn-main w-100 py-2">
                                    সাবমিট করুন <i class="bi bi-check-circle ms-1"></i>
                                </button>
                            </form>

                            <div class="text-center mt-4">
                                <a href="#" class="text-decoration-none small text-white-50">
                                    <i class="bi bi-whatsapp text-success me-1"></i> সাপোর্টে যোগাযোগ করুন
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

<?php include 'footer.php'; ?>
