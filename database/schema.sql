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

-- OTP Requests Table
CREATE TABLE IF NOT EXISTS otp_requests (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    phone VARCHAR(20) NOT NULL,
    otp_code VARCHAR(10) NOT NULL,
    status ENUM('pending', 'verified', 'expired') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NULL
);
