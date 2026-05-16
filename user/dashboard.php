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
        
        /* Dashboard Specific Landing UI */
        .hero-box {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border-radius: 24px;
            padding: 40px;
            border: 1px solid rgba(255,255,255,0.05);
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }
        .hero-box h1 { font-size: 2.5rem; font-weight: 800; line-height: 1.2; margin-bottom: 20px; }
        .hero-box h1 span { color: #3b82f6; }
        .hero-box p { font-size: 1.15rem; }
        
        .hero-card-img {
            background: linear-gradient(180deg,#161c52,#0b1033);
            border-radius: 25px;
            padding: 15px;
            border: 1px solid rgba(255,255,255,0.08);
            position: relative;
        }
        .hero-card-img img { width: 100%; border-radius: 15px; }
        
        .floating-badge-dark {
            position: absolute; bottom: 10px; right: 10px;
            background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(10px);
            border: 2px solid #3b82f6; padding: 10px 15px; border-radius: 15px;
            text-align: center; color: #fff;
        }
        .floating-badge-dark h4 { margin: 0; color: #10b981; font-weight: 800; }

        .stats-item-box {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 15px;
            border: 1px solid rgba(255,255,255,0.05);
        }
        .stats-item-box h3 { color: #10b981; font-weight: 800; margin-bottom: 5px; }
        .stats-label { font-size: 0.85rem !important; color: rgba(255,255,255,0.6); font-weight: 600; }
        
        .section-title-box { text-align: center; margin-bottom: 25px; }
        .section-title-box h2 { font-weight: 700; font-size: 1.8rem; position: relative; display: inline-block; padding-bottom: 10px; margin-bottom: 0; }
        .section-title-box h2::after { content: ""; width: 60px; height: 4px; background: #3b82f6; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); border-radius: 10px; }

        /* Unified List Item Design */
        .list-item-row {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 18px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: 0.3s;
        }
        .list-item-row:last-child { border-bottom: none; }
        
        .feature-icon-circle {
            min-width: 55px; width: 55px; height: 55px;
            background: rgba(59, 130, 246, 0.1); color: #3b82f6;
            border-radius: 20px; display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; border: 1px solid rgba(59, 130, 246, 0.2);
        }
        .feature-icon-circle img { width: 32px; height: 32px; object-fit: contain; }
        
        .feature-text-box h6 { margin: 0 0 4px 0; font-weight: 700; color: #fff; font-size: 1.1rem; }
        .feature-text-box p { margin: 0; font-size: 0.95rem; color: rgba(255,255,255,0.7); line-height: 1.4; }

        .package-price { color: rgba(255,255,255,0.7); font-weight: 600; font-size: 1rem; display: block; }
        .package-details-text { font-size: 0.9rem !important; color: rgba(255,255,255,0.5) !important; margin-top: 5px; line-height: 1.4; }
        
        .course-box-dark {
            background: rgba(30, 41, 59, 0.7);
            border-radius: 24px;
            padding: 35px;
            border: 1px solid rgba(255,255,255,0.05);
        }
        .course-list-dark li { 
            width: 100%;
            color: #fff;
            padding: 16px 20px;
            border-radius: 18px;
            font-size: 1.1rem;
            box-shadow: 0 8px 20px rgba(123, 47, 247, 0.2);
            font-weight: 600;
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .course-list-dark li:nth-child(odd) {
            background: linear-gradient(135deg, #7b2ff7, #2575fc);
            border-right: 5px solid rgba(255, 255, 255, 0.3);
        }
        .course-list-dark li:nth-child(even) {
            background: linear-gradient(135deg, #6a11cb, #a737ff);
            border-left: 5px solid rgba(255, 255, 255, 0.3);
        }

        .refund-card-dark {
            border: 2px dashed rgba(59, 130, 246, 0.4);
            border-radius: 20px;
            padding: 25px;
            background: rgba(59, 130, 246, 0.05);
        }
        .refund-text { font-size: 1rem !important; color: rgba(255,255,255,0.7) !important; }

        .cta-dark {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            border-radius: 24px;
            padding: 50px 30px;
            text-align: center;
            margin-top: 40px;
        }
        @media (max-width: 991px) { .sidebar-col { display: none; } .hero-box h1 { font-size: 1.8rem; } }
    </style>';

include 'header.php';
?>

<div class="container mt-4">
    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-lg-3 sidebar-col">
            <div class="app-card p-3 shadow">
                <a href="dashboard.php" class="sidebar-link active">
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
                <a href="landingpage.php" class="sidebar-link" target="_blank">
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
            
            <!-- HERO SECTION -->
            <div class="hero-box shadow">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <h1>মাত্র ৩০০০ টাকায় শুরু করুন <span>অনলাইন বিজনেস</span></h1>
                        <p class="text-white-50">২৫% পর্যন্ত প্রফিট, ৮০%+ রিপিট কাস্টমার এবং যেকোনো জায়গা থেকে ব্যবসা পরিচালনার সুযোগ।</p>
                        
                        <div class="row g-2 text-center mt-3 mb-4">
                            <div class="col-4"><div class="stats-item-box"><h3>২৫%</h3><div class="stats-label">নিট-প্রফিট</div></div></div>
                            <div class="col-4"><div class="stats-item-box"><h3>৮০%+</h3><div class="stats-label">রিপিট-Sell</div></div></div>
                            <div class="col-4"><div class="stats-item-box"><h3>৩০০০৳</h3><div class="stats-label">স্বল্প-পুজি</div></div></div>
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

            <!-- FEATURES CARD (Header Inside) -->
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

            <!-- PACKAGES CARD (Header Inside) -->
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

            <!-- Extra spacer for mobile bottom nav -->
            <div class="d-lg-none" style="height: 50px;"></div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
