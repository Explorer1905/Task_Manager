<?php
// Database connection details
$host = "localhost"; // Change if not using localhost
$dbname = "task_manager"; // Your database name
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password

try {
    // Create a PDO instance
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Database connection successful!";
} catch (PDOException $e) {
    // echo "Connection failed: " . $e->getMessage();
}
?>
