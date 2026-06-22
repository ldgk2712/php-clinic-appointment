DROP DATABASE IF EXISTS clinic_lab05;

CREATE DATABASE clinic_lab05
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE clinic_lab05;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff') NOT NULL DEFAULT 'staff',
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_users_role_status (role, status)
);

CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(30),
    gender ENUM('male', 'female', 'other') NOT NULL DEFAULT 'other',
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    note TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_patient_email (email),
    INDEX idx_patients_created_at (created_at),
    INDEX idx_patients_status_created_at (status, created_at),
    INDEX idx_patients_phone (phone)
);

CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    appointment_code VARCHAR(50) NOT NULL,
    patient_name VARCHAR(100) NOT NULL,
    patient_email VARCHAR(150),
    appointment_date DATETIME NOT NULL,
    department VARCHAR(100) NOT NULL DEFAULT 'General',
    status ENUM('scheduled', 'confirmed', 'completed', 'cancelled') NOT NULL DEFAULT 'scheduled',
    note TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_appointment_code (appointment_code),
    INDEX idx_appointments_created_at (created_at),
    INDEX idx_appointments_status_created_at (status, created_at),
    INDEX idx_appointments_date (appointment_date),
    INDEX idx_appointments_patient_email (patient_email)
);
