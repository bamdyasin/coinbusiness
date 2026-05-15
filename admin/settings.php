<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

// Handle Settings Update
if (isset($_POST['update_settings'])) {
    foreach ($_POST['settings'] as $key => $value) {
        $safe_key = mysqli_real_escape_string($conn, $key);
        $safe_value = mysqli_real_escape_string($conn, $value);
        mysqli_query($conn, "UPDATE site_settings SET setting_value = '$safe_value' WHERE setting_key = '$safe_key'");
    }
    $message = "<div class='alert alert-success rounded-pill px-4'>Settings updated successfully!</div>";
}

// Fetch current settings
$settings = [];
$res = mysqli_query($conn, "SELECT * FROM site_settings");
while ($row = mysqli_fetch_assoc($res)) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

$page_title = "Course Payment Settings - CoinStore.bd";
include 'header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1" style="color: white;">Course Payment Settings</h2>
        <p style="color: rgba(255,255,255,0.6);">Configure payment methods and system links</p>
    </div>
</div>

<?php echo $message; ?>

<div class="row">
    <div class="col-lg-8">
        <div class="app-card">
            <h5 class="fw-bold mb-4 border-bottom border-white border-opacity-10 pb-3">Payment Options</h5>
            <form action="settings.php" method="POST">
                <div class="row g-4">
                    <!-- bKash -->
                    <div class="col-md-6">
                        <label class="small text-white-50 mb-2">bKash Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-white border-opacity-10 text-danger"><i class="bi bi-b-circle-fill"></i></span>
                            <input type="text" name="settings[bkash_number]" class="form-control bg-dark border-white border-opacity-10 text-white" value="<?php echo $settings['bkash_number'] ?? ''; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="small text-white-50 mb-2">bKash Account Type</label>
                        <input type="text" name="settings[bkash_type]" class="form-control bg-dark border-white border-opacity-10 text-white" value="<?php echo $settings['bkash_type'] ?? 'Personal'; ?>" placeholder="e.g. Personal / Agent" required>
                    </div>

                    <!-- Nagad -->
                    <div class="col-md-6">
                        <label class="small text-white-50 mb-2">Nagad Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-white border-opacity-10 text-warning"><i class="bi bi-n-circle-fill"></i></span>
                            <input type="text" name="settings[nagad_number]" class="form-control bg-dark border-white border-opacity-10 text-white" value="<?php echo $settings['nagad_number'] ?? ''; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="small text-white-50 mb-2">Nagad Account Type</label>
                        <input type="text" name="settings[nagad_type]" class="form-control bg-dark border-white border-opacity-10 text-white" value="<?php echo $settings['nagad_type'] ?? 'Personal'; ?>" placeholder="e.g. Personal / Agent" required>
                    </div>

                    <!-- Rocket -->
                    <div class="col-md-6">
                        <label class="small text-white-50 mb-2">Rocket Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-white border-opacity-10 text-primary"><i class="bi bi-r-circle-fill"></i></span>
                            <input type="text" name="settings[rocket_number]" class="form-control bg-dark border-white border-opacity-10 text-white" value="<?php echo $settings['rocket_number'] ?? ''; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="small text-white-50 mb-2">Rocket Account Type</label>
                        <input type="text" name="settings[rocket_type]" class="form-control bg-dark border-white border-opacity-10 text-white" value="<?php echo $settings['rocket_type'] ?? 'Personal'; ?>" placeholder="e.g. Personal / Agent" required>
                    </div>

                    <div class="col-12">
                        <label class="small text-white-50 mb-2">Payment Instructions (Bangla)</label>
                        <textarea name="settings[payment_instruction]" class="form-control bg-dark border-white border-opacity-10 text-white" rows="3" required><?php echo $settings['payment_instruction'] ?? ''; ?></textarea>
                    </div>
                    <div class="col-12">
                        <label class="small text-white-50 mb-2">WhatsApp Support Link</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-white border-opacity-10 text-success"><i class="bi bi-whatsapp"></i></span>
                            <input type="url" name="settings[whatsapp_support]" class="form-control bg-dark border-white border-opacity-10 text-white" value="<?php echo $settings['whatsapp_support'] ?? ''; ?>" placeholder="https://wa.me/..." required>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <button type="submit" name="update_settings" class="btn btn-primary rounded-pill px-5 fw-bold">
                        <i class="bi bi-save me-2"></i> Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="app-card border-info border-opacity-25">
            <h6 class="fw-bold text-info mb-3"><i class="bi bi-info-circle me-2"></i> Note</h6>
            <p class="small text-white-50" style="line-height: 1.6;">
                These settings directly affect what users see on the <b>Payment Page</b>. Make sure the numbers are correct to avoid payment confusion.
            </p>
            <hr class="border-white border-opacity-10">
            <p class="extra-small text-white-50 mb-0">
                Last updated: <br>
                <span class="text-white"><?php echo date('d M, Y h:i A'); ?></span>
            </p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>