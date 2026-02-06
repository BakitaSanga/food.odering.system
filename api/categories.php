<?php
/**
 * API: Category Listing
 * 
 * Retrieves all categories
 * Returns JSON formatted data
 */
include '../admin/db_connect.php';

$categories = $conn->query("SELECT * FROM category_list ORDER BY name ASC");
$data = [];

while($row = $categories->fetch_assoc()){
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>
