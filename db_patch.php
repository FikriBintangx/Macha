<?php
define('BASEPATH', '1');
include 'application/config/database.php';
$db_config = $db['default'];

$conn = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add description column
$sql = "SHOW COLUMNS FROM products LIKE 'description'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    $conn->query("ALTER TABLE products ADD COLUMN description TEXT AFTER name");
    echo "Added description column to products table.\n";
}

// Create product_ratings table
$sql = "CREATE TABLE IF NOT EXISTS product_ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    full_name VARCHAR(100),
    rating INT,
    comment TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Created product_ratings table successfully.\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

$conn->close();
unlink(__FILE__);
