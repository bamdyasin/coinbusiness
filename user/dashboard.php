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

// Redirect to Premium Files if already paid
if ($user['payment_status'] == 'Paid') {
    header("Location: premiumfiles.php");
    exit();
}

$page_title = "Dashboard - coinstore.bd";
$show_sidebar = true;
$extra_css = '<link rel="stylesheet" href="assets/css/dashboard-home.css">';

include 'user-header.php';
?>

<!-- HERO SECTION -->
<div class="hero-box shadow">
    <div class="row align-items-center">
        <div class="col-lg-7">
            <h1>মাত্র ৩০০০ টাকায় শুরু করুন <span>অনলাইন বিজনেস</span></h1>
            <p class="text-white-50">২৫% পর্যন্ত প্রফিট, ৮০%+ রিপিট কাস্টমার এবং যেকোনো জায়গা থেকে ব্যবসা পরিচালনার সুযোগ।</p>
            
            <div class="stats-card mt-3 mb-4">
                <div class="row g-2 text-center">
                    <div class="col-4"><div class="stats-item"><h3>২৫%</h3><p>নিট-প্রফিট</p></div></div>
                    <div class="col-4"><div class="stats-item"><h3>৮০%+</h3><p>রিপিট-Sell</p></div></div>
                    <div class="col-4"><div class="stats-item"><h3>৩০০০৳</h3><p>স্বল্প-পুজি</p></div></div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4 flex-wrap">
                <a href="payment.php" class="btn btn-primary rounded-pill px-4 py-2 fw-bold">🔥 এখনই এনরোল করুন</a>
                <a href="#course-details" class="btn btn-outline-light rounded-pill px-4 py-2 fw-bold">▶ ভিডিও দেখুন</a>
            </div>
        </div>
        <div class="col-lg-5 text-center mt-4 mt-lg-0">
            <div class="hero-card-img mx-auto" style="max-width: 400px;">
                <img src="images.jpg" alt="Business">
                <div class="floating-badge-dark">
                    <small class="text-white-50" style="font-size: 0.7rem; display: block; text-transform: uppercase; font-weight: 700;">Net Profit</small>
                    <h4>25%</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FEATURES CARD -->
<div class="app-card shadow-sm mb-4">
    <div class="section-title-box"><h2>কেন এই বিজনেস শুরু করবেন?</h2></div>
    <div class="list-item-row">
        <div class="feature-icon-circle"><i class="bi bi-clock-history"></i></div>
        <div class="feature-text-box">
            <h6>Long Term Business</h6>
            <p>দীর্ঘ সময় ধরে ব্যবসা পরিচালনা করা সম্ভব।</p>
        </div>
    </div>
    <div class="list-item-row">
        <div class="feature-icon-circle"><i class="bi bi-people-fill"></i></div>
        <div class="feature-text-box">
            <h6>Repeat Customer</h6>
            <p>৮০%+ কাস্টমার বারবার অর্ডার করে।</p>
        </div>
    </div>
    <div class="list-item-row">
        <div class="feature-icon-circle"><i class="bi bi-wallet2"></i></div>
        <div class="feature-text-box">
            <h6>Low Investment</h6>
            <p>মাত্র ৩০০০ টাকা দিয়েই শুরু করা সম্ভব।</p>
        </div>
    </div>
    <div class="list-item-row">
        <div class="feature-icon-circle"><i class="bi bi-phone-fill"></i></div>
        <div class="feature-text-box">
            <h6>Work Anywhere</h6>
            <p>শুধু মোবাইল দিয়েই ব্যবসা পরিচালনা সম্ভব।</p>
        </div>
    </div>
</div>

<!-- PACKAGES CARD -->
<div class="app-card shadow-sm mb-4">
    <div class="section-title-box"><h2>এই ৩০০০ টাকায় কী কী পাচ্ছেন?</h2></div>
    <div class="list-item-row">
        <div class="feature-icon-circle"><img src="https://cdn-icons-png.flaticon.com/512/196/196578.png"></div>
        <div class="feature-text-box">
            <h6>Visa Card</h6>
            <span class="package-price">10 USD = 1300 টাকা</span>
            <p class="package-details-text d-none d-lg-block">যা ব্যাংকের মাধ্যমে করতে পাসপোর্টসহ ১০–১২ হাজার টাকা লাগতে পারে।</p>
        </div>
    </div>
    <div class="list-item-row">
        <div class="feature-icon-circle"><img src="https://cdn-icons-png.flaticon.com/512/2489/2489756.png"></div>
        <div class="feature-text-box">
            <h6>Account Balance</h6>
            <span class="package-price">5.5 USD = 700 টাকা</span>
            <p class="package-details-text d-none d-lg-block">এটা আপনার একাউন্ট এ থাকবে এবং এটাই আপনার বিজনেসের পুজি।</p>
        </div>
    </div>
    <div class="list-item-row">
        <div class="feature-icon-circle"><img src="https://cdn-icons-png.flaticon.com/512/226/226770.png"></div>
        <div class="feature-text-box">
            <h6>Android App</h6>
            <span class="package-price">প্রিমিয়াম প্রাইস = 1000 টাকা।</span>
            <p class="package-details-text d-none d-lg-block">এটা কম্পিউটার এর বিকল্প হিসেবে কাজ করবে, যেকোনো জায়গা থেকে কাজ করতে পারবেন।</p>
        </div>
    </div>
    <div class="list-item-row">
        <div class="feature-icon-circle"><img src="https://cdn-icons-png.flaticon.com/512/1006/1006771.png"></div>
        <div class="feature-text-box">
            <h6>Website Code</h6>
            <span class="package-price">সম্পূর্ণ FREE Website Code</span>
            <p class="package-details-text d-none d-lg-block">কাস্টমার বাড়লে ওয়েবসাইট থাকলে ভালো এবং বিসনেস বড় করা সহজ হয় ।</p>
        </div>
    </div>
</div>

<!-- COURSE & REFUND -->
<div id="course-details" class="course-box-dark mt-5">
    <div class="row align-items-center g-4">
        <div class="col-lg-7">
            <h3 class="fw-bold mb-4">কোর্সে যা যা থাকছে</h3>
            <ul class="course-list-dark list-unstyled mb-0">
                <li>✅ Full Video Tutorial</li>
                <li>✅ Business Setup Guide</li>
                <li>✅ Android App Setup</li>
                <li>✅ Customer Handling System</li>
                <li>✅ Support & Guidance</li> 
            </ul>
        </div>
        <div class="col-lg-5">
            <div class="refund-card-dark text-center">
                <h4 class="fw-bold mb-3">Refund Guarantee <i class="bi bi-patch-check-fill text-primary"></i></h4>
                <p class="refund-text">Business Details দেখার পর Interested না হলে সম্পূর্ণ টাকা Refund করে দেওয়া হবে।</p>
                <a href="payment.php" class="btn btn-primary rounded-pill w-100 fw-bold py-2 mt-2">এখনই শুরু করুন</a>
            </div>
        </div>
    </div>
</div>

<!-- CTA -->
<div class="cta-dark shadow-lg mb-5">
    <h2 class="fw-bold mb-3">আজই শুরু করুন আপনার Online Business Journey 🚀</h2>
    <p class="cta-p mb-4 text-white-50">মাত্র ২০ মিনিটের ভিডিও দেখেই A to Z সবকিছু বুঝে যাবেন।</p>
    <a href="payment.php" class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-primary">🔥 এখনই এনরোল করুন</a>
</div>

<?php include 'user-footer.php'; ?>