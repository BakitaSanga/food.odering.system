<?php
/**
 * Database Connection Configuration
 * 
 * Establishes connection to MySQL database
 * Used by all PHP files requiring database access
 * 
 * @package FoodOrderingSystem
 * @subpackage Database
 */
/**
 * Database Configuration
 * 
 * @var string $host Database host (localhost for local development)
 * @var string $user Database username
 * @var string $pass Database password
 * @var string $db Database name
 */

// Create database connection
// IMPORTANT for InfinityFree: Replace 'localhost', 'root', and '' with your 
// MySQL Host, MySQL Username, and MySQL Password from the InfinityFree Control Panel.
$conn = new mysqli('localhost','root','','fos_db') or die("Could not connect to mysql: " . mysqli_error($conn));

/**
 * Set character set to UTF-8
 * Prevents encoding issues with special characters
 */
$conn->set_charset("utf8mb4");
?>
