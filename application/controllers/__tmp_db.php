<?php
require_once 'index.php'; // CI entry
$CI =& get_instance();
$CI->load->database();

// Add description column
if (!$CI->db->field_exists('description', 'products')) {
    $CI->db->query("ALTER TABLE products ADD COLUMN description TEXT AFTER name");
}

// Create product_ratings table
$query = "CREATE TABLE IF NOT EXISTS product_ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    full_name VARCHAR(100),
    rating INT,
    comment TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)";
$CI->db->query($query);

echo "Database updated successfully!";
unlink(__FILE__); // Self-delete
