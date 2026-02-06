/**
 * Customer Login Handler
 * 
 * Processes customer login with enhanced error handling
 * Returns JSON response for AJAX calls
 * 
 * @package FoodOrderingSystem
 * @subpackage Authentication
 */

<?php
session_start();
include '../admin/db_connect.php';
include '../admin/admin_class.php';

header('Content-Type: application/json');

// Validate input
if(!isset($_POST['email']) || !isset($_POST['password'])){
    echo json_encode([
        'status' => 'error',
        'message' => 'Email and password are required'
    ]);
    exit;
}

// Sanitize input
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$password = $_POST['password'];

// Validate email format
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid email format'
    ]);
    exit;
}

// Attempt login
$crud = new Action();
$_POST['email'] = $email;
$_POST['password'] = $password;

$login = $crud->login2();

if($login == 1){
    echo json_encode([
        'status' => 'success',
        'message' => 'Login successful',
        'redirect' => 'index.html'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid email or password'
    ]);
}
?>
