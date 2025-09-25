# FILE: db.php
```php
<?php
// db.php
// Create a mysqli connection and export $conn


$DB_HOST = 'localhost';
$DB_USER = 'YOUR_DB_USER';
$DB_PASS = 'YOUR_DB_PASS';
$DB_NAME = 'dbsjtfvusuxg9c'; // or change to your DB name
$DB_PORT = 3306;


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


try {
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);
$conn->set_charset('utf8mb4');
} catch (Exception $e) {
http_response_code(500);
echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
exit;
}
```
