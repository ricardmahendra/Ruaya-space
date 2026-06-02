-- Create admin user for Ruaya Space
-- Email: admin@ruaya.space
-- Password: admin123

-- First, check if the admin user already exists and delete it if needed
DELETE FROM users WHERE email = 'admin@ruaya.space';

-- Insert the new admin user
INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES (
    'Administrator',
    'admin@ruaya.space',
    '$2y$12$uPU5D5NP8EbU5Wvtkt51s.r5SX9i.IQz6bTYJ1Yvb/.Ec6TsvbG.S',
    'admin',
    NOW(),
    NOW()
);

-- Verify the user was created
SELECT id, name, email, role FROM users WHERE email = 'admin@ruaya.space';
