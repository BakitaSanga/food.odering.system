<?php
/**
 * API: Product Listing
 * 
 * Retrieves active products with filtering options:
 * - Search by name/description
 * - Filter by category
 * - Filter by price range
 * 
 * @package FoodOrderingSystem
 * @subpackage API
 */
include '../admin/db_connect.php';

// Initialize query components
$where = " p.status = 1 ";

// Search filter
if(isset($_GET['search']) && !empty($_GET['search'])){
    $search = $conn->real_escape_string($_GET['search']);
    $where .= " AND (p.name LIKE '%$search%' OR p.description LIKE '%$search%') ";
}

// Category filter
if(isset($_GET['category_id']) && !empty($_GET['category_id']) && $_GET['category_id'] != 'all'){
    $cat_id = $conn->real_escape_string($_GET['category_id']);
    $where .= " AND p.category_id = '$cat_id' ";
}

// Price range filter
if(isset($_GET['min_price']) && is_numeric($_GET['min_price'])){
    $min = $conn->real_escape_string($_GET['min_price']);
    $where .= " AND p.price >= $min ";
}

if(isset($_GET['max_price']) && is_numeric($_GET['max_price'])){
    $max = $conn->real_escape_string($_GET['max_price']);
    $where .= " AND p.price <= $max ";
}

/**
 * Fetch products with filters applied
 */
$query = "
    SELECT p.*, c.name as category_name 
    FROM product_list p 
    INNER JOIN category_list c ON p.category_id = c.id 
    WHERE $where
    ORDER BY p.id DESC
";

$products = $conn->query($query);
$data = [];

while($row = $products->fetch_assoc()){
    $row['price_formatted'] = number_format($row['price'], 0) . ' TSH';
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>
