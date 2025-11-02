-- Create a new user for the application
CREATE USER 'transcript_user'@'localhost' IDENTIFIED BY 'secure_password';

-- Grant permissions to the new user for the application database
GRANT ALL PRIVILEGES ON transcript_management.* TO 'transcript_user'@'localhost';

-- Refresh privileges
FLUSH PRIVILEGES;
