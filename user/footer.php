<footer class="footer mt-auto d-none d-lg-block">
  <div class="container text-center">
    <div class="row align-items-center">
        <div class="col-md-6 text-md-start mb-3 mb-md-0">
            <span class="footer-text">© 2026 <span class="text-primary fw-bold">CoinStore.bd</span>. All Rights Reserved.</span>
        </div>
        <div class="col-md-6 text-md-end">
            <div class="d-flex justify-content-center justify-content-md-end gap-3">
                <a href="#" class="footer-link small">Terms</a>
                <a href="#" class="footer-link small">Privacy</a>
                <a href="#" class="footer-link small">Support</a>
            </div>
        </div>
    </div>
  </div>
</footer>

<?php if (isset($_SESSION['user_id'])): ?>
<!-- Mobile Bottom Nav -->
<?php 
    $current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="bottom-nav d-lg-none">
    <a href="dashboard.php" class="bottom-nav-item <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
        <i class="bi bi-speedometer2"></i> হোম
    </a>
    <a href="../referral/index.php" class="bottom-nav-item <?php echo (strpos($_SERVER['PHP_SELF'], '/referral/') !== false) ? 'active' : ''; ?>">
        <i class="bi bi-gift"></i> এফিলিয়েট
    </a>
    <a href="payment.php" class="bottom-nav-item <?php echo ($current_page == 'payment.php') ? 'active' : ''; ?>">
        <i class="bi bi-wallet2"></i> পেমেন্ট
    </a>
    <a href="profile.php" class="bottom-nav-item <?php echo ($current_page == 'profile.php') ? 'active' : ''; ?>">
        <i class="bi bi-person"></i> প্রোফাইল
    </a>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php if (isset($extra_js)) echo $extra_js; ?>
</body>
</html>
