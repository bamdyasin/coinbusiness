<?php
// user/user-header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$root_path = isset($root_path) ? $root_path : '../';
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'CoinStore.bd'; ?></title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom Style -->
    <link rel="stylesheet" href="<?php echo $root_path; ?>assets/css/style.css">
    
    <?php if (isset($show_sidebar) && $show_sidebar): ?>
        <link rel="stylesheet" href="assets/css/dashboard.css">
    <?php else: ?>
        <link rel="stylesheet" href="assets/css/auth.css">
    <?php endif; ?>

    <?php if (isset($extra_css)) echo $extra_css; ?>
</head>
<body>

<?php if (isset($show_sidebar) && $show_sidebar): ?>
<div class="container mt-4">
    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-lg-3 sidebar-col">
            <div class="app-card p-3 shadow">
                <?php $curr = basename($_SERVER['PHP_SELF']); ?>
                <a href="dashboard.php" class="sidebar-link <?php echo ($curr == 'dashboard.php') ? 'active' : ''; ?>">
                    <i class="bi bi-speedometer2"></i> ড্যাশবোর্ড
                </a>
                <a href="profile.php" class="sidebar-link <?php echo ($curr == 'profile.php') ? 'active' : ''; ?>">
                    <i class="bi bi-person-circle"></i> প্রোফাইল
                </a>
                <a href="affiliate.php" class="sidebar-link <?php echo ($curr == 'affiliate.php') ? 'active' : ''; ?>">
                    <i class="bi bi-gift"></i> এফিলিয়েট সিস্টেম
                </a>
                <a href="premiumfiles.php" class="sidebar-link <?php echo ($curr == 'premiumfiles.php') ? 'active' : ''; ?>">
                    <i class="bi bi-cloud-arrow-down"></i> প্রিমিয়াম ফাইল
                </a>
                <a href="../landing/index.php" class="sidebar-link" target="_blank">
                    <i class="bi bi-browser-safari"></i> ল্যান্ডিং পেজ
                </a>
                <a href="payment.php" class="sidebar-link <?php echo ($curr == 'payment.php') ? 'active' : ''; ?>">
                    <i class="bi bi-wallet2"></i> পেমেন্ট হিস্ট্রি
                </a>
                <hr class="border-secondary">
                <a href="logout.php" class="sidebar-link text-danger">
                    <i class="bi bi-box-arrow-right"></i> লগআউট
                </a>
            </div>
        </div>
        <!-- Main Content Start -->
        <div class="col-lg-9 main-content-col">
<?php endif; ?>