<?php
// Database Configuration
$db_host = 'localhost';
$db_name = 'aora';
$db_user = 'root';
$db_pass = ''; // Default XAMPP MySQL password is empty

try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Create rooms table if not exists
$createRoomsTable = "CREATE TABLE IF NOT EXISTS rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_type VARCHAR(50) NOT NULL,
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
)";

$pdo->exec($createRoomsTable);

// Check if room_type column has UNIQUE constraint and remove it
try {
    // First, try to drop any unique index on room_type (if exists)
    $pdo->exec("ALTER TABLE rooms DROP INDEX room_type");
} catch (PDOException $e) {
    // Ignore if the index doesn't exist
}

try {
    // Then modify the column to ensure it has no unique constraint
    $pdo->exec("ALTER TABLE rooms MODIFY room_type VARCHAR(50) NOT NULL");
} catch (PDOException $e) {
    // Ignore if the constraint doesn't exist or other error
}

// Create room_types table if not exists
$createRoomTypesTable = "CREATE TABLE IF NOT EXISTS room_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    slug VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$pdo->exec($createRoomTypesTable);

// Create room_views table if not exists
$createRoomViewsTable = "CREATE TABLE IF NOT EXISTS room_views (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$pdo->exec($createRoomViewsTable);

// Create bed_types table if not exists
$createBedTypesTable = "CREATE TABLE IF NOT EXISTS bed_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$pdo->exec($createBedTypesTable);

// Insert default room views if empty
$stmt = $pdo->query("SELECT COUNT(*) as count FROM room_views");
$result = $stmt->fetch();

if ($result['count'] == 0) {
    $roomViews = [
        ['name' => 'Garden', 'display_order' => 1],
        ['name' => 'Pool', 'display_order' => 2],
        ['name' => 'City', 'display_order' => 3],
        ['name' => 'Ocean', 'display_order' => 4],
        ['name' => 'Sunset', 'display_order' => 5],
        ['name' => 'Panoramic', 'display_order' => 6]
    ];
    
    $viewStmt = $pdo->prepare("INSERT INTO room_views (name, display_order) VALUES (:name, :display_order)");
    foreach ($roomViews as $view) {
        $viewStmt->execute($view);
    }
}

// Insert default bed types if empty
$stmt = $pdo->query("SELECT COUNT(*) as count FROM bed_types");
$result = $stmt->fetch();

if ($result['count'] == 0) {
    $bedTypes = [
        ['name' => 'King', 'display_order' => 1],
        ['name' => 'Queen', 'display_order' => 2],
        ['name' => 'Twin', 'display_order' => 3],
        ['name' => '2 King', 'display_order' => 4],
        ['name' => '3 King', 'display_order' => 5]
    ];
    
    $bedStmt = $pdo->prepare("INSERT INTO bed_types (name, display_order) VALUES (:name, :display_order)");
    foreach ($bedTypes as $bed) {
        $bedStmt->execute($bed);
    }
}

// Insert default room types if empty
$stmt = $pdo->query("SELECT COUNT(*) as count FROM room_types");
$result = $stmt->fetch();

if ($result['count'] == 0) {
    $roomTypes = [
        ['name' => 'Deluxe', 'slug' => 'deluxe', 'description' => 'Elegant contemporary rooms with warm earth tones', 'display_order' => 1],
        ['name' => 'Executive Suite', 'slug' => 'executive', 'description' => 'Spacious luxury with separate living area', 'display_order' => 2],
        ['name' => 'Family Villa', 'slug' => 'family', 'description' => 'Perfect for families with multiple bedrooms', 'display_order' => 3],
        ['name' => 'Presidential Villa', 'slug' => 'presidential', 'description' => 'The pinnacle of luxury living', 'display_order' => 4],
        ['name' => 'Garden View', 'slug' => 'garden', 'description' => 'Serene rooms overlooking lush gardens', 'display_order' => 5],
        ['name' => 'Honeymoon Suite', 'slug' => 'honeymoon', 'description' => 'Romantic settings for couples', 'display_order' => 6],
        ['name' => 'Business Suite', 'slug' => 'business', 'description' => 'Optimized for the modern professional', 'display_order' => 7],
        ['name' => 'Sky Penthouse', 'slug' => 'penthouse', 'description' => 'Ultimate luxury with panoramic views', 'display_order' => 8]
    ];
    
    $typeStmt = $pdo->prepare("INSERT INTO room_types (name, slug, description, display_order) VALUES (:name, :slug, :description, :display_order)");
    foreach ($roomTypes as $type) {
        $typeStmt->execute($type);
    }
}

// Function to get all room types
function getAllRoomTypes($pdo) {
    $stmt = $pdo->query("SELECT * FROM room_types WHERE is_active = 1 ORDER BY display_order ASC");
    return $stmt->fetchAll();
}

// Create bookings table
$createBookingsTable = "CREATE TABLE IF NOT EXISTS bookings (
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
)";

$pdo->exec($createBookingsTable);

// Create menu categories table
$createMenuCategoriesTable = "CREATE TABLE IF NOT EXISTS menu_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$pdo->exec($createMenuCategoriesTable);

// Create menu items table
$createMenuItemsTable = "CREATE TABLE IF NOT EXISTS menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    ingredients TEXT,
    allergens TEXT,
    spice_level VARCHAR(20),
    dietary_info VARCHAR(100),
    is_available TINYINT(1) DEFAULT 1,
    is_signature TINYINT(1) DEFAULT 0,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES menu_categories(id)
)";
$pdo->exec($createMenuItemsTable);

// Create dining experiences table
$createDiningExperiencesTable = "CREATE TABLE IF NOT EXISTS dining_experiences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    long_description TEXT,
    image VARCHAR(255),
    availability VARCHAR(100),
    max_guests INT DEFAULT 6,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$pdo->exec($createDiningExperiencesTable);

// Create table types table
$createTableTypesTable = "CREATE TABLE IF NOT EXISTS table_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    max_people INT NOT NULL DEFAULT 4,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$pdo->exec($createTableTypesTable);

// Add table_type_id column to restaurant_reservations if not exists
$checkColumn = $pdo->query("SHOW COLUMNS FROM restaurant_reservations LIKE 'table_type_id'");
if ($checkColumn->rowCount() == 0) {
    $pdo->exec("ALTER TABLE restaurant_reservations ADD COLUMN table_type_id INT DEFAULT NULL");
}

// Add image column to table_types if not exists
$checkImageColumn = $pdo->query("SHOW COLUMNS FROM table_types LIKE 'image'");
if ($checkImageColumn->rowCount() == 0) {
    $pdo->exec("ALTER TABLE table_types ADD COLUMN image VARCHAR(255) AFTER description");
    
    // Update existing records with default images for special dining experiences
    $pdo->exec("UPDATE table_types SET image = 'https://images.unsplash.com/photo-1559339352-11d035aa65de?ixlib=rb-4.0.3&auto=format&fit=crop&w=1974&q=80' WHERE name = 'The Chef\\'s Table'");
    $pdo->exec("UPDATE table_types SET image = 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80' WHERE name = 'Private Dining Room'");
    $pdo->exec("UPDATE table_types SET image = 'https://images.unsplash.com/photo-1551632436-cbf8dd35adfa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80' WHERE name = 'Garden Terrace'");
    $pdo->exec("UPDATE table_types SET image = 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80' WHERE name = 'Main Dining'");
    $pdo->exec("UPDATE table_types SET image = 'https://images.unsplash.com/photo-1550966871-3ed3cdb51f3a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80' WHERE name = 'Window Seat'");
    $pdo->exec("UPDATE table_types SET image = 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80' WHERE name = 'Bar Area'");
}

// Create sample menus table
$createSampleMenusTable = "CREATE TABLE IF NOT EXISTS sample_menus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    subtitle VARCHAR(100),
    description TEXT,
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$pdo->exec($createSampleMenusTable);

// Insert default sample menus if empty
$stmt = $pdo->query("SELECT COUNT(*) as count FROM sample_menus");
$result = $stmt->fetch();

if ($result['count'] == 0) {
    $sampleMenus = [
        ['title' => 'Tasting Menu', 'subtitle' => '7 courses', 'description' => 'A full 7-course culinary journey showcasing our finest dishes', 'display_order' => 1],
        ['title' => 'À La Carte', 'subtitle' => 'Seasonal', 'description' => 'Our seasonal offerings featuring the freshest ingredients', 'display_order' => 2],
        ['title' => 'Dessert Menu', 'subtitle' => 'Sweet endings', 'description' => 'Indulgent desserts to complete your dining experience', 'display_order' => 3]
    ];
    
    $menuStmt = $pdo->prepare("INSERT INTO sample_menus (title, subtitle, description, display_order) VALUES (:title, :subtitle, :description, :display_order)");
    foreach ($sampleMenus as $menu) {
        $menuStmt->execute($menu);
    }
}

// Create sample menu items table
$createSampleMenuItemsTable = "CREATE TABLE IF NOT EXISTS sample_menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    menu_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    price VARCHAR(50),
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (menu_id) REFERENCES sample_menus(id)
)";
$pdo->exec($createSampleMenuItemsTable);

// Insert default sample menu items if empty
$stmt = $pdo->query("SELECT COUNT(*) as count FROM sample_menu_items");
$result = $stmt->fetch();

if ($result['count'] == 0) {
    $sampleMenuItems = [
        // Tasting Menu items
        ['menu_id' => 1, 'name' => 'Amuse-bouche', 'price' => 'KSh 1,200', 'display_order' => 1],
        ['menu_id' => 1, 'name' => 'Coastal Ceviche', 'price' => 'KSh 2,500', 'display_order' => 2],
        ['menu_id' => 1, 'name' => 'Nyama Choma', 'price' => 'KSh 3,800', 'display_order' => 3],
        ['menu_id' => 1, 'name' => 'Palate Cleanser', 'price' => 'KSh 800', 'display_order' => 4],
        ['menu_id' => 1, 'name' => 'Swahili Pilau', 'price' => 'KSh 2,800', 'display_order' => 5],
        ['menu_id' => 1, 'name' => 'Dessert Trio', 'price' => 'KSh 2,200', 'display_order' => 6],
        
        // A La Carte items
        ['menu_id' => 2, 'name' => 'Starters', 'price' => 'KSh 1,800 - 2,500', 'display_order' => 1],
        ['menu_id' => 2, 'name' => 'Main Courses', 'price' => 'KSh 2,800 - 4,500', 'display_order' => 2],
        ['menu_id' => 2, 'name' => 'Grill Specialties', 'price' => 'KSh 3,200 - 4,800', 'display_order' => 3],
        ['menu_id' => 2, 'name' => 'Vegetarian', 'price' => 'KSh 2,200 - 3,000', 'display_order' => 4],
        ['menu_id' => 2, 'name' => 'Sides', 'price' => 'KSh 650 - 1,200', 'display_order' => 5],
        ['menu_id' => 2, 'name' => 'Desserts', 'price' => 'KSh 1,200 - 1,800', 'display_order' => 6],
        
        // Dessert Menu items
        ['menu_id' => 3, 'name' => 'Chocolate Fondant', 'price' => 'KSh 1,500', 'display_order' => 1],
        ['menu_id' => 3, 'name' => 'Passion Fruit Panna Cotta', 'price' => 'KSh 1,400', 'display_order' => 2],
        ['menu_id' => 3, 'name' => 'Coconut & Mango Tart', 'price' => 'KSh 1,400', 'display_order' => 3],
        ['menu_id' => 3, 'name' => 'Masala Chai Crème Brûlée', 'price' => 'KSh 1,500', 'display_order' => 4],
        ['menu_id' => 3, 'name' => 'Fresh Fruit Platter', 'price' => 'KSh 1,200', 'display_order' => 5],
        ['menu_id' => 3, 'name' => 'Artisan Ice Cream', 'price' => 'KSh 950', 'display_order' => 6]
    ];
    
    $itemStmt = $pdo->prepare("INSERT INTO sample_menu_items (menu_id, name, price, display_order) VALUES (:menu_id, :name, :price, :display_order)");
    foreach ($sampleMenuItems as $item) {
        $itemStmt->execute($item);
    }
}

// Function to get all sample menus with items
function getAllSampleMenus($pdo) {
    $menus = $pdo->query("SELECT * FROM sample_menus WHERE is_active = 1 ORDER BY display_order ASC")->fetchAll();
    
    foreach ($menus as &$menu) {
        $items = $pdo->prepare("SELECT * FROM sample_menu_items WHERE menu_id = :menu_id ORDER BY display_order ASC");
        $items->execute([':menu_id' => $menu['id']]);
        $menu['items'] = $items->fetchAll();
    }
    
    return $menus;
}

// Insert default table types if empty
$stmt = $pdo->query("SELECT COUNT(*) as count FROM table_types");
$result = $stmt->fetch();

if ($result['count'] == 0) {
    $tableTypes = [
        ['name' => "The Chef's Table", 'description' => 'An intimate 8-course journey seated at the kitchen pass. Watch our culinary team create magic while the chef personally explains each dish inspiration and technique.', 'image' => 'https://images.unsplash.com/photo-1559339352-11d035aa65de?ixlib=rb-4.0.3&auto=format&fit=crop&w=1974&q=80', 'max_people' => 6],
        ['name' => 'Private Dining Room', 'description' => 'Host up to 16 guests in our elegant private dining room. Featuring a dedicated menu, personal waiter, and wine pairing options.', 'image' => 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'max_people' => 16],
        ['name' => 'Garden Terrace', 'description' => 'Al fresco dining under the stars. Surrounded by lush gardens and ambient lighting, enjoy our signature menu in Nairobi\'s most romantic setting.', 'image' => 'https://images.unsplash.com/photo-1551632436-cbf8dd35adfa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80', 'max_people' => 12],
        ['name' => 'Main Dining', 'description' => 'Elegant main restaurant seating with ambient lighting and sophisticated atmosphere.', 'image' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'max_people' => 8],
        ['name' => 'Window Seat', 'description' => 'Seating with scenic views of the garden and pool area.', 'image' => 'https://images.unsplash.com/photo-1550966871-3ed3cdb51f3a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'max_people' => 4],
        ['name' => 'Bar Area', 'description' => 'Casual dining at the bar with craft cocktails and light bites.', 'image' => 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'max_people' => 4]
    ];
    
    $tableTypeStmt = $pdo->prepare("INSERT INTO table_types (name, description, image, max_people) VALUES (:name, :description, :image, :max_people)");
    foreach ($tableTypes as $type) {
        $tableTypeStmt->execute($type);
    }
}

// Create restaurant reservations table
$createRestaurantReservationsTable = "CREATE TABLE IF NOT EXISTS restaurant_reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    table_type_id INT DEFAULT NULL,
    reservation_date DATE NOT NULL,
    reservation_time VARCHAR(20) NOT NULL,
    num_guests INT NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    occasion VARCHAR(50),
    selected_items TEXT,
    special_requests TEXT,
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$pdo->exec($createRestaurantReservationsTable);

// Insert default menu data if tables are empty
$stmt = $pdo->query("SELECT COUNT(*) as count FROM menu_categories");
$result = $stmt->fetch();

if ($result['count'] == 0) {
    // Insert menu categories
    $categories = [
        ['name' => 'Signature Dishes', 'description' => 'Our chef\'s signature creations', 'display_order' => 1],
        ['name' => 'Tasting Menu', 'description' => '7-course culinary journey', 'display_order' => 2],
        ['name' => 'A La Carte', 'description' => 'Seasonal offerings', 'display_order' => 3],
        ['name' => 'Desserts', 'description' => 'Sweet endings', 'display_order' => 4],
        ['name' => 'Starters', 'description' => 'Begin your culinary journey', 'display_order' => 5],
        ['name' => 'Main Courses', 'description' => 'Heart of the menu', 'display_order' => 6],
        ['name' => 'Grill Specialties', 'description' => 'Open flame cooking', 'display_order' => 7],
        ['name' => 'Vegetarian', 'description' => 'Plant-based options', 'display_order' => 8],
        ['name' => 'Sides', 'description' => 'Perfect accompaniments', 'display_order' => 9],
        ['name' => 'Beverages', 'description' => 'Drinks and refreshments', 'display_order' => 10]
    ];
    
    $catStmt = $pdo->prepare("INSERT INTO menu_categories (name, description, display_order) VALUES (:name, :description, :display_order)");
    foreach ($categories as $cat) {
        $catStmt->execute($cat);
    }
    
    // Insert menu items
    $menuItems = [
        // Signature Dishes
        ['category_id' => 1, 'name' => 'Nyama Choma', 'description' => 'Grilled premium beef with kachumbari', 'price' => 3800, 'image' => 'https://beehiverl.com/wp-content/uploads/2024/09/Nyama-Choma-2.jpg', 'ingredients' => 'Premium beef, Garlic, Ginger, Swahili spice blend, Lime, Fresh tomatoes, Onions, Cilantro', 'spice_level' => 'Medium', 'dietary_info' => 'Gluten-free option available', 'is_signature' => 1],
        ['category_id' => 1, 'name' => 'Swahili Pilau', 'description' => 'Spiced rice with tender meat and caramelized onions', 'price' => 2200, 'image' => 'https://images.unsplash.com/photo-1633945274405-b6c8069047b0?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'ingredients' => 'Basmati rice, Beef, Cardamom, Cinnamon, Cloves, Cumin, Onions, Garlic', 'spice_level' => 'Mild', 'dietary_info' => 'Contains gluten', 'is_signature' => 1],
        ['category_id' => 1, 'name' => 'Coastal Seafood Platter', 'description' => 'Fresh catch with coconut curry and chapati', 'price' => 4500, 'image' => 'https://images.unsplash.com/photo-1559847844-5315695dadae?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'ingredients' => 'Prawns, Calamari, Fish, Coconut milk, Tamarind, Curry leaves, Lemongrass, Chilies', 'spice_level' => 'Medium-Hot', 'dietary_info' => 'Contains seafood', 'is_signature' => 1],
        ['category_id' => 1, 'name' => 'Samaki wa Kupaka', 'description' => 'Grilled fish in coconut and tamarind sauce', 'price' => 3200, 'image' => 'https://images.unsplash.com/photo-1580476262798-bddd9f4b7369?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'ingredients' => 'Whole tilapia, Coconut milk, Tamarind, Lime, Garlic, Ginger, Chilies, Cilantro', 'spice_level' => 'Medium', 'dietary_info' => 'Gluten-free', 'is_signature' => 1],
        ['category_id' => 1, 'name' => 'Mandazi & Masala Chai', 'description' => 'East African donuts with spiced masala chai', 'price' => 850, 'image' => 'https://ca-times.brightspotcdn.com/dims4/default/2a10669/2147483647/strip/false/crop/6000x4000+0+0/resize/1486x991!/quality/75/?url=https%3A%2F%2Fcalifornia-times-brightspot.s3.amazonaws.com%2F91%2F68%2F749190444099bbb5d78da123e922%2F666808-la-fo-kiano-moju-christmas-sr0836.jpg', 'ingredients' => 'Flour, Coconut milk, Cardamom, Sugar, Yeast, Black tea, Ginger, Cinnamon', 'spice_level' => 'None', 'dietary_info' => 'Vegetarian', 'is_signature' => 1],
        ['category_id' => 1, 'name' => 'Tropical Fruit Platter', 'description' => 'Fresh mango, pineapple, and passion fruit', 'price' => 1200, 'image' => 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?ixlib=rb-4.0.3&auto=format&fit=crop&w=2127&q=80', 'ingredients' => 'Mango, Pineapple, Passion fruit, Papaya, Watermelon, Honey, Lime, Mint', 'spice_level' => 'None', 'dietary_info' => 'Vegan, Gluten-free', 'is_signature' => 1],
        
        // Tasting Menu
        ['category_id' => 2, 'name' => 'Tasting Menu (7 Courses)', 'description' => 'Full 7-course culinary journey', 'price' => 8500, 'image' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'ingredients' => '', 'spice_level' => 'Various', 'dietary_info' => 'Menu changes seasonally', 'is_signature' => 0],
        
        // Starters
        ['category_id' => 5, 'name' => 'Coastal Ceviche', 'description' => 'Fresh fish marinated in citrus', 'price' => 2500, 'image' => 'https://images.unsplash.com/photo-1535399831218-d5bd36d1a6b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80', 'ingredients' => 'Fresh fish, Lime, Onion, Cilantro, Chilies', 'spice_level' => 'Mild', 'dietary_info' => 'Gluten-free', 'is_signature' => 0],
        ['category_id' => 5, 'name' => 'Samosa Trio', 'description' => 'Crispy pastries with spiced filling', 'price' => 1800, 'image' => 'https://images.unsplash.com/photo-1601050690597-df0568f70950?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'ingredients' => 'Flour, Beef, Potatoes, Peas, Spices', 'spice_level' => 'Medium', 'dietary_info' => 'Contains gluten', 'is_signature' => 0],
        ['category_id' => 5, 'name' => 'Kachumbari Fresh Salad', 'description' => 'Tomato and onion salsa', 'price' => 1200, 'image' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'ingredients' => 'Tomatoes, Onions, Cilantro, Lime', 'spice_level' => 'None', 'dietary_info' => 'Vegan, Gluten-free', 'is_signature' => 0],
        
        // Main Courses
        ['category_id' => 6, 'name' => 'Grilled Chicken Breast', 'description' => 'Herb-marinated with seasonal vegetables', 'price' => 2800, 'image' => 'https://images.unsplash.com/photo-1532550907401-a500c9a57435?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80', 'ingredients' => 'Chicken breast, Herbs, Garlic, Olive oil', 'spice_level' => 'None', 'dietary_info' => 'Gluten-free', 'is_signature' => 0],
        ['category_id' => 6, 'name' => 'Lamb Stew', 'description' => 'Slow-cooked with root vegetables', 'price' => 3500, 'image' => 'https://images.unsplash.com/photo-1544025162-d76694265947?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80', 'ingredients' => 'Lamb, Potatoes, Carrots, Onions, Thyme', 'spice_level' => 'Mild', 'dietary_info' => 'Gluten-free', 'is_signature' => 0],
        ['category_id' => 6, 'name' => 'Vegetable Curry', 'description' => 'Mixed vegetables in coconut sauce', 'price' => 2200, 'image' => 'https://images.unsplash.com/photo-1455619452474-d2be8b1e70cd?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'ingredients' => 'Mixed vegetables, Coconut milk, Curry spices', 'spice_level' => 'Medium', 'dietary_info' => 'Vegan, Gluten-free', 'is_signature' => 0],
        
        // Grill Specialties
        ['category_id' => 7, 'name' => 'T-Bone Steak', 'description' => 'Premium cut, grilled to perfection', 'price' => 4800, 'image' => 'https://images.unsplash.com/photo-1600891964092-4316c288032e?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80', 'ingredients' => 'T-Bone beef, Rosemary, Garlic, Sea salt', 'spice_level' => 'None', 'dietary_info' => 'Gluten-free', 'is_signature' => 0],
        ['category_id' => 7, 'name' => 'Mixed Grill Platter', 'description' => 'Beef, chicken, and lamb', 'price' => 4200, 'image' => 'https://images.unsplash.com/photo-1529694157872-4e0c0f3b238b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80', 'ingredients' => 'Beef, Chicken, Lamb, Marinade', 'spice_level' => 'Mild', 'dietary_info' => 'Gluten-free', 'is_signature' => 0],
        
        // Vegetarian
        ['category_id' => 8, 'name' => 'Vegetable Stir Fry', 'description' => 'Seasonal vegetables, soy sauce', 'price' => 2000, 'image' => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?ixlib=rb-4.0.3&auto=format&fit=crop&w=2072&q=80', 'ingredients' => 'Mixed vegetables, Soy sauce, Ginger, Garlic', 'spice_level' => 'Mild', 'dietary_info' => 'Vegan', 'is_signature' => 0],
        ['category_id' => 8, 'name' => 'Mushroom Risotto', 'description' => 'Creamy arborio rice with wild mushrooms', 'price' => 2800, 'image' => 'https://images.unsplash.com/photo-1476124369491-e7addf5db371?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'ingredients' => 'Arborio rice, Wild mushrooms, Parmesan, Herbs', 'spice_level' => 'None', 'dietary_info' => 'Vegetarian', 'is_signature' => 0],
        
        // Sides
        ['category_id' => 9, 'name' => 'Ugali', 'description' => 'Traditional cornmeal porridge', 'price' => 450, 'image' => 'https://images.unsplash.com/photo-1626200419199-391ae4be7a41?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'ingredients' => 'Cornmeal, Water', 'spice_level' => 'None', 'dietary_info' => 'Vegan, Gluten-free', 'is_signature' => 0],
        ['category_id' => 9, 'name' => 'Chapati', 'description' => 'Flaky flatbread', 'price' => 350, 'image' => 'https://images.unsplash.com/photo-1568254183919-78a4f43a2877?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'ingredients' => 'Flour, Oil, Salt', 'spice_level' => 'None', 'dietary_info' => 'Vegetarian', 'is_signature' => 0],
        ['category_id' => 9, 'name' => 'Mchicha', 'description' => 'Sautéed spinach with coconut', 'price' => 650, 'image' => 'https://images.unsplash.com/photo-1576021182211-9ea8dced3690?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'ingredients' => 'Spinach, Coconut milk, Onions, Tomatoes', 'spice_level' => 'None', 'dietary_info' => 'Vegan, Gluten-free', 'is_signature' => 0],
        
        // Desserts
        ['category_id' => 4, 'name' => 'Chocolate Fondant', 'description' => 'Warm chocolate cake with molten center', 'price' => 1500, 'image' => 'https://images.unsplash.com/photo-1624353365286-3f8e62b1aa2c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'ingredients' => 'Dark chocolate, Eggs, Butter, Flour', 'spice_level' => 'None', 'dietary_info' => 'Contains gluten', 'is_signature' => 0],
        ['category_id' => 4, 'name' => 'Passion Fruit Panna Cotta', 'description' => 'Italian cream with tropical fruit', 'price' => 1400, 'image' => 'https://images.unsplash.com/photo-1488477181946-6428a0291777?ixlib=rb-4.0.3&auto=format&fit=crop&w=2072&q=80', 'ingredients' => 'Cream, Passion fruit, Gelatin, Sugar', 'spice_level' => 'None', 'dietary_info' => 'Vegetarian', 'is_signature' => 0],
        ['category_id' => 4, 'name' => 'Coconut & Mango Tart', 'description' => 'Tropical fruit tart', 'price' => 1400, 'image' => 'https://images.unsplash.com/photo-1464305795204-6f5bbfc7fb81?ixlib=rb-4.0.3&auto=format&fit=crop&w=2072&q=80', 'ingredients' => 'Coconut, Mango, Tart shell, Custard', 'spice_level' => 'None', 'dietary_info' => 'Contains gluten', 'is_signature' => 0],
        ['category_id' => 4, 'name' => 'Masala Chai Crème Brûlée', 'description' => 'Spiced tea custard with caramelized top', 'price' => 1500, 'image' => 'https://images.unsplash.com/photo-1470124182917-cc6e71b22ecc?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'ingredients' => 'Chai spices, Cream, Eggs, Sugar', 'spice_level' => 'Mild', 'dietary_info' => 'Contains gluten', 'is_signature' => 0],
        
        // Beverages
        ['category_id' => 10, 'name' => 'Masala Chai', 'description' => 'Spiced tea with milk', 'price' => 450, 'image' => 'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'ingredients' => 'Black tea, Milk, Cardamom, Ginger, Cinnamon', 'spice_level' => 'Mild', 'dietary_info' => 'Vegetarian', 'is_signature' => 0],
        ['category_id' => 10, 'name' => 'Fresh Juice', 'description' => 'Seasonal fruit juice', 'price' => 550, 'image' => 'https://images.unsplash.com/photo-1600271886742-f049cd451bba?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80', 'ingredients' => 'Fresh seasonal fruits', 'spice_level' => 'None', 'dietary_info' => 'Vegan', 'is_signature' => 0],
        ['category_id' => 10, 'name' => 'Red Wine (Glass)', 'description' => 'Selection of fine wines', 'price' => 1200, 'image' => 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'ingredients' => '', 'spice_level' => 'None', 'dietary_info' => 'Vegan', 'is_signature' => 0],
        ['category_id' => 10, 'name' => 'White Wine (Glass)', 'description' => 'Selection of fine wines', 'price' => 1100, 'image' => 'https://images.unsplash.com/photo-1566754436893-a5fc3af4eb33?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'ingredients' => '', 'spice_level' => 'None', 'dietary_info' => 'Vegan', 'is_signature' => 0]
    ];
    
    $itemStmt = $pdo->prepare("INSERT INTO menu_items (category_id, name, description, price, image, ingredients, spice_level, dietary_info, is_signature) VALUES (:category_id, :name, :description, :price, :image, :ingredients, :spice_level, :dietary_info, :is_signature)");
    foreach ($menuItems as $item) {
        $itemStmt->execute($item);
    }
    
    // Insert dining experiences
    $experiences = [
        ['title' => "The Chef's Table", 'description' => 'An intimate 8-course journey seated at the kitchen pass.', 'long_description' => 'Watch our culinary team create magic while the chef personally explains each dish inspiration and technique.', 'image' => 'https://images.unsplash.com/photo-1559339352-11d035aa65de?ixlib=rb-4.0.3&auto=format&fit=crop&w=1974&q=80', 'availability' => 'Thursday-Sunday', 'max_guests' => 6],
        ['title' => 'Private Dining Room', 'description' => 'Host up to 16 guests in our elegant private dining room.', 'long_description' => 'Featuring a dedicated menu, personal waiter, and wine pairing options. Ideal for celebrations and business dinners.', 'image' => 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'availability' => 'Daily', 'max_guests' => 16],
        ['title' => 'Garden Terrace', 'description' => 'Al fresco dining under the stars.', 'long_description' => 'Surrounded by lush gardens and ambient lighting, enjoy our signature menu in Nairobi most romantic setting.', 'image' => 'https://images.unsplash.com/photo-1551632436-cbf8dd35adfa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80', 'availability' => 'Weather permitting, Evenings only', 'max_guests' => 12]
    ];
    
    $expStmt = $pdo->prepare("INSERT INTO dining_experiences (title, description, long_description, image, availability, max_guests) VALUES (:title, :description, :long_description, :image, :availability, :max_guests)");
    foreach ($experiences as $exp) {
        $expStmt->execute($exp);
    }
}

// Function to insert rooms data
function insertRooms($pdo) {
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

    // Insert rooms (use REPLACE to update if exists)
    $stmt = $pdo->prepare("INSERT INTO rooms (room_type, name, description, price, size, occupancy, bed_type, view, amenities, images, badge) 
                           VALUES (:room_type, :name, :description, :price, :size, :occupancy, :bed_type, :view, :amenities, :images, :badge)
                           ON DUPLICATE KEY UPDATE name = VALUES(name), description = VALUES(description), price = VALUES(price), 
                           size = VALUES(size), occupancy = VALUES(occupancy), bed_type = VALUES(bed_type), 
                           view = VALUES(view), amenities = VALUES(amenities), images = VALUES(images), badge = VALUES(badge)");

    foreach ($rooms as $room) {
        $stmt->execute($room);
    }
}

// Run the insert function only if rooms table is empty
$stmt = $pdo->query("SELECT COUNT(*) as count FROM rooms");
$result = $stmt->fetch();

if ($result['count'] == 0) {
    insertRooms($pdo);
}

// Function to get all rooms
function getAllRooms($pdo, $viewFilter = null, $bedFilter = null, $sort = 'price_asc', $limit = null) {
    // Include rooms with is_active = 1, NULL, or empty
    $sql = "SELECT * FROM rooms WHERE is_active = 1 OR is_active IS NULL OR is_active = ''";
    $params = [];

    if ($viewFilter && $viewFilter !== 'all') {
        $sql .= " AND view = :view";
        $params[':view'] = $viewFilter;
    }

    if ($bedFilter && $bedFilter !== 'all') {
        $sql .= " AND bed_type LIKE :bed_type";
        $params[':bed_type'] = '%' . $bedFilter . '%';
    }

    switch ($sort) {
        case 'price_high':
            $sql .= " ORDER BY price DESC";
            break;
        case 'popular':
            $sql .= " ORDER BY badge DESC, id ASC";
            break;
        case 'newest':
            $sql .= " ORDER BY created_at DESC";
            break;
        default:
            $sql .= " ORDER BY price ASC";
    }

    if ($limit) {
        $sql .= " LIMIT " . intval($limit);
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

// Function to get latest rooms (for homepage)
function getLatestRooms($pdo, $limit = 8) {
    $stmt = $pdo->prepare("SELECT * FROM rooms WHERE is_active = 1 OR is_active IS NULL OR is_active = '' ORDER BY created_at DESC LIMIT :limit");
    $stmt->bindValue(':limit', intval($limit), PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Function to get a single room
function getRoomByType($pdo, $roomType) {
    $stmt = $pdo->prepare("SELECT * FROM rooms WHERE room_type = :room_type AND is_active = 1 ORDER BY id ASC LIMIT 1");
    $stmt->execute([':room_type' => $roomType]);
    return $stmt->fetch();
}

// Function to get a room by ID
function getRoomById($pdo, $roomId) {
    $stmt = $pdo->prepare("SELECT * FROM rooms WHERE id = :id AND is_active = 1");
    $stmt->execute([':id' => $roomId]);
    return $stmt->fetch();
}

// Function to check room availability
function checkAvailability($pdo, $roomId, $checkIn, $checkOut) {
    $stmt = $pdo->prepare("SELECT * FROM bookings 
                           WHERE room_id = :room_id 
                           AND status = 'confirmed' 
                           AND ((check_in <= :check_in AND check_out > :check_in) 
                           OR (check_in < :check_out AND check_out >= :check_out) 
                           OR (check_in >= :check_in AND check_out <= :check_out))");
    
    $stmt->execute([
        ':room_id' => $roomId,
        ':check_in' => $checkIn,
        ':check_out' => $checkOut
    ]);
    
    return $stmt->fetchAll(); // Returns existing bookings if any
}

// Function to get alternative available rooms
function getAlternativeRooms($pdo, $checkIn, $checkOut, $excludeRoomId = null) {
    $sql = "SELECT r.* FROM rooms r WHERE r.is_active = 1 AND r.id NOT IN (
        SELECT b.room_id FROM bookings b 
        WHERE b.status = 'confirmed' 
        AND ((b.check_in <= :check_in AND b.check_out > :check_in) 
        OR (b.check_in < :check_out AND b.check_out >= :check_out) 
        OR (b.check_in >= :check_in AND b.check_out <= :check_out))
    )";
    
    if ($excludeRoomId) {
        $sql .= " AND r.id != :exclude_id";
    }
    
    $stmt = $pdo->prepare($sql);
    $params = [
        ':check_in' => $checkIn,
        ':check_out' => $checkOut
    ];
    
    if ($excludeRoomId) {
        $params[':exclude_id'] = $excludeRoomId;
    }
    
    $stmt->execute($params);
    return $stmt->fetchAll();
}

// Function to create a booking
function createBooking($pdo, $data) {
    // Calculate total price
    $checkIn = new DateTime($data['check_in']);
    $checkOut = new DateTime($data['check_out']);
    $nights = $checkOut->diff($checkIn)->days;
    
    $room = getRoomByType($pdo, $data['room_type']);
    $totalPrice = $room['price'] * $nights;
    
    $stmt = $pdo->prepare("INSERT INTO bookings (room_id, guest_name, guest_email, guest_phone, check_in, check_out, adults, children, special_requests, status, total_price) 
                           VALUES (:room_id, :guest_name, :guest_email, :guest_phone, :check_in, :check_out, :adults, :children, :special_requests, 'confirmed', :total_price)");
    
    $stmt->execute([
        ':room_id' => $room['id'],
        ':guest_name' => $data['guest_name'],
        ':guest_email' => $data['guest_email'],
        ':guest_phone' => $data['guest_phone'],
        ':check_in' => $data['check_in'],
        ':check_out' => $data['check_out'],
        ':adults' => $data['adults'],
        ':children' => $data['children'],
        ':special_requests' => $data['special_requests'],
        ':total_price' => $totalPrice
    ]);
    
    return [
        'booking_id' => $pdo->lastInsertId(),
        'total_price' => $totalPrice,
        'nights' => $nights
    ];
}

// Function to get all menu categories
function getAllMenuCategories($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM menu_categories WHERE is_active = 1 ORDER BY display_order ASC");
    $stmt->execute();
    return $stmt->fetchAll();
}

// Function to get menu items by category
function getMenuItemsByCategory($pdo, $categoryId) {
    $stmt = $pdo->prepare("SELECT * FROM menu_items WHERE category_id = :category_id AND is_available = 1 ORDER BY is_signature DESC, name ASC");
    $stmt->execute([':category_id' => $categoryId]);
    return $stmt->fetchAll();
}

// Function to get all menu items
function getAllMenuItems($pdo) {
    $stmt = $pdo->query("SELECT mi.*, mc.name as category_name FROM menu_items mi 
                           LEFT JOIN menu_categories mc ON mi.category_id = mc.id 
                           WHERE mi.is_available = 1 
                           ORDER BY mc.display_order ASC, mi.is_signature DESC, mi.name ASC");
    return $stmt->fetchAll();
}

// Function to get signature dishes
function getSignatureDishes($pdo) {
    $stmt = $pdo->prepare("SELECT mi.*, mc.name as category_name FROM menu_items mi 
                           LEFT JOIN menu_categories mc ON mi.category_id = mc.id 
                           WHERE mi.is_signature = 1 AND mi.is_available = 1 
                           ORDER BY mi.name ASC");
    $stmt->execute();
    return $stmt->fetchAll();
}

// Function to get all dining experiences
function getAllDiningExperiences($pdo) {
    $stmt = $pdo->query("SELECT * FROM dining_experiences WHERE is_active = 1 ORDER BY id ASC");
    return $stmt->fetchAll();
}

// Function to create restaurant reservation
function createRestaurantReservation($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO restaurant_reservations 
                           (table_type_id, reservation_date, reservation_time, num_guests, first_name, last_name, email, phone, occasion, selected_items, special_requests, status) 
                           VALUES (:table_type_id, :reservation_date, :reservation_time, :num_guests, :first_name, :last_name, :email, :phone, :occasion, :selected_items, :special_requests, 'confirmed')");
    
    $stmt->execute([
        ':table_type_id' => isset($data['table_type_id']) ? $data['table_type_id'] : NULL,
        ':reservation_date' => $data['reservation_date'],
        ':reservation_time' => $data['reservation_time'],
        ':num_guests' => $data['num_guests'],
        ':first_name' => $data['first_name'],
        ':last_name' => $data['last_name'],
        ':email' => $data['email'],
        ':phone' => $data['phone'],
        ':occasion' => $data['occasion'],
        ':selected_items' => $data['selected_items'],
        ':special_requests' => $data['special_requests']
    ]);
    
    return [
        'reservation_id' => $pdo->lastInsertId(),
        'reservation_date' => $data['reservation_date'],
        'reservation_time' => $data['reservation_time'],
        'num_guests' => $data['num_guests']
    ];
}

// Function to get all table types
function getAllTableTypes($pdo) {
    $stmt = $pdo->query("SELECT * FROM table_types WHERE is_active = 1 ORDER BY max_people ASC");
    return $stmt->fetchAll();
}

// Create event venues table if not exists
$createEventVenuesTable = "CREATE TABLE IF NOT EXISTS event_venues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    long_description TEXT,
    capacity VARCHAR(50),
    size VARCHAR(50),
    image VARCHAR(255),
    features JSON,
    is_active TINYINT(1) DEFAULT 1,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$pdo->exec($createEventVenuesTable);

// Insert default event venues if empty
$stmt = $pdo->query("SELECT COUNT(*) as count FROM event_venues");
$result = $stmt->fetch();

if ($result['count'] == 0) {
    $eventVenues = [
        [
            'name' => 'The Grand Ballroom',
            'slug' => 'grand-ballroom',
            'description' => 'Our most elegant space, perfect for grand weddings and galas.',
            'long_description' => 'The Grand Ballroom is our flagship venue, featuring 450 m² of column-free space with stunning crystal chandeliers, a built-in sound system, and a private bar and lounge area. Perfect for weddings of up to 200 guests, corporate galas, and exclusive celebrations.',
            'capacity' => '200 guests',
            'size' => '450 m²',
            'image' => 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
            'features' => json_encode(['Column-free space', 'Crystal chandeliers', 'Built-in sound system', 'Private bar and lounge', 'Customizable lighting']),
            'display_order' => 1
        ],
        [
            'name' => 'The Beachfront Lawn',
            'slug' => 'beachfront',
            'description' => 'Outdoor paradise for beach weddings and sunset celebrations.',
            'long_description' => 'Experience the magic of an outdoor celebration at our Beachfront Lawn, offering 500 m² of ocean-view space with private beach access. Perfect for sunset weddings, cocktail receptions, and luxury tent accommodations.',
            'capacity' => '150 guests',
            'size' => '500 m²',
            'image' => 'https://images.unsplash.com/photo-1523438885200-e635ba2c371e?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
            'features' => json_encode(['Ocean views', 'Private beach access', 'Luxury tents available', 'Sunset bonfire setup', 'Outdoor bar area']),
            'display_order' => 2
        ],
        [
            'name' => 'The Boardroom',
            'slug' => 'boardroom',
            'description' => 'Intimate space for board meetings and executive retreats.',
            'long_description' => 'Our Executive Boardroom offers an intimate setting for high-level meetings, featuring 80 m² of executive space with 4K video conferencing capabilities, dedicated high-speed internet, and private catering options.',
            'capacity' => '20 guests',
            'size' => '80 m²',
            'image' => 'https://images.unsplash.com/photo-1431540015161-0bf86838fb31?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
            'features' => json_encode(['4K video conferencing', 'Dedicated high-speed internet', 'Private catering available', 'Executive seating', 'Presentation equipment']),
            'display_order' => 3
        ],
        [
            'name' => 'The Garden Pavilion',
            'slug' => 'garden-pavilion',
            'description' => 'Serene setting surrounded by lush tropical gardens.',
            'long_description' => 'The Garden Pavilion offers a tranquil escape surrounded by manicured tropical gardens. Perfect for intimate ceremonies, rehearsal dinners, and private receptions with a natural, elegant backdrop.',
            'capacity' => '80 guests',
            'size' => '200 m²',
            'image' => 'https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
            'features' => json_encode(['Garden views', 'Natural lighting', 'Climate controlled', 'Adjacent cocktail area', 'Built-in dance floor']),
            'display_order' => 4
        ],
        [
            'name' => 'The Rooftop Terrace',
            'slug' => 'rooftop',
            'description' => 'Panoramic city views for sophisticated celebrations.',
            'long_description' => 'Perched on the top floor, our Rooftop Terrace offers breathtaking panoramic views of the city skyline. Ideal for cocktail parties, milestone celebrations, and intimate weddings under the stars.',
            'capacity' => '60 guests',
            'size' => '150 m²',
            'image' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
            'features' => json_encode(['Panoramic city views', 'Open-air setting', 'Climate control', 'Full bar setup', 'DJ booth']),
            'display_order' => 5
        ],
        [
            'name' => 'The Conference Center',
            'slug' => 'conference',
            'description' => 'State-of-the-art facilities for corporate events.',
            'long_description' => 'Our Conference Center features multiple flexible spaces equipped with the latest technology. From small breakout rooms to large conference halls, we can accommodate various corporate event needs.',
            'capacity' => '300 guests',
            'size' => '600 m²',
            'image' => 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80',
            'features' => json_encode(['Multiple room configurations', 'Latest AV equipment', 'High-speed WiFi', 'Catering services', 'Technical support']),
            'display_order' => 6
        ]
    ];
    
    $venueStmt = $pdo->prepare("INSERT INTO event_venues (name, slug, description, long_description, capacity, size, image, features, display_order) VALUES (:name, :slug, :description, :long_description, :capacity, :size, :image, :features, :display_order)");
    foreach ($eventVenues as $venue) {
        $venueStmt->execute($venue);
    }
}

// Create event inquiries table if not exists
$createEventInquiriesTable = "CREATE TABLE IF NOT EXISTS event_inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venue_id INT DEFAULT NULL,
    event_type VARCHAR(50) NOT NULL,
    guest_name VARCHAR(100) NOT NULL,
    guest_email VARCHAR(100) NOT NULL,
    guest_phone VARCHAR(20) NOT NULL,
    event_date DATE NOT NULL,
    guest_count VARCHAR(50),
    message TEXT,
    status ENUM('pending', 'contacted', 'confirmed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$pdo->exec($createEventInquiriesTable);

// Function to get all event venues
function getAllEventVenues($pdo) {
    $stmt = $pdo->query("SELECT * FROM event_venues WHERE is_active = 1 ORDER BY display_order ASC");
    return $stmt->fetchAll();
}

// Function to get event venue by slug
function getEventVenueBySlug($pdo, $slug) {
    $stmt = $pdo->prepare("SELECT * FROM event_venues WHERE slug = :slug AND is_active = 1");
    $stmt->execute([':slug' => $slug]);
    return $stmt->fetch();
}

// Function to create event inquiry
function createEventInquiry($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO event_inquiries (venue_id, event_type, guest_name, guest_email, guest_phone, event_date, guest_count, message, status) VALUES (:venue_id, :event_type, :guest_name, :guest_email, :guest_phone, :event_date, :guest_count, :message, 'pending')");
    
    $stmt->execute([
        ':venue_id' => isset($data['venue_id']) ? $data['venue_id'] : NULL,
        ':event_type' => $data['event_type'],
        ':guest_name' => $data['guest_name'],
        ':guest_email' => $data['guest_email'],
        ':guest_phone' => $data['guest_phone'],
        ':event_date' => $data['event_date'],
        ':guest_count' => $data['guest_count'],
        ':message' => $data['message']
    ]);
    
    return [
        'inquiry_id' => $pdo->lastInsertId(),
        'guest_name' => $data['guest_name'],
        'event_type' => $data['event_type']
    ];
}

// Create amenity categories table if not exists
$createAmenityCategoriesTable = "CREATE TABLE IF NOT EXISTS amenity_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$pdo->exec($createAmenityCategoriesTable);

// Create amenities table if not exists
$createAmenitiesTable = "CREATE TABLE IF NOT EXISTS amenities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    long_description TEXT,
    icon VARCHAR(50),
    image VARCHAR(255),
    hours VARCHAR(100),
    phone VARCHAR(50),
    features JSON,
    gallery JSON,
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES amenity_categories(id)
)";
$pdo->exec($createAmenitiesTable);

// Insert default amenity categories if empty
$stmt = $pdo->query("SELECT COUNT(*) as count FROM amenity_categories");
$result = $stmt->fetch();

if ($result['count'] == 0) {
    $categories = [
        ['name' => 'Wellness', 'description' => 'Rejuvenate your body and soul in our sanctuary of wellbeing.', 'display_order' => 1],
        ['name' => 'Leisure', 'description' => 'Where relaxation meets recreation in breathtaking settings.', 'display_order' => 2],
        ['name' => 'Business & Events', 'description' => 'Exceptional spaces for productive meetings and memorable celebrations.', 'display_order' => 3],
        ['name' => 'Services', 'description' => 'Thoughtful touches that make your stay effortless.', 'display_order' => 4]
    ];
    
    $catStmt = $pdo->prepare("INSERT INTO amenity_categories (name, description, display_order) VALUES (:name, :description, :display_order)");
    foreach ($categories as $cat) {
        $catStmt->execute($cat);
    }
}

// Insert default amenities if empty
$stmt = $pdo->query("SELECT COUNT(*) as count FROM amenities");
$result = $stmt->fetch();

if ($result['count'] == 0) {
    $amenities = [
        ['category_id' => 1, 'name' => 'The Sanctuary Spa', 'slug' => 'spa', 'description' => 'Traditional Kenyan treatments, steam rooms, and relaxation areas', 'long_description' => 'Our award-winning spa offers a journey of sensory renewal. Drawing from traditional Swahili and Maasai wellness practices, each treatment is designed to restore balance and harmony.', 'icon' => 'fa-spa', 'image' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'hours' => 'Daily 9:00 AM - 9:00 PM', 'phone' => 'Extension 7301', 'features' => json_encode(['6 treatment rooms including couples suite', 'Traditional Kenyan massage techniques', 'Organic locally-sourced products', 'Steam room and sauna', 'Relaxation lounge with herbal teas', 'Private outdoor meditation garden']), 'gallery' => json_encode(['https://images.unsplash.com/photo-1544161515-4ab6ce6db874?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'https://images.unsplash.com/photo-1600334129128-685c5582fd35?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'https://images.unsplash.com/photo-1540555700478-4be289fbe518?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80']), 'display_order' => 1],
        ['category_id' => 1, 'name' => 'Fitness Pavilion', 'slug' => 'fitness', 'description' => 'State-of-the-art equipment with personal training available', 'long_description' => 'Our spacious fitness pavilion features the latest equipment from Technogym, offering everything from cardio to strength training.', 'icon' => 'fa-dumbbell', 'image' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'hours' => 'Open 24/7', 'phone' => 'Extension 7302', 'features' => json_encode(['Cardio cinema with personal screens', 'Strength training area', 'Free weights up to 50kg', 'Yoga mats and accessories', 'Personal training available']), 'gallery' => json_encode(['https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'https://images.unsplash.com/photo-1540496905036-5937c10647cc?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80']), 'display_order' => 2],
        ['category_id' => 1, 'name' => 'Finnish Sauna', 'slug' => 'sauna', 'description' => 'Traditional dry sauna with cold plunge pool', 'long_description' => 'Experience the authentic Finnish sauna tradition with cedar-lined sauna and cold plunge pool.', 'icon' => 'fa-hot-tub', 'image' => 'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'hours' => 'Daily 7:00 AM - 10:00 PM', 'phone' => 'Extension 7303', 'features' => json_encode(['Traditional dry sauna (80-100°C)', 'Cold plunge pool', 'Relaxation lounge', 'Herbal tea station']), 'gallery' => json_encode(['https://images.unsplash.com/photo-1584132967334-10e028bd69f7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'https://images.unsplash.com/photo-1545389336-cf0905564355?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80']), 'display_order' => 3],
        ['category_id' => 1, 'name' => 'Yoga Pavilion', 'slug' => 'yoga', 'description' => 'Daily classes overlooking the gardens', 'long_description' => 'Our open-air yoga pavilion overlooks the lush gardens, providing the perfect setting for morning sun salutations.', 'icon' => 'fa-om', 'image' => 'https://images.unsplash.com/photo-1545389336-cf0905564355?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'hours' => 'Classes: 7:30 AM & 5:30 PM', 'phone' => 'Extension 7304', 'features' => json_encode(['Daily group classes', 'Private sessions available', 'All mats and props provided', 'Outdoor deck with garden views']), 'gallery' => json_encode(['https://images.unsplash.com/photo-1545389336-cf0905564355?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'https://images.unsplash.com/photo-1593811167562-9cef47bfc4d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2072&q=80']), 'display_order' => 4],
        ['category_id' => 2, 'name' => 'Infinity Pool', 'slug' => 'pool', 'description' => 'Overlooking Nairobi skyline with poolside service', 'long_description' => 'Perched overlooking Nairobi skyline, our infinity pool offers a breathtaking setting for relaxation.', 'icon' => 'fa-water', 'image' => 'https://images.unsplash.com/photo-1576016801232-0b41b9c7d8b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'hours' => 'Daily 7:00 AM - 9:00 PM', 'phone' => 'Extension 7305', 'features' => json_encode(['Heated infinity edge pool', 'Sun loungers and cabanas', 'Poolside food and beverage service', 'Adult-only hours 4-6 PM']), 'gallery' => json_encode(['https://images.unsplash.com/photo-1576016801232-0b41b9c7d8b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80']), 'display_order' => 1],
        ['category_id' => 2, 'name' => 'Private Beach', 'slug' => 'beach', 'description' => 'Exclusive lakefront access with cabanas', 'long_description' => 'Escape to our private beach, a tranquil oasis away from the city with powdery sand and clear waters.', 'icon' => 'fa-umbrella-beach', 'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=2073&q=80', 'hours' => 'Daily 8:00 AM - 6:00 PM', 'phone' => 'Extension 7306', 'features' => json_encode(['Private cabanas with waiter service', 'Water sports equipment available', 'Beach bar serving cocktails', 'Sunset bonfires on request']), 'gallery' => json_encode(['https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=2073&q=80', 'https://images.unsplash.com/photo-1590523278191-995cbcda646b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80']), 'display_order' => 2],
        ['category_id' => 2, 'name' => 'The Game Room', 'slug' => 'game', 'description' => 'Billiards, table tennis, and classic arcade games', 'long_description' => 'Our game room is the perfect place to unwind and have fun with billiards and table tennis.', 'icon' => 'fa-gamepad', 'image' => 'https://images.unsplash.com/photo-1511512578047-dfb367046420?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80', 'hours' => 'Daily 10:00 AM - 11:00 PM', 'phone' => 'Extension 7307', 'features' => json_encode(['Professional billiards table', 'Table tennis', 'Classic arcade machines', 'Board games collection']), 'gallery' => json_encode(['https://images.unsplash.com/photo-1511512578047-dfb367046420?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80', 'https://images.unsplash.com/photo-1522252234503-e356532cafd5?ixlib=rb-4.0.3&auto=format&fit=crop&w=2025&q=80']), 'display_order' => 3],
        ['category_id' => 2, 'name' => 'The Reading Room', 'slug' => 'library', 'description' => 'Curated collection of African literature and art books', 'long_description' => 'Our curated library offers a peaceful retreat with a focus on African literature and culture.', 'icon' => 'fa-book-open', 'image' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'hours' => 'Daily 8:00 AM - 10:00 PM', 'phone' => 'Extension 7308', 'features' => json_encode(['Curated collection of 2,000+ books', 'Focus on African authors', 'Art and photography volumes', 'Complimentary tea and coffee']), 'gallery' => json_encode(['https://images.unsplash.com/photo-1521587760476-6c12a4b040da?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80']), 'display_order' => 4],
        ['category_id' => 3, 'name' => 'Conference Halls', 'slug' => 'conference', 'description' => 'Multiple venues with capacity up to 200 guests', 'long_description' => 'Our versatile conference halls are equipped with the latest technology for events from board meetings to large conferences.', 'icon' => 'fa-users', 'image' => 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80', 'hours' => 'By arrangement', 'phone' => 'Extension 7309', 'features' => json_encode(['Multiple venues (20-200 capacity)', 'High-speed WiFi', 'Built-in AV equipment', 'Natural light in all rooms']), 'gallery' => json_encode(['https://images.unsplash.com/photo-1517457373958-b7bdd4587205?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80', 'https://images.unsplash.com/photo-1497366754035-f200968a6a72?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80']), 'display_order' => 1],
        ['category_id' => 3, 'name' => 'Business Center', 'slug' => 'business-center', 'description' => 'Private workstations, printing, and high-speed internet', 'long_description' => 'Our fully equipped business center provides a professional environment for getting work done.', 'icon' => 'fa-briefcase', 'image' => 'https://images.unsplash.com/photo-1497366754035-f200968a6a72?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80', 'hours' => 'Open 24/7', 'phone' => 'Extension 7310', 'features' => json_encode(['Private workstations', 'High-speed printing and scanning', 'Conference call facilities', 'Complimentary coffee and tea']), 'gallery' => json_encode(['https://images.unsplash.com/photo-1497366754035-f200968a6a72?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80', 'https://images.unsplash.com/photo-1497215842964-222b430dc094?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80']), 'display_order' => 2],
        ['category_id' => 3, 'name' => 'Banquet Spaces', 'slug' => 'banquet', 'description' => 'Elegant venues for weddings and galas', 'long_description' => 'From intimate gatherings to grand celebrations, our elegant banquet spaces provide the perfect backdrop.', 'icon' => 'fa-glass-cheers', 'image' => 'https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'hours' => 'By arrangement', 'phone' => 'Extension 7311', 'features' => json_encode(['Multiple venues with various capacities', 'Custom catering menus', 'Dedicated event coordinator', 'Built-in sound and lighting']), 'gallery' => json_encode(['https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80']), 'display_order' => 3],
        ['category_id' => 4, 'name' => '24/7 Concierge', 'slug' => 'concierge', 'description' => 'Your wishes, our command, anytime day or night', 'long_description' => 'Our dedicated concierge team is available around the clock to fulfill your requests.', 'icon' => 'fa-concierge-bell', 'image' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'hours' => '24 hours, 7 days a week', 'phone' => 'Extension 0 or 7312', 'features' => json_encode(['Restaurant reservations', 'Excursion and tour bookings', 'Transportation arrangements', 'Special occasion planning']), 'gallery' => json_encode(['https://images.unsplash.com/photo-1578683010236-d716f9a3f461?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'https://images.unsplash.com/photo-1556740738-b6a63e27c4df?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80']), 'display_order' => 1],
        ['category_id' => 4, 'name' => 'Airport Transfers', 'slug' => 'airport', 'description' => 'Luxury vehicles with professional drivers', 'long_description' => 'Begin and end your journey in comfort with our professional airport transfer service.', 'icon' => 'fa-car', 'image' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'hours' => 'Available 24/7 (advance booking required)', 'phone' => 'Extension 7313', 'features' => json_encode(['Luxury sedan and SUV options', 'Professional uniformed drivers', 'Meet and greet service', 'Complimentary bottled water']), 'gallery' => json_encode(['https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'https://images.unsplash.com/photo-1568605117036-5fe8e7fa0ce2?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80']), 'display_order' => 2],
        ['category_id' => 4, 'name' => 'Laundry Service', 'slug' => 'laundry', 'description' => 'Same-day service with eco-friendly products', 'long_description' => 'Our professional laundry and dry cleaning service ensures your clothes receive the same attention to detail.', 'icon' => 'fa-tshirt', 'image' => 'https://images.unsplash.com/photo-1545173168-9f1947eebb7f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80', 'hours' => 'Daily 7:00 AM - 7:00 PM', 'phone' => 'Extension 7314', 'features' => json_encode(['Same-day service (request before 10 AM)', 'Dry cleaning available', 'Pressing service', 'Eco-friendly products']), 'gallery' => json_encode(['https://images.unsplash.com/photo-1545173168-9f1947eebb7f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80', 'https://images.unsplash.com/photo-1582735689369-4fe89db7114c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80']), 'display_order' => 3],
        ['category_id' => 4, 'name' => 'Complimentary WiFi', 'slug' => 'wifi', 'description' => 'High-speed internet throughout the property', 'long_description' => 'High-speed wireless internet is available throughout the property from your room to the pool deck.', 'icon' => 'fa-wifi', 'image' => 'https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'hours' => '24/7', 'phone' => 'Extension 7315 for assistance', 'features' => json_encode(['High-speed fiber connection', 'Coverage throughout property', 'Multiple device connections', 'Secure network']), 'gallery' => json_encode(['https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'https://images.unsplash.com/photo-1573164713988-2485fc5648d2?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80']), 'display_order' => 4]
    ];
    
    $amenityStmt = $pdo->prepare("INSERT INTO amenities (category_id, name, slug, description, long_description, icon, image, hours, phone, features, gallery, display_order) VALUES (:category_id, :name, :slug, :description, :long_description, :icon, :image, :hours, :phone, :features, :gallery, :display_order)");
    foreach ($amenities as $amenity) {
        $amenityStmt->execute($amenity);
    }
}

// Function to get all amenity categories with their amenities
function getAllAmenityCategories($pdo) {
    $stmt = $pdo->query("SELECT * FROM amenity_categories WHERE is_active = 1 ORDER BY display_order ASC");
    $categories = $stmt->fetchAll();
    
    foreach ($categories as &$category) {
        $catStmt = $pdo->prepare("SELECT * FROM amenities WHERE category_id = :category_id AND is_active = 1 ORDER BY display_order ASC");
        $catStmt->execute([':category_id' => $category['id']]);
        $category['amenities'] = $catStmt->fetchAll();
    }
    
    return $categories;
}

// Function to get all amenities
function getAllAmenities($pdo) {
    $stmt = $pdo->query("SELECT a.*, ac.name as category_name FROM amenities a LEFT JOIN amenity_categories ac ON a.category_id = ac.id WHERE a.is_active = 1 ORDER BY ac.display_order ASC, a.display_order ASC");
    return $stmt->fetchAll();
}

// Function to get amenity by slug
function getAmenityBySlug($pdo, $slug) {
    $stmt = $pdo->prepare("SELECT a.*, ac.name as category_name FROM amenities a LEFT JOIN amenity_categories ac ON a.category_id = ac.id WHERE a.slug = :slug AND a.is_active = 1");
    $stmt->execute([':slug' => $slug]);
    return $stmt->fetch();
}

// Function to get all room views
function getAllRoomViews($pdo) {
    $stmt = $pdo->query("SELECT * FROM room_views WHERE is_active = 1 ORDER BY display_order ASC");
    return $stmt->fetchAll();
}

// Function to add a new room view
function addRoomView($pdo, $name, $display_order = 0) {
    $stmt = $pdo->prepare("INSERT INTO room_views (name, display_order) VALUES (:name, :display_order)");
    $stmt->execute([':name' => $name, ':display_order' => $display_order]);
    return $pdo->lastInsertId();
}

// Function to delete a room view
function deleteRoomView($pdo, $id) {
    $stmt = $pdo->prepare("UPDATE room_views SET is_active = 0 WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

// Function to get all bed types
function getAllBedTypes($pdo) {
    $stmt = $pdo->query("SELECT * FROM bed_types WHERE is_active = 1 ORDER BY display_order ASC");
    return $stmt->fetchAll();
}

// Function to add a new bed type
function addBedType($pdo, $name, $display_order = 0) {
    $stmt = $pdo->prepare("INSERT INTO bed_types (name, display_order) VALUES (:name, :display_order)");
    $stmt->execute([':name' => $name, ':display_order' => $display_order]);
    return $pdo->lastInsertId();
}

// Function to delete a bed type
function deleteBedType($pdo, $id) {
    $stmt = $pdo->prepare("UPDATE bed_types SET is_active = 0 WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

// Create gallery_albums table if not exists
$createGalleryAlbumsTable = "CREATE TABLE IF NOT EXISTS gallery_albums (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    slug VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    cover_image VARCHAR(255),
    icon VARCHAR(50),
    photo_count INT DEFAULT 0,
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$pdo->exec($createGalleryAlbumsTable);

// Create gallery_images table if not exists
$createGalleryImagesTable = "CREATE TABLE IF NOT EXISTS gallery_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    album_id INT NOT NULL,
    src VARCHAR(255) NOT NULL,
    caption VARCHAR(255),
    category VARCHAR(50),
    grid_size ENUM('regular', 'wide', 'tall', 'large') DEFAULT 'regular',
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (album_id) REFERENCES gallery_albums(id)
)";

$pdo->exec($createGalleryImagesTable);

// Create gallery_video table if not exists
$createGalleryVideoTable = "CREATE TABLE IF NOT EXISTS gallery_video (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    thumbnail VARCHAR(255),
    video_url VARCHAR(255),
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$pdo->exec($createGalleryVideoTable);

// Insert default gallery data if tables are empty
$stmt = $pdo->query("SELECT COUNT(*) as count FROM gallery_albums");
$result = $stmt->fetch();

if ($result['count'] == 0) {
    // Insert albums
    $albums = [
        ['title' => 'Rooms & Suites', 'slug' => 'rooms', 'description' => 'Experience luxury and comfort in our carefully designed accommodations.', 'cover_image' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'icon' => 'fa-bed', 'photo_count' => 12, 'display_order' => 1],
        ['title' => 'Restaurant', 'slug' => 'restaurant', 'description' => 'Culinary artistry in an elegant setting.', 'cover_image' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'icon' => 'fa-utensils', 'photo_count' => 10, 'display_order' => 2],
        ['title' => 'Amenities', 'slug' => 'amenities', 'description' => 'World-class facilities for your relaxation and enjoyment.', 'cover_image' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'icon' => 'fa-spa', 'photo_count' => 14, 'display_order' => 3],
        ['title' => 'Surroundings', 'slug' => 'surroundings', 'description' => 'The natural beauty that surrounds Aora.', 'cover_image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'icon' => 'fa-mountain', 'photo_count' => 8, 'display_order' => 4]
    ];
    
    $albumStmt = $pdo->prepare("INSERT INTO gallery_albums (title, slug, description, cover_image, icon, photo_count, display_order) VALUES (:title, :slug, :description, :cover_image, :icon, :photo_count, :display_order)");
    foreach ($albums as $album) {
        $albumStmt->execute($album);
    }
    
    // Insert images for each album
    $images = [
        // Rooms album (album_id = 1)
        ['album_id' => 1, 'src' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Deluxe Room with King Bed', 'category' => 'rooms', 'grid_size' => 'regular', 'display_order' => 1],
        ['album_id' => 1, 'src' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Executive Suite Living Area', 'category' => 'rooms', 'grid_size' => 'wide', 'display_order' => 2],
        ['album_id' => 1, 'src' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Presidential Villa Bedroom', 'category' => 'rooms', 'grid_size' => 'tall', 'display_order' => 3],
        ['album_id' => 1, 'src' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80', 'caption' => 'Family Villa Living Room', 'category' => 'rooms', 'grid_size' => 'regular', 'display_order' => 4],
        ['album_id' => 1, 'src' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Garden View Room', 'category' => 'rooms', 'grid_size' => 'regular', 'display_order' => 5],
        ['album_id' => 1, 'src' => 'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Honeymoon Suite', 'category' => 'rooms', 'grid_size' => 'regular', 'display_order' => 6],
        ['album_id' => 1, 'src' => 'https://images.unsplash.com/photo-1522778526097-ce0a22ceb253?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Business Suite', 'category' => 'rooms', 'grid_size' => 'regular', 'display_order' => 7],
        ['album_id' => 1, 'src' => 'https://images.unsplash.com/photo-1536376072261-38c75010e6c9?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80', 'caption' => 'Sky Penthouse', 'category' => 'rooms', 'grid_size' => 'regular', 'display_order' => 8],
        ['album_id' => 1, 'src' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Suite Bathroom', 'category' => 'rooms', 'grid_size' => 'regular', 'display_order' => 9],
        ['album_id' => 1, 'src' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Room Details', 'category' => 'rooms', 'grid_size' => 'regular', 'display_order' => 10],
        ['album_id' => 1, 'src' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Suite View', 'category' => 'rooms', 'grid_size' => 'regular', 'display_order' => 11],
        ['album_id' => 1, 'src' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Villa Terrace', 'category' => 'rooms', 'grid_size' => 'regular', 'display_order' => 12],
        
        // Restaurant album (album_id = 2)
        ['album_id' => 2, 'src' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Main Dining Room', 'category' => 'restaurant', 'grid_size' => 'regular', 'display_order' => 1],
        ['album_id' => 2, 'src' => 'https://images.unsplash.com/photo-1559339352-11d035aa65de?ixlib=rb-4.0.3&auto=format&fit=crop&w=1974&q=80', 'caption' => "Chef's Table", 'category' => 'restaurant', 'grid_size' => 'wide', 'display_order' => 2],
        ['album_id' => 2, 'src' => 'https://images.unsplash.com/photo-1544025162-d76694265947?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80', 'caption' => 'Nyama Choma', 'category' => 'restaurant', 'grid_size' => 'tall', 'display_order' => 3],
        ['album_id' => 2, 'src' => 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Private Dining', 'category' => 'restaurant', 'grid_size' => 'regular', 'display_order' => 4],
        ['album_id' => 2, 'src' => 'https://images.unsplash.com/photo-1633945274405-b6c8069047b0?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Swahili Pilau', 'category' => 'restaurant', 'grid_size' => 'regular', 'display_order' => 5],
        ['album_id' => 2, 'src' => 'https://images.unsplash.com/photo-1559847844-5315695dadae?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Coastal Seafood', 'category' => 'restaurant', 'grid_size' => 'regular', 'display_order' => 6],
        ['album_id' => 2, 'src' => 'https://images.unsplash.com/photo-1580476262798-bddd9f4b7369?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Samaki wa Kupaka', 'category' => 'restaurant', 'grid_size' => 'regular', 'display_order' => 7],
        ['album_id' => 2, 'src' => 'https://images.unsplash.com/photo-1604411245846-3a7035a6b2e5?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Mandazi & Chai', 'category' => 'restaurant', 'grid_size' => 'regular', 'display_order' => 8],
        ['album_id' => 2, 'src' => 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?ixlib=rb-4.0.3&auto=format&fit=crop&w=2127&q=80', 'caption' => 'Tropical Fruits', 'category' => 'restaurant', 'grid_size' => 'regular', 'display_order' => 9],
        ['album_id' => 2, 'src' => 'https://images.unsplash.com/photo-1551632436-cbf8dd35adfa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80', 'caption' => 'Garden Terrace', 'category' => 'restaurant', 'grid_size' => 'regular', 'display_order' => 10],
        
        // Amenities album (album_id = 3)
        ['album_id' => 3, 'src' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Sanctuary Spa', 'category' => 'amenities', 'grid_size' => 'regular', 'display_order' => 1],
        ['album_id' => 3, 'src' => 'https://images.unsplash.com/photo-1576016801232-0b41b9c7d8b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Infinity Pool', 'category' => 'amenities', 'grid_size' => 'wide', 'display_order' => 2],
        ['album_id' => 3, 'src' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Fitness Pavilion', 'category' => 'amenities', 'grid_size' => 'regular', 'display_order' => 3],
        ['album_id' => 3, 'src' => 'https://images.unsplash.com/photo-1545389336-cf0905564355?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Yoga Pavilion', 'category' => 'amenities', 'grid_size' => 'tall', 'display_order' => 4],
        ['album_id' => 3, 'src' => 'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Sauna', 'category' => 'amenities', 'grid_size' => 'regular', 'display_order' => 5],
        ['album_id' => 3, 'src' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=2073&q=80', 'caption' => 'Private Beach', 'category' => 'amenities', 'grid_size' => 'regular', 'display_order' => 6],
        ['album_id' => 3, 'src' => 'https://images.unsplash.com/photo-1511512578047-dfb367046420?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80', 'caption' => 'Game Room', 'category' => 'amenities', 'grid_size' => 'regular', 'display_order' => 7],
        ['album_id' => 3, 'src' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Library', 'category' => 'amenities', 'grid_size' => 'regular', 'display_order' => 8],
        ['album_id' => 3, 'src' => 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80', 'caption' => 'Conference Hall', 'category' => 'amenities', 'grid_size' => 'regular', 'display_order' => 9],
        ['album_id' => 3, 'src' => 'https://images.unsplash.com/photo-1497366754035-f200968a6a72?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80', 'caption' => 'Business Center', 'category' => 'amenities', 'grid_size' => 'regular', 'display_order' => 10],
        ['album_id' => 3, 'src' => 'https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Banquet Space', 'category' => 'amenities', 'grid_size' => 'regular', 'display_order' => 11],
        ['album_id' => 3, 'src' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Concierge', 'category' => 'amenities', 'grid_size' => 'regular', 'display_order' => 12],
        ['album_id' => 3, 'src' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Airport Transfer', 'category' => 'amenities', 'grid_size' => 'regular', 'display_order' => 13],
        ['album_id' => 3, 'src' => 'https://images.unsplash.com/photo-1545173168-9f1947eebb7f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80', 'caption' => 'Laundry Service', 'category' => 'amenities', 'grid_size' => 'regular', 'display_order' => 14],
        
        // Surroundings album (album_id = 4)
        ['album_id' => 4, 'src' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Sunset Over Nairobi', 'category' => 'surroundings', 'grid_size' => 'regular', 'display_order' => 1],
        ['album_id' => 4, 'src' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Kenyan Landscape', 'category' => 'surroundings', 'grid_size' => 'regular', 'display_order' => 2],
        ['album_id' => 4, 'src' => 'https://images.unsplash.com/photo-1523805009345-7448845a9e53?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Local Wildlife', 'category' => 'surroundings', 'grid_size' => 'wide', 'display_order' => 3],
        ['album_id' => 4, 'src' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Ocean Sunset', 'category' => 'surroundings', 'grid_size' => 'regular', 'display_order' => 4],
        ['album_id' => 4, 'src' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80', 'caption' => 'Safari Adventure', 'category' => 'surroundings', 'grid_size' => 'regular', 'display_order' => 5],
        ['album_id' => 4, 'src' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-4.0.3&auto=format&fit=crop&w=2068&q=80', 'caption' => 'Traditional Village', 'category' => 'surroundings', 'grid_size' => 'regular', 'display_order' => 6],
        ['album_id' => 4, 'src' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Forest Trail', 'category' => 'surroundings', 'grid_size' => 'regular', 'display_order' => 7],
        ['album_id' => 4, 'src' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'caption' => 'Mountain View', 'category' => 'surroundings', 'grid_size' => 'regular', 'display_order' => 8]
    ];
    
    $imageStmt = $pdo->prepare("INSERT INTO gallery_images (album_id, src, caption, category, grid_size, display_order) VALUES (:album_id, :src, :caption, :category, :grid_size, :display_order)");
    foreach ($images as $image) {
        $imageStmt->execute($image);
    }
    
    // Insert video
    $videoStmt = $pdo->prepare("INSERT INTO gallery_video (title, description, thumbnail, video_url) VALUES (:title, :description, :thumbnail, :video_url)");
    $videoStmt->execute([
        'title' => 'The Aora Experience',
        'description' => 'Experience the magic of Aora—where luxury meets the wild heart of Kenya.',
        'thumbnail' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1'
    ]);
}

// Function to get all gallery albums
function getAllGalleryAlbums($pdo) {
    $stmt = $pdo->query("SELECT * FROM gallery_albums WHERE is_active = 1 ORDER BY display_order ASC");
    return $stmt->fetchAll();
}

// Function to get gallery album by slug
function getGalleryAlbumBySlug($pdo, $slug) {
    $stmt = $pdo->prepare("SELECT * FROM gallery_albums WHERE slug = :slug AND is_active = 1");
    $stmt->execute([':slug' => $slug]);
    return $stmt->fetch();
}

// Function to get gallery images by album slug
function getGalleryImagesByAlbumSlug($pdo, $slug) {
    $stmt = $pdo->prepare("SELECT gi.* FROM gallery_images gi 
                            INNER JOIN gallery_albums ga ON gi.album_id = ga.id 
                            WHERE ga.slug = :slug AND gi.is_active = 1 
                            ORDER BY gi.display_order ASC");
    $stmt->execute([':slug' => $slug]);
    return $stmt->fetchAll();
}

// Function to get all gallery images
function getAllGalleryImages($pdo) {
    $stmt = $pdo->query("SELECT gi.*, ga.slug as album_slug FROM gallery_images gi 
                            INNER JOIN gallery_albums ga ON gi.album_id = ga.id 
                            WHERE gi.is_active = 1 
                            ORDER BY ga.display_order ASC, gi.display_order ASC");
    return $stmt->fetchAll();
}

// Function to get gallery video
function getGalleryVideo($pdo) {
    $stmt = $pdo->query("SELECT * FROM gallery_video WHERE is_active = 1 LIMIT 1");
    return $stmt->fetch();
}

// Create visual_stories table for index.php Moments Captured section
$createVisualStoriesTable = "CREATE TABLE IF NOT EXISTS visual_stories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    caption VARCHAR(255),
    image VARCHAR(255) NOT NULL,
    grid_span VARCHAR(20) DEFAULT 'regular',
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$pdo->exec($createVisualStoriesTable);

// Insert default visual stories if empty
$stmt = $pdo->query("SELECT COUNT(*) as count FROM visual_stories");
$result = $stmt->fetch();

if ($result['count'] == 0) {
    $visualStories = [
        ['title' => 'Infinity Edge', 'caption' => 'Sunset over the pool', 'image' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'grid_span' => 'large', 'display_order' => 1],
        ['title' => 'Private Shore', 'caption' => '', 'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'grid_span' => 'regular', 'display_order' => 2],
        ['title' => 'Ocean Suite', 'caption' => '', 'image' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2080&q=80', 'grid_span' => 'regular', 'display_order' => 3],
        ['title' => 'The Dining Room', 'caption' => 'Culinary artistry', 'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'grid_span' => 'wide', 'display_order' => 4],
        ['title' => 'The Spa', 'caption' => '', 'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'grid_span' => 'regular', 'display_order' => 5],
        ['title' => 'African Sunset', 'caption' => '', 'image' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'grid_span' => 'regular', 'display_order' => 6]
    ];
    
    $vsStmt = $pdo->prepare("INSERT INTO visual_stories (title, caption, image, grid_span, display_order) VALUES (:title, :caption, :image, :grid_span, :display_order)");
    foreach ($visualStories as $story) {
        $vsStmt->execute($story);
    }
}

// Function to get all visual stories
function getAllVisualStories($pdo) {
    $stmt = $pdo->query("SELECT * FROM visual_stories WHERE is_active = 1 ORDER BY display_order ASC");
    return $stmt->fetchAll();
}

// Create offers table
$createOffersTable = "CREATE TABLE IF NOT EXISTS offers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    slug VARCHAR(50) NOT NULL UNIQUE,
    subtitle VARCHAR(100),
    description TEXT,
    price VARCHAR(50),
    price_label VARCHAR(50),
    icon VARCHAR(50),
    icon_color VARCHAR(50),
    image1 VARCHAR(255),
    image2 VARCHAR(255),
    image3 VARCHAR(255),
    image4 VARCHAR(255),
    image5 VARCHAR(255),
    inclusions JSON,
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$pdo->exec($createOffersTable);

// Insert default offers if empty
$stmt = $pdo->query("SELECT COUNT(*) as count FROM offers");
$result = $stmt->fetch();

if ($result['count'] == 0) {
    $offers = [
        [
            'title' => 'The Honeymoon Escape',
            'slug' => 'honeymoon-escape',
            'subtitle' => 'Celebrate your love',
            'description' => 'Celebrate your love with a romantic 4-day getaway including candlelit dinners, couples spa treatments, and sunset safari.',
            'price' => '85K',
            'price_label' => '/couple',
            'icon' => 'fa-heart',
            'icon_color' => '#d4b48c',
            'image1' => 'https://media-cdn.tripadvisor.com/media/attractions-splice-spp-674x446/17/0a/08/34.jpg',
            'image2' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
            'image3' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
            'image4' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
            'image5' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
            'inclusions' => json_encode(['Private villa with plunge pool', 'Sunset champagne safari', 'Couples massage & rose petal turndown']),
            'display_order' => 1
        ],
        [
            'title' => 'Weekend Wilderness',
            'slug' => 'weekend-wilderness',
            'subtitle' => 'Immerse in nature',
            'description' => 'Immerse yourself in the wild with guided game drives, bush dinners, and stargazing under the African sky.',
            'price' => '65K',
            'price_label' => '/person',
            'icon' => 'fa-tree',
            'icon_color' => '#4a90a0',
            'image1' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
            'image2' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80',
            'image3' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-4.0.3&auto=format&fit=crop&w=2068&q=80',
            'image4' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
            'image5' => 'https://images.unsplash.com/photo-1523805009345-7448845a9e53?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
            'inclusions' => json_encode(['2 nights in luxury tented camp', 'Morning & evening game drives', 'Bush breakfast & Maasai guide']),
            'display_order' => 2
        ],
        [
            'title' => 'Family Safari Adventure',
            'slug' => 'family-safari',
            'subtitle' => 'Create lasting memories',
            'description' => 'Create lasting memories with kid-friendly game drives, cultural visits, and interactive wildlife experiences.',
            'price' => '120K',
            'price_label' => '/family',
            'icon' => 'fa-paw',
            'icon_color' => '#e9b56b',
            'image1' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80',
            'image2' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
            'image3' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-4.0.3&auto=format&fit=crop&w=2068&q=80',
            'image4' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
            'image5' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
            'inclusions' => json_encode(['Family suite & kids activities', 'Junior ranger program', 'Family game drive & picnic']),
            'display_order' => 3
        ]
    ];
    
    $offerStmt = $pdo->prepare("INSERT INTO offers (title, slug, subtitle, description, price, price_label, icon, icon_color, image1, image2, image3, image4, image5, inclusions, display_order) VALUES (:title, :slug, :subtitle, :description, :price, :price_label, :icon, :icon_color, :image1, :image2, :image3, :image4, :image5, :inclusions, :display_order)");
    foreach ($offers as $offer) {
        $offerStmt->execute($offer);
    }
}

// Function to get all offers
function getAllOffers($pdo) {
    $stmt = $pdo->query("SELECT * FROM offers WHERE is_active = 1 ORDER BY display_order ASC");
    return $stmt->fetchAll();
}

// Function to get offer by slug
function getOfferBySlug($pdo, $slug) {
    $stmt = $pdo->prepare("SELECT * FROM offers WHERE slug = :slug AND is_active = 1");
    $stmt->execute([':slug' => $slug]);
    return $stmt->fetch();
}

// ==================== GALLERY MANAGEMENT FUNCTIONS ====================

// Function to get all gallery albums (including inactive)
function getAllGalleryAlbumsAdmin($pdo) {
    $stmt = $pdo->query("SELECT * FROM gallery_albums ORDER BY display_order ASC");
    return $stmt->fetchAll();
}

// Function to add gallery album
function addGalleryAlbum($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO gallery_albums (title, slug, description, cover_image, icon, photo_count, display_order) VALUES (:title, :slug, :description, :cover_image, :icon, :photo_count, :display_order)");
    $stmt->execute([
        ':title' => $data['title'],
        ':slug' => $data['slug'],
        ':description' => $data['description'],
        ':cover_image' => $data['cover_image'],
        ':icon' => $data['icon'],
        ':photo_count' => $data['photo_count'] ?? 0,
        ':display_order' => $data['display_order'] ?? 0
    ]);
    return $pdo->lastInsertId();
}

// Function to update gallery album
function updateGalleryAlbum($pdo, $id, $data) {
    $stmt = $pdo->prepare("UPDATE gallery_albums SET title = :title, slug = :slug, description = :description, cover_image = :cover_image, icon = :icon, photo_count = :photo_count, display_order = :display_order WHERE id = :id");
    $stmt->execute([
        ':id' => $id,
        ':title' => $data['title'],
        ':slug' => $data['slug'],
        ':description' => $data['description'],
        ':cover_image' => $data['cover_image'],
        ':icon' => $data['icon'],
        ':photo_count' => $data['photo_count'] ?? 0,
        ':display_order' => $data['display_order'] ?? 0
    ]);
}

// Function to delete gallery album
function deleteGalleryAlbum($pdo, $id) {
    $stmt = $pdo->prepare("UPDATE gallery_albums SET is_active = 0 WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

// Function to get all gallery images (including inactive)
function getAllGalleryImagesAdmin($pdo) {
    $stmt = $pdo->query("SELECT gi.*, ga.title as album_title, ga.slug as album_slug FROM gallery_images gi INNER JOIN gallery_albums ga ON gi.album_id = ga.id ORDER BY ga.display_order ASC, gi.display_order ASC");
    return $stmt->fetchAll();
}

// Function to add gallery image
function addGalleryImage($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO gallery_images (album_id, src, caption, category, grid_size, display_order) VALUES (:album_id, :src, :caption, :category, :grid_size, :display_order)");
    $stmt->execute([
        ':album_id' => $data['album_id'],
        ':src' => $data['src'],
        ':caption' => $data['caption'],
        ':category' => $data['category'],
        ':grid_size' => $data['grid_size'] ?? 'regular',
        ':display_order' => $data['display_order'] ?? 0
    ]);
    // Update album photo count
    $pdo->exec("UPDATE gallery_albums SET photo_count = photo_count + 1 WHERE id = " . intval($data['album_id']));
    return $pdo->lastInsertId();
}

// Function to update gallery image
function updateGalleryImage($pdo, $id, $data) {
    $stmt = $pdo->prepare("UPDATE gallery_images SET album_id = :album_id, src = :src, caption = :caption, category = :category, grid_size = :grid_size, display_order = :display_order WHERE id = :id");
    $stmt->execute([
        ':id' => $id,
        ':album_id' => $data['album_id'],
        ':src' => $data['src'],
        ':caption' => $data['caption'],
        ':category' => $data['category'],
        ':grid_size' => $data['grid_size'] ?? 'regular',
        ':display_order' => $data['display_order'] ?? 0
    ]);
}

// Function to delete gallery image
function deleteGalleryImage($pdo, $id) {
    // Get album_id before deleting
    $stmt = $pdo->query("SELECT album_id FROM gallery_images WHERE id = " . intval($id));
    $image = $stmt->fetch();
    
    $stmt = $pdo->prepare("UPDATE gallery_images SET is_active = 0 WHERE id = :id");
    $stmt->execute([':id' => $id]);
    
    // Update album photo count
    if ($image) {
        $pdo->exec("UPDATE gallery_albums SET photo_count = GREATEST(photo_count - 1, 0) WHERE id = " . intval($image['album_id']));
    }
}

// Function to get all gallery videos (including inactive)
function getAllGalleryVideosAdmin($pdo) {
    $stmt = $pdo->query("SELECT * FROM gallery_video ORDER BY id ASC");
    return $stmt->fetchAll();
}

// Function to add gallery video
function addGalleryVideo($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO gallery_video (title, description, thumbnail, video_url) VALUES (:title, :description, :thumbnail, :video_url)");
    $stmt->execute([
        ':title' => $data['title'],
        ':description' => $data['description'],
        ':thumbnail' => $data['thumbnail'],
        ':video_url' => $data['video_url']
    ]);
    return $pdo->lastInsertId();
}

// Function to update gallery video
function updateGalleryVideo($pdo, $id, $data) {
    $stmt = $pdo->prepare("UPDATE gallery_video SET title = :title, description = :description, thumbnail = :thumbnail, video_url = :video_url WHERE id = :id");
    $stmt->execute([
        ':id' => $id,
        ':title' => $data['title'],
        ':description' => $data['description'],
        ':thumbnail' => $data['thumbnail'],
        ':video_url' => $data['video_url']
    ]);
}

// Function to delete gallery video
function deleteGalleryVideo($pdo, $id) {
    $stmt = $pdo->prepare("UPDATE gallery_video SET is_active = 0 WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

// ==================== OFFERS MANAGEMENT FUNCTIONS ====================

// Function to get all offers (including inactive)
function getAllOffersAdmin($pdo) {
    $stmt = $pdo->query("SELECT * FROM offers ORDER BY display_order ASC");
    return $stmt->fetchAll();
}

// Function to add offer
function addOffer($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO offers (title, slug, subtitle, description, price, price_label, icon, icon_color, image1, image2, image3, image4, image5, inclusions, display_order) VALUES (:title, :slug, :subtitle, :description, :price, :price_label, :icon, :icon_color, :image1, :image2, :image3, :image4, :image5, :inclusions, :display_order)");
    $stmt->execute([
        ':title' => $data['title'],
        ':slug' => $data['slug'],
        ':subtitle' => $data['subtitle'],
        ':description' => $data['description'],
        ':price' => $data['price'],
        ':price_label' => $data['price_label'],
        ':icon' => $data['icon'],
        ':icon_color' => $data['icon_color'],
        ':image1' => $data['image1'],
        ':image2' => $data['image2'],
        ':image3' => $data['image3'],
        ':image4' => $data['image4'],
        ':image5' => $data['image5'],
        ':inclusions' => $data['inclusions'],
        ':display_order' => $data['display_order'] ?? 0
    ]);
    return $pdo->lastInsertId();
}

// Function to update offer
function updateOffer($pdo, $id, $data) {
    $stmt = $pdo->prepare("UPDATE offers SET title = :title, slug = :slug, subtitle = :subtitle, description = :description, price = :price, price_label = :price_label, icon = :icon, icon_color = :icon_color, image1 = :image1, image2 = :image2, image3 = :image3, image4 = :image4, image5 = :image5, inclusions = :inclusions, display_order = :display_order WHERE id = :id");
    $stmt->execute([
        ':id' => $id,
        ':title' => $data['title'],
        ':slug' => $data['slug'],
        ':subtitle' => $data['subtitle'],
        ':description' => $data['description'],
        ':price' => $data['price'],
        ':price_label' => $data['price_label'],
        ':icon' => $data['icon'],
        ':icon_color' => $data['icon_color'],
        ':image1' => $data['image1'],
        ':image2' => $data['image2'],
        ':image3' => $data['image3'],
        ':image4' => $data['image4'],
        ':image5' => $data['image5'],
        ':inclusions' => $data['inclusions'],
        ':display_order' => $data['display_order'] ?? 0
    ]);
}

// Function to delete offer
function deleteOffer($pdo, $id) {
    $stmt = $pdo->prepare("UPDATE offers SET is_active = 0 WHERE id = :id");
    $stmt->execute([':id' => $id]);
}
