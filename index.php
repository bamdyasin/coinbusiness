<?php
$page_title = 'Home';
include 'includes/header.php';
?>

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

<?php include 'includes/footer.php'; ?>
