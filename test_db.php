<?php
/**
 * Test Database Connection
 * Run this to check if database is working correctly
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Database Test</h1>";

$db_host = 'localhost';
$db_name = 'aora';
$db_user = 'root';
$db_pass = '';

try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✓ Database connection successful!</p>";
    
    // Check if rooms table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'rooms'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green;'>✓ Rooms table exists!</p>";
    } else {
        echo "<p style='color: red;'>✗ Rooms table does NOT exist!</p>";
    }
    
    // Get all rooms
    $stmt = $pdo->query("SELECT * FROM rooms");
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h2>Rooms in Database: " . count($rooms) . "</h2>";
    
    if (count($rooms) > 0) {
        echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
        echo "<tr><th>ID</th><th>Room Type</th><th>Name</th><th>Price</th><th>View</th><th>Bed Type</th></tr>";
        foreach ($rooms as $room) {
            echo "<tr>";
            echo "<td>" . $room['id'] . "</td>";
            echo "<td>" . $room['room_type'] . "</td>";
            echo "<td>" . $room['name'] . "</td>";
            echo "<td>KSh " . number_format($room['price']) . "</td>";
            echo "<td>" . $room['view'] . "</td>";
            echo "<td>" . $room['bed_type'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: orange;'>No rooms found. Please run setup.php first!</p>";
    }
    
    // Test getAllRooms function
    echo "<h2>Testing getAllRooms function</h2>";
    include 'database.php';
    $allRooms = getAllRooms($pdo);
    echo "<p>Function returned: " . count($allRooms) . " rooms</p>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
