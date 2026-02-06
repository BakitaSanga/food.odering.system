<?php
// Test database connection and check user_info table
include 'db_connect.php';

echo "<h2>Database Connection Test</h2>";

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "<p style='color: green;'>✓ Database connected successfully</p>";

// Check user_info table structure
echo "<h3>user_info Table Structure:</h3>";
$result = $conn->query("DESCRIBE user_info");
if ($result) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . $row['Default'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color: red;'>Error describing table: " . $conn->error . "</p>";
}

// Check user_info data
echo "<h3>user_info Table Data:</h3>";
$result = $conn->query("SELECT * FROM user_info LIMIT 10");
if ($result) {
    echo "<p>Total rows: " . $result->num_rows . "</p>";
    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='5'>";
        // Get column names dynamically
        $fields = $result->fetch_fields();
        echo "<tr>";
        foreach ($fields as $field) {
            echo "<th>" . $field->name . "</th>";
        }
        echo "</tr>";
        
        // Reset pointer and display data
        $result->data_seek(0);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: orange;'>No users found in database</p>";
    }
} else {
    echo "<p style='color: red;'>Error querying table: " . $conn->error . "</p>";
}

// Check users (admin) table
echo "<h3>users (Admin) Table Data:</h3>";
$result = $conn->query("SELECT * FROM users ORDER BY id DESC");
if ($result) {
    echo "<p>Total admin users: " . $result->num_rows . "</p>";
    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Name</th><th>Username</th><th>Type</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . ($row['type'] == 1 ? 'Admin' : 'Staff') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

$conn->close();
?>
