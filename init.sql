-- init.sql
CREATE DATABASE IF NOT EXISTS feedback_form;
USE feedback_form;

CREATE TABLE IF NOT EXISTS feedback (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    phone_number VARCHAR(20),
    email VARCHAR(255),
    text TEXT,
    created_at DATETIME
);
