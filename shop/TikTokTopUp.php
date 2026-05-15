<?php
session_start();
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TikTok Top-Up - coinstore.bd</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom Style -->
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            background-color: #0f172a;
            color: white;
            padding-top: 80px;
            padding-bottom: 50px;
        }
        .navbar {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
        }
        .order-form-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 40px;
        }
        .form-control, .form-select {
            background-color: rgba(15, 23, 42, 0.6); /* Darker and more distinct */
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #fff;
            padding: 12px;
        }
        .form-select option {
            background-color: #1e293b; /* Solid background for options */
            color: #fff;
        }
        .form-control:focus, .form-select:focus {
            background-color: rgba(15, 23, 42, 0.8);
            border-color: #fe2c55; /* TikTok Brand Color */
            box-shadow: 0 0 0 0.25rem rgba(254, 44, 85, 0.15);
            color: #fff;
        }
        .btn-tiktok {
            background: linear-gradient(135deg, #fe2c55 0%, #ee1d52 100%);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 12px;
            padding: 15px;
            transition: 0.3s;
        }
        .btn-tiktok:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(254, 44, 85, 0.3);
        }
        .tiktok-badge {
            background: rgba(254, 44, 85, 0.1);
            color: #fe2c55;
            padding: 5px 15px;
            border-radius: 30px;
            font-size: 0.9rem;
            display: inline-block;
            margin-bottom: 15px;
        }
        /* Tab Styling (Capsule Type) */
        .tabs-container {
            background: rgba(255, 255, 255, 0.03);
            padding: 5px;
            border-radius: 50px;
            display: flex;
            border: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 30px;
            /* max-width: 400px; */
            margin-left: auto;
            margin-right: auto;
            overflow: hidden;
        }
        .nav-pills {
            width: 100%;
            display: flex;
        }
        .nav-pills .nav-item {
            flex: 1;
        }
        .nav-pills .nav-link {
            background: transparent;
            color: rgba(255, 255, 255, 0.6);
            border-radius: 50px;
            padding: 12px 20px;
            font-weight: 600;
            border: none;
            transition: 0.3s;
            width: 100%;
            display: block;
        }
        .nav-pills .nav-link.active {
            background: #fe2c55;
            color: white;
            box-shadow: 0 5px 15px rgba(254, 44, 85, 0.3);
        }
        .nav-pills .nav-link:hover:not(.active) {
            color: white;
            background: rgba(255, 255, 255, 0.05);
        }
        /* Budget Counter Styling */
        .budget-counter {
            display: flex;
            align-items: center;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 15px;
            overflow: hidden;
            width: 100%;
        }
        .counter-btn {
            background: rgba(255, 255, 255, 0.05);
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: 0.3s;
        }
        .counter-btn:hover {
            background: rgba(254, 44, 85, 0.2);
            color: #fe2c55;
        }
        .budget-input {
            flex: 1;
            background: transparent;
            border: none;
            color: white;
            text-align: center;
            font-size: 1.2rem;
            font-weight: 700;
            padding: 10px;
            outline: none;
        }
        .budget-input::-webkit-inner-spin-button,
        .budget-input::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        /* Professional Hero Section */
        .hero-section {
            position: relative;
            /* padding: 40px 0; */
            z-index: 1;
        }
        .hero-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(254, 44, 85, 0.15) 0%, rgba(37, 244, 238, 0.05) 50%, transparent 70%);
            filter: blur(50px);
            z-index: -1;
        }
        .hero-slogan {
            font-size: 3.5rem;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #ffffff 40%, #fe2c55 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .hero-subtitle {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.5);
            text-transform: uppercase;
            letter-spacing: 5px;
            font-weight: 500;
        }
        @media (max-width: 768px) {
            .hero-slogan { font-size: 2.2rem; }
            .hero-subtitle { font-size: 0.8rem; letter-spacing: 3px; }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand fw-bold" href="../index.php">🚀 CoinStore.bd</a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item">
            <a class="nav-link text-white" href="../index.php">হোম</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            
            <!-- Professional Hero Section -->
            <div class="hero-section text-center mb-5">
                <div class="hero-glow"></div>
                <p class="hero-subtitle mb-2">Premium Growth Service</p>
                <h1 class="hero-slogan">ভাইরাল হোন <span style="color: #fe2c55; -webkit-text-fill-color: #fe2c55;">নিজের স্টাইলে</span></h1>
                <p class="text-white-50 mt-3">ক্যাটাগরি নির্বাচন করুন</p>
            </div>

            <!-- Tab Navigation (Capsule Type) -->
            <div class="text-center">
                <div class="tabs-container">
                    <ul class="nav nav-pills" id="tiktokTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="boost-tab" data-bs-toggle="pill" data-bs-target="#boost" type="button" role="tab" aria-controls="boost" aria-selected="true"><i class="bi bi-rocket-takeoff me-2"></i> Boost Now</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="coin-tab" data-bs-toggle="pill" data-bs-target="#coin" type="button" role="tab" aria-controls="coin" aria-selected="false"><i class="bi bi-coin me-2"></i> Get Coin</button>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="order-form-card shadow-lg">
                <form action="../user/payment.php" method="GET">
                    <input type="hidden" name="product" value="TikTok">
                    
                    <div class="tab-content" id="tiktokTabContent">
                        <!-- Boost Now Tab -->
                        <div class="tab-pane fade show active" id="boost" role="tabpanel">
                            <div class="mb-4">
                                <label class="form-label text-white-50 small">প্রমোটের ধরন</label>
                                <select class="form-select" name="promo_type" required>
                                    <option value="Video Views" selected>ভিডিও ভিউ বাড়ান</option>
                                    <option value="Likes & Comments">লাইক এবং কমেন্ট</option>
                                    <option value="More Followers">ফলোয়ার বাড়ান</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-white-50 small">আপনার বাজেট (টাকা)</label>
                                <div class="budget-counter">
                                    <button type="button" class="counter-btn" onclick="updateBudget(-100)">−</button>
                                    <input type="number" class="budget-input" name="budget" id="budget_val" value="200" min="200" step="100">
                                    <button type="button" class="counter-btn" onclick="updateBudget(100)">+</button>
                                </div>
                                <div class="form-text text-white-50 small mt-2">
                                    <i class="bi bi-info-circle me-1"></i> সর্বনিম্ন: 5,000 ভিউ & 1,000 লাইক
                                </div>
                            </div>
                        </div>
                        
                        <!-- Get Coin Tab -->
                        <div class="tab-pane fade" id="coin" role="tabpanel">
                            <div class="mb-4">
                                <label class="form-label text-white-50 small">কয়েনের পরিমাণ</label>
                                <div class="budget-counter">
                                    <button type="button" class="counter-btn" onclick="updateCoins(-10)">−</button>
                                    <input type="number" class="budget-input" name="coin_amount" id="coin_val" value="50" min="50" step="10">
                                    <button type="button" class="counter-btn" onclick="updateCoins(10)">+</button>
                                </div>
                                <div class="form-text text-white-50 small mt-2">
                                    <i class="bi bi-info-circle me-1"></i> সর্বনিম্ন: ৫০ কয়েন
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ID Section (Dynamically updated by JS) -->
                    <div id="video_link_section">
                        <div class="mb-4">
                            <label class="form-label text-white-50 small" id="id_label">টিকটক ভিডিও লিংক (Video Link)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0 text-white-50" id="id_icon"><i class="bi bi-link-45deg"></i></span>
                                <input type="text" class="form-control border-start-0" name="player_id" id="video_url_input" placeholder="https://www.tiktok.com/@username/video/..." required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-white-50 small">আপনার হোয়াটসঅ্যাপ নম্বর</label>
                        <input type="text" class="form-control" name="whatsapp" placeholder="017XXXXXXXX" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label text-white-50 small">পেমেন্ট মাধ্যম</label>
                            <select class="form-select" name="payment_method" required>
                                <option value="" selected disabled>পছন্দ করুন</option>
                                <option value="bKash">বিকাশ (bKash)</option>
                                <option value="Nagad">নগদ (Nagad)</option>
                                <option value="Rocket">রকেট (Rocket)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label text-white-50 small">ট্রানজেকশন আইডি (TrxID)</label>
                            <input type="text" class="form-control" name="trxid" placeholder="8N72KL9X" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-tiktok w-100 fs-5">
                        অর্ডার কনফার্ম করুন <i class="bi bi-arrow-right-circle ms-2"></i>
                    </button>
                </form>
            </div>

            <div class="mt-5 p-4 rounded-4" style="background: rgba(255,255,255,0.03); border: 1px dashed rgba(255,255,255,0.1);">
                <h6 class="fw-bold text-white mb-3"><i class="bi bi-info-circle text-warning me-2"></i> জরুরি নির্দেশনা:</h6>
                <ul class="text-white-50 small mb-0">
                    <li class="mb-2">অর্ডার করার ১০-৩০ মিনিটের মধ্যে সার্ভিস ডেলিভারি করা হবে।</li>
                    <li id="rule_public" class="mb-2">ভিডিও অবশ্যই পাবলিক হতে হবে (Private ভিডিওতে কাজ হবে না)।</li>
                    <li>যেকোনো প্রয়োজনে আমাদের সাপোর্ট টিমে যোগাযোগ করুন।</li>
                </ul>
            </div>

        </div>
    </div>
</div>

<footer class="footer mt-5 py-4 text-center border-top border-white border-opacity-10">
    <span class="text-white-50 small">© 2026 CoinStore.bd. All Rights Reserved.</span>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function updateBudget(change) {
        const input = document.getElementById('budget_val');
        let newVal = parseInt(input.value) + change;
        if (newVal < 200) newVal = 200;
        input.value = newVal;
    }

    function updateCoins(change) {
        const input = document.getElementById('coin_val');
        let newVal = parseInt(input.value) + change;
        if (newVal < 50) newVal = 50;
        input.value = newVal;
    }

    document.addEventListener('DOMContentLoaded', function() {
        var boostTab = document.getElementById('boost-tab');
        var coinTab = document.getElementById('coin-tab');

        boostTab.addEventListener('shown.bs.tab', function () {
            document.getElementById('video_link_section').style.display = 'block';
            document.getElementById('video_url_input').setAttribute('required', 'required');
            document.getElementById('rule_public').innerText = 'ভিডিও অবশ্যই পাবলিক হতে হবে (Private ভিডিওতে কাজ হবে না)।';
        });

        coinTab.addEventListener('shown.bs.tab', function () {
            document.getElementById('video_link_section').style.display = 'none';
            document.getElementById('video_url_input').removeAttribute('required');
            document.getElementById('rule_public').innerText = 'অর্ডার করার পর আমাদের হোয়াটসঅ্যাপে যোগাযোগ করুন।';
        });
    });
</script>
</body>
</html>