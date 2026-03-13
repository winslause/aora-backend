<?php
include 'database.php';
$tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
echo "Tables:\n";
foreach($tables as $t) {
    echo "- $t\n";
}

// Check sample_menus table structure
echo "\n\nSample menus table:\n";
$stmt = $pdo->query("DESCRIBE sample_menus");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

// Check if sample_menu_items exists
if (in_array('sample_menu_items', $tables)) {
    echo "\n\nSample menu items table exists:\n";
    $stmt = $pdo->query("DESCRIBE sample_menu_items");
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
    
    echo "\n\nData in sample_menu_items:\n";
    $stmt = $pdo->query("SELECT * FROM sample_menu_items");
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
} else {
    echo "\n\nsample_menu_items table does NOT exist!";
}
?>
