<?php
$db = new PDO('mysql:host=localhost;dbname=db_macha_umkm', 'root', '');
echo "--- USERS ---\n";
$stmt = $db->query('SELECT * FROM users');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    print_r($row);
}
echo "\n--- SUPPLIERS ---\n";
$stmt = $db->query('SELECT * FROM suppliers');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    print_r($row);
}
?>
