<?php
session_start();
$page_title = 'Premium Services - coinstore.bd';
$root_path = './'; 
include 'includes/header.php';
?>

<div class="services-hero py-5" style="background: radial-gradient(circle at 0% 0%, #1a1f3c 0%, #0b0e11 100%); min-height: 100vh; display: flex; align-items: center; position: relative; overflow: hidden;">
    <!-- Abstract Background Elements -->
    <div class="bg-shape shadow-lg" style="position: absolute; top: -100px; right: -100px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(255, 215, 0, 0.05) 0%, transparent 70%); border-radius: 50%;"></div>
    <div class="bg-shape shadow-lg" style="position: absolute; bottom: -150px; left: -100px; width: 500px; height: 500px; background: radial-gradient(circle, rgba(59, 130, 246, 0.03) 0%, transparent 70%); border-radius: 50%;"></div>

    <div class="container position-relative" style="z-index: 2;">
        <!-- Header Section -->
        <div class="text-center mb-5 pb-3">
            <span class="badge px-3 py-2 mb-3" style="background: rgba(255, 215, 0, 0.1); color: #ffd700; border: 1px solid rgba(255, 215, 0, 0.2); border-radius: 30px; font-weight: 600; letter-spacing: 1px; font-size: 0.75rem; text-transform: uppercase;">Premium Quality Solutions</span>
            <h1 class="display-3 fw-bold text-white mb-3" style="letter-spacing: -1px;">এক্সক্লুসিভ <span style="background: linear-gradient(135deg, #ffd700 0%, #daa520 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">সার্ভিস</span> কালেকশন</h1>
            <p class="text-white-50 fs-5 mx-auto" style="max-width: 700px; line-height: 1.8;">বাংলাদেশের সবচেয়ে নির্ভরযোগ্য ডিজিটাল সার্ভিস প্ল্যাটফর্ম। প্রফেশনাল সাপোর্ট এবং দ্রুততম ডেলিভারি নিশ্চিত করছি আমরা।</p>
        </div>

        <!-- Services Grid -->
        <div class="row g-4 justify-content-center">
            
            <!-- TikTok Service (Active & Premium) -->
            <div class="col-md-6 col-lg-4">
                <div class="service-card-premium active-service" onclick="window.location.href='shop/TikTokTopUp.php'">
                    <div class="popular-tag">Popular</div>
                    <div class="card-overlay"></div>
                    <div class="card-inner p-4 p-xl-5">
                        <div class="icon-box-premium mb-4" style="background: linear-gradient(135deg, rgba(254, 44, 85, 0.2) 0%, transparent 100%); border-color: rgba(254, 44, 85, 0.3); color: #fe2c55;">
                            <i class="bi bi-tiktok"></i>
                        </div>
                        <h3 class="h2 text-white fw-bold mb-3">TikTok বুস্ট ও কয়েন</h3>
                        <p class="text-white-50 mb-4" style="font-size: 0.95rem; min-height: 3rem;">টিকটক আইডি প্রমোট, ভিডিও ভাইরাল এবং সবচেয়ে কম দামে ইনস্ট্যান্ট কয়েন টপ-আপ।</p>
                        
                        <div class="d-flex align-items-center justify-content-between mt-auto">
                            <span class="text-white-50 small"><i class="bi bi-check2-circle me-2 text-success"></i>Instant Delivery</span>
                            <a href="shop/TikTokTopUp.php" class="btn-action">অর্ডার করুন <i class="bi bi-arrow-right-short ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PUBG UC Service -->
            <div class="col-md-6 col-lg-4">
                <div class="service-card-premium">
                    <div class="card-overlay"></div>
                    <div class="card-inner p-4 p-xl-5">
                        <div class="icon-box-premium mb-4" style="background: linear-gradient(135deg, rgba(255, 152, 0, 0.15) 0%, transparent 100%); border-color: rgba(255, 152, 0, 0.2); color: #ff9800;">
                            <i class="bi bi-controller"></i>
                        </div>
                        <h3 class="h2 text-white fw-bold mb-3">PUBG UC Top-Up</h3>
                        <p class="text-white-50 mb-4" style="font-size: 0.95rem; min-height: 3rem;">নিরাপদ এবং দ্রুততম সময়ে আপনার পাবজি আইডিতে ইউসি (UC) টপ-আপ সুবিধা।</p>
                        
                        <div class="d-flex align-items-center justify-content-between mt-auto">
                            <span class="status-indicator">
                                <span class="dot"></span>
                                Coming Soon
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Free Fire Diamond Service -->
            <div class="col-md-6 col-lg-4">
                <div class="service-card-premium">
                    <div class="card-overlay"></div>
                    <div class="card-inner p-4 p-xl-5">
                        <div class="icon-box-premium mb-4" style="background: linear-gradient(135deg, rgba(3, 169, 244, 0.15) 0%, transparent 100%); border-color: rgba(3, 169, 244, 0.2); color: #03a9f4;">
                            <i class="bi bi-gem"></i>
                        </div>
                        <h3 class="h2 text-white fw-bold mb-3">Free Fire Diamond</h3>
                        <p class="text-white-50 mb-4" style="font-size: 0.95rem; min-height: 3rem;">সবচেয়ে কম দামে ফ্রি-ফায়ার ডায়মন্ড টপ-আপ এবং উইকলি/মান্থলি মেম্বারশিপ।</p>
                        
                        <div class="d-flex align-items-center justify-content-between mt-auto">
                            <span class="status-indicator">
                                <span class="dot"></span>
                                Coming Soon
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Business Service (Polished Active) -->
            <div class="col-md-6 col-lg-4">
                <div class="service-card-premium clickable" onclick="window.location.href='landing/landingpage.php'">
                    <div class="card-overlay"></div>
                    <div class="card-inner p-4 p-xl-5">
                        <div class="icon-box-premium mb-4" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, transparent 100%); border-color: rgba(59, 130, 246, 0.2); color: #3b82f6;">
                            <i class="bi bi-rocket-takeoff"></i>
                        </div>
                        <h3 class="h2 text-white fw-bold mb-3">বিজনেস সলিউশন</h3>
                        <p class="text-white-50 mb-4" style="font-size: 0.95rem; min-height: 3rem;">আপনার নিজের টপ-আপ বিজনেস শুরু করার জন্য কমপ্লিট এ-টু-জেড গাইডলাইন।</p>
                        
                        <div class="d-flex align-items-center justify-content-between mt-auto">
                            <span class="text-white-50 small"><i class="bi bi-award me-2 text-primary"></i>Certified Guide</span>
                            <a href="landing/landingpage.php" class="btn-action" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; border-color: rgba(59, 130, 246, 0.2);">শুরু করুন <i class="bi bi-arrow-right-short ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Premium Card Base Styles */
    .service-card-premium {
        position: relative;
        background: rgba(30, 41, 59, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 32px;
        height: 100%;
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        overflow: hidden;
        cursor: pointer;
        backdrop-filter: blur(12px);
    }

    .service-card-premium:not(.clickable):not(.active-service) {
        cursor: default;
    }

    .card-inner {
        position: relative;
        z-index: 5;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    /* Hover Effects */
    .service-card-premium:hover {
        transform: translateY(-12px);
        background: rgba(30, 41, 59, 0.6);
        border-color: rgba(255, 215, 0, 0.3);
        box-shadow: 0 40px 80px -20px rgba(0, 0, 0, 0.6);
    }

    /* Icon Box Styling */
    .icon-box-premium {
        width: 72px;
        height: 72px;
        border-radius: 20px;
        border: 1px solid;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        transition: all 0.5s ease;
    }

    .service-card-premium:hover .icon-box-premium {
        transform: scale(1.1) rotate(8deg);
    }

    /* Popular Tag */
    .popular-tag {
        position: absolute;
        top: 25px;
        right: -35px;
        background: linear-gradient(135deg, #ffd700 0%, #daa520 100%);
        color: #0a192f;
        padding: 5px 40px;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        transform: rotate(45deg);
        z-index: 10;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    /* Button Action Styling */
    .btn-action {
        background: rgba(254, 44, 85, 0.1);
        border: 1px solid rgba(254, 44, 85, 0.2);
        color: #fe2c55;
        padding: 8px 18px;
        border-radius: 14px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
    }

    .btn-action:hover {
        background: #fe2c55;
        color: white;
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(254, 44, 85, 0.3);
    }

    /* Status Indicator for Coming Soon */
    .status-indicator {
        display: inline-flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.05);
        padding: 6px 15px;
        border-radius: 30px;
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.6);
        font-weight: 600;
    }

    .status-indicator .dot {
        width: 8px;
        height: 8px;
        background: #ffd700;
        border-radius: 50%;
        margin-right: 8px;
        box-shadow: 0 0 10px #ffd700;
        animation: pulse-dot 2s infinite;
    }

    @keyframes pulse-dot {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.5); opacity: 0.5; }
        100% { transform: scale(1); opacity: 1; }
    }

    /* Overlay Background Animation */
    .card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255, 215, 0, 0.05) 0%, transparent 50%);
        opacity: 0;
        transition: opacity 0.5s ease;
    }

    .service-card-premium:hover .card-overlay {
        opacity: 1;
    }

    /* Responsive Adjustments */
    @media (max-width: 991px) {
        .display-3 { font-size: 2.8rem; }
    }
    @media (max-width: 767px) {
        .display-3 { font-size: 2.2rem; }
        .service-card-premium { border-radius: 24px; }
    }
</style>

<?php include 'includes/footer.php'; ?>
