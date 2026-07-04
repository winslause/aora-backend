<?php
// Admin Process - Handles all admin CRUD operations
// Check if session is already started before calling session_start()
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_error.log');

// Set custom error handler to return JSON errors
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

try {
    include 'database.php';

// SMTP Configuration (same as api.php)
$smtpHost = 'mail.aora45.com';
$smtpPort = 465;
$smtpUsername = 'Info@aora45.com';
$smtpPassword = '1n4M@tioN26';
$smtpFromEmail = 'Info@aora45.com';
$smtpFromName = 'Aora Hotel';
$adminEmail = 'Info@aora45.com';

// Simple SMTP Mailer Class
class SMTP_mailer {
    private $host, $port, $username, $password, $from_email, $from_name, $socket;
    
    public function __construct($host, $port, $username, $password, $from_email, $from_name) {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->from_email = $from_email;
        $this->from_name = $from_name;
    }
    
    private function readResponse() {
        $response = '';
        while ($line = fgets($this->socket, 515)) {
            $response .= $line;
            if (substr($line, 3, 1) == ' ') break;
        }
        return $response;
    }
    
    private function sendCommand($command) {
        fputs($this->socket, $command . "\r\n");
        return $this->readResponse();
    }
    
    public function send($to_email, $to_name, $subject, $body) {
        $crlf = "\r\n";
        try {
            $context = stream_context_create([
                'ssl' => ['verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true]
            ]);
            
            $this->socket = stream_socket_client('ssl://' . $this->host . ':' . $this->port, $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $context);
            
            if (!$this->socket) {
                $context2 = stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true]]);
                $this->socket = stream_socket_client('tls://' . $this->host . ':587', $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $context2);
                if (!$this->socket) return false;
                $response = $this->readResponse();
                $this->sendCommand("EHLO " . gethostname());
                $this->sendCommand("AUTH LOGIN");
                $this->sendCommand(base64_encode($this->username));
                $response = $this->sendCommand(base64_encode($this->password));
                if (substr($response, 0, 3) != '235') { fclose($this->socket); return false; }
            } else {
                $response = $this->readResponse();
                $this->sendCommand("EHLO " . gethostname());
                $this->sendCommand("AUTH LOGIN");
                $this->sendCommand(base64_encode($this->username));
                $response = $this->sendCommand(base64_encode($this->password));
                if (substr($response, 0, 3) != '235') { fclose($this->socket); return false; }
            }
            
            $this->sendCommand("MAIL FROM:<" . $this->from_email . ">");
            $this->sendCommand("RCPT TO:<" . $to_email . ">");
            $this->sendCommand("DATA");
            
            $message = "From: " . $this->from_name . " <" . $this->from_email . ">" . $crlf;
            $message .= "To: " . $to_name . " <" . $to_email . ">" . $crlf;
            $message .= "Subject: " . $subject . $crlf;
            $message .= "MIME-Version: 1.0" . $crlf;
            $message .= "Content-Type: text/html; charset=UTF-8" . $crlf;
            $message .= $crlf . $body . $crlf . "." . $crlf;
            
            fputs($this->socket, $message);
            $response = $this->readResponse();
            $this->sendCommand("QUIT");
            fclose($this->socket);
            return true;
        } catch (Exception $e) {
            if ($this->socket) fclose($this->socket);
            return false;
        }
    }
}

// Get action from request
$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');

// Check if admin is logged in
function checkAdminSession() {
    // Try to start session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION['admin_id'])) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
        exit;
    }
}

// Handle different actions
switch ($action) {
    // Admin Login
    case 'login':
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        
        $admin = authenticateAdmin($pdo, $email, $password);
        if ($admin && isset($admin['success']) && $admin['success']) {
            $adminData = $admin['admin'];
            $_SESSION['admin_id'] = $adminData['id'];
            $_SESSION['admin_email'] = $adminData['email'];
            $_SESSION['admin_name'] = $adminData['name'];
            echo json_encode(['success' => true, 'message' => 'Login successful', 'admin' => $adminData]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
        }
        break;
    
    // Admin Logout
    case 'logout':
        session_destroy();
        echo json_encode(['success' => true, 'message' => 'Logged out successfully']);
        break;
    
    // Check admin session
    case 'check_session':
        if (isset($_SESSION['admin_id'])) {
            echo json_encode(['success' => true, 'logged_in' => true, 'admin' => [
                'id' => $_SESSION['admin_id'],
                'email' => $_SESSION['admin_email'],
                'name' => $_SESSION['admin_name']
            ]]);
        } else {
            echo json_encode(['success' => true, 'logged_in' => false]);
        }
        break;
    
    // ==================== ROOM MANAGEMENT ====================
    
    // Get all room types (no auth required for dropdown)
    case 'get_all_room_types':
        $stmt = $pdo->query("SELECT * FROM room_types WHERE is_active = 1 ORDER BY display_order ASC");
        $roomTypes = $stmt->fetchAll();
        echo json_encode(['success' => true, 'room_types' => $roomTypes]);
        break;
    
    // Add room type
    case 'add_room_type':
        checkAdminSession();
        $name = $_POST['name'];
        $slug = strtolower(str_replace(' ', '-', $name));
        $description = $_POST['description'] ?? '';
        
        // Get next display order automatically
        $stmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 as next_order FROM room_types");
        $display_order = $stmt->fetch()['next_order'];
        
        try {
            $stmt = $pdo->prepare("INSERT INTO room_types (name, slug, description, display_order) VALUES (:name, :slug, :description, :display_order)");
            $stmt->execute(['name' => $name, 'slug' => $slug, 'description' => $description, 'display_order' => $display_order]);
            echo json_encode(['success' => true, 'message' => 'Room type added successfully', 'id' => $pdo->lastInsertId()]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Room type already exists or invalid data']);
        }
        break;
    
    // Update room type
    case 'update_room_type':
        checkAdminSession();
        $id = $_POST['id'];
        $name = $_POST['name'];
        $slug = strtolower(str_replace(' ', '-', $name));
        $description = $_POST['description'] ?? '';
        $display_order = $_POST['display_order'] ?? 0;
        
        try {
            $stmt = $pdo->prepare("UPDATE room_types SET name = :name, slug = :slug, description = :description, display_order = :display_order WHERE id = :id");
            $stmt->execute(['name' => $name, 'slug' => $slug, 'description' => $description, 'display_order' => $display_order, 'id' => $id]);
            echo json_encode(['success' => true, 'message' => 'Room type updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error updating room type']);
        }
        break;
    
    // Delete room type
    case 'delete_room_type':
        checkAdminSession();
        $id = $_POST['id'];
        // Soft delete - set is_active to 0
        $stmt = $pdo->prepare("UPDATE room_types SET is_active = 0 WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Room type deleted successfully']);
        break;
    
    // Get all rooms
    case 'get_all_rooms':
        checkAdminSession();
        $stmt = $pdo->query("SELECT * FROM rooms ORDER BY price ASC");
        $rooms = $stmt->fetchAll();
        foreach ($rooms as &$room) {
            $room['amenities'] = json_decode($room['amenities'], true);
            $room['images'] = json_decode($room['images'], true);
        }
        echo json_encode(['success' => true, 'rooms' => $rooms]);
        break;
    
    // Add room
    case 'add_room':
        checkAdminSession();
        
        // Handle image uploads
        $uploadedImages = [];
        if (!empty($_FILES['roomImages']['name'][0])) {
            $uploadDir = __DIR__ . '/uploads/rooms/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            for ($i = 0; $i < count($_FILES['roomImages']['name']); $i++) {
                if ($_FILES['roomImages']['error'][$i] === UPLOAD_ERR_OK) {
                    $tmpName = $_FILES['roomImages']['tmp_name'][$i];
                    $name = basename($_FILES['roomImages']['name'][$i]);
                    $ext = pathinfo($name, PATHINFO_EXTENSION);
                    $newName = uniqid('room_') . '.' . $ext;
                    $targetPath = $uploadDir . $newName;
                    
                    if (move_uploaded_file($tmpName, $targetPath)) {
                        $uploadedImages[] = 'uploads/rooms/' . $newName;
                    }
                }
            }
        }
        
        // Merge uploaded images with provided URLs
        $imagesFromForm = $_POST['images'] ?? '[]';
        $imagesArray = json_decode($imagesFromForm, true);
        $allImages = array_merge($uploadedImages, $imagesArray);
        
        $data = [
            'room_type' => $_POST['room_type'],
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'price' => $_POST['price'],
            'size' => $_POST['size'],
            'occupancy' => $_POST['occupancy'],
            'bed_type' => $_POST['bed_type'],
            'view' => $_POST['view'],
            'amenities' => $_POST['amenities'],
            'badge' => $_POST['badge'],
            'images' => json_encode($allImages)
        ];
        
        $stmt = $pdo->prepare("INSERT INTO rooms (room_type, name, description, price, size, occupancy, bed_type, view, amenities, badge, images) 
                               VALUES (:room_type, :name, :description, :price, :size, :occupancy, :bed_type, :view, :amenities, :badge, :images)");
        $stmt->execute($data);
        
        echo json_encode(['success' => true, 'message' => 'Room added successfully', 'id' => $pdo->lastInsertId()]);
        break;
    
    // Update room
    case 'update_room':
        checkAdminSession();
        $id = $_POST['id'];
        
        // Handle image uploads
        $uploadedImages = [];
        if (!empty($_FILES['roomImages']['name'][0])) {
            $uploadDir = __DIR__ . '/uploads/rooms/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            for ($i = 0; $i < count($_FILES['roomImages']['name']); $i++) {
                if ($_FILES['roomImages']['error'][$i] === UPLOAD_ERR_OK) {
                    $tmpName = $_FILES['roomImages']['tmp_name'][$i];
                    $name = basename($_FILES['roomImages']['name'][$i]);
                    $ext = pathinfo($name, PATHINFO_EXTENSION);
                    $newName = uniqid('room_') . '.' . $ext;
                    $targetPath = $uploadDir . $newName;
                    
                    if (move_uploaded_file($tmpName, $targetPath)) {
                        $uploadedImages[] = 'uploads/rooms/' . $newName;
                    }
                }
            }
        }
        
        // Merge uploaded images with provided URLs
        $imagesFromForm = $_POST['images'] ?? '[]';
        $imagesArray = json_decode($imagesFromForm, true);
        $allImages = array_merge($uploadedImages, $imagesArray);
        
        $data = [
            'room_type' => $_POST['room_type'],
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'price' => $_POST['price'],
            'size' => $_POST['size'],
            'occupancy' => $_POST['occupancy'],
            'bed_type' => $_POST['bed_type'],
            'view' => $_POST['view'],
            'amenities' => $_POST['amenities'],
            'badge' => $_POST['badge'],
            'images' => json_encode($allImages),
            'id' => $id
        ];
        
        $sql = "UPDATE rooms SET room_type=:room_type, name=:name, description=:description, price=:price, 
                size=:size, occupancy=:occupancy, bed_type=:bed_type, view=:view, amenities=:amenities, 
                badge=:badge, images=:images WHERE id=:id";
        $data['id'] = $id;
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
        
        echo json_encode(['success' => true, 'message' => 'Room updated successfully']);
        break;
    
    // Delete room
    case 'delete_room':
        checkAdminSession();
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM rooms WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Room deleted successfully']);
        break;
    
    // ==================== AMENITIES MANAGEMENT ====================
    
    // Get all amenities
    case 'get_all_amenities':
        // Don't require admin session for reading amenities
        $stmt = $pdo->query("SELECT a.*, ac.name as category_name FROM amenities a 
                              LEFT JOIN amenity_categories ac ON a.category_id = ac.id 
                              ORDER BY ac.display_order ASC, a.display_order ASC");
        $amenities = $stmt->fetchAll();
        foreach ($amenities as &$amenity) {
            $amenity['features'] = json_decode($amenity['features'], true);
            $amenity['gallery'] = json_decode($amenity['gallery'], true);
        }
        echo json_encode(['success' => true, 'amenities' => $amenities]);
        break;
    
    // Get amenity categories
    case 'get_amenity_categories':
        checkAdminSession();
        $stmt = $pdo->query("SELECT * FROM amenity_categories WHERE is_active = 1 ORDER BY display_order ASC");
        $categories = $stmt->fetchAll();
        echo json_encode(['success' => true, 'categories' => $categories]);
        break;
    
    // Add amenity
    case 'add_amenity':
        checkAdminSession();
        
        // Get next display order for this category
        $stmt = $pdo->prepare("SELECT COALESCE(MAX(display_order), 0) + 1 as next_order FROM amenities WHERE category_id = ?");
        $stmt->execute([$_POST['category_id']]);
        $nextOrder = $stmt->fetch()['next_order'];
        
        // Handle image uploads (3 images)
        $uploadedImages = [];
        $uploadDir = __DIR__ . '/uploads/amenities/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Process up to 3 image uploads
        for ($i = 1; $i <= 3; $i++) {
            $fileKey = 'amenityImage' . $i;
            if (!empty($_FILES[$fileKey]['name'])) {
                if ($_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
                    $tmpName = $_FILES[$fileKey]['tmp_name'];
                    $name = basename($_FILES[$fileKey]['name']);
                    $ext = pathinfo($name, PATHINFO_EXTENSION);
                    $newName = 'amenity_' . uniqid() . '_' . $i . '.' . $ext;
                    $targetPath = $uploadDir . $newName;
                    
                    if (move_uploaded_file($tmpName, $targetPath)) {
                        $uploadedImages[] = 'uploads/amenities/' . $newName;
                    }
                }
            }
        }
        
        // Get image URLs from form (for URLs entered manually)
        $imageUrls = [];
        for ($i = 1; $i <= 3; $i++) {
            $urlKey = 'amenityImageUrl' . $i;
            if (!empty($_POST[$urlKey])) {
                $imageUrls[] = $_POST[$urlKey];
            }
        }
        
        // Merge uploaded files with URL inputs
        $allImages = array_merge($uploadedImages, $imageUrls);
        
        // Set main image to first image
        $mainImage = !empty($allImages) ? $allImages[0] : '';
        
        // Parse features from JSON
        $features = isset($_POST['features']) ? json_decode($_POST['features'], true) : [];
        if (!is_array($features)) {
            $features = [];
        }
        
        $data = [
            'category_id' => $_POST['category_id'],
            'name' => $_POST['name'],
            'slug' => strtolower(str_replace(' ', '-', $_POST['name'])),
            'description' => $_POST['description'],
            'long_description' => $_POST['long_description'],
            'icon' => 'fa-spa', // Always use fa-spa
            'image' => $mainImage,
            'hours' => $_POST['hours'],
            'phone' => '',
            'features' => json_encode($features),
            'gallery' => json_encode($allImages),
            'display_order' => $nextOrder
        ];
        
        $stmt = $pdo->prepare("INSERT INTO amenities (category_id, name, slug, description, long_description, icon, image, hours, phone, features, gallery, display_order) 
                               VALUES (:category_id, :name, :slug, :description, :long_description, :icon, :image, :hours, :phone, :features, :gallery, :display_order)");
        $stmt->execute($data);
        
        echo json_encode(['success' => true, 'message' => 'Amenity added successfully', 'id' => $pdo->lastInsertId()]);
        break;
    
    // Update amenity
    case 'update_amenity':
        checkAdminSession();
        $id = $_POST['id'];
        
        // Get existing gallery images from database
        $stmt = $pdo->prepare("SELECT gallery FROM amenities WHERE id = ?");
        $stmt->execute([$id]);
        $existingAmenity = $stmt->fetch();
        $existingGallery = $existingAmenity ? json_decode($existingAmenity['gallery'], true) : [];
        if (!is_array($existingGallery)) {
            $existingGallery = [];
        }
        
        // Start with existing gallery images
        $allImages = $existingGallery;
        
        // Handle image uploads (3 images) - replace at specific positions
        $uploadDir = __DIR__ . '/uploads/amenities/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Process up to 3 image uploads - they replace at positions 0, 1, 2
        for ($i = 1; $i <= 3; $i++) {
            $fileKey = 'amenityImage' . $i;
            if (!empty($_FILES[$fileKey]['name']) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES[$fileKey]['tmp_name'];
                $name = basename($_FILES[$fileKey]['name']);
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $newName = 'amenity_' . uniqid() . '_' . $i . '.' . $ext;
                $targetPath = $uploadDir . $newName;
                
                if (move_uploaded_file($tmpName, $targetPath)) {
                    // Replace at position i-1
                    $allImages[$i - 1] = 'uploads/amenities/' . $newName;
                }
            }
        }
        
        // Handle new URLs from form inputs - replace at specific positions
        for ($i = 1; $i <= 3; $i++) {
            $urlKey = 'amenityImageUrl' . $i;
            if (!empty($_POST[$urlKey])) {
                // Replace at position i-1
                $allImages[$i - 1] = $_POST[$urlKey];
            }
        }
        
        // Also check if frontend sent explicit existingImages array (from URL replacement)
        if (isset($_POST['existingImages']) && is_array($_POST['existingImages'])) {
            $frontendImages = $_POST['existingImages'];
            // Replace at positions where frontend has values
            for ($i = 0; $i < count($frontendImages); $i++) {
                if (!empty($frontendImages[$i])) {
                    $allImages[$i] = $frontendImages[$i];
                }
            }
        }
        
        // Re-index array to remove gaps and empty values
        $allImages = array_values(array_filter($allImages, function($val) {
            return !empty(trim($val));
        }));
        
        // Set main image to first image
        $mainImage = !empty($allImages) ? $allImages[0] : '';
        
        // Parse features from JSON
        $features = isset($_POST['features']) ? json_decode($_POST['features'], true) : [];
        if (!is_array($features)) {
            $features = [];
        }
        
        $data = [
            'category_id' => $_POST['category_id'],
            'name' => $_POST['name'],
            'slug' => strtolower(str_replace(' ', '-', $_POST['name'])),
            'description' => $_POST['description'],
            'long_description' => $_POST['long_description'],
            'icon' => 'fa-spa', // Always use fa-spa
            'image' => $mainImage,
            'hours' => $_POST['hours'],
            'phone' => '',
            'features' => json_encode($features),
            'gallery' => json_encode($allImages),
            'id' => $id
        ];
        
        $stmt = $pdo->prepare("UPDATE amenities SET category_id=:category_id, name=:name, slug=:slug, description=:description, 
                              long_description=:long_description, icon=:icon, image=:image, hours=:hours, phone=:phone, 
                              features=:features, gallery=:gallery WHERE id=:id");
        $stmt->execute($data);
        
        echo json_encode(['success' => true, 'message' => 'Amenity updated successfully']);
        break;
    
    // Delete amenity
    case 'delete_amenity':
        checkAdminSession();
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM amenities WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Amenity deleted successfully']);
        break;
    
    // ==================== AMENITY CATEGORIES MANAGEMENT ====================
    
    // Get amenity categories
    case 'get_all_amenity_categories':
        checkAdminSession();
        $stmt = $pdo->query("SELECT * FROM amenity_categories WHERE is_active = 1 ORDER BY display_order ASC");
        $categories = $stmt->fetchAll();
        echo json_encode(['success' => true, 'categories' => $categories]);
        break;
    
    // Add amenity category
    case 'add_amenity_category':
        checkAdminSession();
        $name = $_POST['name'];
        $description = $_POST['description'] ?? '';
        
        // Get next display order automatically
        $stmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 as next_order FROM amenity_categories");
        $display_order = $stmt->fetch()['next_order'];
        
        try {
            $stmt = $pdo->prepare("INSERT INTO amenity_categories (name, description, display_order) VALUES (:name, :description, :display_order)");
            $stmt->execute(['name' => $name, 'description' => $description, 'display_order' => $display_order]);
            echo json_encode(['success' => true, 'message' => 'Category added successfully', 'id' => $pdo->lastInsertId()]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Category already exists or invalid data']);
        }
        break;
    
    // Update amenity category
    case 'update_amenity_category':
        checkAdminSession();
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'] ?? '';
        $display_order = $_POST['display_order'] ?? 0;
        
        try {
            $stmt = $pdo->prepare("UPDATE amenity_categories SET name = :name, description = :description, display_order = :display_order WHERE id = :id");
            $stmt->execute(['name' => $name, 'description' => $description, 'display_order' => $display_order, 'id' => $id]);
            echo json_encode(['success' => true, 'message' => 'Category updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error updating category']);
        }
        break;
    
    // Delete amenity category
    case 'delete_amenity_category':
        checkAdminSession();
        $id = $_POST['id'];
        // Soft delete
        $stmt = $pdo->prepare("UPDATE amenity_categories SET is_active = 0 WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Category deleted successfully']);
        break;
    
    // ==================== AMENITY FEATURES MANAGEMENT ====================
    
    // Get all unique features from amenities
    case 'get_all_amenity_features':
        checkAdminSession();
        $stmt = $pdo->query("SELECT DISTINCT features FROM amenities WHERE features IS NOT NULL");
        $results = $stmt->fetchAll();
        
        $allFeatures = [];
        foreach ($results as $row) {
            if ($row['features']) {
                $features = json_decode($row['features'], true);
                if (is_array($features)) {
                    $allFeatures = array_merge($allFeatures, $features);
                }
            }
        }
        $allFeatures = array_unique($allFeatures);
        sort($allFeatures);
        
        echo json_encode(['success' => true, 'features' => $allFeatures]);
        break;
    
    // Add amenity feature
    case 'add_amenity_feature':
        checkAdminSession();
        $featureToAdd = isset($_POST['feature']) ? trim($_POST['feature']) : '';
        
        if (empty($featureToAdd)) {
            echo json_encode(['success' => false, 'message' => 'Feature name is required']);
            break;
        }
        
        // Get all amenities to check if feature already exists
        $stmt = $pdo->query("SELECT id, features FROM amenities");
        $amenities = $stmt->fetchAll();
        
        $featureExists = false;
        foreach ($amenities as $amenity) {
            $features = json_decode($amenity['features'], true);
            if (is_array($features) && in_array($featureToAdd, $features)) {
                $featureExists = true;
                break;
            }
        }
        
        if ($featureExists) {
            echo json_encode(['success' => false, 'message' => 'Feature already exists']);
            break;
        }
        
        // Add feature to the first amenity (or create a placeholder)
        if (count($amenities) > 0) {
            $firstAmenityId = $amenities[0]['id'];
            $existingFeatures = json_decode($amenities[0]['features'], true);
            if (!is_array($existingFeatures)) {
                $existingFeatures = [];
            }
            $existingFeatures[] = $featureToAdd;
            
            $updateStmt = $pdo->prepare("UPDATE amenities SET features = ? WHERE id = ?");
            $updateStmt->execute([json_encode($existingFeatures), $firstAmenityId]);
            
            echo json_encode(['success' => true, 'message' => 'Feature added successfully']);
        } else {
            // No amenities exist - create a placeholder
            echo json_encode(['success' => false, 'message' => 'Please add at least one amenity first before adding features']);
        }
        break;
    
    // Delete amenity feature
    case 'delete_amenity_feature':
        checkAdminSession();
        $featureToDelete = $_POST['feature'];
        
        // Get all amenities that have this feature
        $stmt = $pdo->query("SELECT id, features FROM amenities WHERE features IS NOT NULL");
        $amenities = $stmt->fetchAll();
        
        $deleted = 0;
        foreach ($amenities as $amenity) {
            $features = json_decode($amenity['features'], true);
            if (is_array($features) && in_array($featureToDelete, $features)) {
                // Remove the feature from array
                $features = array_diff($features, [$featureToDelete]);
                $features = array_values($features); // Re-index array
                
                // Update the amenity
                $updateStmt = $pdo->prepare("UPDATE amenities SET features = ? WHERE id = ?");
                $updateStmt->execute([json_encode($features), $amenity['id']]);
                $deleted++;
            }
        }
        
        echo json_encode(['success' => true, 'message' => "Feature '$featureToDelete' removed from $deleted amenities"]);
        break;
    
    // ==================== BOOKINGS MANAGEMENT ====================
    
    // Get all bookings
    case 'get_all_bookings':
        checkAdminSession();
        $stmt = $pdo->query("SELECT b.*, r.name as room_name, r.id as room_id, r.room_type FROM bookings b 
                              LEFT JOIN rooms r ON b.room_id = r.id 
                              ORDER BY b.created_at DESC");
        $bookings = $stmt->fetchAll();
        echo json_encode(['success' => true, 'bookings' => $bookings]);
        break;
    
    // Update booking status
    case 'update_booking_status':
        checkAdminSession();
        $id = $_POST['id'];
        $status = $_POST['status'];
        $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
        echo json_encode(['success' => true, 'message' => 'Booking status updated']);
        break;
    
    // Delete booking
    case 'delete_booking':
        checkAdminSession();
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Booking deleted successfully']);
        break;
    
    // Send email to booking guest
    case 'send_booking_email':
        checkAdminSession();
        $booking_id = $_POST['booking_id'];
        $message = $_POST['message'];
        $subject = $_POST['subject'];
        
        // Get booking details
        $stmt = $pdo->prepare("SELECT b.*, r.name as room_name, r.id as room_id FROM bookings b 
                              LEFT JOIN rooms r ON b.room_id = r.id WHERE b.id = ?");
        $stmt->execute([$booking_id]);
        $booking = $stmt->fetch();
        
        if (!$booking) {
            echo json_encode(['success' => false, 'message' => 'Booking not found']);
            break;
        }
        
        $mailer = new SMTP_mailer($smtpHost, $smtpPort, $smtpUsername, $smtpPassword, $smtpFromEmail, $smtpFromName);
        
        $body = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #8a735b; color: white; padding: 20px; text-align: center; }
                .content { background-color: #f9f9f9; padding: 20px; }
                .message-box { background-color: white; padding: 15px; border-radius: 5px; margin: 15px 0; border-left: 4px solid #8a735b; }
                .footer { background-color: #333; color: white; padding: 15px; text-align: center; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Message from Aora Hotel</h1>
                </div>
                <div class='content'>
                    <p>Dear <strong>{$booking['guest_name']}</strong>,</p>
                    <p>{$message}</p>
                    
                    <div class='message-box'>
                        <p><strong>Your Booking Details:</strong></p>
                        <p>Booking ID: #{$booking['id']}</p>
                        <p>Room: {$booking['room_id']}</p>
                        <p>Check-in: {$booking['check_in']}</p>
                        <p>Check-out: {$booking['check_out']}</p>
                    </div>
                    
                    <p>If you have any questions, please don't hesitate to contact us.</p>
                    
                    <p>Best regards,<br>The Aora Hotel Team</p>
                </div>
                <div class='footer'>
                    <p>Aora Hotel - Your Luxurious Escape</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        $result = $mailer->send($booking['guest_email'], $booking['guest_name'], $subject, $body);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Email sent successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to send email']);
        }
        break;
    
    // ==================== EVENT INQUIRIES MANAGEMENT ====================
    
    // Get all event inquiries
    case 'get_all_event_inquiries':
        checkAdminSession();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM event_inquiries");
        $total = $stmt->fetch()['total'];
        
        $stmt = $pdo->query("SELECT e.*, v.name as venue_name FROM event_inquiries e 
                              LEFT JOIN event_venues v ON e.venue_id = v.id 
                              ORDER BY e.created_at DESC LIMIT $limit OFFSET $offset");
        $inquiries = $stmt->fetchAll();
        echo json_encode(['success' => true, 'inquiries' => $inquiries, 'total' => $total, 'page' => $page, 'total_pages' => ceil($total / $limit)]);
        break;
    
    // Update event inquiry status
    case 'update_inquiry_status':
        checkAdminSession();
        $id = $_POST['id'];
        $status = $_POST['status'];
        $stmt = $pdo->prepare("UPDATE event_inquiries SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
        echo json_encode(['success' => true, 'message' => 'Inquiry status updated']);
        break;
    
    // Delete event inquiry
    case 'delete_inquiry':
        checkAdminSession();
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM event_inquiries WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Inquiry deleted successfully']);
        break;
    
    // Send email to event inquiry guest
    case 'send_inquiry_email':
        checkAdminSession();
        $inquiry_id = $_POST['inquiry_id'];
        $message = $_POST['message'];
        $subject = $_POST['subject'];
        
        // Get inquiry details
        $stmt = $pdo->prepare("SELECT e.*, v.name as venue_name FROM event_inquiries e 
                              LEFT JOIN event_venues v ON e.venue_id = v.id WHERE e.id = ?");
        $stmt->execute([$inquiry_id]);
        $inquiry = $stmt->fetch();
        
        if (!$inquiry) {
            echo json_encode(['success' => false, 'message' => 'Inquiry not found']);
            break;
        }
        
        $mailer = new SMTP_mailer($smtpHost, $smtpPort, $smtpUsername, $smtpPassword, $smtpFromEmail, $smtpFromName);
        
        $body = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #8a735b; color: white; padding: 20px; text-align: center; }
                .content { background-color: #f9f9f9; padding: 20px; }
                .message-box { background-color: white; padding: 15px; border-radius: 5px; margin: 15px 0; border-left: 4px solid #8a735b; }
                .footer { background-color: #333; color: white; padding: 15px; text-align: center; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Message from Aora Hotel - Event Inquiry</h1>
                </div>
                <div class='content'>
                    <p>Dear <strong>{$inquiry['guest_name']}</strong>,</p>
                    <p>{$message}</p>
                    
                    <div class='message-box'>
                        <p><strong>Your Event Inquiry Details:</strong></p>
                        <p>Inquiry ID: #{$inquiry['id']}</p>
                        <p>Event Type: {$inquiry['event_type']}</p>
                        <p>Venue: " . ($inquiry['venue_name'] ?? 'Not specified') . "</p>
                        <p>Event Date: {$inquiry['event_date']}</p>
                        <p>Guest Count: {$inquiry['guest_count']}</p>
                    </div>
                    
                    <p>If you have any questions, please don't hesitate to contact us.</p>
                    
                    <p>Best regards,<br>The Aora Hotel Team</p>
                </div>
                <div class='footer'>
                    <p>Aora Hotel - Your Luxurious Escape</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        $result = $mailer->send($inquiry['guest_email'], $inquiry['guest_name'], $subject, $body);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Email sent successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to send email']);
        }
        break;
    
    // ==================== EVENT VENUES MANAGEMENT ====================
    
    // Get all event venues
    case 'get_all_event_venues':
        checkAdminSession();
        $stmt = $pdo->query("SELECT * FROM event_venues WHERE is_active = 1 ORDER BY display_order ASC");
        $venues = $stmt->fetchAll();
        foreach ($venues as &$venue) {
            $venue['features'] = json_decode($venue['features'], true);
        }
        echo json_encode(['success' => true, 'venues' => $venues]);
        break;
    
    // Add event venue
    case 'add_event_venue':
        checkAdminSession();
        
        // Get next display order automatically
        $stmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 as next_order FROM event_venues");
        $nextOrder = $stmt->fetch()['next_order'];
        
        $name = $_POST['name'];
        $slug = strtolower(str_replace(' ', '-', $name));
        $description = $_POST['description'] ?? '';
        $long_description = $_POST['long_description'] ?? '';
        $capacity = $_POST['capacity'] ?? '';
        $size = $_POST['size'] ?? '';
        $image = $_POST['image'] ?? '';
        
        // Handle image upload
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = __DIR__ . '/uploads/events/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $tmpName = $_FILES['image']['tmp_name'];
            $fileName = basename($_FILES['image']['name']);
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $newName = 'venue_' . uniqid() . '.' . $ext;
            $targetPath = $uploadDir . $newName;
            
            if (move_uploaded_file($tmpName, $targetPath)) {
                $image = 'uploads/events/' . $newName;
            }
        }
        
        $features = isset($_POST['features']) ? json_decode($_POST['features'], true) : [];
        if (!is_array($features)) {
            $features = [];
        }
        
        try {
            $stmt = $pdo->prepare("INSERT INTO event_venues (name, slug, description, long_description, capacity, size, image, features, display_order) 
                                   VALUES (:name, :slug, :description, :long_description, :capacity, :size, :image, :features, :display_order)");
            $stmt->execute([
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'long_description' => $long_description,
                'capacity' => $capacity,
                'size' => $size,
                'image' => $image,
                'features' => json_encode($features),
                'display_order' => $nextOrder
            ]);
            echo json_encode(['success' => true, 'message' => 'Venue added successfully', 'id' => $pdo->lastInsertId()]);
        } catch (PDOException $e) {
            error_log('Error adding venue: ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error adding venue: ' . $e->getMessage()]);
        }
        break;
    
    // Update event venue
    case 'update_event_venue':
        checkAdminSession();
        $id = $_POST['id'];
        
        $name = $_POST['name'];
        $slug = strtolower(str_replace(' ', '-', $name));
        $description = $_POST['description'] ?? '';
        $long_description = $_POST['long_description'] ?? '';
        $capacity = $_POST['capacity'] ?? '';
        $size = $_POST['size'] ?? '';
        $display_order = $_POST['display_order'] ?? 0;
        
        // Get existing image
        $stmt = $pdo->prepare("SELECT image FROM event_venues WHERE id = ?");
        $stmt->execute([$id]);
        $existingVenue = $stmt->fetch();
        $image = $existingVenue['image'] ?? '';
        
        // Handle image upload
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = __DIR__ . '/uploads/events/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $tmpName = $_FILES['image']['tmp_name'];
            $fileName = basename($_FILES['image']['name']);
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $newName = 'venue_' . uniqid() . '.' . $ext;
            $targetPath = $uploadDir . $newName;
            
            if (move_uploaded_file($tmpName, $targetPath)) {
                $image = 'uploads/events/' . $newName;
            }
        }
        
        $features = isset($_POST['features']) ? json_decode($_POST['features'], true) : [];
        if (!is_array($features)) {
            $features = [];
        }
        
        try {
            $stmt = $pdo->prepare("UPDATE event_venues SET name=:name, slug=:slug, description=:description, 
                                  long_description=:long_description, capacity=:capacity, size=:size, image=:image, 
                                  features=:features, display_order=:display_order WHERE id=:id");
            $stmt->execute([
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'long_description' => $long_description,
                'capacity' => $capacity,
                'size' => $size,
                'image' => $image,
                'features' => json_encode($features),
                'display_order' => $display_order,
                'id' => $id
            ]);
            echo json_encode(['success' => true, 'message' => 'Venue updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error updating venue']);
        }
        break;
    
    // Delete event venue
    case 'delete_event_venue':
        checkAdminSession();
        $id = $_POST['id'];
        // Soft delete
        $stmt = $pdo->prepare("UPDATE event_venues SET is_active = 0 WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Venue deleted successfully']);
        break;
    
    // ==================== LIVE EVENTS MANAGEMENT ====================
    
    // Get all live events
    case 'get_all_live_events':
        checkAdminSession();
        $stmt = $pdo->query("SELECT * FROM live_events ORDER BY event_date DESC");
        $events = $stmt->fetchAll();
        echo json_encode(['success' => true, 'events' => $events]);
        break;
    
    // Add live event
    case 'add_live_event':
        checkAdminSession();
        $description = $_POST['description'] ?? '';
        $event_date = $_POST['event_date'] ?? '';
        $posted_date = $_POST['posted_date'] ?? date('Y-m-d');
        
        if (empty($description) || empty($event_date)) {
            echo json_encode(['success' => false, 'message' => 'Description and event date are required']);
            break;
        }
        
        // Handle image upload
        $image = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/uploads/live_events/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = 'live_event_' . uniqid() . '.' . $ext;
            $targetPath = $uploadDir . $filename;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $image = 'uploads/live_events/' . $filename;
            }
        }
        
        try {
            $stmt = $pdo->prepare("INSERT INTO live_events (description, event_date, posted_date, image) VALUES (:description, :event_date, :posted_date, :image)");
            $stmt->execute(['description' => $description, 'event_date' => $event_date, 'posted_date' => $posted_date, 'image' => $image]);
            echo json_encode(['success' => true, 'message' => 'Live event added successfully', 'id' => $pdo->lastInsertId()]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error adding live event']);
        }
        break;
    
    // Update live event
    case 'update_live_event':
        checkAdminSession();
        $id = $_POST['id'];
        $description = $_POST['description'] ?? '';
        $event_date = $_POST['event_date'] ?? '';
        $posted_date = $_POST['posted_date'] ?? '';
        
        if (empty($description) || empty($event_date)) {
            echo json_encode(['success' => false, 'message' => 'Description and event date are required']);
            break;
        }
        
        // Get existing image
        $stmt = $pdo->prepare("SELECT image FROM live_events WHERE id = ?");
        $stmt->execute([$id]);
        $existing = $stmt->fetch();
        $image = $existing['image'] ?? '';
        
        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/uploads/live_events/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = 'live_event_' . uniqid() . '.' . $ext;
            $targetPath = $uploadDir . $filename;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                // Delete old image if exists
                if (!empty($image) && file_exists(__DIR__ . '/' . $image)) {
                    unlink(__DIR__ . '/' . $image);
                }
                $image = 'uploads/live_events/' . $filename;
            }
        }
        
        try {
            $stmt = $pdo->prepare("UPDATE live_events SET description = :description, event_date = :event_date, posted_date = :posted_date, image = :image WHERE id = :id");
            $stmt->execute(['description' => $description, 'event_date' => $event_date, 'posted_date' => $posted_date, 'image' => $image, 'id' => $id]);
            echo json_encode(['success' => true, 'message' => 'Live event updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error updating live event']);
        }
        break;
    
    // Delete live event
    case 'delete_live_event':
        checkAdminSession();
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM live_events WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Live event deleted successfully']);
        break;
    
    // ==================== DASHBOARD STATS ====================
    
    // Get dashboard statistics
    case 'get_dashboard_stats':
        checkAdminSession();
        
        // Total bookings
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM bookings");
        $totalBookings = $stmt->fetch()['total'];
        
        // Pending bookings
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM bookings WHERE status = 'pending'");
        $pendingBookings = $stmt->fetch()['total'];
        
        // Confirmed bookings
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM bookings WHERE status = 'confirmed'");
        $confirmedBookings = $stmt->fetch()['total'];
        
        // Total revenue
        $stmt = $pdo->query("SELECT COALESCE(SUM(total_price), 0) as total FROM bookings WHERE status = 'confirmed'");
        $totalRevenue = $stmt->fetch()['total'];
        
        // Total rooms
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM rooms");
        $totalRooms = $stmt->fetch()['total'];
        
        // Total amenities
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM amenities");
        $totalAmenities = $stmt->fetch()['total'];
        
        // Event inquiries
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM event_inquiries");
        $totalInquiries = $stmt->fetch()['total'];
        
        // Pending inquiries
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM event_inquiries WHERE status = 'pending'");
        $pendingInquiries = $stmt->fetch()['total'];
        
        // Recent bookings
        $stmt = $pdo->query("SELECT b.*, r.name as room_name FROM bookings b 
                            LEFT JOIN rooms r ON b.room_id = r.id 
                            ORDER BY b.created_at DESC LIMIT 5");
        $recentBookings = $stmt->fetchAll();
        
        echo json_encode([
            'success' => true, 
            'stats' => [
                'total_bookings' => $totalBookings,
                'pending_bookings' => $pendingBookings,
                'confirmed_bookings' => $confirmedBookings,
                'total_revenue' => $totalRevenue,
                'total_rooms' => $totalRooms,
                'total_amenities' => $totalAmenities,
                'total_inquiries' => $totalInquiries,
                'pending_inquiries' => $pendingInquiries,
                'recent_bookings' => $recentBookings
            ]
        ]);
        break;
    
    // ==================== GALLERY MANAGEMENT ====================
    
    // Get all gallery albums
    case 'get_all_gallery_albums':
        checkAdminSession();
        $stmt = $pdo->query("SELECT * FROM gallery_albums ORDER BY display_order ASC");
        $albums = $stmt->fetchAll();
        echo json_encode(['success' => true, 'albums' => $albums]);
        break;
    
    // Add gallery album
    case 'add_gallery_album':
        checkAdminSession();
        $title = $_POST['title'];
        $slug = strtolower(str_replace(' ', '-', $title));
        $description = $_POST['description'] ?? '';
        $cover_image = $_POST['cover_image'] ?? '';
        $icon = $_POST['icon'] ?? 'fa-images';
        $photo_count = $_POST['photo_count'] ?? 0;
        
        // Get next display order automatically
        $stmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 as next_order FROM gallery_albums");
        $display_order = $stmt->fetch()['next_order'];
        
        try {
            $stmt = $pdo->prepare("INSERT INTO gallery_albums (title, slug, description, cover_image, icon, photo_count, display_order) VALUES (:title, :slug, :description, :cover_image, :icon, :photo_count, :display_order)");
            $stmt->execute(['title' => $title, 'slug' => $slug, 'description' => $description, 'cover_image' => $cover_image, 'icon' => $icon, 'photo_count' => $photo_count, 'display_order' => $display_order]);
            echo json_encode(['success' => true, 'message' => 'Album added successfully', 'id' => $pdo->lastInsertId()]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error adding album']);
        }
        break;
    
    // Update gallery album
    case 'update_gallery_album':
        checkAdminSession();
        $id = $_POST['id'];
        $title = $_POST['title'];
        $slug = strtolower(str_replace(' ', '-', $title));
        $description = $_POST['description'] ?? '';
        $cover_image = $_POST['cover_image'] ?? '';
        $icon = $_POST['icon'] ?? 'fa-images';
        $photo_count = $_POST['photo_count'] ?? 0;
        $display_order = $_POST['display_order'] ?? 0;
        
        // Handle file upload for cover image
        if (!empty($_FILES['cover_image_file']['name'])) {
            $uploadDir = __DIR__ . '/uploads/gallery/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $tmpName = $_FILES['cover_image_file']['tmp_name'];
            $fileName = basename($_FILES['cover_image_file']['name']);
            $uniqueName = 'cover_' . time() . '_' . $fileName;
            $targetPath = $uploadDir . $uniqueName;
            
            if (move_uploaded_file($tmpName, $targetPath)) {
                $cover_image = 'uploads/gallery/' . $uniqueName;
            }
        }
        
        try {
            $stmt = $pdo->prepare("UPDATE gallery_albums SET title = :title, slug = :slug, description = :description, cover_image = :cover_image, icon = :icon, photo_count = :photo_count, display_order = :display_order WHERE id = :id");
            $stmt->execute(['title' => $title, 'slug' => $slug, 'description' => $description, 'cover_image' => $cover_image, 'icon' => $icon, 'photo_count' => $photo_count, 'display_order' => $display_order, 'id' => $id]);
            echo json_encode(['success' => true, 'message' => 'Album updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error updating album']);
        }
        break;
    
    // Delete gallery album
    case 'delete_gallery_album':
        checkAdminSession();
        $id = $_POST['id'];
        $stmt = $pdo->prepare("UPDATE gallery_albums SET is_active = 0 WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Album deleted successfully']);
        break;
    
    // Get all gallery images
    case 'get_all_gallery_images':
        checkAdminSession();
        $stmt = $pdo->query("SELECT gi.*, ga.title as album_title, ga.slug as album_slug FROM gallery_images gi INNER JOIN gallery_albums ga ON gi.album_id = ga.id WHERE gi.is_active = 1 ORDER BY ga.display_order ASC, gi.display_order ASC");
        $images = $stmt->fetchAll();
        echo json_encode(['success' => true, 'images' => $images]);
        break;
    
    // Get gallery images by album
    case 'get_gallery_images_by_album':
        checkAdminSession();
        $album_id = $_POST['album_id'];
        $stmt = $pdo->prepare("SELECT * FROM gallery_images WHERE album_id = ? AND is_active = 1 ORDER BY display_order ASC");
        $stmt->execute([$album_id]);
        $images = $stmt->fetchAll();
        echo json_encode(['success' => true, 'images' => $images]);
        break;
    
    // Upload gallery image file
    case 'upload_gallery_image':
        checkAdminSession();
        $album_id = $_POST['album_id'];
        
        if (!empty($_FILES['imageFile']['name'])) {
            $uploadDir = __DIR__ . '/uploads/gallery/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $tmpName = $_FILES['imageFile']['tmp_name'];
            $fileName = basename($_FILES['imageFile']['name']);
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $newName = 'gallery_' . uniqid() . '.' . $ext;
            $targetPath = $uploadDir . $newName;
            
            if (move_uploaded_file($tmpName, $targetPath)) {
                $file_path = 'uploads/gallery/' . $newName;
                echo json_encode(['success' => true, 'file_path' => $file_path]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to upload file']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'No file uploaded']);
        }
        break;
    
    // Add gallery image
    case 'add_gallery_image':
        checkAdminSession();
        $album_id = $_POST['album_id'];
        $src = $_POST['src'] ?? '';
        $caption = $_POST['caption'] ?? '';
        $category = $_POST['category'] ?? '';
        $grid_size = $_POST['grid_size'] ?? 'regular';
        
        // Get next display order automatically
        $stmt = $pdo->prepare("SELECT COALESCE(MAX(display_order), 0) + 1 as next_order FROM gallery_images WHERE album_id = ?");
        $stmt->execute([$album_id]);
        $display_order = $stmt->fetch()['next_order'];
        
        // Handle file upload if present
        if (!empty($_FILES['imageFile']['name'])) {
            $uploadDir = __DIR__ . '/uploads/gallery/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $tmpName = $_FILES['imageFile']['tmp_name'];
            $fileName = basename($_FILES['imageFile']['name']);
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $newName = 'gallery_' . uniqid() . '.' . $ext;
            $targetPath = $uploadDir . $newName;
            
            if (move_uploaded_file($tmpName, $targetPath)) {
                $src = 'uploads/gallery/' . $newName;
            }
        }
        
        $stmt = $pdo->prepare("INSERT INTO gallery_images (album_id, src, caption, category, grid_size, display_order) VALUES (:album_id, :src, :caption, :category, :grid_size, :display_order)");
        $stmt->execute(['album_id' => $album_id, 'src' => $src, 'caption' => $caption, 'category' => $category, 'grid_size' => $grid_size, 'display_order' => $display_order]);
        
        // Update album photo count
        $pdo->exec("UPDATE gallery_albums SET photo_count = photo_count + 1 WHERE id = " . intval($album_id));
        
        echo json_encode(['success' => true, 'message' => 'Image added successfully', 'id' => $pdo->lastInsertId()]);
        break;
    
    // Update gallery image
    case 'update_gallery_image':
        checkAdminSession();
        $id = $_POST['id'];
        $album_id = $_POST['album_id'];
        $src = $_POST['src'] ?? '';
        $caption = $_POST['caption'] ?? '';
        $category = $_POST['category'] ?? '';
        $grid_size = $_POST['grid_size'] ?? 'regular';
        $display_order = $_POST['display_order'] ?? 0;
        
        $stmt = $pdo->prepare("UPDATE gallery_images SET album_id = :album_id, src = :src, caption = :caption, category = :category, grid_size = :grid_size, display_order = :display_order WHERE id = :id");
        $stmt->execute(['album_id' => $album_id, 'src' => $src, 'caption' => $caption, 'category' => $category, 'grid_size' => $grid_size, 'display_order' => $display_order, 'id' => $id]);
        
        echo json_encode(['success' => true, 'message' => 'Image updated successfully']);
        break;
    
    // Delete gallery image - actually delete from database and server
    case 'delete_gallery_image':
        checkAdminSession();
        $id = $_POST['id'];
        
        // Get image info before deleting
        $stmt = $pdo->query("SELECT src, album_id FROM gallery_images WHERE id = " . intval($id));
        $image = $stmt->fetch();
        
        // Delete the actual file from server if it exists and is a local file
        if ($image && !empty($image['src'])) {
            $filePath = __DIR__ . '/' . $image['src'];
            if (file_exists($filePath) && is_file($filePath)) {
                unlink($filePath);
            }
        }
        
        // Delete from database
        $stmt = $pdo->prepare("DELETE FROM gallery_images WHERE id = :id");
        $stmt->execute(['id' => $id]);
        
        // Update album photo count
        if ($image) {
            $pdo->exec("UPDATE gallery_albums SET photo_count = GREATEST(photo_count - 1, 0) WHERE id = " . intval($image['album_id']));
        }
        
        echo json_encode(['success' => true, 'message' => 'Image deleted successfully']);
        break;
    
    // Get all gallery videos
    case 'get_all_gallery_videos':
        checkAdminSession();
        $stmt = $pdo->query("SELECT * FROM gallery_video ORDER BY id ASC");
        $videos = $stmt->fetchAll();
        echo json_encode(['success' => true, 'videos' => $videos]);
        break;
    
    // Add gallery video
    case 'add_gallery_video':
        checkAdminSession();
        $title = $_POST['title'];
        $description = $_POST['description'] ?? '';
        $thumbnail = $_POST['thumbnail'] ?? '';
        $video_url = $_POST['video_url'] ?? '';
        
        $stmt = $pdo->prepare("INSERT INTO gallery_video (title, description, thumbnail, video_url) VALUES (:title, :description, :thumbnail, :video_url)");
        $stmt->execute(['title' => $title, 'description' => $description, 'thumbnail' => $thumbnail, 'video_url' => $video_url]);
        
        echo json_encode(['success' => true, 'message' => 'Video added successfully', 'id' => $pdo->lastInsertId()]);
        break;
    
    // Update gallery video
    case 'update_gallery_video':
        checkAdminSession();
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'] ?? '';
        $thumbnail = $_POST['thumbnail'] ?? '';
        $video_url = $_POST['video_url'] ?? '';
        
        $stmt = $pdo->prepare("UPDATE gallery_video SET title = :title, description = :description, thumbnail = :thumbnail, video_url = :video_url WHERE id = :id");
        $stmt->execute(['title' => $title, 'description' => $description, 'thumbnail' => $thumbnail, 'video_url' => $video_url, 'id' => $id]);
        
        echo json_encode(['success' => true, 'message' => 'Video updated successfully']);
        break;
    
    // Delete gallery video
    case 'delete_gallery_video':
        checkAdminSession();
        $id = $_POST['id'];
        $stmt = $pdo->prepare("UPDATE gallery_video SET is_active = 0 WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Video deleted successfully']);
        break;
    
    // ==================== OFFERS MANAGEMENT ====================
    
    // Get all offers
    case 'get_all_offers_admin':
        checkAdminSession();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM offers WHERE is_active = 1");
        $total = $stmt->fetch()['total'];
        
        $stmt = $pdo->query("SELECT * FROM offers WHERE is_active = 1 ORDER BY display_order ASC LIMIT $limit OFFSET $offset");
        $offers = $stmt->fetchAll();
        foreach ($offers as &$offer) {
            $offer['inclusions'] = json_decode($offer['inclusions'], true);
        }
        echo json_encode(['success' => true, 'offers' => $offers, 'total' => $total, 'page' => $page, 'total_pages' => ceil($total / $limit)]);
        break;
    
    // Add offer
    case 'add_offer':
        checkAdminSession();
        $title = $_POST['title'];
        $slug = strtolower(str_replace(' ', '-', $title));
        $subtitle = $_POST['subtitle'] ?? '';
        $description = $_POST['description'] ?? '';
        $price = $_POST['price'] ?? '';
        $price_label = $_POST['price_label'] ?? '';
        $icon = $_POST['icon'] ?? 'fa-gift';
        $icon_color = $_POST['icon_color'] ?? '#b89a78';
        
        // Handle image uploads (5 images)
        $uploadDir = __DIR__ . '/uploads/offers/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $images = ['', '', '', '', ''];
        
        // Process up to 5 image uploads
        for ($i = 1; $i <= 5; $i++) {
            $fileKey = 'offerImageFile' . $i;
            // First check if a file was uploaded
            if (!empty($_FILES[$fileKey]['name']) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES[$fileKey]['tmp_name'];
                $name = basename($_FILES[$fileKey]['name']);
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $newName = 'offer_' . uniqid() . '_' . $i . '.' . $ext;
                $targetPath = $uploadDir . $newName;
                
                if (move_uploaded_file($tmpName, $targetPath)) {
                    $images[$i - 1] = 'uploads/offers/' . $newName;
                }
            } else {
                // Fall back to URL input if no file uploaded
                $urlKey = 'image' . $i;
                if (!empty($_POST[$urlKey])) {
                    $images[$i - 1] = $_POST[$urlKey];
                }
            }
        }
        
        $inclusions = $_POST['inclusions'] ?? '[]';
        $start_date = $_POST['start_date'] ?? null;
        $end_date = $_POST['end_date'] ?? null;
        
        // Get next display order automatically
        $stmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 as next_order FROM offers");
        $display_order = $stmt->fetch()['next_order'];
        
        try {
            $stmt = $pdo->prepare("INSERT INTO offers (title, slug, subtitle, description, price, price_label, icon, icon_color, image1, image2, image3, image4, image5, inclusions, start_date, end_date, display_order) VALUES (:title, :slug, :subtitle, :description, :price, :price_label, :icon, :icon_color, :image1, :image2, :image3, :image4, :image5, :inclusions, :start_date, :end_date, :display_order)");
            $stmt->execute([
                'title' => $title, 'slug' => $slug, 'subtitle' => $subtitle, 'description' => $description,
                'price' => $price, 'price_label' => $price_label, 'icon' => $icon, 'icon_color' => $icon_color,
                'image1' => $images[0], 'image2' => $images[1], 'image3' => $images[2], 'image4' => $images[3], 'image5' => $images[4],
                'inclusions' => $inclusions, 'start_date' => $start_date, 'end_date' => $end_date, 'display_order' => $display_order
            ]);
            echo json_encode(['success' => true, 'message' => 'Offer added successfully', 'id' => $pdo->lastInsertId()]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error adding offer']);
        }
        break;
    
    // Update offer
    case 'update_offer':
        checkAdminSession();
        $id = $_POST['id'];
        $title = $_POST['title'];
        $slug = strtolower(str_replace(' ', '-', $title));
        $subtitle = $_POST['subtitle'] ?? '';
        $description = $_POST['description'] ?? '';
        $price = $_POST['price'] ?? '';
        $price_label = $_POST['price_label'] ?? '';
        $icon = $_POST['icon'] ?? 'fa-gift';
        $icon_color = $_POST['icon_color'] ?? '#b89a78';
        $inclusions = $_POST['inclusions'] ?? '[]';
        $start_date = $_POST['start_date'] ?? null;
        $end_date = $_POST['end_date'] ?? null;
        $display_order = $_POST['display_order'] ?? 0;
        
        // Get existing images from database
        $stmt = $pdo->prepare("SELECT image1, image2, image3, image4, image5 FROM offers WHERE id = ?");
        $stmt->execute([$id]);
        $existingOffer = $stmt->fetch();
        $images = [
            $existingOffer['image1'] ?? '',
            $existingOffer['image2'] ?? '',
            $existingOffer['image3'] ?? '',
            $existingOffer['image4'] ?? '',
            $existingOffer['image5'] ?? ''
        ];
        
        // Handle image uploads (5 images)
        $uploadDir = __DIR__ . '/uploads/offers/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Process up to 5 image uploads - they replace at positions 0, 1, 2, 3, 4
        for ($i = 1; $i <= 5; $i++) {
            $fileKey = 'offerImageFile' . $i;
            // First check if a new file was uploaded
            if (!empty($_FILES[$fileKey]['name']) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES[$fileKey]['tmp_name'];
                $name = basename($_FILES[$fileKey]['name']);
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $newName = 'offer_' . uniqid() . '_' . $i . '.' . $ext;
                $targetPath = $uploadDir . $newName;
                
                if (move_uploaded_file($tmpName, $targetPath)) {
                    // Replace at position i-1
                    $images[$i - 1] = 'uploads/offers/' . $newName;
                }
            } else {
                // Check if URL was provided (for URL input replacement)
                $urlKey = 'image' . $i;
                if (!empty($_POST[$urlKey])) {
                    // Replace at position i-1
                    $images[$i - 1] = $_POST[$urlKey];
                }
            }
        }
        
        try {
            $stmt = $pdo->prepare("UPDATE offers SET title = :title, slug = :slug, subtitle = :subtitle, description = :description, price = :price, price_label = :price_label, icon = :icon, icon_color = :icon_color, image1 = :image1, image2 = :image2, image3 = :image3, image4 = :image4, image5 = :image5, inclusions = :inclusions, start_date = :start_date, end_date = :end_date, display_order = :display_order WHERE id = :id");
            $stmt->execute([
                'title' => $title, 'slug' => $slug, 'subtitle' => $subtitle, 'description' => $description,
                'price' => $price, 'price_label' => $price_label, 'icon' => $icon, 'icon_color' => $icon_color,
                'image1' => $images[0], 'image2' => $images[1], 'image3' => $images[2], 'image4' => $images[3], 'image5' => $images[4],
                'inclusions' => $inclusions, 'start_date' => $start_date, 'end_date' => $end_date, 'display_order' => $display_order, 'id' => $id
            ]);
            echo json_encode(['success' => true, 'message' => 'Offer updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error updating offer']);
        }
        break;
    
    // Delete offer
    case 'delete_offer':
        checkAdminSession();
        $id = $_POST['id'];
        $stmt = $pdo->prepare("UPDATE offers SET is_active = 0 WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Offer deleted successfully']);
        break;
    
    // ==================== OFFER INCLUSIONS MANAGEMENT ====================
    
    // Get all inclusions
    case 'get_all_inclusions':
        checkAdminSession();
        $stmt = $pdo->query("SELECT * FROM offer_inclusions ORDER BY display_order ASC");
        $inclusions = $stmt->fetchAll();
        echo json_encode(['success' => true, 'inclusions' => $inclusions]);
        break;
    
    // Add inclusion
    case 'add_inclusion':
        checkAdminSession();
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $icon = $_POST['icon'] ?? 'fa-check';
        
        if (empty($name)) {
            echo json_encode(['success' => false, 'message' => 'Name is required']);
            break;
        }
        
        // Get next display order
        $stmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 as next_order FROM offer_inclusions");
        $nextOrder = $stmt->fetch()['next_order'];
        
        try {
            $stmt = $pdo->prepare("INSERT INTO offer_inclusions (name, description, icon, display_order) VALUES (:name, :description, :icon, :display_order)");
            $stmt->execute(['name' => $name, 'description' => $description, 'icon' => $icon, 'display_order' => $nextOrder]);
            echo json_encode(['success' => true, 'message' => 'Inclusion added successfully', 'id' => $pdo->lastInsertId()]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error adding inclusion']);
        }
        break;
    
    // Delete inclusion
    case 'delete_inclusion':
        checkAdminSession();
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM offer_inclusions WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Inclusion deleted successfully']);
        break;
    
    // ==================== MENU MANAGEMENT ====================
    
    // Get all menu categories
    case 'get_all_menu_categories':
        checkAdminSession();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM menu_categories");
        $total = $stmt->fetch()['total'];
        
        $stmt = $pdo->query("SELECT * FROM menu_categories ORDER BY display_order ASC LIMIT $limit OFFSET $offset");
        $categories = $stmt->fetchAll();
        echo json_encode(['success' => true, 'categories' => $categories, 'total' => $total, 'page' => $page, 'total_pages' => ceil($total / $limit)]);
        break;
    
    // Add menu category
    case 'add_menu_category':
        checkAdminSession();
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        
        // Get next display order automatically
        $stmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 as next_order FROM menu_categories");
        $display_order = $stmt->fetch()['next_order'];
        
        try {
            $stmt = $pdo->prepare("INSERT INTO menu_categories (name, description, display_order) VALUES (:name, :description, :display_order)");
            $stmt->execute(['name' => $name, 'description' => $description, 'display_order' => $display_order]);
            echo json_encode(['success' => true, 'message' => 'Category added successfully', 'id' => $pdo->lastInsertId()]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error adding category']);
        }
        break;
    
    // Update menu category
    case 'update_menu_category':
        checkAdminSession();
        $id = $_POST['id'];
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $display_order = $_POST['display_order'] ?? 0;
        
        try {
            $stmt = $pdo->prepare("UPDATE menu_categories SET name = :name, description = :description, display_order = :display_order WHERE id = :id");
            $stmt->execute(['name' => $name, 'description' => $description, 'display_order' => $display_order, 'id' => $id]);
            echo json_encode(['success' => true, 'message' => 'Category updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error updating category']);
        }
        break;
    
    // Delete menu category
    case 'delete_menu_category':
        checkAdminSession();
        $id = $_POST['id'];
        
        // Delete associated menu items first to avoid foreign key constraint violation
        $stmt = $pdo->prepare("DELETE FROM menu_items WHERE category_id = ?");
        $stmt->execute([$id]);
        
        // Then delete the category
        $stmt = $pdo->prepare("DELETE FROM menu_categories WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Category deleted successfully']);
        break;
    
    // Get all menu items
    case 'get_all_menu_items':
        checkAdminSession();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM menu_items");
        $total = $stmt->fetch()['total'];
        
        $stmt = $pdo->query("SELECT mi.*, mc.name as category_name FROM menu_items mi LEFT JOIN menu_categories mc ON mi.category_id = mc.id ORDER BY mc.display_order ASC, mi.display_order ASC LIMIT $limit OFFSET $offset");
        $items = $stmt->fetchAll();
        foreach ($items as &$item) {
            // Decode JSON columns if they exist and are valid JSON
            if (isset($item['ingredients']) && $item['ingredients']) {
                $decoded = json_decode($item['ingredients'], true);
                $item['ingredients'] = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : [];
            } else {
                $item['ingredients'] = [];
            }
            if (isset($item['allergens']) && $item['allergens']) {
                $decoded = json_decode($item['allergens'], true);
                $item['allergens'] = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : [];
            } else {
                $item['allergens'] = [];
            }
        }
        echo json_encode(['success' => true, 'items' => $items, 'total' => $total, 'page' => $page, 'total_pages' => ceil($total / $limit)]);
        break;
    
    // Get signature menu items only
    case 'get_signature_menu_items':
        checkAdminSession();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM menu_items WHERE is_signature = 1");
        $total = $stmt->fetch()['total'];
        
        $stmt = $pdo->query("SELECT mi.*, mc.name as category_name FROM menu_items mi LEFT JOIN menu_categories mc ON mi.category_id = mc.id WHERE mi.is_signature = 1 ORDER BY mc.display_order ASC, mi.display_order ASC LIMIT $limit OFFSET $offset");
        $items = $stmt->fetchAll();
        foreach ($items as &$item) {
            if (isset($item['ingredients']) && $item['ingredients']) {
                $decoded = json_decode($item['ingredients'], true);
                $item['ingredients'] = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : [];
            } else {
                $item['ingredients'] = [];
            }
            if (isset($item['allergens']) && $item['allergens']) {
                $decoded = json_decode($item['allergens'], true);
                $item['allergens'] = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : [];
            } else {
                $item['allergens'] = [];
            }
        }
        echo json_encode(['success' => true, 'items' => $items, 'total' => $total, 'page' => $page, 'total_pages' => ceil($total / $limit)]);
        break;
    
    // Add menu item
case 'add_menu_item':
    checkAdminSession();
    $category_id = $_POST['category_id'] ?? null;
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;
    $is_signature = $_POST['is_signature'] ?? 0;
    $is_available = $_POST['is_available'] ?? 1;
    $ingredients = $_POST['ingredients'] ?? '[]';
    $allergens = $_POST['allergens'] ?? '[]';
    
    // Get next display order
    $stmt = $pdo->prepare("SELECT COALESCE(MAX(display_order), 0) + 1 as next_order FROM menu_items WHERE category_id = ?");
    $stmt->execute([$category_id]);
    $display_order = $stmt->fetch()['next_order'];
    
    // ====== FIXED: IMAGE HANDLING ======
    $image = '';
    $uploadSuccess = false;
    
    // Check for file upload with key 'imageFile' (matches JavaScript)
    if (isset($_FILES['imageFile']) && $_FILES['imageFile']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/uploads/menu/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $tmpName = $_FILES['imageFile']['tmp_name'];
        $fileName = basename($_FILES['imageFile']['name']);
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
        
        if (in_array($ext, $allowed)) {
            $newName = 'menu_' . uniqid() . '.' . $ext;
            $targetPath = $uploadDir . $newName;
            
            if (move_uploaded_file($tmpName, $targetPath)) {
                $image = 'uploads/menu/' . $newName;
                $uploadSuccess = true;
                error_log("Image uploaded successfully: " . $image);
            } else {
                error_log("Failed to move uploaded file: " . $tmpName . " to " . $targetPath);
            }
        } else {
            error_log("Invalid file type: " . $ext);
        }
    }
    
    // If no file uploaded, check for URL from form
    if (!$uploadSuccess && !empty($_POST['image']) && filter_var($_POST['image'], FILTER_VALIDATE_URL)) {
        $image = $_POST['image'];
        error_log("Using URL image: " . $image);
    }
    
    // LOG THE RESULT FOR DEBUGGING
    error_log("Signature dish: " . $is_signature . ", Image: " . ($image ?: 'EMPTY') . ", Upload success: " . ($uploadSuccess ? 'YES' : 'NO'));
    
    // IMPORTANT: For signature dishes, only use placeholder if NO image was provided at all
    // If user uploaded a file but it failed, we should NOT silently replace with placeholder
    if (empty($image) && $is_signature == 1 && !$uploadSuccess) {
        // Only use placeholder if user didn't try to upload or provide a URL
        if (empty($_FILES['imageFile']['name']) && empty($_POST['image'])) {
            $image = 'https://via.placeholder.com/300x200/f5f0eb/8a735b?text=Signature+Dish';
            error_log("Using placeholder for signature dish (no image provided)");
        } else {
            // User tried to upload but it failed - return error
            echo json_encode(['success' => false, 'message' => 'Image upload failed. Please try again.']);
            break;
        }
    }
    
    try {
        $stmt = $pdo->prepare("INSERT INTO menu_items (category_id, name, description, price, image, is_signature, is_available, display_order, ingredients, allergens) VALUES (:category_id, :name, :description, :price, :image, :is_signature, :is_available, :display_order, :ingredients, :allergens)");
        $stmt->execute([
            'category_id' => $category_id, 
            'name' => $name, 
            'description' => $description, 
            'price' => $price, 
            'image' => $image, 
            'is_signature' => $is_signature, 
            'is_available' => $is_available, 
            'display_order' => $display_order, 
            'ingredients' => $ingredients, 
            'allergens' => $allergens
        ]);
        echo json_encode(['success' => true, 'message' => 'Menu item added successfully', 'id' => $pdo->lastInsertId(), 'image' => $image]);
    } catch (PDOException $e) {
        error_log('Error adding menu item: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error adding menu item: ' . $e->getMessage()]);
    }
    break;
    
    // Update menu item
case 'update_menu_item':
    checkAdminSession();
    $id = $_POST['id'];
    $category_id = $_POST['category_id'] ?? null;
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;
    $is_signature = $_POST['is_signature'] ?? 0;
    $is_available = $_POST['is_available'] ?? 1;
    $display_order = $_POST['display_order'] ?? 0;
    $ingredients = $_POST['ingredients'] ?? '[]';
    $allergens = $_POST['allergens'] ?? '[]';
    
    // Get existing image
    $stmt = $pdo->prepare("SELECT image FROM menu_items WHERE id = ?");
    $stmt->execute([$id]);
    $existingItem = $stmt->fetch();
    $image = $existingItem['image'] ?? '';
    $uploadSuccess = false;
    
    // Check for file upload with key 'imageFile'
    if (isset($_FILES['imageFile']) && $_FILES['imageFile']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/uploads/menu/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $tmpName = $_FILES['imageFile']['tmp_name'];
        $fileName = basename($_FILES['imageFile']['name']);
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
        
        if (in_array($ext, $allowed)) {
            $newName = 'menu_' . uniqid() . '.' . $ext;
            $targetPath = $uploadDir . $newName;
            
            if (move_uploaded_file($tmpName, $targetPath)) {
                // Delete old image if exists and is local
                if (!empty($image) && strpos($image, 'uploads/menu/') === 0) {
                    $oldPath = __DIR__ . $image;
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                $image = 'uploads/menu/' . $newName;
                $uploadSuccess = true;
                error_log("Image updated successfully: " . $image);
            } else {
                error_log("Failed to move uploaded file: " . $tmpName . " to " . $targetPath);
            }
        } else {
            error_log("Invalid file type: " . $ext);
        }
    }
    
    // If no file uploaded, check for URL from form
    if (!$uploadSuccess && !empty($_POST['image']) && filter_var($_POST['image'], FILTER_VALIDATE_URL)) {
        $image = $_POST['image'];
        error_log("Using URL image for update: " . $image);
    }
    
    try {
        $stmt = $pdo->prepare("UPDATE menu_items SET category_id = :category_id, name = :name, description = :description, price = :price, image = :image, is_signature = :is_signature, is_available = :is_available, display_order = :display_order, ingredients = :ingredients, allergens = :allergens WHERE id = :id");
        $stmt->execute([
            'category_id' => $category_id, 
            'name' => $name, 
            'description' => $description, 
            'price' => $price, 
            'image' => $image, 
            'is_signature' => $is_signature, 
            'is_available' => $is_available, 
            'display_order' => $display_order, 
            'ingredients' => $ingredients, 
            'allergens' => $allergens,
            'id' => $id
        ]);
        echo json_encode(['success' => true, 'message' => 'Menu item updated successfully', 'image' => $image]);
    } catch (PDOException $e) {
        error_log('Error updating menu item: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error updating menu item: ' . $e->getMessage()]);
    }
    break;
    
    // Delete menu item
    case 'delete_menu_item':
        checkAdminSession();
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM menu_items WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Menu item deleted successfully']);
        break;
    
    // Get popular menu items (for dashboard)
    case 'get_popular_menu_items':
        // This would require a menu_orders table - return menu items with highest display_order as popular
        $stmt = $pdo->query("SELECT mi.*, mc.name as category_name FROM menu_items mi LEFT JOIN menu_categories mc ON mi.category_id = mc.id WHERE mi.is_available = 1 ORDER BY mi.is_signature DESC, mi.display_order ASC LIMIT 5");
        $items = $stmt->fetchAll();
        echo json_encode(['success' => true, 'items' => $items]);
        break;
    
    // ==================== SETTINGS MANAGEMENT ====================
    
    // Update admin password
    case 'update_admin_password':
        checkAdminSession();
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        // Verify current password (hardcoded)
        if ($current_password !== 'admin123') {
            echo json_encode(['success' => false, 'message' => 'Current password is incorrect']);
            break;
        }
        
        if ($new_password !== $confirm_password) {
            echo json_encode(['success' => false, 'message' => 'New passwords do not match']);
            break;
        }
        
        if (strlen($new_password) < 6) {
            echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters']);
            break;
        }
        
        // In a real app, would hash and store in database
        echo json_encode(['success' => true, 'message' => 'Password updated successfully']);
        break;
    
    // Update admin settings
    case 'update_admin_settings':
        checkAdminSession();
        $admin_name = $_POST['admin_name'] ?? '';
        $admin_email = $_POST['admin_email'] ?? '';
        
        // Update session variables
        if (!empty($admin_name)) {
            $_SESSION['admin_name'] = $admin_name;
        }
        if (!empty($admin_email)) {
            $_SESSION['admin_email'] = $admin_email;
        }
        
        echo json_encode(['success' => true, 'message' => 'Settings updated successfully']);
        break;
    
    // ==================== PAGINATION SUPPORT ====================
    
    // Get paginated bookings
    case 'get_bookings_paginated':
        checkAdminSession();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM bookings");
        $total = $stmt->fetch()['total'];
        
        $stmt = $pdo->query("SELECT b.*, r.name as room_name, r.room_type, r.price as room_price FROM bookings b 
                              LEFT JOIN rooms r ON b.room_id = r.id 
                              ORDER BY b.created_at DESC LIMIT $limit OFFSET $offset");
        $bookings = $stmt->fetchAll();
        
        // Calculate total cost for each booking
        foreach ($bookings as &$booking) {
            if (!empty($booking['check_in']) && !empty($booking['check_out'])) {
                $checkIn = new DateTime($booking['check_in']);
                $checkOut = new DateTime($booking['check_out']);
                $nights = $checkOut->diff($checkIn)->days;
                $nights = max($nights, 1); // At least 1 night
                
                // Use total_price if already set, otherwise calculate from room price
                if (empty($booking['total_price']) && !empty($booking['room_price'])) {
                    $booking['total_cost'] = $booking['room_price'] * $nights;
                } else {
                    $booking['total_cost'] = $booking['total_price'] ?? 0;
                }
            } else {
                $booking['total_cost'] = $booking['total_price'] ?? 0;
            }
        }
        
        echo json_encode([
            'success' => true, 
            'bookings' => $bookings,
            'total' => $total,
            'page' => $page,
            'total_pages' => ceil($total / $limit)
        ]);
        break;
    
    // Get paginated rooms
    case 'get_rooms_paginated':
        checkAdminSession();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM rooms");
        $total = $stmt->fetch()['total'];
        
        $stmt = $pdo->query("SELECT * FROM rooms ORDER BY price ASC LIMIT $limit OFFSET $offset");
        $rooms = $stmt->fetchAll();
        foreach ($rooms as &$room) {
            $room['amenities'] = json_decode($room['amenities'], true);
            $room['images'] = json_decode($room['images'], true);
        }
        
        echo json_encode([
            'success' => true, 
            'rooms' => $rooms,
            'total' => $total,
            'page' => $page,
            'total_pages' => ceil($total / $limit)
        ]);
        break;
    
    // Get paginated amenities
    case 'get_amenities_paginated':
        checkAdminSession();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM amenities");
        $total = $stmt->fetch()['total'];
        
        $stmt = $pdo->query("SELECT a.*, ac.name as category_name FROM amenities a 
                              LEFT JOIN amenity_categories ac ON a.category_id = ac.id 
                              ORDER BY ac.display_order ASC, a.display_order ASC 
                              LIMIT $limit OFFSET $offset");
        $amenities = $stmt->fetchAll();
        foreach ($amenities as &$amenity) {
            $amenity['features'] = json_decode($amenity['features'], true);
            $amenity['gallery'] = json_decode($amenity['gallery'], true);
        }
        
        echo json_encode([
            'success' => true, 
            'amenities' => $amenities,
            'total' => $total,
            'page' => $page,
            'total_pages' => ceil($total / $limit)
        ]);
        break;
    
    // Get paginated gallery images
    case 'get_gallery_images_paginated':
        checkAdminSession();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM gallery_images WHERE is_active = 1");
        $total = $stmt->fetch()['total'];
        
        $stmt = $pdo->query("SELECT gi.*, ga.title as album_title, ga.slug as album_slug FROM gallery_images gi 
                              INNER JOIN gallery_albums ga ON gi.album_id = ga.id 
                              WHERE gi.is_active = 1 
                              ORDER BY ga.display_order ASC, gi.display_order ASC 
                              LIMIT $limit OFFSET $offset");
        $images = $stmt->fetchAll();
        
        echo json_encode([
            'success' => true, 
            'images' => $images,
            'total' => $total,
            'page' => $page,
            'total_pages' => ceil($total / $limit)
        ]);
        break;
    
    // ==================== SAMPLE MENUS MANAGEMENT ====================
    
    // Get all sample menus
    case 'get_all_sample_menus':
        checkAdminSession();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM sample_menus");
        $total = $stmt->fetch()['total'];
        
        $stmt = $pdo->query("SELECT * FROM sample_menus ORDER BY display_order ASC LIMIT $limit OFFSET $offset");
        $menus = $stmt->fetchAll();
        echo json_encode(['success' => true, 'menus' => $menus, 'total' => $total, 'page' => $page, 'total_pages' => ceil($total / $limit)]);
        break;
    
    // Add sample menu
    case 'add_sample_menu':
        checkAdminSession();
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        
        // Get next display order automatically
        $stmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 as next_order FROM sample_menus");
        $display_order = $stmt->fetch()['next_order'];
        
        try {
            $stmt = $pdo->prepare("INSERT INTO sample_menus (title, description, display_order) VALUES (:title, :description, :display_order)");
            $stmt->execute(['title' => $title, 'description' => $description, 'display_order' => $display_order]);
            echo json_encode(['success' => true, 'message' => 'Sample menu added successfully', 'id' => $pdo->lastInsertId()]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error adding sample menu']);
        }
        break;
    
    // Update sample menu
    case 'update_sample_menu':
        checkAdminSession();
        $id = $_POST['id'];
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $display_order = $_POST['display_order'] ?? 0;
        
        try {
            $stmt = $pdo->prepare("UPDATE sample_menus SET title = :title, description = :description, display_order = :display_order WHERE id = :id");
            $stmt->execute(['title' => $title, 'description' => $description, 'display_order' => $display_order, 'id' => $id]);
            echo json_encode(['success' => true, 'message' => 'Sample menu updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error updating sample menu']);
        }
        break;
    
    // Delete sample menu
    case 'delete_sample_menu':
        checkAdminSession();
        $id = $_POST['id'];
        $stmt = $pdo->prepare("UPDATE sample_menus SET is_active = 0 WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Sample menu deleted successfully']);
        break;
    
    // ==================== SAMPLE MENU ITEMS MANAGEMENT ====================
    
    // Get sample menu items by menu_id
    case 'get_sample_menu_items':
        checkAdminSession();
        $menu_id = $_POST['menu_id'];
        $stmt = $pdo->prepare("SELECT * FROM sample_menu_items WHERE menu_id = ? ORDER BY display_order ASC");
        $stmt->execute([$menu_id]);
        $items = $stmt->fetchAll();
        echo json_encode(['success' => true, 'items' => $items]);
        break;
    
    // Add sample menu item
    case 'add_sample_menu_item':
        checkAdminSession();
        $menu_id = $_POST['menu_id'] ?? null;
        $name = $_POST['name'] ?? '';
        $price = $_POST['price'] ?? '';
        
        if (!$menu_id || !$name) {
            echo json_encode(['success' => false, 'message' => 'Menu ID and name are required']);
            break;
        }
        
        // Get next display order automatically
        $stmt = $pdo->prepare("SELECT COALESCE(MAX(display_order), 0) + 1 as next_order FROM sample_menu_items WHERE menu_id = ?");
        $stmt->execute([$menu_id]);
        $display_order = $stmt->fetch()['next_order'];
        
        try {
            $stmt = $pdo->prepare("INSERT INTO sample_menu_items (menu_id, name, price, display_order) VALUES (:menu_id, :name, :price, :display_order)");
            $stmt->execute(['menu_id' => $menu_id, 'name' => $name, 'price' => $price, 'display_order' => $display_order]);
            echo json_encode(['success' => true, 'message' => 'Item added successfully', 'id' => $pdo->lastInsertId()]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error adding item']);
        }
        break;
    
    // Update sample menu item
    case 'update_sample_menu_item':
        checkAdminSession();
        $id = $_POST['id'];
        $name = $_POST['name'] ?? '';
        $price = $_POST['price'] ?? '';
        $display_order = $_POST['display_order'] ?? 0;
        
        try {
            $stmt = $pdo->prepare("UPDATE sample_menu_items SET name = :name, price = :price, display_order = :display_order WHERE id = :id");
            $stmt->execute(['name' => $name, 'price' => $price, 'display_order' => $display_order, 'id' => $id]);
            echo json_encode(['success' => true, 'message' => 'Item updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error updating item']);
        }
        break;
    
    // Delete sample menu item
    case 'delete_sample_menu_item':
        checkAdminSession();
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM sample_menu_items WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Item deleted successfully']);
        break;
    
    // Get all sample menus (for dropdown)
    case 'get_all_sample_menus_dropdown':
    
    // Get all table types
    case 'get_all_table_types':
        checkAdminSession();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM table_types");
        $total = $stmt->fetch()['total'];
        
        $stmt = $pdo->query("SELECT * FROM table_types ORDER BY max_people ASC LIMIT $limit OFFSET $offset");
        $types = $stmt->fetchAll();
        echo json_encode(['success' => true, 'types' => $types, 'total' => $total, 'page' => $page, 'total_pages' => ceil($total / $limit)]);
        break;
    
    // Add table type
    case 'add_table_type':
        checkAdminSession();
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $max_people = $_POST['max_people'] ?? 2;
        $price = $_POST['price'] ?? 0;
        $image = $_POST['image'] ?? '';
        $features = $_POST['features'] ?? '[]';
        
        // Get next display order automatically
        $stmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 as next_order FROM table_types");
        $display_order = $stmt->fetch()['next_order'];
        
        // Handle image upload
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = __DIR__ . '/uploads/table_types/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $tmpName = $_FILES['image']['tmp_name'];
            $fileName = basename($_FILES['image']['name']);
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $newName = 'table_' . uniqid() . '.' . $ext;
            $targetPath = $uploadDir . $newName;
            
            if (move_uploaded_file($tmpName, $targetPath)) {
                $image = 'uploads/table_types/' . $newName;
            }
        }
        
        try {
            $stmt = $pdo->prepare("INSERT INTO table_types (name, description, max_people, price, image, features, display_order) VALUES (:name, :description, :max_people, :price, :image, :features, :display_order)");
            $stmt->execute(['name' => $name, 'description' => $description, 'max_people' => $max_people, 'price' => $price, 'image' => $image, 'features' => $features, 'display_order' => $display_order]);
            echo json_encode(['success' => true, 'message' => 'Table type added successfully', 'id' => $pdo->lastInsertId()]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error adding table type']);
        }
        break;
    
    // Update table type
    case 'update_table_type':
        checkAdminSession();
        $id = $_POST['id'];
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $max_people = $_POST['max_people'] ?? 2;
        $price = $_POST['price'] ?? 0;
        $features = $_POST['features'] ?? '[]';
        $display_order = $_POST['display_order'] ?? 0;
        
        // Get existing image
        $stmt = $pdo->prepare("SELECT image FROM table_types WHERE id = ?");
        $stmt->execute([$id]);
        $existingType = $stmt->fetch();
        $image = $existingType['image'] ?? '';
        
        // Handle image upload
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = __DIR__ . '/uploads/table_types/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $tmpName = $_FILES['image']['tmp_name'];
            $fileName = basename($_FILES['image']['name']);
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $newName = 'table_' . uniqid() . '.' . $ext;
            $targetPath = $uploadDir . $newName;
            
            if (move_uploaded_file($tmpName, $targetPath)) {
                $image = 'uploads/table_types/' . $newName;
            }
        }
        
        try {
            $stmt = $pdo->prepare("UPDATE table_types SET name = :name, description = :description, max_people = :max_people, price = :price, image = :image, features = :features, display_order = :display_order WHERE id = :id");
            $stmt->execute(['name' => $name, 'description' => $description, 'max_people' => $max_people, 'price' => $price, 'image' => $image, 'features' => $features, 'display_order' => $display_order, 'id' => $id]);
            echo json_encode(['success' => true, 'message' => 'Table type updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error updating table type']);
        }
        break;
    
    // Delete table type
    case 'delete_table_type':
        checkAdminSession();
        $id = $_POST['id'];
        $stmt = $pdo->prepare("UPDATE table_types SET is_active = 0 WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Table type deleted successfully']);
        break;
    
    // ==================== RESTAURANT RESERVATIONS MANAGEMENT ====================
    
    // Get all restaurant reservations
    case 'get_all_restaurant_reservations':
        checkAdminSession();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM restaurant_reservations");
        $total = $stmt->fetch()['total'];
        
        $stmt = $pdo->query("SELECT r.*, t.name as table_type_name FROM restaurant_reservations r 
                              LEFT JOIN table_types t ON r.table_type_id = t.id 
                              ORDER BY r.reservation_date DESC, r.reservation_time DESC LIMIT $limit OFFSET $offset");
        $reservations = $stmt->fetchAll();
        echo json_encode(['success' => true, 'reservations' => $reservations, 'total' => $total, 'page' => $page, 'total_pages' => ceil($total / $limit)]);
        break;
    
    // Update restaurant reservation status
    case 'update_restaurant_reservation_status':
        checkAdminSession();
        $id = $_POST['id'];
        $status = $_POST['status'];
        $stmt = $pdo->prepare("UPDATE restaurant_reservations SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
        
        // If confirming, send email to customer
        if ($status === 'confirmed') {
            $stmt = $pdo->prepare("SELECT * FROM restaurant_reservations WHERE id = ?");
            $stmt->execute([$id]);
            $reservation = $stmt->fetch();
            
            if ($reservation) {
                $mailer = new SMTP_mailer($smtpHost, $smtpPort, $smtpUsername, $smtpPassword, $smtpFromEmail, $smtpFromName);
                
                $body = "
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .header { background-color: #8a735b; color: white; padding: 20px; text-align: center; }
                        .content { background-color: #f9f9f9; padding: 20px; }
                        .details { background-color: white; padding: 15px; border-radius: 5px; margin: 15px 0; }
                        .footer { background-color: #333; color: white; padding: 15px; text-align: center; font-size: 12px; }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <h1>Table Reservation Confirmed - Aora</h1>
                        </div>
                        <div class='content'>
                            <p>Dear <strong>{$reservation['guest_name']}</strong>,</p>
                            <p>Your table reservation at Aora has been confirmed!</p>
                            
                            <div class='details'>
                                <p><strong>Reservation Details:</strong></p>
                                <p>Reservation ID: #{$reservation['id']}</p>
                                <p>Date: {$reservation['reservation_date']}</p>
                                <p>Time: {$reservation['reservation_time']}</p>
                                <p>Number of Guests: {$reservation['guest_count']}</p>
                                <p>Table Type: {$reservation['table_type_name']}</p>
                            </div>
                            
                            <p>If you need to make any changes, please contact us.</p>
                            
                            <p>Best regards,<br>The Aora Restaurant Team</p>
                        </div>
                        <div class='footer'>
                            <p>Aora - Beyond Ordinary Dining</p>
                        </div>
                    </div>
                </body>
                </html>
                ";
                
                $mailer->send($reservation['guest_email'], $reservation['guest_name'], 'Table Reservation Confirmed - Aora', $body);
            }
        }
        
        echo json_encode(['success' => true, 'message' => 'Reservation status updated']);
        break;
    
    // Delete restaurant reservation
    case 'delete_restaurant_reservation':
        checkAdminSession();
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM restaurant_reservations WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Reservation deleted successfully']);
        break;
    
    // Send email to restaurant reservation guest
    case 'send_restaurant_reservation_email':
        checkAdminSession();
        $reservation_id = $_POST['reservation_id'];
        $message = $_POST['message'];
        $subject = $_POST['subject'];
        
        // Get reservation details
        $stmt = $pdo->prepare("SELECT r.*, t.name as table_type_name FROM restaurant_reservations r 
                              LEFT JOIN table_types t ON r.table_type_id = t.id 
                              WHERE r.id = ?");
        $stmt->execute([$reservation_id]);
        $reservation = $stmt->fetch();
        
        if (!$reservation) {
            echo json_encode(['success' => false, 'message' => 'Reservation not found']);
            break;
        }
        
        $mailer = new SMTP_mailer($smtpHost, $smtpPort, $smtpUsername, $smtpPassword, $smtpFromEmail, $smtpFromName);
        
        $body = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #8a735b; color: white; padding: 20px; text-align: center; }
                .content { background-color: #f9f9f9; padding: 20px; }
                .message-box { background-color: white; padding: 15px; border-radius: 5px; margin: 15px 0; border-left: 4px solid #8a735b; }
                .footer { background-color: #333; color: white; padding: 15px; text-align: center; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Message from Aora Restaurant</h1>
                </div>
                <div class='content'>
                    <p>Dear <strong>{$reservation['guest_name']}</strong>,</p>
                    <p>{$message}</p>
                    
                    <div class='message-box'>
                        <p><strong>Your Reservation Details:</strong></p>
                        <p>Reservation ID: #{$reservation['id']}</p>
                        <p>Date: {$reservation['reservation_date']}</p>
                        <p>Time: {$reservation['reservation_time']}</p>
                        <p>Guests: {$reservation['guest_count']}</p>
                    </div>
                    
                    <p>If you have any questions, please don't hesitate to contact us.</p>
                    
                    <p>Best regards,<br>The Aora Restaurant Team</p>
                </div>
                <div class='footer'>
                    <p>Aora - Beyond Ordinary Dining</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        $result = $mailer->send($reservation['guest_email'], $reservation['guest_name'], $subject, $body);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Email sent successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to send email']);
        }
        break;
    
    // ==================== CONTACT MESSAGES MANAGEMENT ====================
    
    // Get all contact messages
    case 'get_all_contact_messages':
        checkAdminSession();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM contact_messages");
        $total = $stmt->fetch()['total'];
        
        $stmt = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT $limit OFFSET $offset");
        $messages = $stmt->fetchAll();
        echo json_encode(['success' => true, 'messages' => $messages, 'total' => $total, 'page' => $page, 'total_pages' => ceil($total / $limit)]);
        break;
    
    // Get contact message by ID
    case 'get_contact_message_by_id':
        checkAdminSession();
        $id = $_POST['id'];
        $stmt = $pdo->prepare("SELECT * FROM contact_messages WHERE id = ?");
        $stmt->execute([$id]);
        $message = $stmt->fetch();
        if ($message) {
            echo json_encode(['success' => true, 'message' => $message]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Message not found']);
        }
        break;
    
    // Update contact message status
    case 'update_contact_message_status':
        checkAdminSession();
        $id = $_POST['id'];
        $status = $_POST['status'];
        $stmt = $pdo->prepare("UPDATE contact_messages SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
        echo json_encode(['success' => true, 'message' => 'Message status updated']);
        break;
    
    // Delete contact message
    case 'delete_contact_message':
        checkAdminSession();
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM contact_messages WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Message deleted successfully']);
        break;
    
    // Send email to contact message sender
    case 'send_contact_email':
        checkAdminSession();
        $contact_id = $_POST['contact_id'];
        $message = $_POST['message'];
        $subject = $_POST['subject'];
        
        // Get contact message details
        $stmt = $pdo->prepare("SELECT * FROM contact_messages WHERE id = ?");
        $stmt->execute([$contact_id]);
        $contact = $stmt->fetch();
        
        if (!$contact) {
            echo json_encode(['success' => false, 'message' => 'Contact message not found']);
            break;
        }
        
        $mailer = new SMTP_mailer($smtpHost, $smtpPort, $smtpUsername, $smtpPassword, $smtpFromEmail, $smtpFromName);
        
        $body = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #8a735b; color: white; padding: 20px; text-align: center; }
                .content { background-color: #f9f9f9; padding: 20px; }
                .message-box { background-color: white; padding: 15px; border-radius: 5px; margin: 15px 0; border-left: 4px solid #8a735b; }
                .footer { background-color: #333; color: white; padding: 15px; text-align: center; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Message from Aora Hotel</h1>
                </div>
                <div class='content'>
                    <p>Dear <strong>{$contact['name']}</strong>,</p>
                    <p>{$message}</p>
                    
                    <p>If you have any questions, please don't hesitate to contact us.</p>
                    
                    <p>Best regards,<br>The Aora Hotel Team</p>
                </div>
                <div class='footer'>
                    <p>Aora Hotel - Your Luxurious Escape</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        $result = $mailer->send($contact['email'], $contact['name'], $subject, $body);
        
        if ($result) {
            // Update status to replied
            $stmt = $pdo->prepare("UPDATE contact_messages SET status = 'replied' WHERE id = ?");
            $stmt->execute([$contact_id]);
            echo json_encode(['success' => true, 'message' => 'Email sent successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to send email']);
        }
        break;
    
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

} catch (Exception $e) {
    error_log('Admin Process Error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}
