<?php
$page_title = "Admin Dashboard - CoinStore.bd";
include 'header.php';

// Handle OTP Deletion
if (isset($_GET['delete_otp'])) {
    $otp_id = intval($_GET['delete_otp']);
    mysqli_query($conn, "DELETE FROM otp_requests WHERE id = $otp_id");
    header("Location: index.php?msg=deleted");
    exit();
}

// Handle Manual Verification
if (isset($_GET['verify_otp'])) {
    $otp_id = intval($_GET['verify_otp']);
    mysqli_query($conn, "UPDATE otp_requests SET status = 'verified' WHERE id = $otp_id");
    header("Location: index.php?msg=verified");
    exit();
}

// Handle Premium Request Actions
if (isset($_GET['action']) && isset($_GET['req_id'])) {
    $req_id = intval($_GET['req_id']);
    $action = $_GET['action'];

    if ($action == 'approve') {
        $req_query = mysqli_query($conn, "SELECT * FROM premium_requests WHERE id = $req_id");
        $req_data = mysqli_fetch_assoc($req_query);
        $u_id = $req_data['user_id'];

        mysqli_query($conn, "UPDATE premium_requests SET status = 'approved' WHERE id = $req_id");
        mysqli_query($conn, "UPDATE users SET payment_status = 'Paid' WHERE id = $u_id");

        $user_query = mysqli_query($conn, "SELECT referred_by FROM users WHERE id = $u_id");
        $user_data = mysqli_fetch_assoc($user_query);
        $ref_by = $user_data['referred_by'];

        if (!empty($ref_by)) {
            mysqli_query($conn, "UPDATE users SET balance = balance + 100.00 WHERE referral_code = '$ref_by'");
        }

        header("Location: index.php?msg=approved");
        exit();
    } elseif ($action == 'reject') {
        mysqli_query($conn, "UPDATE premium_requests SET status = 'rejected' WHERE id = $req_id");
        header("Location: index.php?msg=rejected");
        exit();
    } elseif ($action == 'delete_req') {
        mysqli_query($conn, "DELETE FROM premium_requests WHERE id = $req_id");
        header("Location: index.php?msg=req_deleted");
        exit();
    }
}
?>

<!-- Welcome Banner -->
<div class="motivation-card shadow">
    <h3 class="fw-bold text-white mb-2">এডমিন ড্যাশবোর্ডে স্বাগতম!</h3>
    <p class="mb-0 text-white-50">এখান থেকে আপনি ইউজার, পেমেন্ট এবং ওটিপি রিকোয়েস্টগুলো ম্যানেজ করতে পারবেন।</p>
</div>

<!-- Quick Stats -->
<div class="row g-3 mb-4 text-center">
    <div class="col-6 col-md-4">
        <div class="app-card py-3">
            <?php 
                $u_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
                $u_row = mysqli_fetch_assoc($u_res);
            ?>
            <h3 class="fw-bold text-primary mb-0"><?php echo $u_row['total']; ?></h3>
            <small class="text-white-50">মোট ইউজার</small>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="app-card py-3">
            <?php 
                $p_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM premium_requests WHERE status='pending'");
                $p_row = mysqli_fetch_assoc($p_res);
            ?>
            <h3 class="fw-bold text-warning mb-0"><?php echo $p_row['total']; ?></h3>
            <small class="text-white-50">পেন্ডিং পেমেন্ট</small>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="app-card py-3">
            <?php 
                $o_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM otp_requests WHERE status='pending'");
                $o_row = mysqli_fetch_assoc($o_res);
            ?>
            <h3 class="fw-bold text-info mb-0"><?php echo $o_row['total']; ?></h3>
            <small class="text-white-50">পেন্ডিং ওটিপি</small>
        </div>
    </div>
</div>

<!-- Premium Requests -->
<div class="app-card">
    <h5 class="fw-bold mb-4"><i class="bi bi-star-fill text-warning me-2"></i> Premium Requests</h5>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Method</th>
                    <th>TrxID</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $pre_query = mysqli_query($conn, "SELECT pr.*, u.name as user_name, u.phone as user_phone FROM premium_requests pr JOIN users u ON pr.user_id = u.id ORDER BY FIELD(pr.status, 'pending', 'approved', 'rejected'), pr.id DESC LIMIT 10");
                if (mysqli_num_rows($pre_query) > 0) {
                    while ($row = mysqli_fetch_assoc($pre_query)) {
                        $status_badge = 'status-' . $row['status'];
                        ?>
                        <tr>
                            <td>
                                <div class="fw-bold"><?php echo $row['user_name']; ?></div>
                                <div class="small text-white-50"><?php echo $row['user_phone']; ?></div>
                            </td>
                            <td>
                                <div class="small fw-bold text-info"><?php echo $row['method']; ?></div>
                                <div class="small text-white-50"><?php echo $row['sender_number']; ?></div>
                            </td>
                            <td><code class="text-primary"><?php echo $row['trxid']; ?></code></td>
                            <td><span class="status-pill <?php echo $status_badge; ?>"><?php echo ucfirst($row['status']); ?></span></td>
                            <td class="text-end">
                                <?php if ($row['status'] == 'pending'): ?>
                                    <a href="?action=approve&req_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success rounded-pill px-3 me-1" onclick="return confirm('Approve?')">Approve</a>
                                    <a href="?action=reject&req_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger rounded-pill px-3" onclick="return confirm('Reject?')">Reject</a>
                                <?php else: ?>
                                    <a href="?action=delete_req&req_id=<?php echo $row['id']; ?>" class="text-danger fs-5" onclick="return confirm('Delete?')"><i class="bi bi-trash"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center py-3 text-white-50'>No requests found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- OTP Requests -->
<div class="app-card">
    <h5 class="fw-bold mb-4"><i class="bi bi-shield-lock-fill text-info me-2"></i> Recent OTP Requests</h5>
    <div class="row g-3">
        <?php
        $otp_query = mysqli_query($conn, "SELECT * FROM otp_requests ORDER BY FIELD(status, 'pending', 'verified', 'expired'), id DESC LIMIT 6");
        if (mysqli_num_rows($otp_query) > 0) {
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
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-primary rounded-pill px-3" onclick="copyOTP('<?php echo $row['otp_code']; ?>')">Copy</button>
                                <?php if ($row['status'] != 'verified'): ?>
                                    <a href="?verify_otp=<?php echo $row['id']; ?>" class="btn btn-sm btn-success rounded-pill px-3" onclick="return confirm('Verify?')">Verify</a>
                                <?php endif; ?>
                                <?php if ($row['status'] != 'pending'): ?>
                                    <a href="?delete_otp=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill px-2" onclick="return confirm('Delete?')"><i class="bi bi-trash"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="mt-2 text-white-50 small">
                            <i class="bi bi-clock me-1"></i> Expires: <?php echo date('h:i A', strtotime($row['expires_at'])); ?>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div class='col-12 text-center text-white-50'>No OTP requests</div>";
        }
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>