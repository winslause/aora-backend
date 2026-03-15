<?php
// API Endpoint for Rooms and Bookings
header('Content-Type: application/json');

// Disable error display for production (errors are still logged)
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Log errors to file for debugging
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_error.log');

include 'database.php';

// SMTP Configuration for Gmail
$smtpHost = 'smtp.gmail.com';
$smtpPort = 465; // Use SSL port
$smtpUsername = 'wenbusale383@gmail.com';
$smtpPassword = 'chqj uzdx dbev lpaa';
$smtpFromEmail = 'wenbusale383@gmail.com';
$smtpFromName = 'Aora Hotel';
$adminEmail = 'wenbusale383@gmail.com';

// Simple SMTP Mailer Class using PHPMailer-style implementation
class SMTP_mailer {
    private $host;
    private $port;
    private $username;
    private $password;
    private $from_email;
    private $from_name;
    private $socket;
    
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
            // Connect using stream_socket_client with SSL
            $context = stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                    'SNI_enabled' => true,
                    'crypto_method' => STREAM_CRYPTO_METHOD_SSLv23_CLIENT
                ]
            ]);
            
            // Try SSL connection on port 465
            $this->socket = stream_socket_client(
                'ssl://' . $this->host . ':' . $this->port,
                $errno,
                $errstr,
                30,
                STREAM_CLIENT_CONNECT,
                $context
            );
            
            if (!$this->socket) {
                // Try TLS connection on port 587 as fallback
                $context2 = stream_context_create([
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    ]
                ]);
                
                $this->socket = stream_socket_client(
                    'tls://' . $this->host . ':587',
                    $errno,
                    $errstr,
                    30,
                    STREAM_CLIENT_CONNECT,
                    $context2
                );
                
                if (!$this->socket) {
                    error_log("SMTP Connection Error: $errstr ($errno)");
                    return false;
                }
                
                // Read welcome message
                $response = $this->readResponse();
                
                // EHLO
                $this->sendCommand("EHLO " . gethostname());
                
                // AUTH LOGIN
                $response = $this->sendCommand("AUTH LOGIN");
                
                // Username
                $response = $this->sendCommand(base64_encode($this->username));
                
                // Password
                $response = $this->sendCommand(base64_encode($this->password));
                
                if (substr($response, 0, 3) != '235') {
                    error_log("SMTP Auth Error: " . $response);
                    fclose($this->socket);
                    return false;
                }
                
            } else {
                // SSL connection successful
                // Read welcome message
                $response = $this->readResponse();
                
                // EHLO
                $this->sendCommand("EHLO " . gethostname());
                
                // AUTH LOGIN
                $response = $this->sendCommand("AUTH LOGIN");
                
                // Username
                $response = $this->sendCommand(base64_encode($this->username));
                
                // Password
                $response = $this->sendCommand(base64_encode($this->password));
                
                if (substr($response, 0, 3) != '235') {
                    error_log("SMTP Auth Error: " . $response);
                    fclose($this->socket);
                    return false;
                }
            }
            
            // MAIL FROM
            $this->sendCommand("MAIL FROM:<" . $this->from_email . ">");
            
            // RCPT TO
            $this->sendCommand("RCPT TO:<" . $to_email . ">");
            
            // DATA
            $this->sendCommand("DATA");
            
            // Build email headers and body
            $message = "From: " . $this->from_name . " <" . $this->from_email . ">" . $crlf;
            $message .= "To: " . $to_name . " <" . $to_email . ">" . $crlf;
            $message .= "Subject: " . $subject . $crlf;
            $message .= "MIME-Version: 1.0" . $crlf;
            $message .= "Content-Type: text/html; charset=UTF-8" . $crlf;
            $message .= $crlf;
            $message .= $body . $crlf;
            $message .= "." . $crlf;
            
            fputs($this->socket, $message);
            $response = $this->readResponse();
            
            // QUIT
            $this->sendCommand("QUIT");
            fclose($this->socket);
            
            return true;
            
        } catch (Exception $e) {
            error_log("SMTP Error: " . $e->getMessage());
            if ($this->socket) {
                fclose($this->socket);
            }
            return false;
        }
    }
}

// Function to send booking confirmation email to guest
function sendBookingConfirmationEmail($guest_email, $guest_name, $booking_data, $room) {
    global $smtpHost, $smtpPort, $smtpUsername, $smtpPassword, $smtpFromEmail, $smtpFromName;
    
    $mailer = new SMTP_mailer($smtpHost, $smtpPort, $smtpUsername, $smtpPassword, $smtpFromEmail, $smtpFromName);
    
    $subject = "Booking Confirmation - Aora Hotel";
    
    $body = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #8a735b; color: white; padding: 20px; text-align: center; }
            .content { background-color: #f9f9f9; padding: 20px; }
            .details { background-color: white; padding: 15px; border-radius: 5px; margin: 15px 0; }
            .details p { margin: 8px 0; }
            .footer { background-color: #333; color: white; padding: 15px; text-align: center; font-size: 12px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>Booking Confirmed!</h1>
            </div>
            <div class='content'>
                <p>Dear <strong>$guest_name</strong>,</p>
                <p>Thank you for choosing Aora Hotel! Your booking has been confirmed.</p>
                
                <div class='details'>
                    <h3>Booking Details</h3>
                    <p><strong>Booking ID:</strong> #{$booking_data['booking_id']}</p>
                    <p><strong>Room:</strong> {$room['name']}</p>
                    <p><strong>Check-in:</strong> {$booking_data['check_in']}</p>
                    <p><strong>Check-out:</strong> {$booking_data['check_out']}</p>
                    <p><strong>Number of Nights:</strong> {$booking_data['nights']}</p>
                    <p><strong>Adults:</strong> {$booking_data['adults']}</p>
                    <p><strong>Children:</strong> {$booking_data['children']}</p>
                    <p><strong>Total Price:</strong> KSh " . number_format($booking_data['total_price'], 0) . "</p>
                </div>
                
                <p>We look forward to welcoming you to Aora Hotel!</p>
                
                <p>Best regards,<br>The Aora Hotel Team</p>
            </div>
            <div class='footer'>
                <p>Aora Hotel - Your Luxurious Escape</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    return $mailer->send($guest_email, $guest_name, $subject, $body);
}

// Function to send booking notification to hotel admin
function sendBookingNotificationToAdmin($booking_data, $room) {
    global $smtpHost, $smtpPort, $smtpUsername, $smtpPassword, $smtpFromEmail, $smtpFromName, $adminEmail;
    
    $mailer = new SMTP_mailer($smtpHost, $smtpPort, $smtpUsername, $smtpPassword, $smtpFromEmail, $smtpFromName);
    
    $subject = "New Booking Received - Aora Hotel #" . $booking_data['booking_id'];
    
    $body = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #8a735b; color: white; padding: 20px; text-align: center; }
            .content { background-color: #f9f9f9; padding: 20px; }
            .details { background-color: white; padding: 15px; border-radius: 5px; margin: 15px 0; }
            .details p { margin: 8px 0; }
            .alert { background-color: #ffcccc; padding: 15px; border-radius: 5px; margin: 15px 0; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>New Booking Received!</h1>
            </div>
            <div class='content'>
                <div class='alert'>
                    <p><strong>⚠️ New booking needs attention!</strong></p>
                </div>
                
                <div class='details'>
                    <h3>Guest Information</h3>
                    <p><strong>Guest Name:</strong> {$booking_data['guest_name']}</p>
                    <p><strong>Email:</strong> {$booking_data['guest_email']}</p>
                    <p><strong>Phone:</strong> {$booking_data['guest_phone']}</p>
                </div>
                
                <div class='details'>
                    <h3>Booking Details</h3>
                    <p><strong>Booking ID:</strong> #{$booking_data['booking_id']}</p>
                    <p><strong>Room Type:</strong> {$room['name']}</p>
                    <p><strong>Check-in:</strong> {$booking_data['check_in']}</p>
                    <p><strong>Check-out:</strong> {$booking_data['check_out']}</p>
                    <p><strong>Number of Nights:</strong> {$booking_data['nights']}</p>
                    <p><strong>Adults:</strong> {$booking_data['adults']}</p>
                    <p><strong>Children:</strong> {$booking_data['children']}</p>
                    <p><strong>Total Price:</strong> KSh " . number_format($booking_data['total_price'], 0) . "</p>
                </div>
                
                <div class='details'>
                    <h3>Special Requests</h3>
                    <p>" . (empty($booking_data['special_requests']) ? 'None' : nl2br(htmlspecialchars($booking_data['special_requests']))) . "</p>
                </div>
            </div>
        </div>
    </body>
    </html>
    ";
    
    return $mailer->send($adminEmail, 'Hotel Admin', $subject, $body);
}

// Get action from GET or POST
$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');

switch ($action) {
    case 'get_rooms':
        // Get filter parameters - support both GET and POST
        $viewFilter = isset($_GET['view']) ? $_GET['view'] : (isset($_POST['view']) ? $_POST['view'] : null);
        $bedFilter = isset($_GET['bed']) ? $_GET['bed'] : (isset($_POST['bed']) ? $_POST['bed'] : null);
        $sort = isset($_GET['sort']) ? $_GET['sort'] : (isset($_POST['sort']) ? $_POST['sort'] : 'price_asc');
        $limit = isset($_GET['limit']) ? $_GET['limit'] : (isset($_POST['limit']) ? $_POST['limit'] : null);
        
        if ($limit) {
            $rooms = getLatestRooms($pdo, $limit);
        } else {
            $rooms = getAllRooms($pdo, $viewFilter, $bedFilter, $sort);
        }
        
        // Decode JSON amenities and images for each room
        foreach ($rooms as &$room) {
            $room['amenities'] = json_decode($room['amenities'], true);
            $room['images'] = json_decode($room['images'], true);
        }
        
        echo json_encode(['success' => true, 'rooms' => $rooms]);
        break;
        
    case 'get_room':
        // Get room by ID or room_type from request - support both GET and POST
        $roomId = isset($_GET['room_id']) ? intval($_GET['room_id']) : (isset($_POST['room_id']) ? intval($_POST['room_id']) : 0);
        $roomType = isset($_GET['room_type']) ? $_GET['room_type'] : (isset($_POST['room_type']) ? $_POST['room_type'] : '');
        
        $room = null;
        
        // First try to get by ID (prioritize ID for unique room selection)
        if ($roomId > 0) {
            $room = getRoomById($pdo, $roomId);
        }
        
        // Fall back to room_type if no ID provided or room not found
        if (!$room && !empty($roomType)) {
            $room = getRoomByType($pdo, $roomType);
        }
        
        if (!$room) {
            echo json_encode(['success' => false, 'message' => 'Room not found']);
            break;
        }
        
        $room['amenities'] = json_decode($room['amenities'], true);
        $room['images'] = json_decode($room['images'], true);
        
        echo json_encode(['success' => true, 'room' => $room]);
        break;
        
    case 'check_availability':
        // Get parameters from request - support POST only (FormData)
        $roomId = isset($_POST['room_id']) ? intval($_POST['room_id']) : 0;
        $roomType = isset($_POST['room_type']) ? $_POST['room_type'] : '';
        $checkIn = isset($_POST['check_in']) ? $_POST['check_in'] : '';
        $checkOut = isset($_POST['check_out']) ? $_POST['check_out'] : '';
        
        if ((empty($roomId) && empty($roomType)) || empty($checkIn) || empty($checkOut)) {
            echo json_encode(['success' => false, 'message' => 'All fields are required']);
            break;
        }
        
        // Validate dates
        $checkInDate = new DateTime($checkIn);
        $checkOutDate = new DateTime($checkOut);
        $today = new DateTime();
        
        if ($checkInDate < $today) {
            echo json_encode(['success' => false, 'message' => 'Check-in date cannot be in the past']);
            break;
        }
        
        if ($checkOutDate <= $checkInDate) {
            echo json_encode(['success' => false, 'message' => 'Check-out must be after check-in']);
            break;
        }
        
        // Get the room by ID or type
        $room = null;
        if ($roomId > 0) {
            $room = getRoomById($pdo, $roomId);
        }
        if (!$room && !empty($roomType)) {
            $room = getRoomByType($pdo, $roomType);
        }
        
        if (!$room) {
            echo json_encode(['success' => false, 'message' => 'Room not found']);
            break;
        }
        
        // Check for existing bookings
        $existingBookings = checkAvailability($pdo, $room['id'], $checkIn, $checkOut);
        
        if (!empty($existingBookings)) {
            // Room is booked, get alternatives
            $alternatives = getAlternativeRooms($pdo, $checkIn, $checkOut, $room['id']);
            
            foreach ($alternatives as &$alt) {
                $alt['amenities'] = json_decode($alt['amenities'], true);
                $alt['images'] = json_decode($alt['images'], true);
            }
            
            echo json_encode([
                'success' => false,
                'booked' => true,
                'message' => 'This room is already booked for the selected dates.',
                'alternatives' => $alternatives
            ]);
        } else {
            // Room is available
            $nights = $checkInDate->diff($checkOutDate)->days;
            $totalPrice = $room['price'] * $nights;
            
            echo json_encode([
                'success' => true,
                'available' => true,
                'room' => $room,
                'nights' => $nights,
                'total_price' => $totalPrice
            ]);
        }
        break;
        
    case 'create_booking':
        // Get parameters from request
        $roomId = isset($_POST['room_id']) ? intval($_POST['room_id']) : 0;
        $roomType = isset($_POST['room_type']) ? $_POST['room_type'] : '';
        $data = [
            'room_type' => $roomType,
            'guest_name' => isset($_POST['guest_name']) ? $_POST['guest_name'] : '',
            'guest_email' => isset($_POST['guest_email']) ? $_POST['guest_email'] : '',
            'guest_phone' => isset($_POST['guest_phone']) ? $_POST['guest_phone'] : '',
            'check_in' => isset($_POST['check_in']) ? $_POST['check_in'] : '',
            'check_out' => isset($_POST['check_out']) ? $_POST['check_out'] : '',
            'adults' => isset($_POST['adults']) ? intval($_POST['adults']) : 1,
            'children' => isset($_POST['children']) ? intval($_POST['children']) : 0,
            'special_requests' => isset($_POST['special_requests']) ? $_POST['special_requests'] : ''
        ];
        
        // Validate required fields
        if ((empty($roomId) && empty($roomType)) || empty($data['guest_name']) || empty($data['guest_email']) || 
            empty($data['check_in']) || empty($data['check_out'])) {
            echo json_encode(['success' => false, 'message' => 'Please fill in all required fields']);
            break;
        }
        
        // Validate email
        if (!filter_var($data['guest_email'], FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Please enter a valid email address']);
            break;
        }
        
        // Get the room by ID or type
        $room = null;
        if ($roomId > 0) {
            $room = getRoomById($pdo, $roomId);
        }
        if (!$room && !empty($roomType)) {
            $room = getRoomByType($pdo, $roomType);
        }
        
        if (!$room) {
            echo json_encode(['success' => false, 'message' => 'Room not found']);
            break;
        }
        
        $existingBookings = checkAvailability($pdo, $room['id'], $data['check_in'], $data['check_out']);
        
        if (!empty($existingBookings)) {
            echo json_encode(['success' => false, 'message' => 'Sorry, this room has just been booked by another guest.']);
            break;
        }
        
        // Create the booking
        $booking = createBooking($pdo, $data);
        
        // Add additional data for email
        $booking['guest_name'] = $data['guest_name'];
        $booking['guest_email'] = $data['guest_email'];
        $booking['guest_phone'] = $data['guest_phone'];
        $booking['check_in'] = $data['check_in'];
        $booking['check_out'] = $data['check_out'];
        $booking['adults'] = $data['adults'];
        $booking['children'] = $data['children'];
        $booking['special_requests'] = $data['special_requests'];
        
        // Send confirmation email to guest
        $emailSentToGuest = sendBookingConfirmationEmail($data['guest_email'], $data['guest_name'], $booking, $room);
        
        // Send notification email to hotel admin
        $emailSentToAdmin = sendBookingNotificationToAdmin($booking, $room);
        
        // Log email status (for debugging)
        error_log("Booking #{$booking['booking_id']} - Email to guest: " . ($emailSentToGuest ? 'Sent' : 'Failed'));
        error_log("Booking #{$booking['booking_id']} - Email to admin: " . ($emailSentToAdmin ? 'Sent' : 'Failed'));
        
        echo json_encode([
            'success' => true,
            'message' => 'Booking confirmed successfully!',
            'booking' => $booking,
            'room' => $room
        ]);
        break;
        
    // Restaurant API endpoints
    case 'get_menu_categories':
        $categories = getMenuCategories($pdo);
        echo json_encode(['success' => true, 'categories' => $categories]);
        break;
        
    case 'get_menu_items':
        $categoryId = isset($_POST['category_id']) ? $_POST['category_id'] : null;
        $items = getMenuItems($pdo, $categoryId);
        echo json_encode(['success' => true, 'items' => $items]);
        break;
        
    case 'get_signature_dishes':
        $dishes = getSignatureDishes($pdo);
        echo json_encode(['success' => true, 'dishes' => $dishes]);
        break;
        
    case 'get_dining_experiences':
        $experiences = getDiningExperiences($pdo);
        echo json_encode(['success' => true, 'experiences' => $experiences]);
        break;
    
    case 'get_table_types':
        $tableTypes = getAllTableTypes($pdo);
        echo json_encode(['success' => true, 'table_types' => $tableTypes]);
        break;
        
    case 'create_restaurant_reservation':
        try {
            $data = [
                'table_type_id' => isset($_POST['table_type_id']) ? intval($_POST['table_type_id']) : NULL,
                'reservation_date' => isset($_POST['reservation_date']) ? $_POST['reservation_date'] : '',
                'reservation_time' => isset($_POST['reservation_time']) ? $_POST['reservation_time'] : '',
                'num_guests' => isset($_POST['num_guests']) ? intval($_POST['num_guests']) : 1,
                'first_name' => isset($_POST['first_name']) ? $_POST['first_name'] : '',
                'last_name' => isset($_POST['last_name']) ? $_POST['last_name'] : '',
                'email' => isset($_POST['email']) ? $_POST['email'] : '',
                'phone' => isset($_POST['phone']) ? $_POST['phone'] : '',
                'occasion' => isset($_POST['occasion']) ? $_POST['occasion'] : '',
                'selected_items' => isset($_POST['selected_items']) ? $_POST['selected_items'] : '',
                'special_requests' => isset($_POST['special_requests']) ? $_POST['special_requests'] : ''
            ];
            
            // Log the incoming data for debugging
            error_log("Restaurant reservation data: " . print_r($data, true));
            
            // Validate required fields
            if (empty($data['reservation_date']) || empty($data['reservation_time']) || 
                empty($data['first_name']) || empty($data['last_name']) || 
                empty($data['email']) || empty($data['phone'])) {
                echo json_encode(['success' => false, 'message' => 'Please fill in all required fields']);
                break;
            }
            
            // Validate email
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['success' => false, 'message' => 'Please enter a valid email address']);
                break;
            }
            
            // Create the reservation
            $reservation = createRestaurantReservation($pdo, $data);
            
            // Add full name for email
            $guest_name = $data['first_name'] . ' ' . $data['last_name'];
            $data['reservation_id'] = $reservation['reservation_id'];
            
            // Send confirmation email to guest
            $emailSentToGuest = sendRestaurantReservationConfirmation($data['email'], $guest_name, $reservation);
            
            // Send notification email to hotel admin
            $emailSentToAdmin = sendRestaurantReservationNotificationToAdmin($data);
            
            // Log email status
            error_log("Restaurant Reservation #{$reservation['reservation_id']} - Email to guest: " . ($emailSentToGuest ? 'Sent' : 'Failed'));
            error_log("Restaurant Reservation #{$reservation['reservation_id']} - Email to admin: " . ($emailSentToAdmin ? 'Sent' : 'Failed'));
            
            echo json_encode([
                'success' => true,
                'message' => 'Table reserved successfully!',
                'reservation' => $reservation,
                'email_sent' => $emailSentToGuest
            ]);
        } catch (Exception $e) {
            error_log("Restaurant reservation error: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
        break;
        
    case 'get_amenities':
        // Get amenities for index page
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 6;
        $amenities = getAmenitiesForIndex($pdo, $limit);
        echo json_encode(['success' => true, 'amenities' => $amenities]);
        break;
        
    // Room Views API
    case 'get_room_views':
        $views = getAllRoomViews($pdo);
        echo json_encode(['success' => true, 'views' => $views]);
        break;
        
    case 'add_room_view':
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $display_order = isset($_POST['display_order']) ? intval($_POST['display_order']) : 0;
        
        if (empty($name)) {
            echo json_encode(['success' => false, 'message' => 'View name is required']);
            break;
        }
        
        try {
            $id = addRoomView($pdo, $name, $display_order);
            echo json_encode(['success' => true, 'message' => 'View added successfully', 'id' => $id]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'View already exists or error occurred']);
        }
        break;
        
    case 'delete_room_view':
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        
        if ($id == 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid view ID']);
            break;
        }
        
        deleteRoomView($pdo, $id);
        echo json_encode(['success' => true, 'message' => 'View deleted successfully']);
        break;
        
    // Bed Types API
    case 'get_bed_types':
        $bedTypes = getAllBedTypes($pdo);
        echo json_encode(['success' => true, 'bed_types' => $bedTypes]);
        break;
        
    case 'add_bed_type':
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $display_order = isset($_POST['display_order']) ? intval($_POST['display_order']) : 0;
        
        if (empty($name)) {
            echo json_encode(['success' => false, 'message' => 'Bed type name is required']);
            break;
        }
        
        try {
            $id = addBedType($pdo, $name, $display_order);
            echo json_encode(['success' => true, 'message' => 'Bed type added successfully', 'id' => $id]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Bed type already exists or error occurred']);
        }
        break;
        
    case 'delete_bed_type':
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        
        if ($id == 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid bed type ID']);
            break;
        }
        
        deleteBedType($pdo, $id);
        echo json_encode(['success' => true, 'message' => 'Bed type deleted successfully']);
        break;
        
    // Get filter options for rooms page
    case 'get_filter_options':
        $views = getAllRoomViews($pdo);
        $bedTypes = getAllBedTypes($pdo);
        echo json_encode(['success' => true, 'views' => $views, 'bed_types' => $bedTypes]);
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

// Get restaurant menu categories
function getMenuCategories($pdo) {
    $categories = getAllMenuCategories($pdo);
    return $categories;
}

// Get menu items by category
function getMenuItems($pdo, $categoryId = null) {
    if ($categoryId) {
        return getMenuItemsByCategory($pdo, $categoryId);
    }
    return getAllMenuItems($pdo);
}

// Get dining experiences
function getDiningExperiences($pdo) {
    return getAllDiningExperiences($pdo);
}

// Send restaurant reservation confirmation email to guest
function sendRestaurantReservationConfirmation($guest_email, $guest_name, $reservation_data) {
    global $smtpHost, $smtpPort, $smtpUsername, $smtpPassword, $smtpFromEmail, $smtpFromName;
    
    $mailer = new SMTP_mailer($smtpHost, $smtpPort, $smtpUsername, $smtpPassword, $smtpFromEmail, $smtpFromName);
    
    $subject = "Restaurant Reservation Confirmed - Aora Hotel";
    
    $body = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #8a735b; color: white; padding: 20px; text-align: center; }
            .content { background-color: #f9f9f9; padding: 20px; }
            .details { background-color: white; padding: 15px; border-radius: 5px; margin: 15px 0; }
            .details p { margin: 8px 0; }
            .footer { background-color: #333; color: white; padding: 15px; text-align: center; font-size: 12px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>Table Reserved!</h1>
            </div>
            <div class='content'>
                <p>Dear <strong>$guest_name</strong>,</p>
                <p>Thank you! Your table reservation at Aora Restaurant has been confirmed.</p>
                
                <div class='details'>
                    <h3>Reservation Details</h3>
                    <p><strong>Reservation ID:</strong> #{$reservation_data['reservation_id']}</p>
                    <p><strong>Date:</strong> {$reservation_data['reservation_date']}</p>
                    <p><strong>Time:</strong> {$reservation_data['reservation_time']}</p>
                    <p><strong>Number of Guests:</strong> {$reservation_data['num_guests']}</p>
                </div>
                
                <p>We look forward to serving you!</p>
                
                <p>Best regards,<br>The Aora Restaurant Team</p>
            </div>
            <div class='footer'>
                <p>Aora Hotel - Your Luxurious Escape</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    return $mailer->send($guest_email, $guest_name, $subject, $body);
}

// Send restaurant reservation notification to hotel admin
function sendRestaurantReservationNotificationToAdmin($reservation_data) {
    global $smtpHost, $smtpPort, $smtpUsername, $smtpPassword, $smtpFromEmail, $smtpFromName, $adminEmail;
    
    $mailer = new SMTP_mailer($smtpHost, $smtpPort, $smtpUsername, $smtpPassword, $smtpFromEmail, $smtpFromName);
    
    $guest_name = $reservation_data['first_name'] . ' ' . $reservation_data['last_name'];
    $subject = "New Restaurant Reservation - Aora Hotel #" . $reservation_data['reservation_id'];
    
    $body = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #8a735b; color: white; padding: 20px; text-align: center; }
            .content { background-color: #f9f9f9; padding: 20px; }
            .details { background-color: white; padding: 15px; border-radius: 5px; margin: 15px 0; }
            .details p { margin: 8px 0; }
            .alert { background-color: #ffcccc; padding: 15px; border-radius: 5px; margin: 15px 0; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>New Restaurant Reservation!</h1>
            </div>
            <div class='content'>
                <div class='alert'>
                    <p><strong>⚠️ New restaurant reservation!</strong></p>
                </div>
                
                <div class='details'>
                    <h3>Guest Information</h3>
                    <p><strong>Name:</strong> $guest_name</p>
                    <p><strong>Email:</strong> {$reservation_data['email']}</p>
                    <p><strong>Phone:</strong> {$reservation_data['phone']}</p>
                </div>
                
                <div class='details'>
                    <h3>Reservation Details</h3>
                    <p><strong>Reservation ID:</strong> #{$reservation_data['reservation_id']}</p>
                    <p><strong>Date:</strong> {$reservation_data['reservation_date']}</p>
                    <p><strong>Time:</strong> {$reservation_data['reservation_time']}</p>
                    <p><strong>Number of Guests:</strong> {$reservation_data['num_guests']}</p>
                    <p><strong>Occasion:</strong> " . (empty($reservation_data['occasion']) ? 'None' : $reservation_data['occasion']) . "</p>
                </div>
                
                <div class='details'>
                    <h3>Selected Menu Items</h3>
                    <p>" . (empty($reservation_data['selected_items']) ? 'None selected' : nl2br(htmlspecialchars($reservation_data['selected_items']))) . "</p>
                </div>
                
                <div class='details'>
                    <h3>Special Requests</h3>
                    <p>" . (empty($reservation_data['special_requests']) ? 'None' : nl2br(htmlspecialchars($reservation_data['special_requests']))) . "</p>
                </div>
            </div>
        </div>
    </body>
    </html>
    ";
    
    return $mailer->send($adminEmail, 'Hotel Admin', $subject, $body);
}

// Get amenities for index page
function getAmenitiesForIndex($pdo, $limit = 6) {
    $stmt = $pdo->prepare("SELECT a.*, ac.name as category_name FROM amenities a 
        LEFT JOIN amenity_categories ac ON a.category_id = ac.id 
        WHERE a.is_active = 1 
        ORDER BY a.display_order ASC 
        LIMIT :limit");
    $stmt->bindValue(':limit', intval($limit), PDO::PARAM_INT);
    $stmt->execute();
    $amenities = $stmt->fetchAll();
    
    // Decode JSON fields
    foreach ($amenities as &$amenity) {
        $amenity['features'] = json_decode($amenity['features'], true);
        $amenity['gallery'] = json_decode($amenity['gallery'], true);
    }
    
    return $amenities;
}