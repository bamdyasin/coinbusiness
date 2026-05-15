CREATE DATABASE IF NOT EXISTS coinstorebd;

USE coinstorebd;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(100),
    password VARCHAR(255) NOT NULL,
    referral_code VARCHAR(20) UNIQUE,
    referred_by VARCHAR(20),
    balance DECIMAL(10,2) DEFAULT 0.00,
    referral_clicks INT(11) DEFAULT 0,
    status VARCHAR(50) DEFAULT 'Verified User',
    payment_status ENUM('Unpaid', 'Paid') DEFAULT 'Unpaid',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Admins Table
CREATE TABLE IF NOT EXISTS admins (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default Admin (User: admin / Pass: admin123)
-- Hash generated via password_hash('admin123', PASSWORD_DEFAULT)
INSERT IGNORE INTO admins (id, username, password) VALUES 
(1, 'admin', '$2y$10$7R6yNfN/wP/6r7vF.X/l/O0h0.oGqSgE4xS3v7f9.X8bZ3m6Y6a7.');

-- OTP Requests Table
CREATE TABLE IF NOT EXISTS otp_requests (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    phone VARCHAR(20) NOT NULL,
    otp_code VARCHAR(10) NOT NULL,
    status ENUM('pending', 'verified', 'expired') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NULL
);

-- Premium Requests Table
CREATE TABLE IF NOT EXISTS premium_requests (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    method VARCHAR(50) NOT NULL,
    sender_number VARCHAR(20) NOT NULL,
    trxid VARCHAR(50) NOT NULL UNIQUE,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Site Settings Table
CREATE TABLE IF NOT EXISTS site_settings (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(50) NOT NULL UNIQUE,
    setting_value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default Site Settings
INSERT IGNORE INTO site_settings (setting_key, setting_value) VALUES 
('bkash_number', '০১৭XXXXXXXX'),
('bkash_type', 'Personal'),
('nagad_number', '০১৭XXXXXXXX'),
('nagad_type', 'Personal'),
('rocket_number', '০১৮XXXXXXXX'),
('rocket_type', 'Personal'),
('payment_instruction', 'বিকাশ, নগদ অথবা রকেট অ্যাপ থেকে "Send Money" করুন।'),
('whatsapp_support', 'https://wa.me/8801700000000');
