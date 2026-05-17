<?php
$page_title = 'TikTok Top-Up';
$root_path = '../';
include '../includes/header.php';
?>

<div class="container mt-4 mb-5">
    <div class="row g-4">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>

        <!-- Main Content -->
        <div class="col-lg-9">
            
            <div class="app-card shadow-lg">
                <!-- Professional Hero Section Inside Card -->
                <div class="hero-section text-center mb-5">
                    <div class="hero-glow"></div>
                    <p class="hero-subtitle mb-2">Premium Growth Service</p>
                    <h1 class="hero-slogan">ভাইরাল হোন <span style="color: #fe2c55; -webkit-text-fill-color: #fe2c55;">নিজের স্টাইলে</span></h1>
                    <p class="text-white-50 mt-3">ক্যাটাগরি নির্বাচন করুন</p>
                </div>

                <!-- Tab Navigation (Buttons Only) -->
                <div class="tabs-btn-container">
                    <ul class="nav nav-pills" id="tiktokTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="boost-tab" data-bs-toggle="pill" data-bs-target="#boost" type="button" role="tab" aria-controls="boost" aria-selected="true"><i class="bi bi-rocket-takeoff"></i> Boost Now</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="coin-tab" data-bs-toggle="pill" data-bs-target="#coin" type="button" role="tab" aria-controls="coin" aria-selected="false"><i class="bi bi-coin"></i> Get Coin</button>
                        </li>
                    </ul>
                </div>

                <form action="../user/payment.php" method="GET">
                    <input type="hidden" name="product" value="TikTok">
                    
                    <div class="tab-content" id="tiktokTabContent">
                        <!-- Boost Now Tab -->
                        <div class="tab-pane fade show active" id="boost" role="tabpanel">
                            <div class="mb-4">
                                <label class="form-label text-white-50 small"><i class="bi bi-caret-right-fill me-1 text-tiktok-sm"></i>প্রমোটের ধরন</label>
                                <select class="form-select" name="promo_type" required>
                                    <option value="Video Views" selected>ভিডিও ভিউ বাড়ান</option>
                                    <option value="Likes & Comments">লাইক এবং কমেন্ট</option>
                                    <option value="More Followers">ফলোয়ার বাড়ান</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-white-50 small"><i class="bi bi-caret-right-fill me-1 text-tiktok-sm"></i>আপনার বাজেট (টাকা)</label>
                                <div class="budget-counter">
                                    <button type="button" class="counter-btn" onclick="updateBudget(-100)">−</button>
                                    <input type="number" class="budget-input" name="budget" id="budget_val" value="200" min="200" step="100">
                                    <button type="button" class="counter-btn" onclick="updateBudget(100)">+</button>
                                </div>
                                <div class="form-text text-white-50 small mt-2">
                                    <i class="bi bi-info-circle me-1"></i> সর্বনিম্ন: 5,000 ভিউ & 1,000 লাইক
                                </div>
                            </div>
                        </div>
                        
                        <!-- Get Coin Tab -->
                        <div class="tab-pane fade" id="coin" role="tabpanel">
                            <div class="mb-4">
                                <label class="form-label text-white-50 small"><i class="bi bi-caret-right-fill me-1 text-tiktok-sm"></i>কয়েনের পরিমাণ</label>
                                <div class="budget-counter">
                                    <button type="button" class="counter-btn" onclick="updateCoins(-10)">−</button>
                                    <input type="number" class="budget-input" name="coin_amount" id="coin_val" value="50" min="50" step="10">
                                    <button type="button" class="counter-btn" onclick="updateCoins(10)">+</button>
                                </div>
                                <div class="form-text text-white-50 small mt-2">
                                    <i class="bi bi-info-circle me-1"></i> সর্বনিম্ন: ৫০ কয়েন
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ID Section (Dynamically updated by JS) -->
                    <div id="video_link_section">
                        <div class="mb-4">
                            <label class="form-label text-white-50 small" id="id_label">টিকটক ভিডিও লিংক (Video Link)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0 text-white-50" id="id_icon"><i class="bi bi-link-45deg"></i></span>
                                <input type="text" class="form-control border-start-0" name="player_id" id="video_url_input" placeholder="https://www.tiktok.com/@username/video/..." required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-white-50 small"><i class="bi bi-caret-right-fill me-1 text-tiktok-sm"></i>আপনার হোয়াটসঅ্যাপ নম্বর</label>
                        <input type="text" class="form-control" name="whatsapp" placeholder="017XXXXXXXX" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label text-white-50 small"><i class="bi bi-caret-right-fill me-1 text-tiktok-sm"></i>পেমেন্ট মাধ্যম</label>
                            <select class="form-select" name="payment_method" id="payment_method" required onchange="updatePaymentInfo()">
                                <option value="" selected disabled>পছন্দ করুন</option>
                                <option value="bKash">বিকাশ (bKash)</option>
                                <option value="Nagad">নগদ (Nagad)</option>
                                <option value="Rocket">রকেট (Rocket)</option>
                            </select>
                            
                            <!-- Dynamic Payment Info -->
                            <div id="payment_info_box" class="mt-3 p-3 rounded-3 d-none" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="small text-white-50" id="method_display">bKash</span>
                                    <span class="badge bg-primary px-2 py-1" style="font-size: 0.65rem;" id="account_type">Personal</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold fs-5 text-white" id="payment_number">017XXXXXXXX</span>
                                    <button type="button" class="btn btn-sm btn-link text-tiktok-sm p-0 text-decoration-none" onclick="copyNumber()">
                                        <i class="bi bi-copy me-1"></i> Copy
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label text-white-50 small"><i class="bi bi-caret-right-fill me-1 text-tiktok-sm"></i>ট্রানজেকশন আইডি (TrxID)</label>
                            <input type="text" class="form-control" name="trxid" placeholder="8N72KL9X" required>

                            <small class="text-tiktok-sm fw-500">
                                <i class="bi bi-info-circle me-1"></i> টাকা পাঠানোর পর মেসেজে <b>TrxID</b> পাবেন। 
                            </small>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-tiktok w-100 fs-5">
                        অর্ডার কনফার্ম করুন <i class="bi bi-arrow-right-circle ms-2"></i>
                    </button>
                </form>
            </div>

            <div class="mt-5 p-4 rounded-4" style="background: rgba(255,255,255,0.03); border: 1px dashed rgba(255,255,255,0.1);">
                <h6 class="fw-bold text-white mb-3"><i class="bi bi-info-circle text-warning me-2"></i> জরুরি নির্দেশনা:</h6>
                <ul class="text-white-50 small mb-0">
                    <li class="mb-2">অর্ডার করার ১০-৩০ মিনিটের মধ্যে সার্ভিস ডেলিভারি করা হবে।</li>
                    <li id="rule_public" class="mb-2">ভিডিও অবশ্যই পাবলিক হতে হবে (Private ভিডিওতে কাজ হবে না)।</li>
                    <li>যেকোনো প্রয়োজনে আমাদের সাপোর্ট টিমে যোগাযোগ করুন।</li>
                </ul>
            </div>

            <!-- FAQ Section -->
            <div class="app-card shadow-lg mt-5">
                <h4 class="fw-bold text-white mb-4"><i class="bi bi-question-circle text-tiktok-sm me-2"></i> গ্রাহকদের সাধারণ প্রশ্নাবলী</h4>
                <div class="accordion accordion-flush custom-accordion" id="faqAccordion">
                    <div class="accordion-item faq-item mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed bg-transparent text-white fw-bold px-3 py-3 shadow-none d-block" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                <div>(বুস্ট করুন) অপশন কাদের জন্য?</div>
                                <div class="faq-preview text-white-50 small fw-normal mt-1 text-truncate-1">যারা ভিডিও বুস্ট করার বিষয়ে কিছুই জানেন না (বুস্ট করুন) অপশন তাদের জন্য। আপনি পেমেন্ট করার পর আপনার ভিডিও লিংক ও পেমেন্ট ইনফো সাবমিট করবেন...</div>
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-white-50 px-3 pt-0">
                                যারা ভিডিও বুস্ট করার বিষয়ে কিছুই জানেন না (বুস্ট করুন) অপশন তাদের জন্য। আপনি পেমেন্ট করার পর আপনার ভিডিও লিংক ও পেমেন্ট ইনফো সাবমিট করবেন এরপর বাকি সমস্ত কাজ আমরা সততা, দক্ষতা এবং আন্তরিকতার সাথে সম্পন্ন করব।
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item faq-item mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed bg-transparent text-white fw-bold px-3 py-3 shadow-none d-block" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                <div>(কয়েন নিন) অপশন কাদের জন্য?</div>
                                <div class="faq-preview text-white-50 small fw-normal mt-1 text-truncate-1">যারা নিজের ভিডিও নিজেই বুস্ট করতে পারেন বা শুধুমাত্র কয়েন নিতে চান তাদের জন্য (কয়েন নিন) অপসন।</div>
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-white-50 px-3 pt-0">
                                যারা নিজের ভিডিও নিজেই বুস্ট করতে পারেন বা শুধুমাত্র কয়েন নিতে চান তাদের জন্য (কয়েন নিন) অপসন।
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item faq-item mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed bg-transparent text-white fw-bold px-3 py-3 shadow-none d-block" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                <div>আমাদের থেকে কেন সার্ভিস নিবেন?</div>
                                <div class="faq-preview text-white-50 small fw-normal mt-1 text-truncate-1">আমরা সততা, দক্ষতা এবং আন্তরিকতার সাথে গ্রাহকের দেয়া কাজ সঠিক সময়ে সম্পন্ন করে থাকি। তাই ১০০% নিশ্চিন্তে...</div>
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-white-50 px-3 pt-0">
                                আমরা সততা, দক্ষতা এবং আন্তরিকতার সাথে গ্রাহকের দেয়া কাজ সঠিক সময়ে সম্পন্ন করে থাকি। তাই ১০০% নিশ্চিন্তে ও নিরাপদে আপনি আমাদের থেকে সার্ভিস নিতে পারেন।
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Testimonials Section -->
            <div class="app-card shadow-lg mt-5 mb-5">
                <h4 class="fw-bold text-white mb-4"><i class="bi bi-chat-heart text-tiktok-sm me-2"></i> গ্রাহকদের মতামত</h4>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="testimonial-card h-100 p-4 rounded-4">
                            <div class="stars mb-2">★★★★★</div>
                            <p class="text-white-50 small italic mb-3">"আলহামদুলিল্লাহ, তাদের সার্ভিস অনেক ভালো। আমি তাদের থেকে একাধিক বার সার্ভিস নিয়েছি। Highly recommended."</p>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-tiktok text-white rounded-circle me-2 d-flex align-items-center justify-content-center">T</div>
                                <div>
                                    <h6 class="mb-0 text-white small fw-bold">Tanvir Ahmed</h6>
                                    <small class="text-tiktok-sm" style="font-size: 0.7rem;">প্রমোট কাস্টমার</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="testimonial-card h-100 p-4 rounded-4">
                            <div class="stars mb-2">★★★★★</div>
                            <p class="text-white-50 small italic mb-3">"ওনাদের সার্ভিস অনেক ভালো। ৫ মিনিটের মধ্যে coin দিয়ে দেয়। আপনারা চাইলে ওনাদের থেকে কয়েন নিতে পারেন। সার্ভিস ভালো পাবেন আশাকরি।"</p>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-tiktok text-white rounded-circle me-2 d-flex align-items-center justify-content-center">R</div>
                                <div>
                                    <h6 class="mb-0 text-white small fw-bold">Rahat Kabir</h6>
                                    <small class="text-tiktok-sm" style="font-size: 0.7rem;">কয়েন কালেক্টর</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="testimonial-card h-100 p-4 rounded-4">
                            <div class="stars mb-2">★★★★☆</div>
                            <p class="text-white-50 small italic mb-3">"অনেক ভালো business রিলিটেড সাপোর্ট দিয়ে থাকে। খুঁটিনাটি ও সিক্রেট বিষয়ে সহজ ভাবে আলোচনা করে. ওনাদের টিম পারদর্শী। আমি ১০০% রিকোমেন্ড করি।"</p>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-tiktok text-white rounded-circle me-2 d-flex align-items-center justify-content-center">S</div>
                                <div>
                                    <h6 class="mb-0 text-white small fw-bold">Sultana Kamal</h6>
                                    <small class="text-tiktok-sm" style="font-size: 0.7rem;">কনসালটেন্সি হোল্ডার</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>
            </div>
            </div>

<script>
    const paymentData = {
        'bKash': { number: '017XXXXXXXX', type: 'Personal' },
        'Nagad': { number: '018XXXXXXXX', type: 'Personal' },
        'Rocket': { number: '019XXXXXXXX', type: 'Personal' }
    };

    function updatePaymentInfo() {
        const select = document.getElementById('payment_method');
        const infoBox = document.getElementById('payment_info_box');
        const methodDisplay = document.getElementById('method_display');
        const accountType = document.getElementById('account_type');
        const paymentNumber = document.getElementById('payment_number');
        
        const selected = select.value;
        
        if (selected && paymentData[selected]) {
            methodDisplay.innerText = selected;
            accountType.innerText = paymentData[selected].type;
            paymentNumber.innerText = paymentData[selected].number;
            infoBox.classList.remove('d-none');
        } else {
            infoBox.classList.add('d-none');
        }
    }

    function copyNumber() {
        const number = document.getElementById('payment_number').innerText;
        navigator.clipboard.writeText(number).then(() => {
            const btn = event.currentTarget;
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check2"></i> Copied';
            setTimeout(() => {
                btn.innerHTML = originalHtml;
            }, 2000);
        });
    }

    function updateBudget(change) {
        const input = document.getElementById('budget_val');
        let newVal = parseInt(input.value) + change;
        if (newVal < 200) newVal = 200;
        input.value = newVal;
    }

    function updateCoins(change) {
        const input = document.getElementById('coin_val');
        let newVal = parseInt(input.value) + change;
        if (newVal < 50) newVal = 50;
        input.value = newVal;
    }

    document.addEventListener('DOMContentLoaded', function() {
        var boostTab = document.getElementById('boost-tab');
        var coinTab = document.getElementById('coin-tab');

        if(boostTab && coinTab) {
            boostTab.addEventListener('shown.bs.tab', function () {
                document.getElementById('video_link_section').style.display = 'block';
                document.getElementById('video_url_input').setAttribute('required', 'required');
                document.getElementById('rule_public').innerText = 'ভিডিও অবশ্যই পাবলিক হতে হবে (Private ভিডিওতে কাজ হবে না)।';
            });

            coinTab.addEventListener('shown.bs.tab', function () {
                document.getElementById('video_link_section').style.display = 'none';
                document.getElementById('video_url_input').removeAttribute('required');
                document.getElementById('rule_public').innerText = 'অর্ডার করার পর আমাদের হোয়াটসঅ্যাপে যোগাযোগ করুন।';
            });
        }
    });
</script>

<?php include '../includes/footer.php'; ?>
