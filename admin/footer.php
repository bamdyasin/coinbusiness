        </div> <!-- col-lg-9 End -->
    </div> <!-- row End -->
</div> <!-- container End -->

<!-- Mobile Bottom Nav (Matching User Side) -->
<style>
    .admin-bottom-nav {
        display: none;
        position: fixed;
        bottom: 20px;
        left: 20px;
        right: 20px;
        background: rgba(30, 41, 59, 0.8);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        z-index: 1100;
        padding: 10px 5px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    }
    .bottom-nav-item {
        text-align: center;
        color: rgba(255, 255, 255, 0.5);
        text-decoration: none;
        font-size: 0.7rem;
        flex: 1;
    }
    .bottom-nav-item i { font-size: 1.3rem; display: block; }
    .bottom-nav-item.active { color: #3b82f6; }
    @media (max-width: 991px) {
        .admin-bottom-nav { display: flex; }
    }
</style>
<div class="admin-bottom-nav">
    <a href="index.php" class="bottom-nav-item active">
        <i class="bi bi-grid-1x2-fill"></i> হোম
    </a>
    <a href="users.php" class="bottom-nav-item">
        <i class="bi bi-people-fill"></i> ইউজার
    </a>
    <a href="orders.php" class="bottom-nav-item">
        <i class="bi bi-cart-fill"></i> অর্ডার
    </a>
    <a href="logout.php" class="bottom-nav-item text-danger">
        <i class="bi bi-box-arrow-right"></i> লগআউট
    </a>
</div>

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
</body>
</html>