-- Runtime schema assumptions extracted from request-time checks.
-- Import this after healthquarters.sql for environments where you want
-- the expected tables/columns pre-created while keeping current PHP behavior unchanged.

CREATE TABLE IF NOT EXISTS email_otps (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    otp VARCHAR(6) NOT NULL,
    expires_at DATETIME NOT NULL,
    verified TINYINT(1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email)
);

CREATE TABLE IF NOT EXISTS user_notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    appointment_id INT DEFAULT NULL,
    source_type VARCHAR(40) DEFAULT NULL,
    source_id INT DEFAULT NULL,
    category VARCHAR(40) NOT NULL DEFAULT 'general',
    type VARCHAR(40) NOT NULL DEFAULT 'general',
    title VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    action_url VARCHAR(255) DEFAULT NULL,
    is_read TINYINT(1) NOT NULL DEFAULT 0,
    email_sent TINYINT(1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_read (user_id, is_read),
    INDEX idx_source (source_type, source_id)
);

CREATE TABLE IF NOT EXISTS patient_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    appointment_id INT DEFAULT NULL,
    title VARCHAR(255) NOT NULL,
    branch VARCHAR(120) DEFAULT NULL,
    file_name VARCHAR(255) DEFAULT NULL,
    notes TEXT DEFAULT NULL,
    file_path VARCHAR(255) DEFAULT NULL,
    file_type VARCHAR(100) DEFAULT NULL,
    file_size INT DEFAULT NULL,
    uploaded_by INT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user_created (user_id, created_at)
);

CREATE TABLE IF NOT EXISTS reschedule_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    appointment_id INT NOT NULL,
    user_id INT NOT NULL,
    requested_date DATE NOT NULL,
    requested_time VARCHAR(20) NOT NULL,
    reason TEXT DEFAULT NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'Pending',
    admin_notes TEXT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_appointment (appointment_id),
    INDEX idx_user_status (user_id, status)
);

CREATE TABLE IF NOT EXISTS schedule_blocks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    block_date DATE NOT NULL,
    block_time VARCHAR(20) DEFAULT NULL,
    branch VARCHAR(100) DEFAULT NULL,
    reason VARCHAR(255) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS admin_activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_user_id INT NOT NULL,
    action VARCHAR(80) NOT NULL,
    entity_type VARCHAR(80) NOT NULL,
    entity_id INT NOT NULL DEFAULT 0,
    details_json LONGTEXT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_admin_created (admin_user_id, created_at),
    INDEX idx_entity_lookup (entity_type, entity_id)
);

ALTER TABLE home_service_appointments
    ADD COLUMN confirmation_sent TINYINT(1) DEFAULT 0;

ALTER TABLE home_service_appointments
    ADD COLUMN reminder_sent TINYINT(1) DEFAULT 0;

ALTER TABLE home_service_appointments
    ADD COLUMN fasting_reminder_sent TINYINT(1) DEFAULT 0;

ALTER TABLE user_notifications
    ADD COLUMN source_type VARCHAR(40) NULL DEFAULT NULL;

ALTER TABLE user_notifications
    ADD COLUMN source_id INT NULL DEFAULT NULL;

ALTER TABLE user_notifications
    ADD COLUMN category VARCHAR(40) NOT NULL DEFAULT 'general';

ALTER TABLE user_notifications
    ADD COLUMN action_url VARCHAR(255) NULL DEFAULT NULL;

ALTER TABLE corporate_inquiries
    ADD COLUMN user_id INT NULL DEFAULT NULL;

ALTER TABLE corporate_inquiries
    ADD COLUMN hmo_provider VARCHAR(120) NULL DEFAULT NULL;

ALTER TABLE corporate_inquiries
    ADD COLUMN hmo_code VARCHAR(80) NULL DEFAULT NULL;

ALTER TABLE corporate_inquiries
    ADD COLUMN hmo_coverage VARCHAR(80) NULL DEFAULT NULL;

ALTER TABLE corporate_inquiries
    ADD COLUMN hmo_covered_count INT NULL DEFAULT NULL;
