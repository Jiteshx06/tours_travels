-- Create database
CREATE DATABASE IF NOT EXISTS tours_db;
USE tours_db;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create packages table
CREATE TABLE IF NOT EXISTS packages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    package_name VARCHAR(200) NOT NULL,
    destination VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    duration VARCHAR(50) NOT NULL,
    description TEXT,
    image_url VARCHAR(500),
    category VARCHAR(50),
    max_group_size INT,
    includes_flights BOOLEAN DEFAULT FALSE,
    hotel_rating INT,
    highlights TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create bookings table
CREATE TABLE IF NOT EXISTS bookings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    package_id INT NOT NULL,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    travel_date DATE NOT NULL,
    number_of_travelers INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    special_requests TEXT,
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    payment_status ENUM('pending', 'completed', 'refunded') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (package_id) REFERENCES packages(id) ON DELETE CASCADE
);

-- Create password_resets table for forgot password functionality
CREATE TABLE IF NOT EXISTS password_resets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL,
    token VARCHAR(255) NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (email),
    INDEX (token)
);

-- Create contact_inquiries table
CREATE TABLE IF NOT EXISTS contact_inquiries (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(200),
    message TEXT NOT NULL,
    status ENUM('new', 'in_progress', 'resolved') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Insert sample packages data
INSERT INTO packages (package_name, destination, price, duration, description, image_url, category, max_group_size, includes_flights, hotel_rating, highlights) VALUES
('GLIMPSES OF EUROPE', 'Europe', 89999.00, '8 Nights / 9 Days', 'Experience the best of Europe with visits to iconic cities and landmarks.', 'assets/Europe.jpg', 'international', 40, TRUE, 4, 'Round-trip flights included|4-Star Hotels|Guided tours|All major attractions'),

('LONDON EXPLORER', 'United Kingdom', 125999.00, '15 Nights / 16 Days', 'Explore Big Ben, Buckingham Palace, and Thames River in England\'s historic capital.', 'assets/londan.jpg', 'international', 45, TRUE, 5, 'Round-trip flights included|5-Star Hotels|Private tours|Thames River cruise'),

('BALI PARADISE', 'Indonesia', 65999.00, '5 Nights / 6 Days', 'Best of Bali experience with beautiful beaches and cultural sites.', 'assets/bali.jpg', 'international,honeymoon', 20, TRUE, 4, 'Beach resort stay|Spa treatments|Cultural tours|Water sports'),

('KASHMIR VALLEY', 'Jammu & Kashmir', 35999.00, '6 Nights / 7 Days', 'Experience the paradise on earth with stunning valleys and lakes.', 'assets/kashmir.jpg', 'domestic,family', 30, FALSE, 3, 'Shikara ride|Local transport|Valley tours|Traditional meals'),

('GOA BEACHES', 'Goa', 25999.00, '4 Nights / 5 Days', 'Relax on pristine beaches and enjoy vibrant nightlife in Goa.', 'assets/goa pakege.jpg', 'domestic', 30, FALSE, 4, 'Beach resort|Water sports|Nightlife tours|Local cuisine'),

('RAJASTHAN ROYAL', 'Rajasthan', 42999.00, '7 Nights / 8 Days', 'Discover royal palaces and vibrant culture of Rajasthan.', 'assets/rajestan pakege.jpg', 'domestic,family', 35, FALSE, 4, 'Palace visits|Camel safari|Cultural shows|Traditional Rajasthani meals'),

('DUBAI DELIGHTS', 'UAE', 55999.00, '5 Nights / 6 Days', 'Experience luxury and adventure in the city of gold.', 'assets/dubai.jpg', 'international', 25, TRUE, 5, 'Burj Khalifa|Desert safari|Dubai Mall|Marina cruise'),

('SINGAPORE SPECIAL', 'Singapore', 72999.00, '6 Nights / 7 Days', 'Modern city experience with Gardens by the Bay and Sentosa Island.', 'assets/singapore.jpg', 'international,family', 30, TRUE, 4, 'Universal Studios|Gardens by the Bay|Sentosa Island|Night Safari');

-- Create indexes for better performance
CREATE INDEX idx_bookings_user ON bookings(user_id);
CREATE INDEX idx_bookings_package ON bookings(package_id);
CREATE INDEX idx_bookings_status ON bookings(status);
CREATE INDEX idx_users_email ON users(email);