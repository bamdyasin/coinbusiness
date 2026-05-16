<?php
session_start();
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - coinstore.bd' : 'Home - coinstore.bd'; ?></title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom Style -->
    <?php $root_path = isset($root_path) ? $root_path : ''; ?>
    <link rel="stylesheet" href="<?php echo $root_path; ?>style.css">
    <?php if (isset($extra_css)) echo $extra_css; ?>
    <style>
        body { padding-top: 85px; }
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding: 15px 0;
        }
        .navbar-brand {
            font-size: 1.4rem;
        }
        /* Offcanvas Custom Styles */
        .offcanvas {
            width: 280px !important;
            height: 100vh !important;
        }
        .offcanvas-body {
            display: flex;
            flex-direction: column;
            padding: 2rem 1.5rem !important;
        }
        .offcanvas .nav-link {
            font-size: 1.1rem;
            padding: 0.8rem 0 !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: block !important;
            color: white !important;
        }
        .offcanvas .navbar-nav {
            display: block !important;
            width: 100%;
        }
        .offcanvas .nav-item {
            display: block !important;
            width: 100%;
        }
        .offcanvas .nav-item:last-child .nav-link {
            border-bottom: none;
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
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?php echo $root_path; ?>index.php">🚀 CoinStore.bd</a>
    <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</nav>

<div class="offcanvas offcanvas-end bg-dark text-white" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
  <div class="offcanvas-header border-bottom border-secondary">
    <h5 class="offcanvas-title fw-bold" id="offcanvasNavbarLabel">🚀 CoinStore.bd</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <form class="d-flex mb-4" role="search">
      <div class="input-group">
        <input class="form-control search-input" type="text" placeholder="অর্ডার স্ট্যাটাস দেখুন" aria-label="Search">
        <button class="btn search-btn" type="submit">
          <i class="bi bi-search"></i>
        </button>
      </div>
    </form>
    <ul class="navbar-nav pe-3">
      <li class="nav-item">
          <a class="nav-link text-white" href="<?php echo $root_path; ?>landing/landingpage.php">রিসেলার হন</a>
      </li>
      <li class="nav-item">
          <a class="nav-link text-white" href="<?php echo $root_path; ?>shop/TikTokTopUp.php">টিকটক শপ</a>
      </li>
      <?php if(isset($_SESSION['user_id'])): ?>
          <li class="nav-item">
              <a class="nav-link text-white" href="<?php echo $root_path; ?>user/dashboard.php">ড্যাশবোর্ড</a>
          </li>
          <li class="nav-item mt-3">
              <a class="btn btn-primary rounded-pill px-4 w-100" href="<?php echo $root_path; ?>user/profile.php">প্রোফাইল</a>
          </li>
      <?php else: ?>
          <li class="nav-item">
              <a class="nav-link text-white" href="<?php echo $root_path; ?>user/login.php">লগইন</a>
          </li>
          <li class="nav-item mt-3">
              <a class="btn btn-outline-primary rounded-pill px-4 w-100" href="<?php echo $root_path; ?>user/register.php">রেজিস্টার</a>
          </li>
      <?php endif; ?>
    </ul>
  </div>
</div>
