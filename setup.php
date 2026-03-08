<?php
/**
 * Database Setup Script
 * Run this file once to set up the database and insert rooms
 * Access: http://localhost/aora/setup.php
 */

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';

echo "<h1>Aora Database Setup</h1>";

try {
    // Connect without database to create it
    $pdo = new PDO("mysql:host=$db_host", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS aora");
    echo "<p style='color: green;'>✓ Database 'aora' created/verified</p>";
    
    // Select the database
    $pdo->exec("USE aora");
    
    // Create rooms table
    $pdo->exec("CREATE TABLE IF NOT EXISTS rooms (
        id INT AUTO_INCREMENT PRIMARY KEY,
        room_type VARCHAR(50) NOT NULL UNIQUE,
        name VARCHAR(100) NOT NULL,
        description TEXT,
        price DECIMAL(10,2) NOT NULL,
        size VARCHAR(20),
        occupancy VARCHAR(50),
        bed_type VARCHAR(50),
        view VARCHAR(50),
        amenities TEXT,
        images JSON,
        badge VARCHAR(50),
        is_active TINYINT(1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    echo "<p style='color: green;'>✓ Rooms table created</p>";
    
    // Create bookings table
    $pdo->exec("CREATE TABLE IF NOT EXISTS bookings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        room_id INT NOT NULL,
        guest_name VARCHAR(100) NOT NULL,
        guest_email VARCHAR(100) NOT NULL,
        guest_phone VARCHAR(20),
        check_in DATE NOT NULL,
        check_out DATE NOT NULL,
        adults INT DEFAULT 1,
        children INT DEFAULT 0,
        special_requests TEXT,
        status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
        total_price DECIMAL(10,2),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (room_id) REFERENCES rooms(id)
    )");
    echo "<p style='color: green;'>✓ Bookings table created</p>";
    
    // Create table types table
    $pdo->exec("CREATE TABLE IF NOT EXISTS table_types (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        description TEXT,
        max_people INT NOT NULL DEFAULT 4,
        is_active TINYINT(1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    echo "<p style='color: green;'>✓ Table types table created</p>";
    
    // Check if table types already exist
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM table_types");
    $tableTypeCount = $stmt->fetch()['count'];
    
    if ($tableTypeCount == 0) {
        // Insert table types
        $tableTypes = [
            ['name' => "The Chef's Table", 'description' => 'An intimate dining experience at the kitchen pass', 'max_people' => 6],
            ['name' => 'Private Dining Room', 'description' => 'Exclusive use of our private dining space', 'max_people' => 16],
            ['name' => 'Garden Terrace', 'description' => 'Al fresco dining under the stars', 'max_people' => 12],
            ['name' => 'Main Dining', 'description' => 'Elegant main restaurant seating', 'max_people' => 8],
            ['name' => 'Window Seat', 'description' => 'Seating with scenic views', 'max_people' => 4],
            ['name' => 'Bar Area', 'description' => 'Casual dining at the bar', 'max_people' => 4]
        ];
        
        $tableTypeStmt = $pdo->prepare("INSERT INTO table_types (name, description, max_people) VALUES (:name, :description, :max_people)");
        foreach ($tableTypes as $type) {
            $tableTypeStmt->execute($type);
        }
        echo "<p style='color: green;'>✓ Table types inserted successfully!</p>";
    } else {
        echo "<p style='color: blue;'>✓ Table types already exist in database ($tableTypeCount types)</p>";
    }
    
    // Check if rooms already exist
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM rooms");
    $roomCount = $stmt->fetch()['count'];
    
    if ($roomCount == 0) {
        // Insert rooms
        $rooms = [
            [
                'room_type' => 'deluxe',
                'name' => 'Deluxe Room',
                'description' => 'Experience elegance in our Deluxe Room, featuring contemporary design with warm earth tones. Perfect for the discerning traveler seeking comfort and style.',
                'price' => 35000,
                'size' => '45 m²',
                'occupancy' => '2 Adults',
                'bed_type' => 'King',
                'view' => 'Garden',
                'amenities' => json_encode(['Free WiFi', 'Air Conditioning', 'Smart TV', 'Coffee Maker', 'Rain Shower', 'Mini Bar', 'Room Safe', 'Bathrobe & Slippers']),
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80',
                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]),
                'badge' => 'Best Seller'
            ],
            [
                'room_type' => 'executive',
                'name' => 'Executive Suite',
                'description' => 'Our Executive Suite offers spacious luxury with a separate living area, perfect for business travelers or those seeking extra space.',
                'price' => 55000,
                'size' => '65 m²',
                'occupancy' => '2 Adults',
                'bed_type' => 'King',
                'view' => 'Pool',
                'amenities' => json_encode(['Separate Living Room', 'Panoramic Views', 'Executive Lounge Access', 'Work Desk', 'Espresso Machine', 'Bathrobe & Slippers', 'Premium Toiletries', 'Evening Turndown']),
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80',
                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]),
                'badge' => NULL
            ],
            [
                'room_type' => 'family',
                'name' => 'Family Villa',
                'description' => 'Perfect for families, our villa offers two bedrooms, a private garden, and all the comforts of home in a luxurious setting.',
                'price' => 75000,
                'size' => '95 m²',
                'occupancy' => '4 Adults + 2 Children',
                'bed_type' => '2 King',
                'view' => 'Garden',
                'amenities' => json_encode(['Two Bedrooms', 'Private Garden', 'Full Kitchen', 'Living Room', 'Children\'s Play Area', 'Outdoor Dining', 'BBQ Facilities', 'Laundry Service']),
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80',
                    'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]),
                'badge' => NULL
            ],
            [
                'room_type' => 'presidential',
                'name' => 'Presidential Villa',
                'description' => 'The pinnacle of luxury. Our Presidential Villa offers unmatched elegance with panoramic views, personal butler service, and exquisite furnishings.',
                'price' => 150000,
                'size' => '200 m²',
                'occupancy' => '6 Adults',
                'bed_type' => '3 King',
                'view' => 'Ocean',
                'amenities' => json_encode(['Private Terrace', 'Butler Service', 'Jacuzzi', 'Dining Room', 'Wine Cellar', 'Steam Room', 'Home Theater', 'Private Check-in']),
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80',
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]),
                'badge' => 'Premium'
            ],
            [
                'room_type' => 'garden',
                'name' => 'Garden View Room',
                'description' => 'Wake up to lush garden views in this serene room, designed for nature lovers seeking tranquility.',
                'price' => 30000,
                'size' => '35 m²',
                'occupancy' => '2 Adults',
                'bed_type' => 'Queen',
                'view' => 'Garden',
                'amenities' => json_encode(['Garden View', 'Queen Bed', 'Private Balcony', 'Rain Shower', 'Organic Toiletries', 'Tea/Coffee', 'Ceiling Fan', 'Mosquito Nets']),
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80',
                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]),
                'badge' => NULL
            ],
            [
                'room_type' => 'honeymoon',
                'name' => 'Honeymoon Suite',
                'description' => 'Designed for romance, this suite features intimate settings, a private balcony with sunset views, and special amenities for couples.',
                'price' => 65000,
                'size' => '55 m²',
                'occupancy' => '2 Adults',
                'bed_type' => 'King',
                'view' => 'Sunset',
                'amenities' => json_encode(['King Bed', 'Sunset Balcony', 'Champagne on Arrival', 'Rose Petal Turndown', 'Double Vanity', 'Deep Soaking Tub', 'Candlelit Dining', 'Couples Massage']),
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80',
                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]),
                'badge' => 'Romantic'
            ],
            [
                'room_type' => 'business',
                'name' => 'Business Suite',
                'description' => 'Optimized for the modern professional, featuring a dedicated workspace and all the tech amenities needed for productivity.',
                'price' => 45000,
                'size' => '50 m²',
                'occupancy' => '2 Adults',
                'bed_type' => 'King',
                'view' => 'City',
                'amenities' => json_encode(['Work Desk', 'Ergonomic Chair', 'High-speed Internet', 'Printer Access', 'Conference Phone', 'Stationery Set', 'Complimentary Printing', 'Meeting Space']),
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1522778526097-ce0a22ceb253?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80',
                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]),
                'badge' => NULL
            ],
            [
                'room_type' => 'penthouse',
                'name' => 'Sky Penthouse',
                'description' => 'The ultimate expression of luxury living, occupying the entire top floor with 360° views and unparalleled amenities.',
                'price' => 200000,
                'size' => '150 m²',
                'occupancy' => '4 Adults',
                'bed_type' => '2 King',
                'view' => 'Panoramic',
                'amenities' => json_encode(['Rooftop Terrace', 'Private Pool', 'Hot Tub', 'Outdoor Kitchen', 'Panoramic Views', 'Private Elevator', 'Wine Room', 'Personal Chef']),
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1536376072261-38c75010e6c9?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80',
                    'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80',
                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'
                ]),
                'badge' => 'Luxury'
            ]
        ];
        
        $stmt = $pdo->prepare("INSERT INTO rooms (room_type, name, description, price, size, occupancy, bed_type, view, amenities, images, badge) 
                               VALUES (:room_type, :name, :description, :price, :size, :occupancy, :bed_type, :view, :amenities, :images, :badge)
                               ON DUPLICATE KEY UPDATE name = VALUES(name)");
        
        foreach ($rooms as $room) {
            $stmt->execute($room);
        }
        
        echo "<p style='color: green;'>✓ All 8 rooms inserted successfully!</p>";
    } else {
        echo "<p style='color: blue;'>✓ Rooms already exist in database ($roomCount rooms)</p>";
    }
    
    echo "<h2 style='color: green;'>Setup Complete!</h2>";
    echo "<p>Now you can access <a href='rooms.php'>rooms.php</a></p>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
