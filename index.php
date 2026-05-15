<?php
session_start();
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - coinstore.bd</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom Style -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<style>
    body { padding-top: 70px; }
    .navbar {
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1030;
    }
    .search-input {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #4ade80; /* Light green */
        border-radius: 50px 0 0 50px;
        padding-left: 20px;
    }
    .search-input::placeholder {
        color: rgba(74, 222, 128, 0.6); /* Semi-transparent light green */
    }
    .search-input:focus {
        background: rgba(255, 255, 255, 0.1);
        border-color: #4ade80;
        box-shadow: none;
        color: #4ade80;
    }
    .search-btn {
        border-radius: 0 50px 50px 0;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-left: none;
        background: rgba(59, 130, 246, 0.2);
        color: #3b82f6;
    }
    .search-btn:hover {
        background: #3b82f6;
        color: white;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">🚀 CoinStore.bd</a>
    <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <form class="d-flex ms-lg-4 mt-3 mt-lg-0" role="search">
        <div class="input-group">
          <input class="form-control search-input" type="text" placeholder="অর্ডার স্ট্যাটাস দেখুন" aria-label="Search">
          <button class="btn search-btn" type="submit">
            <i class="bi bi-search"></i>
          </button>
        </div>
      </form>
      <ul class="navbar-nav ms-auto align-items-center py-3 py-lg-0">
        <li class="nav-item">
            <a class="nav-link text-white" href="landing/landingpage.html">রিসেলার হন</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="shop/TikTokTopUp.php">টিকটক শপ</a>
        </li>
        <?php if(isset($_SESSION['user_id'])): ?>
            <li class="nav-item">
                <a class="nav-link text-white" href="user/dashboard.php">ড্যাশবোর্ড</a>
            </li>
            <li class="nav-item mt-2 mt-lg-0 ms-lg-2">
                <a class="btn btn-primary rounded-pill px-4 w-100" href="user/profile.php">প্রোফাইল</a>
            </li>
        <?php else: ?>
            <li class="nav-item">
                <a class="nav-link text-white" href="user/login.php">লগইন</a>
            </li>
            <li class="nav-item mt-2 mt-lg-0 ms-lg-2">
                <a class="btn btn-outline-primary rounded-pill px-4 w-100" href="user/register.php">রেজিস্টার</a>
            </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="shop-container">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-white">আমাদের শপ</h2>
            <p class="text-white-50">আপনার পছন্দের গেম টপ-আপ এবং সার্ভিস বেছে নিন</p>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- TikTok -->
            <div class="col-6 col-lg-3">
                <div class="shop-card tiktok">
                    <div class="card-icon">
                        <i class="bi bi-tiktok"></i>
                    </div>
                    <h5>TikTok</h5>
                    <p>Coins & Follower</p>
                    <a href="shop/TikTokTopUp.php" class="btn btn-shop">অর্ডার করুন</a>
                </div>
            </div>

            <!-- PUBG -->
            <div class="col-6 col-lg-3">
                <div class="shop-card pubg coming-soon">
                    <div class="card-icon">
                        <i class="bi bi-controller"></i>
                    </div>
                    <h5>PUBG</h5>
                    <p>UC Top-up</p>
                    <button class="btn btn-shop disabled">Coming Soon</button>
                </div>
            </div>

            <!-- Free Fire -->
            <div class="col-6 col-lg-3">
                <div class="shop-card freefire coming-soon">
                    <div class="card-icon">
                        <i class="bi bi-fire"></i>
                    </div>
                    <h5>Free Fire</h5>
                    <p>Diamond Top-up</p>
                    <button class="btn btn-shop disabled">Coming Soon</button>
                </div>
            </div>

            <!-- Call of Duty -->
            <div class="col-6 col-lg-3">
                <div class="shop-card cod coming-soon">
                    <div class="card-icon">
                        <i class="bi bi-shield-shaded"></i>
                    </div>
                    <h5>Call of Duty</h5>
                    <p>CP Top-up</p>
                    <button class="btn btn-shop disabled">Coming Soon</button>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="footer mt-auto py-3">
  <div class="container text-center">
    <span class="text-white-50">© 2026 CoinStore.bd. All Rights Reserved.</span>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
