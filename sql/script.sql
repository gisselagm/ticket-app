-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS support_app 
    CHARACTER SET utf8mb4 
    COLLATE utf8mb4_general_ci;

-- Select the database
USE support_app;

-- Create the tickets table if it doesn't exist
CREATE TABLE IF NOT EXISTS tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    status ENUM('open', 'in progress', 'closed') DEFAULT 'open',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert 5 sample records in English
INSERT INTO tickets (title, description, status) VALUES
    ('Login Issue', 'User is unable to log in due to an incorrect password error.', 'open'),
    ('Page Load Problem', 'The webpage takes too long to load for users.', 'in progress'),
    ('Feature Request', 'Request to add new filtering options in the search functionality.', 'open'),
    ('Bug Report', 'The application crashes when clicking the submit button.', 'closed'),
    ('Database Error', 'Unexpected database error when updating the user profile.', 'in progress');
