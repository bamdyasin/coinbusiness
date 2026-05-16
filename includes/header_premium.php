<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Set default root path
$root_path = isset($root_path) ? $root_path : '';

// Handle Language (Basic logic matching coinstorebd)
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'bn';
}
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'] == 'en' ? 'en' : 'bn';
}
?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - coinstore.bd' : 'Home - coinstore.bd'; ?></title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom Style -->
    <link rel="stylesheet" href="<?php echo $root_path; ?>style.css">
    <link rel="stylesheet" href="<?php echo $root_path; ?>premium.css">
    <?php if (isset($extra_css)) echo $extra_css; ?>
    
    <style>
        /* Exact styles from coinstorebd reference */
        header {
            background-color: #0a192f;
            color: #ffffff;
            padding: 0.8rem 20px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo a {
            text-decoration: none;
            display: flex;
            align-items: center;
            color: #ffd700;
        }

        .logo-icon {
            font-size: 1.8rem;
            filter: drop-shadow(0 0 5px rgba(255, 215, 0, 0.4));
            transition: 0.3s;
        }

        .logo-icon:hover {
            transform: rotate(15deg) scale(1.1);
        }

        /* Search Bar Styles - Fully Responsive */
        .search-container {
            flex: 1;
            margin: 0 10px;
            min-width: 120px;
            max-width: 400px;
        }

        .search-container form {
            display: flex;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 215, 0, 0.3);
            border-radius: 25px;
            overflow: hidden;
        }

        .search-container input {
            width: 100%;
            padding: 0.4rem 0.8rem;
            background: transparent;
            border: none;
            color: white;
            outline: none;
            font-size: 0.75rem;
        }

        .search-container input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .search-container button {
            background: transparent;
            border: none;
            padding: 0 0.8rem;
            cursor: pointer;
            font-size: 0.9rem;
            color: #ffd700;
        }

        /* Lang Switch */
        .lang-switch-wrap {
            margin-left: auto;
            margin-right: 15px;
        }

        .lang-link {
            text-decoration: none;
            color: #ffd700;
            font-weight: 600;
            font-size: 0.8rem;
            padding: 5px 12px;
            border: 1px solid rgba(255, 215, 0, 0.4);
            border-radius: 30px;
            display: flex;
            align-items: center;
            gap: 5px;
            background: rgba(255, 255, 255, 0.05);
            transition: 0.3s;
        }

        /* Menu Toggle */
        .menu-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            width: 38px;
            height: 40px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 215, 0, 0.2);
            border-radius: 50%;
            color: #ffd700;
        }

        /* Navigation Drawer */
        nav#nav-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 80%;
            max-width: 300px;
            height: 100vh;
            background-color: #0a192f;
            transition: 0.3s ease;
            z-index: 1001;
            box-shadow: -5px 0 15px rgba(0,0,0,0.3);
            display: block;
        }

        nav#nav-menu.active {
            right: 0;
        }

        .nav-close {
            position: absolute;
            top: 0.8rem;
            right: 20px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #ffd700;
            font-size: 1.2rem;
        }

        nav ul {
            list-style: none;
            padding: 80px 0 0 0;
            margin: 0;
        }

        nav ul li a {
            display: block;
            padding: 1.2rem 2rem;
            color: #ffffff !important;
            text-decoration: none;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            transition: 0.3s;
        }

        nav ul li a:hover {
            background: #ffd700;
            color: #0a192f !important;
            padding-left: 2.5rem;
        }

        /* Mobile specific adjustments */
        @media (max-width: 768px) {
            body { padding-top: 70px; }
            .search-container { margin: 0 5px; }
            .lang-switch-wrap { margin-right: 8px; }
            .lang-link { padding: 4px 10px; font-size: 0.7rem; }
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <a href="<?php echo $root_path; ?>index.php">
            <span class="logo-icon">🪙</span>
        </a>
    </div>

    <!-- Responsive Search -->
    <div class="search-container">
        <form>
            <input type="text" placeholder="TrxID দিন">
            <button type="submit">🔍</button>
        </form>
    </div>

    <div class="lang-switch-wrap">
        <?php if($_SESSION['lang'] == 'bn'): ?>
            <a href="?lang=en" class="lang-link"><i class="fas fa-globe"></i> EN</a>
        <?php else: ?>
            <a href="?lang=bn" class="lang-link"><i class="fas fa-globe"></i> বাং</a>
        <?php endif; ?>
    </div>

    <div class="menu-toggle" id="mobile-menu-trigger">
        <i class="fas fa-bars"></i>
    </div>

    <nav id="nav-menu">
        <div class="nav-close" id="nav-close-btn">
            <i class="fas fa-times"></i>
        </div>
        <ul>
            <li><a href="<?php echo $root_path; ?>index.php"><i class="fas fa-home me-2"></i> হোম</a></li>
            <li><a href="<?php echo $root_path; ?>index.php?tab=promote"><i class="fas fa-bullhorn me-2"></i> প্রমোট</a></li>
            <li><a href="<?php echo $root_path; ?>shop/TikTokTopUp.php"><i class="fas fa-coins me-2"></i> কয়েন নিন</a></li>
            <li><a href="<?php echo $root_path; ?>landing/landingpage.php"><i class="fas fa-briefcase me-2"></i> বিজনেস</a></li>
            <li><a href="#"><i class="fas fa-info-circle me-2"></i> আমাদের সম্পর্কে</a></li>
            <li><a href="#"><i class="fas fa-envelope me-2"></i> যোগাযোগ</a></li>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <li><a href="<?php echo $root_path; ?>user/dashboard.php"><i class="fas fa-tachometer-alt me-2"></i> ড্যাশবোর্ড</a></li>
                <li><a href="<?php echo $root_path; ?>user/profile.php" style="background: #ffd700; color: #0a192f !important;"><i class="fas fa-user me-2"></i> প্রোফাইল</a></li>
            <?php else: ?>
                <li><a href="<?php echo $root_path; ?>user/login.php"><i class="fas fa-sign-in-alt me-2"></i> লগইন</a></li>
                <li><a href="<?php echo $root_path; ?>user/register.php" style="background: #ffd700; color: #0a192f !important;"><i class="fas fa-user-plus me-2"></i> রেজিস্টার</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<script>
    // Exact drawer logic from coinstorebd reference
    document.addEventListener('DOMContentLoaded', function() {
        const menuTrigger = document.getElementById('mobile-menu-trigger');
        const navMenu = document.getElementById('nav-menu');
        const closeBtn = document.getElementById('nav-close-btn');

        if(menuTrigger && navMenu) {
            menuTrigger.addEventListener('click', function() {
                navMenu.classList.add('active');
            });
        }

        if(closeBtn && navMenu) {
            closeBtn.addEventListener('click', function() {
                navMenu.classList.remove('active');
            });
        }

        // Close on outside click
        document.addEventListener('click', function(event) {
            if (navMenu && navMenu.classList.contains('active') && 
                !navMenu.contains(event.target) && 
                !menuTrigger.contains(event.target)) {
                navMenu.classList.remove('active');
            }
        });
    });
</script>
