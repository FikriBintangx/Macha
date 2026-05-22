<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_macha_umkm";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sqls = [
        "CREATE TABLE IF NOT EXISTS suppliers (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            phone VARCHAR(50),
            address TEXT,
            logo VARCHAR(255),
            status ENUM('active', 'inactive') DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )",
        "CREATE TABLE IF NOT EXISTS supplier_products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            supplier_id INT NOT NULL,
            product_name VARCHAR(255) NOT NULL,
            category VARCHAR(100),
            stock INT DEFAULT 0,
            unit VARCHAR(50),
            price DECIMAL(10, 2) NOT NULL,
            image VARCHAR(255),
            description TEXT,
            status ENUM('available', 'out_of_stock') DEFAULT 'available',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE CASCADE
        )",
        "CREATE TABLE IF NOT EXISTS supplier_requests (
            id INT AUTO_INCREMENT PRIMARY KEY,
            supplier_id INT NOT NULL,
            requested_by_admin_id INT,
            product_name VARCHAR(255) NOT NULL,
            quantity INT NOT NULL,
            note TEXT,
            status ENUM('pending', 'approved', 'rejected', 'processing', 'shipped', 'completed') DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE CASCADE
        )",
        "CREATE TABLE IF NOT EXISTS supplier_shipments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            request_id INT NOT NULL,
            supplier_id INT NOT NULL,
            tracking_number VARCHAR(100),
            shipping_proof VARCHAR(255),
            shipped_at DATETIME,
            delivered_at DATETIME,
            status VARCHAR(50) DEFAULT 'shipped',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (request_id) REFERENCES supplier_requests(id) ON DELETE CASCADE,
            FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE CASCADE
        )"
    ];

    foreach ($sqls as $sql) {
        $conn->exec($sql);
        echo "Table created successfully\n";
    }

    $password_hash = password_hash('password123', PASSWORD_BCRYPT);
    $conn->exec("INSERT IGNORE INTO suppliers (id, name, email, password, phone, status) VALUES (1, 'Test Supplier', 'supplier@test.com', '$password_hash', '08123456789', 'active')");

} catch(PDOException $e) {
    /** @var PDOException $e */
    echo "Connection failed: " . $e->getMessage();
}
?>
