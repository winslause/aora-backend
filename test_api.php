<?php
// Simple API test file to diagnose rooms loading issue
// Upload this to your InfinityFree server and access it directly

header('Content-Type: application/json');

echo "=== AORA API DEBUG TEST ===\n\n";

// Test 1: Check PHP version
echo "PHP Version: " . PHP_VERSION . "\n";

// Test 2: Check PDO MySQL
echo "PDO MySQL: " . (extension_loaded('pdo_mysql') ? 'Loaded' : 'NOT LOADED') . "\n\n";

// Include database
echo "=== Including database.php ===\n";
include 'database.php';
echo "Database included successfully\n\n";

// Test 3: Check connection
echo "=== Testing Database Connection ===\n";
try {
    $test = $pdo->query("SELECT 1");
    echo "Connection: OK\n";
} catch (PDOException $e) {
    echo "Connection FAILED: " . $e->getMessage() . "\n";
    exit;
}

// Test 4: Check rooms table
echo "\n=== Checking Rooms Table ===\n";
try {
    $count = $pdo->query("SELECT COUNT(*) as count FROM rooms")->fetch();
    echo "Rooms count: " . $count['count'] . "\n";
} catch (PDOException $e) {
    echo "Rooms table ERROR: " . $e->getMessage() . "\n";
}

// Test 5: Check room_views table
echo "\n=== Checking Room Views Table ===\n";
try {
    $count = $pdo->query("SELECT COUNT(*) as count FROM room_views")->fetch();
    echo "Room views count: " . $count['count'] . "\n";
} catch (PDOException $e) {
    echo "Room views table ERROR: " . $e->getMessage() . "\n";
}

// Test 6: Check bed_types table
echo "\n=== Checking Bed Types Table ===\n";
try {
    $count = $pdo->query("SELECT COUNT(*) as count FROM bed_types")->fetch();
    echo "Bed types count: " . $count['count'] . "\n";
} catch (PDOException $e) {
    echo "Bed types table ERROR: " . $e->getMessage() . "\n";
}

// Test 7: Try to get rooms
echo "\n=== Testing getAllRooms() ===\n";
try {
    $rooms = getAllRooms($pdo);
    echo "Rooms fetched: " . count($rooms) . "\n";
    
    if (count($rooms) > 0) {
        echo "\nFirst room:\n";
        print_r($rooms[0]);
    }
} catch (Exception $e) {
    echo "getAllRooms ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

// Test 8: Test API get_rooms action
echo "\n=== Testing API get_rooms action ===\n";
$_POST['action'] = 'get_rooms';
$_POST['view'] = 'all';
$_POST['bed'] = 'all';
$_POST['sort'] = 'price_asc';

ob_start();
include 'api.php';
$api_output = ob_get_clean();

echo "API Output:\n";
echo $api_output . "\n";

echo "\n=== END OF TEST ===\n";
