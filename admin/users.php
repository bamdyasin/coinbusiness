<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Handle User Deletion
if (isset($_GET['delete_user'])) {
    $u_id = intval($_GET['delete_user']);
    mysqli_query($conn, "DELETE FROM users WHERE id = $u_id");
    header("Location: users.php?msg=deleted");
    exit();
}

// Handle Balance Update (Quick Edit)
if (isset($_POST['update_balance'])) {
    $u_id = intval($_POST['user_id']);
    $new_balance = mysqli_real_escape_string($conn, $_POST['balance']);
    mysqli_query($conn, "UPDATE users SET balance = '$new_balance' WHERE id = $u_id");
    header("Location: users.php?msg=updated");
    exit();
}

$page_title = "User Management - CoinStore.bd";
include 'header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1" style="color: white;">User Management</h2>
        <p style="color: rgba(255,255,255,0.6);">View and manage all registered users</p>
    </div>
    <div class="d-flex gap-2">
        <form class="d-flex" action="users.php" method="GET">
            <input type="text" name="search" class="form-control form-control-sm rounded-pill bg-dark border-white border-opacity-10 text-white px-3" placeholder="Search phone/name...">
        </form>
        <button class="btn btn-outline-info rounded-pill px-4 btn-sm" onclick="location.reload()">
            <i class="bi bi-arrow-clockwise"></i>
        </button>
    </div>
</div>

<div class="app-card">
    <div class="row g-3">
        <?php
        $search_query = "";
        if(isset($_GET['search'])) {
            $s = mysqli_real_escape_string($conn, $_GET['search']);
            $search_query = " WHERE name LIKE '%$s%' OR phone LIKE '%$s%' ";
        }

        $u_query = mysqli_query($conn, "SELECT * FROM users $search_query ORDER BY id DESC");
        if ($u_query && mysqli_num_rows($u_query) > 0) {
            while ($row = mysqli_fetch_assoc($u_query)) {
                $is_paid = ($row['payment_status'] == 'Paid');
                $status_color = $is_paid ? 'status-approved' : 'status-pending';
                ?>
                <div class="col-md-6 col-lg-4">
                    <div class="p-3 rounded-4 border border-white border-opacity-10 mb-2 h-100 d-flex flex-column justify-content-between shadow-sm" style="background: rgba(255,255,255,0.02);">
                        <div>
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                        <i class="bi bi-person-fill fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold small"><?php echo $row['name']; ?></div>
                                        <div class="extra-small text-white-50" style="font-size: 0.7rem;"><?php echo $row['phone']; ?></div>
                                    </div>
                                </div>
                                <span class="status-pill <?php echo $status_color; ?>" style="font-size: 0.65rem;">
                                    <?php echo $is_paid ? 'Premium' : 'Free'; ?>
                                </span>
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <div class="bg-dark bg-opacity-30 p-2 rounded-3 border border-white border-opacity-5">
                                        <div class="extra-small text-white-50" style="font-size: 0.6rem;">BALANCE</div>
                                        <div class="fw-bold text-primary">৳<?php echo number_format($row['balance'], 2); ?></div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-dark bg-opacity-30 p-2 rounded-3 border border-white border-opacity-5">
                                        <div class="extra-small text-white-50" style="font-size: 0.6rem;">REFERRALS</div>
                                        <div class="fw-bold text-info">
                                            <?php 
                                                $ref_code = $row['referral_code'];
                                                $count_ref = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE referred_by='$ref_code'");
                                                echo mysqli_fetch_assoc($count_ref)['total'];
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-white-50 small" style="font-size: 0.65rem;">
                                <i class="bi bi-calendar-event me-1"></i> Joined: <?php echo date('d M, Y', strtotime($row['created_at'])); ?>
                            </div>
                            <div class="d-flex gap-1">
                                <!-- Quick Edit Balance Button -->
                                <button class="btn btn-sm btn-outline-info rounded-pill px-2 border-0" data-bs-toggle="modal" data-bs-target="#editBalance<?php echo $row['id']; ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <a href="?delete_user=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill px-2 border-0" onclick="return confirm('Delete this user account?')">
                                    <i class="bi bi-trash3-fill"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Edit Balance Modal -->
                        <div class="modal fade" id="editBalance<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content bg-dark border border-white border-opacity-10 text-white rounded-4">
                                    <div class="modal-body p-4">
                                        <h6 class="fw-bold mb-3">Edit Balance</h6>
                                        <form action="users.php" method="POST">
                                            <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                            <div class="mb-3">
                                                <label class="small text-white-50 mb-1">New Balance (৳)</label>
                                                <input type="number" step="0.01" name="balance" class="form-control bg-dark border-white border-opacity-10 text-white rounded-3" value="<?php echo $row['balance']; ?>" required>
                                            </div>
                                            <button type="submit" name="update_balance" class="btn btn-primary w-100 rounded-pill fw-bold">Update Balance</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div class='col-12 text-center py-5 text-white-50'><i class='bi bi-people fs-1 d-block mb-2 opacity-25'></i>No users registered yet</div>";
        }
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>