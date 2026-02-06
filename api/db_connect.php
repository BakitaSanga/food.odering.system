<?php
// api/db_connect.php
$conn= new mysqli('localhost','root','','fos_db');
if($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}
?>
