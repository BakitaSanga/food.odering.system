/**
 * API: Product Listing
 * 
 * Retrieves all active products with category information
 * Returns JSON formatted data for frontend consumption
 * 
 * @package FoodOrderingSystem
 * @subpackage API
 */

<?php
include '../admin/db_connect.php';

/**
 * Fetch all active products
 * Joins with category_list to include category names
 * Only returns products with status = 1 (available)
 */
$products = $conn->query("
    SELECT p.*, c.name as category_name 
    FROM product_list p 
    INNER JOIN category_list c ON p.category_id = c.id 
    WHERE p.status = 1 
    ORDER BY p.id DESC
");

$data = [];

/**
 * Process each product
 * Format price in TSH and prepare for JSON output
 */
while($row = $products->fetch_assoc()){
    // Format price in Tanzanian Shillings
    $row['price_formatted'] = number_format($row['price'], 0) . ' TSH';
    $data[] = $row;
}

/**
 * Set JSON header and return product data
 */
header('Content-Type: application/json');
echo json_encode($data);
?>
