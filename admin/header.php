<?php
// Session and DB logic moved to main pages to avoid headers already sent errors
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Admin Panel - CoinStore.bd'; ?></title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --primary-blue: #3b82f6;
            --border-white: rgba(255, 255, 255, 0.1);
        }
        body {
            background-color: var(--bg-dark);
            color: white;
            font-family: 'Hind Siliguri', sans-serif;
            padding-top: 80px;
            padding-bottom: 90px;
        }
        
        /* Navbar Style from User Side */
        .fixed-navbar {
            position: fixed;
            top: 0; width: 100%;
            z-index: 1050;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-white);
            padding: 12px 0;
        }
        
        /* Sidebar Styling (Professional & Matching) */
        .sidebar { 
            height: calc(100vh - 80px); 
            background: var(--card-bg); 
            backdrop-filter: blur(10px);
            padding: 20px; 
            border: 1px solid var(--border-white);
            border-radius: 20px;
            position: sticky;
            top: 90px;
        }
        
        .nav-link { 
            color: rgba(255, 255, 255, 0.7); 
            padding: 12px 20px; 
            border-radius: 12px; 
            margin-bottom: 5px; 
            transition: 0.3s; 
            display: flex; 
            align-items: center; 
            text-decoration: none;
        }
        .nav-link:hover, .nav-link.active { 
            background: rgba(59, 130, 246, 0.15); 
            color: #3b82f6; 
        }
        .nav-link i { font-size: 1.2rem; margin-right: 15px; }

        /* Card Styling from User Side */
        .app-card {
            background: var(--card-bg);
            border: 1px solid var(--border-white);
            border-radius: 20px;
            padding: 25px;
            backdrop-filter: blur(10px);
            margin-bottom: 20px;
        }
        
        .motivation-card {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
        }

        /* Tables */
        .table { 
            color: white; 
            border-color: var(--border-white);
            --bs-table-bg: transparent;
            --bs-table-hover-bg: rgba(255, 255, 255, 0.05);
            --bs-table-hover-color: white;
        }
        .table thead th { border-bottom: 1px solid rgba(255,255,255,0.2); color: rgba(255,255,255,0.6); font-weight: 500; }
        .table tbody td { border-bottom: 1px solid var(--border-white); vertical-align: middle; }

        /* OTP Specifics */
        .otp-code-box {
            background: rgba(0,0,0,0.3);
            color: #38bdf8;
            padding: 8px 15px;
            border-radius: 8px;
            font-family: monospace;
            font-size: 1.1rem;
            border: 1px dashed rgba(56, 189, 248, 0.3);
        }
        
        .status-pill {
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-pending { background: rgba(245, 158, 11, 0.2); color: #fbbf24; }
        .status-verified, .status-approved { background: rgba(16, 185, 129, 0.2); color: #34d399; }
        .status-expired, .status-rejected { background: rgba(239, 68, 68, 0.2); color: #f87171; }

        @media (max-width: 991px) {
            .sidebar-col { display: none; }
        }
    </style>
</head>
<body>

<!-- Admin Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-navbar">
  <div class="container">
    <a class="navbar-brand fw-bold text-white" href="index.php">
        <span class="text-primary">🚀</span> CoinStore<span class="text-primary">.Admin</span>
    </a>
    <div class="ms-auto d-flex align-items-center">
        <span class="text-white-50 small me-3 d-none d-md-block">👋 Admin: <b><?php echo $_SESSION['admin_username']; ?></b></span>
        <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-4">
    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-lg-3 sidebar-col">
            <div class="sidebar">
                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>" href="index.php">
                    <i class="bi bi-grid-1x2-fill"></i> ড্যাশবোর্ড
                </a>
                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'premium_requests.php') ? 'active' : ''; ?>" href="premium_requests.php">
                    <i class="bi bi-star-fill"></i> প্রিমিয়াম রিকোয়েস্ট
                </a>
                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'otp_requests.php') ? 'active' : ''; ?>" href="otp_requests.php">
                    <i class="bi bi-shield-lock-fill"></i> ওটিপি রিকোয়েস্ট
                </a>
                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'users.php') ? 'active' : ''; ?>" href="users.php">
                    <i class="bi bi-people-fill"></i> ইউজার লিস্ট
                </a>
                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'settings.php') ? 'active' : ''; ?>" href="settings.php">
                    <i class="bi bi-gear-fill"></i> পেমেন্ট সেটিংস
                </a>
                <a class="nav-link" href="../user/dashboard.php" target="_blank">
                    <i class="bi bi-speedometer"></i> ইউজার ড্যাশবোর্ড
                </a>
                <hr class="border-secondary opacity-25">
                <a class="nav-link text-danger" href="logout.php">
                    <i class="bi bi-box-arrow-right"></i> লগআউট
                </a>
            </div>
        </div>

        <!-- Content Area -->
        <div class="col-lg-9">
