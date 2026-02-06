<?php
/**
 * API: Cart Operations
 * 
 * Handles shopping cart operations for authenticated users
 * - Retrieve cart items
 * - Calculate totals
 * - Format prices in TSH
 * 
 * @package FoodOrderingSystem
 * @subpackage API
 */
session_start();
include '../admin/db_connect.php';

/**
 * Check if user is logged in
 * Returns error if no active session
 */
if(!isset($_SESSION['login_user_id'])){
    echo json_encode([
        'status' => 'error',
        'message' => 'Please login to view cart'
    ]);
    exit;
}

$user_id = $_SESSION['login_user_id'];

/**
 * Fetch cart items for current user
 * Joins with product_list to get product details
 */
$cart_query = $conn->query("
    SELECT c.*, p.name, p.price, p.img_path 
    FROM cart c 
    INNER JOIN product_list p ON c.product_id = p.id 
    WHERE c.user_id = $user_id
");

$items = [];
$total = 0;

/**
 * Process each cart item
 * Calculate item totals and format prices
 */
while($row = $cart_query->fetch_assoc()){
    $item_total = $row['price'] * $row['qty'];
    $total += $item_total;
    
    // Format prices in Tanzanian Shillings
    $row['price_formatted'] = number_format($row['price'], 0) . ' TSH';
    $row['total_formatted'] = number_format($item_total, 0) . ' TSH';
    
    $items[] = $row;
}

/**
 * Return JSON response
 * Includes cart items and formatted total
 */
echo json_encode([
    'status' => 'success',
    'items' => $items,
    'total' => $total,
    'total_formatted' => number_format($total, 0) . ' TSH'
]);
?>
