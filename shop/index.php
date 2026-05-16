<?php
$page_title = 'Home';
include 'header.php';
?>

<div class="container mt-4 mb-5">
    <div class="row g-4">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>

        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="app-card shadow-lg">
                <!-- Professional Hero Section -->
                <div class="hero-section text-center mb-4">
                    <div class="hero-glow"></div>
                    <div class="instruction-badge">
                        <i class="bi bi-grid-fill me-2 text-gold"></i> নিচের সার্ভিসগুলো থেকে আপনার পছন্দেরটি বেছে নিন
                    </div>
                </div>

                <div class="row g-4 justify-content-center">
                    <!-- TikTok -->
                    <div class="col-6 col-md-4 col-xl-3">
                        <div class="shop-card tiktok">
                            <div class="card-icon">
                                <i class="bi bi-tiktok"></i>
                            </div>
                            <h5>TikTok</h5>
                            <p>Coins & Follower</p>
                            <a href="TikTokTopUp.php" class="btn btn-shop">অর্ডার করুন</a>
                        </div>
                    </div>

                    <!-- PUBG -->
                    <div class="col-6 col-md-4 col-xl-3">
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
                    <div class="col-6 col-md-4 col-xl-3">
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
                    <div class="col-6 col-md-4 col-xl-3">
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
    </div>
</div>

<?php include 'footer.php'; ?>
