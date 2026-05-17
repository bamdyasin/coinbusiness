<?php
$current_shop_page = basename($_SERVER['PHP_SELF']);
?>
<div class="col-lg-3 sidebar-col">
    <div class="app-card p-3 shadow">
        <h5 class="fw-bold mb-3 px-2 text-gold"><i class="bi bi-shop me-2"></i> Shop Menu</h5>
        
        <a href="TikTokTopUp.php" class="sidebar-link <?php echo ($current_shop_page == 'TikTokTopUp.php') ? 'active' : ''; ?>">
            <i class="bi bi-grid-fill"></i> All Services
        </a>
        
        <a href="TikTokTopUp.php" class="sidebar-link <?php echo ($current_shop_page == 'TikTokTopUp.php') ? 'active' : ''; ?>">
            <i class="bi bi-tiktok"></i> TikTok Top-Up
        </a>
        
        <a href="#" class="sidebar-link text-white-50">
            <i class="bi bi-controller"></i> PUBG UC (Soon)
        </a>
        
        <a href="#" class="sidebar-link text-white-50">
            <i class="bi bi-fire"></i> Free Fire (Soon)
        </a>
    </div>
</div>
