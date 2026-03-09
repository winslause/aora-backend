<?php
/**
 * Fix Database - Remove UNIQUE constraint from room_type column in rooms table
 * Run this file once to fix the duplicate entry error
 */

$db_host = 'localhost';
$db_name = 'aora';
$db_user = 'root';
$db_pass = ''; // Default XAMPP MySQL password is empty

try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to database successfully.<br>";
    
    // Check existing indexes on the rooms table
    $stmt = $pdo->query("SHOW INDEX FROM rooms");
    $indexes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Current indexes on 'rooms' table:</h3>";
    echo "<pre>";
    print_r($indexes);
    echo "</pre>";
    
    // Find and drop any unique index on room_type
    foreach ($indexes as $index) {
        if ($index['Key_name'] !== 'PRIMARY' && $index['Column_name'] === 'room_type') {
            echo "Found index: " . $index['Key_name'] . " on column " . $index['Column_name'] . "<br>";
            
            // Drop the unique index
            $pdo->exec("DROP INDEX " . $index['Key_name'] . " ON rooms");
            echo "Dropped index: " . $index['Key_name'] . "<br>";
        }
    }
    
    // Also try to alter the column to ensure it has no unique constraint
    $pdo->exec("ALTER TABLE rooms MODIFY room_type VARCHAR(50) NOT NULL");
    echo "Modified room_type column to remove any unique constraint.<br>";
    
    echo "<h3 style='color: green;'>Fix completed successfully!</h3>";
    echo "<p>You can now add rooms with the same room type in admin.php</p>";
    echo "<a href='admin.php'>Go to Admin Panel</a>";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
