/**
 * API: System Settings
 * 
 * Retrieves system configuration settings
 * Used for displaying restaurant information on frontend
 * 
 * @package FoodOrderingSystem
 * @subpackage API
 */

<?php
include '../admin/db_connect.php';

/**
 * Fetch system settings
 * Returns first row (should only be one settings record)
 */
$settings = $conn->query("SELECT * FROM system_settings LIMIT 1")->fetch_assoc();

/**
 * Return JSON response with settings
 */
header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'settings' => $settings
]);
?>
