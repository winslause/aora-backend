<?php
// Database Configuration
$db_host = 'localhost';
$db_name = 'aora';
$db_user = 'root';
$db_pass = ''; // Default XAMPP MySQL password is empty

try {
    // Create PDO connection with performance optimizations
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false, // Use native prepared statements
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
    ];
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass, $options);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if setup has been run, if not run it
$stmt = $pdo->query("SHOW TABLES LIKE 'site_config'");
if ($stmt->rowCount() == 0) {
    // First time loading - run setup
    include 'database_setup.php';
}

// ==================== ROOM FUNCTIONS ====================

// Function to get all room types
function getAllRoomTypes($pdo) {
    $stmt = $pdo->query("SELECT * FROM room_types WHERE is_active = 1 ORDER BY display_order ASC");
    return $stmt->fetchAll();
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

// ==================== RESTAURANT FUNCTIONS ====================

// Function to get all sample menus with items - Optimized with JOIN
function getAllSampleMenus($pdo) {
    $menus = $pdo->query("SELECT * FROM sample_menus WHERE is_active = 1 ORDER BY display_order ASC")->fetchAll();
    
    if (empty($menus)) {
        return $menus;
    }
    
    // Get all items for all menus in a single query
    $menuIds = array_column($menus, 'id');
    $placeholders = implode(',', array_fill(0, count($menuIds), '?'));
    
    $itemsStmt = $pdo->prepare("SELECT * FROM sample_menu_items WHERE menu_id IN ($placeholders) ORDER BY menu_id, display_order ASC");
    $itemsStmt->execute($menuIds);
    $allItems = $itemsStmt->fetchAll();
    
    // Group items by menu_id
    $itemsByMenu = [];
    foreach ($allItems as $item) {
        $itemsByMenu[$item['menu_id']][] = $item;
    }
    
    // Attach items to menus
    foreach ($menus as &$menu) {
        $menu['items'] = $itemsByMenu[$menu['id']] ?? [];
    }
    
    return $menus;
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

// ==================== EVENT FUNCTIONS ====================

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
    $stmt = $pdo->prepare("INSERT INTO event_inquiries 
                           (venue_id, event_type, guest_name, guest_email, guest_phone, event_date, guest_count, message, status) 
                           VALUES (:venue_id, :event_type, :guest_name, :guest_email, :guest_phone, :event_date, :guest_count, :message, 'pending')");
    
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
        'inquiry_id' => $pdo->lastInsertId()
    ];
}

// ==================== AMENITY FUNCTIONS ====================

// Function to get all amenity categories with their amenities
function getAllAmenityCategories($pdo) {
    $categories = $pdo->query("SELECT * FROM amenity_categories WHERE is_active = 1 ORDER BY display_order ASC")->fetchAll();
    
    if (empty($categories)) {
        return $categories;
    }
    
    // Get all amenities for all categories in a single query
    $categoryIds = array_column($categories, 'id');
    
    // Check if there are any category IDs
    if (empty($categoryIds)) {
        // Return categories with empty amenities arrays
        foreach ($categories as &$category) {
            $category['amenities'] = [];
        }
        return $categories;
    }
    
    $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));
    
    $amenitiesStmt = $pdo->prepare("SELECT * FROM amenities WHERE category_id IN ($placeholders) AND is_active = 1 ORDER BY category_id, display_order ASC");
    $amenitiesStmt->execute($categoryIds);
    $allAmenities = $amenitiesStmt->fetchAll();
    
    // Group amenities by category_id
    $amenitiesByCategory = [];
    foreach ($allAmenities as $amenity) {
        $amenitiesByCategory[$amenity['category_id']][] = $amenity;
    }
    
    // Attach amenities to categories
    foreach ($categories as &$category) {
        $category['amenities'] = $amenitiesByCategory[$category['id']] ?? [];
    }
    
    return $categories;
}

// Function to get amenities by category
function getAmenitiesByCategory($pdo, $categoryId) {
    $stmt = $pdo->prepare("SELECT * FROM amenities WHERE category_id = :category_id AND is_active = 1 ORDER BY display_order ASC");
    $stmt->execute([':category_id' => $categoryId]);
    return $stmt->fetchAll();
}

// Function to get all amenities
function getAllAmenities($pdo) {
    $stmt = $pdo->query("SELECT a.*, ac.name as category_name FROM amenities a 
                           LEFT JOIN amenity_categories ac ON a.category_id = ac.id 
                           WHERE a.is_active = 1 
                           ORDER BY ac.display_order ASC, a.display_order ASC");
    return $stmt->fetchAll();
}

// Function to get amenity by slug
function getAmenityBySlug($pdo, $slug) {
    $stmt = $pdo->prepare("SELECT a.*, ac.name as category_name FROM amenities a 
                           LEFT JOIN amenity_categories ac ON a.category_id = ac.id 
                           WHERE a.slug = :slug AND a.is_active = 1");
    $stmt->execute([':slug' => $slug]);
    return $stmt->fetch();
}

// ==================== GALLERY FUNCTIONS ====================

// Function to get all gallery albums
function getAllGalleryAlbums($pdo) {
    $stmt = $pdo->query("SELECT * FROM gallery_albums WHERE is_active = 1 ORDER BY display_order ASC");
    return $stmt->fetchAll();
}

// Function to get gallery images by album
function getGalleryImagesByAlbum($pdo, $albumId) {
    $stmt = $pdo->prepare("SELECT * FROM gallery_images WHERE album_id = :album_id AND is_active = 1 ORDER BY display_order ASC");
    $stmt->execute([':album_id' => $albumId]);
    return $stmt->fetchAll();
}

// Function to get all gallery images
function getAllGalleryImages($pdo) {
    $stmt = $pdo->query("SELECT gi.*, ga.title as album_title FROM gallery_images gi 
                           LEFT JOIN gallery_albums ga ON gi.album_id = ga.id 
                           WHERE gi.is_active = 1 
                           ORDER BY ga.display_order ASC, gi.display_order ASC");
    return $stmt->fetchAll();
}

// Function to get all gallery videos
function getAllGalleryVideos($pdo) {
    $stmt = $pdo->query("SELECT * FROM gallery_video WHERE is_active = 1 ORDER BY id ASC");
    return $stmt->fetchAll();
}

// Function to get all visual stories
function getAllVisualStories($pdo) {
    $stmt = $pdo->query("SELECT * FROM visual_stories WHERE is_active = 1 ORDER BY display_order ASC");
    return $stmt->fetchAll();
}

// ==================== OFFERS FUNCTIONS ====================

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

// Function to get all inclusions
function getAllInclusions($pdo) {
    $stmt = $pdo->query("SELECT * FROM offer_inclusions WHERE is_active = 1 ORDER BY display_order ASC");
    return $stmt->fetchAll();
}

// ==================== CONTACT FUNCTIONS ====================

// Function to create contact message
function createContactMessage($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, phone, subject, message) 
                           VALUES (:name, :email, :phone, :subject, :message)");
    
    $stmt->execute([
        ':name' => $data['name'],
        ':email' => $data['email'],
        ':phone' => $data['phone'],
        ':subject' => $data['subject'],
        ':message' => $data['message']
    ]);
    
    return [
        'message_id' => $pdo->lastInsertId()
    ];
}

// Function to get all contact messages (for admin)
function getAllContactMessages($pdo) {
    $stmt = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
    return $stmt->fetchAll();
}

// ==================== ADMIN FUNCTIONS ====================

// Function to get all bookings (for admin)
function getAllBookings($pdo, $status = null) {
    if ($status) {
        $stmt = $pdo->prepare("SELECT b.*, r.name as room_name FROM bookings b 
                               LEFT JOIN rooms r ON b.room_id = r.id 
                               WHERE b.status = :status 
                               ORDER BY b.created_at DESC");
        $stmt->execute([':status' => $status]);
    } else {
        $stmt = $pdo->query("SELECT b.*, r.name as room_name FROM bookings b 
                               LEFT JOIN rooms r ON b.room_id = r.id 
                               ORDER BY b.created_at DESC");
    }
    return $stmt->fetchAll();
}

// Function to update booking status
function updateBookingStatus($pdo, $bookingId, $status) {
    $stmt = $pdo->prepare("UPDATE bookings SET status = :status WHERE id = :id");
    $stmt->execute([':status' => $status, ':id' => $bookingId]);
    return $stmt->rowCount();
}

// Function to delete a booking
function deleteBooking($pdo, $bookingId) {
    $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = :id");
    $stmt->execute([':id' => $bookingId]);
    return $stmt->rowCount();
}

// Function to get all restaurant reservations (for admin)
function getAllRestaurantReservations($pdo, $status = null) {
    if ($status) {
        $stmt = $pdo->prepare("SELECT rr.*, tt.name as table_type_name FROM restaurant_reservations rr 
                               LEFT JOIN table_types tt ON rr.table_type_id = tt.id 
                               WHERE rr.status = :status 
                               ORDER BY rr.reservation_date DESC, rr.reservation_time DESC");
        $stmt->execute([':status' => $status]);
    } else {
        $stmt = $pdo->query("SELECT rr.*, tt.name as table_type_name FROM restaurant_reservations rr 
                               LEFT JOIN table_types tt ON rr.table_type_id = tt.id 
                               ORDER BY rr.reservation_date DESC, rr.reservation_time DESC");
    }
    return $stmt->fetchAll();
}

// Function to update restaurant reservation status
function updateRestaurantReservationStatus($pdo, $reservationId, $status) {
    $stmt = $pdo->prepare("UPDATE restaurant_reservations SET status = :status WHERE id = :id");
    $stmt->execute([':status' => $status, ':id' => $reservationId]);
    return $stmt->rowCount();
}

// Function to delete a restaurant reservation
function deleteRestaurantReservation($pdo, $reservationId) {
    $stmt = $pdo->prepare("DELETE FROM restaurant_reservations WHERE id = :id");
    $stmt->execute([':id' => $reservationId]);
    return $stmt->rowCount();
}

// Function to get all event inquiries (for admin)
function getAllEventInquiries($pdo, $status = null) {
    if ($status) {
        $stmt = $pdo->prepare("SELECT ei.*, ev.name as venue_name FROM event_inquiries ei 
                               LEFT JOIN event_venues ev ON ei.venue_id = ev.id 
                               WHERE ei.status = :status 
                               ORDER BY ei.created_at DESC");
        $stmt->execute([':status' => $status]);
    } else {
        $stmt = $pdo->query("SELECT ei.*, ev.name as venue_name FROM event_inquiries ei 
                               LEFT JOIN event_venues ev ON ei.venue_id = ev.id 
                               ORDER BY ei.created_at DESC");
    }
    return $stmt->fetchAll();
}

// Function to update event inquiry status
function updateEventInquiryStatus($pdo, $inquiryId, $status) {
    $stmt = $pdo->prepare("UPDATE event_inquiries SET status = :status WHERE id = :id");
    $stmt->execute([':status' => $status, ':id' => $inquiryId]);
    return $stmt->rowCount();
}

// Function to delete an event inquiry
function deleteEventInquiry($pdo, $inquiryId) {
    $stmt = $pdo->prepare("DELETE FROM event_inquiries WHERE id = :id");
    $stmt->execute([':id' => $inquiryId]);
    return $stmt->rowCount();
}

// Function to get all room views
function getAllRoomViews($pdo) {
    $stmt = $pdo->query("SELECT * FROM room_views WHERE is_active = 1 ORDER BY display_order ASC");
    return $stmt->fetchAll();
}

// Function to get all bed types
function getAllBedTypes($pdo) {
    $stmt = $pdo->query("SELECT * FROM bed_types WHERE is_active = 1 ORDER BY display_order ASC");
    return $stmt->fetchAll();
}

// Function to add a room view
function addRoomView($pdo, $name) {
    // Get the next display order automatically
    $stmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 as next_order FROM room_views");
    $result = $stmt->fetch();
    $next_order = $result['next_order'];
    
    $stmt = $pdo->prepare("INSERT INTO room_views (name, display_order, is_active) VALUES (:name, :display_order, 1)");
    $stmt->execute(['name' => $name, 'display_order' => $next_order]);
    return $pdo->lastInsertId();
}

// Function to delete a room view
function deleteRoomView($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM room_views WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

// Function to add a bed type
function addBedType($pdo, $name) {
    // Get the next display order automatically
    $stmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 as next_order FROM bed_types");
    $result = $stmt->fetch();
    $next_order = $result['next_order'];
    
    $stmt = $pdo->prepare("INSERT INTO bed_types (name, display_order, is_active) VALUES (:name, :display_order, 1)");
    $stmt->execute(['name' => $name, 'display_order' => $next_order]);
    return $pdo->lastInsertId();
}

// Function to delete a bed type
function deleteBedType($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM bed_types WHERE id = :id");
    $stmt->execute(['id' => $id]);
}
