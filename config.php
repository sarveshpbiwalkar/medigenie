<?php
// db_connection.php

$servername = "localhost"; // Change if your server is different
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "medigenie"; // Your database name

// Google Cloud credentials
$googleCredentialsPath = 'c:/xampp/htdocs/medigenie/config/google-credentials.json';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
