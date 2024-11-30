<?php
// db_connection.php

$servername = "localhost"; // Change if your server is different
$username = "your_username"; // Your database username
$password = "your_password"; // Your database password
$dbname = "your_database"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>