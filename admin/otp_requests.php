<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Handle OTP Deletion
if (isset($_GET['delete_otp'])) {
    $otp_id = intval($_GET['delete_otp']);
    mysqli_query($conn, "DELETE FROM otp_requests WHERE id = $otp_id");
    header("Location: otp_requests.php?msg=deleted");
    exit();
}

// Handle Manual Verification
if (isset($_GET['verify_otp'])) {
    $otp_id = intval($_GET['verify_otp']);
    mysqli_query($conn, "UPDATE otp_requests SET status = 'verified' WHERE id = $otp_id");
    header("Location: otp_requests.php?msg=verified");
    exit();
}

$page_title = "OTP Requests - CoinStore.bd";
include 'header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1" style="color: white;">OTP Requests</h2>
        <p style="color: rgba(255,255,255,0.6);">Monitor and verify recent user OTP requests</p>
    </div>
    <button class="btn btn-outline-info rounded-pill px-4" onclick="location.reload()">
        <i class="bi bi-arrow-clockwise me-2"></i>Refresh List
    </button>
</div>

<div class="app-card">
    <div class="row g-3">
        <?php
        $otp_query = mysqli_query($conn, "SELECT * FROM otp_requests ORDER BY FIELD(status, 'pending', 'verified', 'expired'), id DESC");
        if ($otp_query && mysqli_num_rows($otp_query) > 0) {
            while ($row = mysqli_fetch_assoc($otp_query)) {
                $status_class = 'status-' . $row['status'];
                ?>
                <div class="col-md-6">
                    <div class="p-3 rounded-4 border border-white border-opacity-10 mb-2">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold"><?php echo $row['phone']; ?></span>
                            <span class="status-pill <?php echo $status_class; ?>"><?php echo ucfirst($row['status']); ?></span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="otp-code-box"><?php echo $row['otp_code']; ?></div>
                            <button class="btn btn-sm btn-primary rounded-pill px-3" onclick="copyOTP('<?php echo $row['otp_code']; ?>')">Copy</button>
                        </div>
                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <div class="text-white-50 small">
                                <i class="bi bi-clock me-1"></i> Expires: <?php echo date('h:i A', strtotime($row['expires_at'])); ?>
                            </div>
                            <div class="d-flex gap-2">
                                <?php if ($row['status'] != 'verified'): ?>
                                    <a href="?verify_otp=<?php echo $row['id']; ?>" class="btn btn-sm btn-success rounded-pill px-3" onclick="return confirm('Verify?')">Verify</a>
                                <?php endif; ?>
                                <?php if ($row['status'] != 'pending'): ?>
                                    <a href="?delete_otp=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill px-2" onclick="return confirm('Delete?')"><i class="bi bi-trash"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div class='col-12 text-center text-white-50 py-5'>No OTP requests found</div>";
        }
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>