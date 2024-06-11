<?php
// MySQL server configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "upwork4";

// Create a connection to the MySQL server
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character set to utf8 (optional)
$conn->set_charset("utf8");

// Now you can use $conn to perform MySQL queries
?>
