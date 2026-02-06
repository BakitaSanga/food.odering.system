<?php
/**
 * API: System Settings
 * 
 * Retrieves system configuration settings
 * Used for displaying restaurant information on frontend
 * 
 * @package FoodOrderingSystem
 * @subpackage API
 */
session_start();
include '../admin/db_connect.php';

/**
 * Fetch system settings
 */
$settings = $conn->query("SELECT * FROM system_settings LIMIT 1")->fetch_assoc();

$response = [
    'status' => 'success',
    'settings' => $settings
];

// Add user info if logged in
if(isset($_SESSION['login_user_id'])){
    $response['user'] = [
        'id' => $_SESSION['login_user_id'],
        'name' => $_SESSION['login_first_name'] . ' ' . $_SESSION['login_last_name']
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
