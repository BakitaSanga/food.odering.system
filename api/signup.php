/**
 * Customer Signup Handler
 * 
 * Processes customer registration with validation and error handling
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

// Validate required fields
$required = ['email', 'password', 'first_name', 'last_name', 'mobile', 'address'];
foreach($required as $field){
    if(!isset($_POST[$field]) || empty($_POST[$field])){
        echo json_encode([
            'status' => 'error',
            'message' => ucfirst(str_replace('_', ' ', $field)) . ' is required'
        ]);
        exit;
    }
}

// Sanitize inputs
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$first_name = htmlspecialchars($_POST['first_name'], ENT_QUOTES, 'UTF-8');
$last_name = htmlspecialchars($_POST['last_name'], ENT_QUOTES, 'UTF-8');
$mobile = htmlspecialchars($_POST['mobile'], ENT_QUOTES, 'UTF-8');
$address = htmlspecialchars($_POST['address'], ENT_QUOTES, 'UTF-8');
$password = $_POST['password'];

// Validate email format
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid email format'
    ]);
    exit;
}

// Validate password strength
if(strlen($password) < 6){
    echo json_encode([
        'status' => 'error',
        'message' => 'Password must be at least 6 characters'
    ]);
    exit;
}

// Validate mobile number (basic check)
if(!preg_match('/^[0-9+\-\s()]+$/', $mobile)){
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid mobile number format'
    ]);
    exit;
}

// Attempt signup
$crud = new Action();
$_POST['email'] = $email;
$_POST['first_name'] = $first_name;
$_POST['last_name'] = $last_name;
$_POST['mobile'] = $mobile;
$_POST['address'] = $address;
$_POST['password'] = $password;

$signup = $crud->signup();

if($signup == 1){
    echo json_encode([
        'status' => 'success',
        'message' => 'Registration successful',
        'redirect' => 'index.html'
    ]);
} elseif($signup == 2){
    echo json_encode([
        'status' => 'error',
        'message' => 'Email already registered'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Registration failed. Please try again'
    ]);
}
?>
