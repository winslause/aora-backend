<?php
// Start session first
session_start();

// Determine the base path dynamically
$base_path = '/';
if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
    $base_path = '/aora-backend/';
}
define('BASE_PATH', $base_path);

// Enable output buffering for faster rendering
ob_start();

// Enable gzip compression for faster page loads
if (extension_loaded('zlib') && !ini_get('zlib.output_compression')) {
    ob_start('ob_gzhandler');
}

// Handle API requests
if (isset($_GET['page']) && strpos($_GET['page'], 'api/') === 0) {
    $apiPath = str_replace('api/', '', $_GET['page']);
    $apiFile = 'api/' . $apiPath . '.php';
    if (file_exists($apiFile)) {
        include $apiFile;
        exit;
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'API endpoint not found']);
        exit;
    }
}

$page = $_GET['page'] ?? 'home';

// Handle logout before any output
if ($page === 'logout') {
    session_destroy();
    header('Location: ' . BASE_PATH);
    exit;
}

// Pages that require authentication (admin only)
$protected_pages = ['admin', 'profile', 'payments'];

// Check if user is logged in for protected pages
if (in_array($page, $protected_pages) && !isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_PATH . 'login');
    exit;
}


switch ($page) {
    case 'home':
        include 'home.php';
        break;
    case 'house':
        include 'house.php';
        break;
    case 'houses':
        include 'houses.php';
        break;
    case 'moving_services':
        include 'moving_services.php';
        break;
    case 'about':
        include 'about.php';
        break;
    case 'profile':
        include 'profile.php';
        break;
    case 'login':
        include 'login.php';
        break;
    case 'register':
        include 'register.php';
        break;
    case 'reset_password':
        include 'reset_password.php';
        break;
    case 'payments':
        include 'payment.php';
        break;
    case 'amenities':
        include 'amenities.php';
        break;
    case 'restaurant':
        include 'restaurant.php';
        break;
    case 'rooms':
        include 'rooms.php';
        break;
    case 'offers':
        include 'offers.php';
        break;
    case 'gallery':
        include 'gallery.php';
        break;
    case 'contact':
        include 'contact.php';
        break;
    case 'events':
        include 'events.php';
        break;
    default:
        include 'home.php';
        break;
}

// Flush output buffer for faster rendering
ob_end_flush();

?>