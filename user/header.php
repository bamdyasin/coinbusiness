<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'coinstore.bd'; ?></title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom Style -->
    <?php 
        $base_path = (strpos($_SERVER['PHP_SELF'], '/referral/') !== false) ? '../user/' : '';
    ?>
    <link rel="stylesheet" href="<?php echo $base_path; ?>style.css">
    <?php if (isset($extra_css)) echo $extra_css; ?>
    <style>
        .fixed-navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1050;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding: 12px 0;
        }
        body {
            padding-top: 80px; /* Adjust based on navbar height */
        }
        .navbar-brand {
            font-size: 1.4rem;
            letter-spacing: -0.5px;
        }
        .user-greeting {
            background: rgba(255, 255, 255, 0.05);
            padding: 6px 15px;
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .btn-logout {
            transition: all 0.3s;
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #ef4444;
        }
        .btn-logout:hover {
            background: #ef4444;
            color: white;
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.4);
        }
    </style>
</head>
<body>

<?php if (isset($_SESSION['user_id'])): ?>
<!-- Dashboard Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-navbar">
  <div class="container">
    <a class="navbar-brand fw-bold text-white" href="../index.php">
        <span class="text-primary">🚀</span> CoinStore<span class="text-primary">.bd</span>
    </a>
    
    <!-- Navigation Links -->
    <div class="d-none d-lg-flex ms-4">
        <a href="../shop/index.php" class="text-white-50 text-decoration-none hover-white transition-all px-3">শপ</a>
    </div>
    
    <!-- Right side items -->
    <div class="ms-auto d-flex align-items-center">
        <div class="d-none d-lg-flex align-items-center me-3">
            <div class="user-greeting">
                <span class="text-white-50 small">👋 স্বাগতম, </span>
                <span class="text-white fw-semibold small"><?php echo isset($user['name']) ? $user['name'] : ''; ?></span>
            </div>
        </div>
        
        <div class="d-none d-lg-block">
            <a href="logout.php" class="btn btn-logout btn-sm rounded-pill px-4 fw-bold">লগআউট</a>
        </div>

        <!-- Mobile Profile/User Icon -->
        <div class="d-lg-none">
            <a href="?view=profile" class="text-white opacity-75 hover-opacity-100 transition-all">
                <i class="bi bi-person-circle fs-2"></i>
            </a>
        </div>
    </div>
  </div>
</nav>
<?php endif; ?>
