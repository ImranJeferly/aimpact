CREATE TABLE IF NOT EXISTS submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tasks TEXT,
    ai_experience VARCHAR(255),
    timeline VARCHAR(255),
    budget VARCHAR(255),
    business_name VARCHAR(255),
    contact_name VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(50),
    submission_date DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    fullname VARCHAR(100),
    role ENUM('admin', 'author') DEFAULT 'author',
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- First, remove any existing admin users
DELETE FROM admins WHERE username = 'admin';

-- Insert default admin user (password: 4c9Tj4H8*)
INSERT INTO admins (username, password) VALUES ('admin', '$2y$10$XQFKDg1Y3mKc7qKSHiHxHOU4aqtfMGCwlXTA3SLQVbwtpQQ4MQ1C.');

-- Add new admin users for authors
INSERT INTO admins (username, password) VALUES 
('imran', '$2y$10$XQFKDg1Y3mKc7qKSHiHxHOU4aqtfMGCwlXTA3SLQVbwtpQQ4MQ1C.'),
('huseyn', '$2y$10$XQFKDg1Y3mKc7qKSHiHxHOU4aqtfMGCwlXTA3SLQVbwtpQQ4MQ1C.'),
('kamran', '$2y$10$XQFKDg1Y3mKc7qKSHiHxHOU4aqtfMGCwlXTA3SLQVbwtpQQ4MQ1C.');

-- Update the authors' information
UPDATE admins SET 
fullname = 'Imran Mammadov', role = 'author' WHERE username = 'imran';

UPDATE admins SET 
fullname = 'Huseyn Mammadov', role = 'author' WHERE username = 'huseyn';

UPDATE admins SET 
fullname = 'Kamran Aliyev', role = 'author' WHERE username = 'kamran';

-- Make sure the main admin remains an admin
UPDATE admins SET 
role = 'admin' WHERE username = 'admin';

-- Create blogs table
CREATE TABLE IF NOT EXISTS blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content TEXT NOT NULL,
    image_url VARCHAR(255),
    excerpt TEXT,
    status ENUM('draft', 'published') DEFAULT 'draft',
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

ALTER TABLE blogs 
DROP FOREIGN KEY blogs_ibfk_1,
DROP COLUMN author_id,
ADD COLUMN author VARCHAR(100) AFTER content;

-- Create blog categories table
CREATE TABLE IF NOT EXISTS blog_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create blog-category relationship table
CREATE TABLE IF NOT EXISTS blog_category_relations (
    blog_id INT,
    category_id INT,
    PRIMARY KEY (blog_id, category_id),
    FOREIGN KEY (blog_id) REFERENCES blogs(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES blog_categories(id) ON DELETE CASCADE
);

-- Create testimonials table
CREATE TABLE IF NOT EXISTS testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR(255) NOT NULL,
    company_name VARCHAR(255),
    position VARCHAR(255),
    content TEXT NOT NULL,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    image_url VARCHAR(255),
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    approved_at TIMESTAMP NULL
);

-- Add indexes for better performance
ALTER TABLE blogs ADD INDEX idx_status_date (status, created_at);
ALTER TABLE blogs ADD INDEX idx_slug (slug);
ALTER TABLE testimonials ADD INDEX idx_status_featured (status, featured);
