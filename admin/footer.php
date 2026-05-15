        </div> <!-- col-lg-9 End -->
    </div> <!-- row End -->
</div> <!-- container End -->

<?php if (isset($_SESSION['admin_id'])): ?>
<!-- Mobile Bottom Nav (Matching User Side Style) -->
<style>
    .admin-bottom-nav {
        display: none;
        position: fixed;
        bottom: 0;
        width: 100%;
        background: #1e293b;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        z-index: 1100;
        padding: 10px 0;
    }
    .bottom-nav-item {
        text-align: center;
        color: rgba(255, 255, 255, 0.5);
        text-decoration: none;
        font-size: 0.8rem;
        flex: 1;
    }
    .bottom-nav-item i { 
        font-size: 1.3rem; 
        display: block; 
    }
    .bottom-nav-item.active { 
        color: #3b82f6; 
    }
    @media (max-width: 991px) {
        .admin-bottom-nav { 
            display: flex; 
        }
    }
</style>

<div class="admin-bottom-nav">
    <?php 
        $current_page = basename($_SERVER['PHP_SELF']); 
        // Get pending premium requests count for the badge
        $pending_count_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM premium_requests WHERE status='pending'");
        $pending_count = ($pending_count_res) ? mysqli_fetch_assoc($pending_count_res)['total'] : 0;
        
        // Get pending OTP count for the badge
        $otp_count_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM otp_requests WHERE status='pending'");
        $otp_count = ($otp_count_res) ? mysqli_fetch_assoc($otp_count_res)['total'] : 0;
    ?>
    <a href="index.php" class="bottom-nav-item <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
        <i class="bi bi-grid-1x2-fill"></i> হোম
    </a>
    <a href="premium_requests.php" class="bottom-nav-item <?php echo ($current_page == 'premium_requests.php') ? 'active' : ''; ?> position-relative">
        <i class="bi bi-star-fill"></i>
        <?php if ($pending_count > 0): ?>
            <span class="position-absolute top-0 start-50 translate-middle-x badge rounded-pill bg-danger" style="font-size: 0.6rem; margin-top: -5px; margin-left: 10px;">
                <?php echo $pending_count; ?>
            </span>
        <?php endif; ?>
        প্রিমিয়াম
    </a>
    <a href="otp_requests.php" class="bottom-nav-item <?php echo ($current_page == 'otp_requests.php') ? 'active' : ''; ?> position-relative">
        <i class="bi bi-shield-lock-fill"></i>
        <?php if ($otp_count > 0): ?>
            <span class="position-absolute top-0 start-50 translate-middle-x badge rounded-pill bg-info" style="font-size: 0.6rem; margin-top: -5px; margin-left: 10px;">
                <?php echo $otp_count; ?>
            </span>
        <?php endif; ?>
        ওটিপি
    </a>
    <a href="users.php" class="bottom-nav-item <?php echo ($current_page == 'users.php') ? 'active' : ''; ?>">
        <i class="bi bi-people-fill"></i> ইউজার
    </a>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function copyOTP(otp) {
    navigator.clipboard.writeText(otp).then(() => {
        const toast = document.createElement('div');
        toast.style = "position:fixed; bottom:90px; left:50%; transform:translateX(-50%); background:#3b82f6; color:white; padding:10px 25px; border-radius:50px; font-weight:bold; z-index:9999; box-shadow:0 10px 20px rgba(0,0,0,0.3);";
        toast.innerHTML = "OTP " + otp + " Copied!";
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 2000);
    });
}
</script>
<?php if (isset($extra_js)) echo $extra_js; ?>
</body>
</html>