<?php if (isset($_SESSION['user_id'])): ?>
<!-- Mobile Bottom Nav -->
<?php 
    $current_page = basename($_SERVER['PHP_SELF']);
    $is_in_referral = (strpos($_SERVER['PHP_SELF'], '/referral/') !== false);
    $user_dir = $is_in_referral ? '../user/' : '';
    $ref_dir = $is_in_referral ? '' : '../referral/';
?>
<div class="bottom-nav">
    <a href="<?php echo $user_dir; ?>dashboard.php?view=overview" class="bottom-nav-item <?php echo (isset($view) && $view == 'overview' && !$is_in_referral) ? 'active' : ''; ?>">
        <i class="bi bi-speedometer2"></i> হোম
    </a>
    <a href="<?php echo $ref_dir; ?>index.php" class="bottom-nav-item <?php echo ($is_in_referral) ? 'active' : ''; ?>">
        <i class="bi bi-gift"></i> এফিলিয়েট
    </a>
    <a href="<?php echo $user_dir; ?>payment.php" class="bottom-nav-item <?php echo ($current_page == 'payment.php') ? 'active' : ''; ?>">
        <i class="bi bi-wallet2"></i> পেমেন্ট
    </a>
    <a href="<?php echo $user_dir; ?>profile.php" class="bottom-nav-item <?php echo ($current_page == 'profile.php') ? 'active' : ''; ?>">
        <i class="bi bi-person"></i> প্রোফাইল
    </a>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php if (isset($extra_js)) echo $extra_js; ?>
</body>
</html>
