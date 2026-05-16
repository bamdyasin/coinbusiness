<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once '../includes/db.php';

// Fetch settings for footer
$footer_settings = [];
$res = mysqli_query($conn, "SELECT * FROM site_settings");
while ($row = mysqli_fetch_assoc($res)) {
    $footer_settings[$row['setting_key']] = $row['setting_value'];
}

$footer_title = "CoinStore.bd";
$footer_about_text = "বাংলাদেশের অন্যতম নির্ভরযোগ্য গেমিং সার্ভিস প্রোভাইডার। আমরা দিচ্ছি সবচেয়ে কম দামে কয়েন, ইউসি এবং ডায়মন্ড টপ-আপ সুবিধা।";
$footer_location = "#";
$footer_tiktok = "#";
$footer_facebook = "https://facebook.com/coinstorebd";
$footer_youtube = "#";
$footer_copyright = "© 2026 CoinStore.bd - All Rights Reserved.";
$support_whatsapp = str_replace(['https://wa.me/', 'http://wa.me/'], '', $footer_settings['whatsapp_support'] ?? '8801700000000');

// Translation helper if not exists
if (!function_exists('__')) {
    function __($key) {
        $langs = [
            'bn' => ['chat_whatsapp' => 'হোয়াটসঅ্যাপে চ্যাট করুন'],
            'en' => ['chat_whatsapp' => 'Chat on WhatsApp']
        ];
        $lang = $_SESSION['lang'] ?? 'bn';
        return $langs[$lang][$key] ?? $key;
    }
}
?>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3><?php echo htmlspecialchars($footer_title); ?></h3>
                <p><?php echo $footer_about_text; ?></p>
            </div>
            

            <div class="footer-section">
                <h3>Connect With Us</h3>
                <div class="footer-social-row">
                    <!-- Contact Icons -->
                    <?php if ($footer_location): ?>
                    <a href="<?php echo htmlspecialchars($footer_location); ?>" target="_blank" class="contact-item" title="Our Location">
                        <span class="contact-icon"><i class="fas fa-location-dot"></i></span>
                    </a>
                    <?php endif; ?>
                    
                    <?php if ($footer_tiktok): ?>
                    <a href="<?php echo htmlspecialchars($footer_tiktok); ?>" target="_blank" class="contact-item" title="TikTok">
                        <span class="contact-icon"><i class="fab fa-tiktok"></i></span>
                    </a>
                    <?php endif; ?>

                    <?php if ($footer_facebook): ?>
                    <a href="<?php echo htmlspecialchars($footer_facebook); ?>" target="_blank" class="contact-item" title="Facebook">
                        <span class="contact-icon"><i class="fab fa-facebook-f"></i></span>
                    </a>
                    <?php endif; ?>

                    <a href="https://wa.me/<?php echo $support_whatsapp; ?>" target="_blank" class="contact-item" title="WhatsApp">
                        <span class="contact-icon"><i class="fab fa-whatsapp"></i></span>
                    </a>

                    <?php if ($footer_youtube): ?>
                    <a href="<?php echo htmlspecialchars($footer_youtube); ?>" target="_blank" class="contact-item" title="YouTube">
                        <span class="contact-icon"><i class="fab fa-youtube"></i></span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p><?php echo htmlspecialchars($footer_copyright); ?></p>
        </div>
    </footer>

    <!-- Order Status Modal -->
    <div id="statusModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeStatusModal()">&times;</span>
            <div id="statusResult">
                <!-- Result will be loaded here via AJAX -->
            </div>
        </div>
    </div>

    <!-- Success Notification Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content" style="text-align: center; padding: 3rem 2rem;">
            <div style="margin-bottom: 1.5rem;">
                <div style="width: 80px; height: 80px; background: rgba(46, 204, 113, 0.1); color: #2ecc71; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 3rem; margin: 0 auto; border: 4px solid #2ecc71; animation: scaleUp 0.5s ease-out;">
                    ✓
                </div>
            </div>
            <h2 id="successTitle" style="color: #fff; margin-bottom: 1rem;">Success!</h2>
            <p id="successMessage" style="color: rgba(255,255,255,0.7); margin-bottom: 2rem; font-size: 1.1rem; line-height: 1.5;"></p>
            <button onclick="closeSuccessModal()" class="btn btn-shop" style="width: 100%;">Continue</button>
        </div>
    </div>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/<?php echo $support_whatsapp; ?>" class="whatsapp-float" target="_blank">
        <i class="fab fa-whatsapp"></i>
        <span>Chat Now</span>
    </a>

    <script>
        window.supportWhatsApp = "<?php echo $support_whatsapp; ?>";
        
        function closeStatusModal() {
            document.getElementById('statusModal').style.display = 'none';
        }
        
        function closeSuccessModal() {
            document.getElementById('successModal').style.display = 'none';
        }

        // Close modals on outside click
        window.onclick = function(event) {
            if (event.target.className === 'modal') {
                event.target.style.display = 'none';
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php if (isset($extra_js)) echo $extra_js; ?>
</body>
</html>
