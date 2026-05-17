<?php if (isset($show_sidebar) && $show_sidebar): ?>
            <!-- Extra spacer for mobile bottom nav -->
            <div class="d-lg-none" style="height: 50px;"></div>
        </div> <!-- End col-lg-9 -->
    </div> <!-- End row -->
</div> <!-- End container -->

<!-- Mobile Bottom Nav -->
<div class="bottom-nav d-lg-none">
    <?php $curr = basename($_SERVER['PHP_SELF']); ?>
    <a href="dashboard.php" class="bottom-nav-item <?php echo ($curr == 'dashboard.php') ? 'active' : ''; ?>">
        <i class="bi bi-speedometer2"></i> হোম
    </a>
    <a href="affiliate.php" class="bottom-nav-item <?php echo ($curr == 'affiliate.php') ? 'active' : ''; ?>">
        <i class="bi bi-gift"></i> এফিলিয়েট
    </a>
    <a href="payment.php" class="bottom-nav-item <?php echo ($curr == 'payment.php') ? 'active' : ''; ?>">
        <i class="bi bi-wallet2"></i> পেমেন্ট
    </a>
    <a href="profile.php" class="bottom-nav-item <?php echo ($curr == 'profile.php') ? 'active' : ''; ?>">
        <i class="bi bi-person"></i> প্রোফাইল
    </a>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php if (isset($extra_js)) echo $extra_js; ?>
</body>
</html>