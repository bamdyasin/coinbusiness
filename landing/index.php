<?php
session_start();
include '../includes/db.php';

$referrer_name = "";
$ref_code = "";

// 1. Priority: URL parameter
if (isset($_GET['ref']) && !empty($_GET['ref'])) {
    $ref_code = mysqli_real_escape_string($conn, $_GET['ref']);
    $_SESSION['ref'] = $ref_code;
    // Store in cookie for 30 days
    setcookie('ref_code', $ref_code, time() + (86400 * 30), "/"); 
} 
// 2. Secondary: Session
elseif (isset($_SESSION['ref'])) {
    $ref_code = $_SESSION['ref'];
}
// 3. Fallback: Cookie
elseif (isset($_COOKIE['ref_code'])) {
    $ref_code = mysqli_real_escape_string($conn, $_COOKIE['ref_code']);
    $_SESSION['ref'] = $ref_code; // Sync back to session
}

// Fetch Referrer Name if we have a code
if (!empty($ref_code)) {
    $ref_query = mysqli_query($conn, "SELECT name FROM users WHERE referral_code = '$ref_code'");
    if ($row = mysqli_fetch_assoc($ref_query)) {
        $referrer_name = $row['name'];
    }
}

$page_title = 'coinstore.bd Course';
$root_path = '../';
$extra_css = '
<link rel="stylesheet" href="style.css">
<style>
    .ref-toast {
        position: fixed;
        top: 20px;
        right: 20px;
        background: rgba(30, 41, 59, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(59, 130, 246, 0.3);
        color: white;
        padding: 15px 25px;
        border-radius: 15px;
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        animation: slideIn 0.5s ease forwards;
    }
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    .ref-avatar {
        width: 40px;
        height: 40px;
        background: #3b82f6;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    @media (max-width: 991px) {
        body {
            padding-bottom: 80px;
        }
    }
</style>';

include '../includes/header.php';
?>

<?php if (!empty($referrer_name)): ?>
<div class="ref-toast" id="refToast">
    <div class="ref-avatar"><?php echo strtoupper(substr($referrer_name, 0, 1)); ?></div>
    <div>
        <small class="text-white-50 d-block" style="font-size: 0.7rem;">Referred By</small>
        <span class="fw-bold"><?php echo $referrer_name; ?></span>
    </div>
    <button type="button" class="btn-close btn-close-white ms-2" onclick="document.getElementById('refToast').remove()"></button>
</div>
<script>
    setTimeout(() => {
        const toast = document.getElementById('refToast');
        if(toast) {
            toast.style.transition = '0.5s';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 500);
        }
    }, 2000); // 2 seconds
</script>
<?php endif; ?>

<!-- HERO -->

<section class="hero">

  <div class="container">

    <div class="row align-items-center g-5">

      <div class="col-lg-6">

        <h1>
          মাত্র ৩০০০ টাকায়
          শুরু করুন
          <span>অনলাইন বিজনেস</span>
        </h1>

        <p>
          ২৫% পর্যন্ত প্রফিট, ৮০%+ রিপিট কাস্টমার
          এবং যেকোনো জায়গা থেকে ব্যবসা পরিচালনার সুযোগ।
        </p>

        <div class="stats-card">

          <div class="row text-center">

            <div class="col-4">
              <div class="stats-item">
                <h3>২৫%</h3> 
                <p>নিট-প্রফিট</p>
              </div>
            </div>

            <div class="col-4">
              <div class="stats-item">
                <h3>৮০%+</h3>
                <p>রিপিট-Sell</p>
              </div>
            </div>

            <div class="col-4">
              <div class="stats-item">
                <h3>৩০০০৳</h3>
                <p>স্বল্প-পুজি</p>
              </div>
            </div>

          </div>

        </div>

        <!-- BUTTONS -->

        <div class="d-flex gap-3 flex-wrap mt-4 justify-content-center justify-content-lg-start">

          <a href="../user/register.php" class="btn btn-main">
            🔥 এখনই এনরোল করুন
          </a>

          <a href="../payment/payment.html" class="btn btn-outline-custom">
            ▶ ভিডিও দেখুন
          </a>

        </div>

      </div>

      <div class="col-lg-6">

        <div class="hero-card">

          <img src="images.jpg" alt="Business Image">

          <div class="floating-badge">

            <small>Net Profit</small>

            <h4>25%</h4>

          </div>

        </div>

      </div>

    </div>

  </div>

</section>

<!-- FEATURES -->

<section>

  <div class="container">

    <div class="section-title">
      <h2>কেন এই বিজনেস শুরু করবেন?</h2>
    </div>

    <!-- Desktop -->

    <div class="row g-4 d-none d-md-flex">

      <div class="col-md-6 col-lg-3">
        <div class="feature-card">
          <div class="feature-icon">
            <i class="bi bi-clock-history"></i>
          </div>
          <h5>Long Term Business</h5>
          <p>দীর্ঘ সময় ধরে ব্যবসা পরিচালনা করা সম্ভব।</p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="feature-card">
          <div class="feature-icon">
            <i class="bi bi-people-fill"></i>
          </div>
          <h5>Repeat Customer</h5>
          <p>৮০%+ কাস্টমার বারবার অর্ডার করে।</p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="feature-card">
          <div class="feature-icon">
            <i class="bi bi-wallet2"></i>
          </div>
          <h5>Low Investment</h5>
          <p>মাত্র ৩০০০ টাকা দিয়েই শুরু করা সম্ভব।</p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="feature-card">
          <div class="feature-icon">
            <i class="bi bi-phone-fill"></i>
          </div>
          <h5>Work Anywhere</h5>
          <p>শুধু মোবাইল দিয়েই ব্যবসা পরিচালনা সম্ভব।</p>
        </div>
      </div>

    </div>

    <!-- Mobile -->

    <div class="d-block d-md-none">

      <div class="mobile-combined-card">

        <div class="mobile-item">

          <div class="mobile-icon">
            <i class="bi bi-clock-history"></i>
          </div>

          <div class="mobile-content">
            <h5>Long Term Business</h5>
            <p>দীর্ঘ সময় ধরে ব্যবসা পরিচালনা করা সম্ভব।</p>
          </div>

        </div>

        <div class="mobile-item">

          <div class="mobile-icon">
            <i class="bi bi-people-fill"></i>
          </div>

          <div class="mobile-content">
            <h5>Repeat Customer</h5>
            <p>৮০%+ কাস্টমার বারবার অর্ডার করে।</p>
          </div>

        </div>

        <div class="mobile-item">

          <div class="mobile-icon">
            <i class="bi bi-wallet2"></i>
          </div>

          <div class="mobile-content">
            <h5>Low Investment</h5>
            <p>মাত্র ৩০০০ টাকা দিয়েই শুরু করা সম্ভব।</p>
          </div>

        </div>

        <div class="mobile-item">

          <div class="mobile-icon">
            <i class="bi bi-phone-fill"></i>
          </div>

          <div class="mobile-content">
            <h5>Work Anywhere</h5>
            <p>শুধু মোবাইল দিয়েই ব্যবসা পরিচালনা সম্ভব।</p>
          </div>

        </div>

      </div>

    </div>

  </div>

</section>

<!-- PACKAGES -->

<section>

  <div class="container">

    <div class="section-title">
      <h2>এই ৩০০০ টাকায় কী কী পাচ্ছেন?</h2>
    </div>

    <!-- Desktop -->

    <div class="row g-4 d-none d-md-flex">

      <div class="col-md-6 col-lg-3">
        <div class="package-card">
          <div class="package-number">01</div>
          <img src="https://cdn-icons-png.flaticon.com/512/196/196578.png">
          <h4>Visa Card</h4>
          <p><b>10 USD = 1300 টাকা।</b></p>
          <p>যা ব্যাংকের মাধ্যমে করতে পাসপোর্টসহ ১০–১২ হাজার টাকা লাগতে পারে।</p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="package-card">
          <div class="package-number">02</div>
          <img src="https://cdn-icons-png.flaticon.com/512/2489/2489756.png">
          <h4>Account Balance</h4>
          <p><b>5.5 USD = 700 টাকা।</b></p>
          <p>এটা আপনার একাউন্ট এ থাকবে এবং এটাই আপনার বিজনেসের পুজি।</p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="package-card">
          <div class="package-number">03</div>
          <img src="https://cdn-icons-png.flaticon.com/512/226/226770.png">
          <h4>Android App</h4>
          <p><b>প্রিমিয়াম প্রাইস = 1000 টাকা।</b></p>
          <p>এটা কম্পিউটার এর বিকল্প হিসেবে কাজ করবে, যেকোনো জায়গা থেকে কাজ করতে পারবেন।</p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="package-card">
          <div class="package-number">04</div>
          <img src="https://cdn-icons-png.flaticon.com/512/1006/1006771.png">
          <h4>Website Code</h4>
          <p><b>সম্পূর্ণ FREE Website Code</b></p>
          <p>কাস্টমার বাড়লে ওয়েবসাইট থাকলে ভালো এবং বিসনেস বড় করা সহজ হয় ।</p>
        </div> 
      </div>
 
    </div>

    <!-- Mobile -->

    <div class="d-block d-md-none">

      <div class="mobile-combined-card">

        <div class="mobile-item">

          <div class="mobile-icon">
            <img src="https://cdn-icons-png.flaticon.com/512/196/196578.png">
          </div>

          <div class="mobile-content">
            <h5>Visa Card</h5>
            <p>10 USD = 1300 টাকা</p>
          </div>

        </div>

        <div class="mobile-item">

          <div class="mobile-icon">
            <img src="https://cdn-icons-png.flaticon.com/512/2489/2489756.png">
          </div>

          <div class="mobile-content">
            <h5>Account Balance</h5>
            <p>5.5 USD = 700 টাকা</p>
          </div>

        </div>

        <div class="mobile-item">

          <div class="mobile-icon">
            <img src="https://cdn-icons-png.flaticon.com/512/226/226770.png">
          </div>

          <div class="mobile-content">
            <h5>Android App</h5>
            <p>প্রিমিয়াম প্রাইস = 1000 টাকা।</p>
          </div>

        </div>

        <div class="mobile-item">

          <div class="mobile-icon">
            <img src="https://cdn-icons-png.flaticon.com/512/1006/1006771.png">
          </div>

          <div class="mobile-content">
            <h5>Website Code</h5>
            <p>সম্পূর্ণ FREE Website Code</p>
          </div>

        </div>

      </div>

    </div>

  </div>

</section>

<!-- COURSE -->

<section>

  <div class="container">

    <div class="course-box">

      <div class="row align-items-center g-5">

        <div class="col-lg-6">

          <h2 class="fw-bold mb-4">
            কোর্সে যা যা থাকছে
          </h2>

          <ul class="course-list list-unstyled">

            <li>✅ Full Video Tutorial</li>
            <li>✅ Business Setup Guide</li>
            <li>✅ Android App Setup</li>
            <li>✅ Customer Handling System</li>
            <li>✅ Support & Guidance</li> 

          </ul>

        </div>

        <div class="col-lg-6">

          <div class="refund-card text-center">

            <h2 class="fw-bold mb-4">
              Refund Guarantee <i class="bi bi-patch-check-fill text-primary"></i>
            </h2>

            <p class="fs-5 text-secondary">
              Business Details দেখার পর Interested না হলে
              সম্পূর্ণ টাকা Refund করে দেওয়া হবে।
            </p>

            <a href="../user/register.php" class="btn btn-main mt-3">
              এখনই শুরু করুন
            </a>

          </div>

        </div>

      </div>

    </div>

  </div>

</section>

<!-- CTA -->

<section>

  <div class="container">

    <div class="cta">

      <h2>
        আজই শুরু করুন আপনার
        Online Business Journey 🚀
      </h2>

      <p>
        মাত্র ২০ মিনিটের ভিডিও দেখেই A to Z সবকিছু বুঝে যাবেন।
      </p>

      <a href="../user/register.php" class="btn btn-light btn-lg px-5 py-3 rounded-4 mt-4 fw-bold">
        🔥 এখনই এনরোল করুন
      </a>

    </div>

  </div>

</section>

<?php include '../includes/footer.php'; ?>
