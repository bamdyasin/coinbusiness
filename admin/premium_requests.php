<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
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

        header("Location: premium_requests.php?msg=approved");
        exit();
    } elseif ($action == 'reject') {
        mysqli_query($conn, "UPDATE premium_requests SET status = 'rejected' WHERE id = $req_id");
        header("Location: premium_requests.php?msg=rejected");
        exit();
    } elseif ($action == 'delete_req') {
        mysqli_query($conn, "DELETE FROM premium_requests WHERE id = $req_id");
        header("Location: premium_requests.php?msg=req_deleted");
        exit();
    }
}

$page_title = "Premium Requests - CoinStore.bd";
include 'header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1" style="color: white;">Premium Requests</h2>
        <p style="color: rgba(255,255,255,0.6);">Manage and verify user membership payments</p>
    </div>
    <button class="btn btn-outline-info rounded-pill px-4" onclick="location.reload()">
        <i class="bi bi-arrow-clockwise me-2"></i>Refresh List
    </button>
</div>

<div class="app-card">
    <div class="row g-3">
        <?php
        $pre_query = mysqli_query($conn, "SELECT pr.*, u.name as user_name, u.phone as user_phone FROM premium_requests pr JOIN users u ON pr.user_id = u.id ORDER BY FIELD(pr.status, 'pending', 'approved', 'rejected'), pr.id DESC");
        if ($pre_query && mysqli_num_rows($pre_query) > 0) {
            while ($row = mysqli_fetch_assoc($pre_query)) {
                $status_badge = 'status-' . $row['status'];
                $method_icon = "bi-wallet2";
                if(strtolower($row['method']) == 'bkash') $method_icon = "bi-b-circle-fill text-danger";
                if(strtolower($row['method']) == 'nagad') $method_icon = "bi-n-circle-fill text-warning";
                if(strtolower($row['method']) == 'rocket') $method_icon = "bi-r-circle-fill text-primary";
                ?>
                <div class="col-md-6">
                    <div class="p-3 rounded-4 border border-white border-opacity-10 mb-2 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold small"><?php echo $row['user_name']; ?></div>
                                        <div class="extra-small text-white-50" style="font-size: 0.7rem;"><?php echo $row['user_phone']; ?></div>
                                    </div>
                                </div>
                                <span class="status-pill <?php echo $status_badge; ?>"><?php echo ucfirst($row['status']); ?></span>
                            </div>
                            
                            <div class="bg-dark bg-opacity-30 p-2 rounded-3 border border-white border-opacity-5 mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="bi <?php echo $method_icon; ?> fs-5 me-2"></i>
                                        <span class="small fw-bold"><?php echo $row['method']; ?></span>
                                    </div>
                                    <code class="text-info"><?php echo $row['trxid']; ?></code>
                                </div>
                                <div class="extra-small text-white-50 mt-1" style="font-size: 0.65rem;">Sender: <?php echo $row['sender_number']; ?></div>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-white-50 small">
                                    <i class="bi bi-calendar3 me-1"></i> <?php echo date('d M, h:i A', strtotime($row['created_at'])); ?>
                                </div>
                                <div class="d-flex gap-2">
                                    <?php if ($row['status'] == 'pending'): ?>
                                        <a href="?action=approve&req_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success rounded-pill px-3" onclick="return confirm('Approve?')">Approve</a>
                                        <a href="?action=reject&req_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger rounded-pill px-3" onclick="return confirm('Reject?')">Reject</a>
                                    <?php else: ?>
                                        <a href="?action=delete_req&req_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill px-2" onclick="return confirm('Delete?')">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div class='col-12 text-center py-5 text-white-50'><i class='bi bi-inbox fs-1 d-block mb-2 opacity-25'></i>No requests found</div>";
        }
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>