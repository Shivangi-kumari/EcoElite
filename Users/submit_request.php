<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost"; // Your database server
$username = "root"; // Your database username (default for XAMPP/WAMP)
$password = ""; // Your database password (default is empty for XAMPP/WAMP)
$dbname = "waste_management"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the data from the AJAX request
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$wasteType = $_POST['wasteType'];
$location = $_POST['location'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO schedule_requests (name, email, phone, wasteType, location) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $email, $phone, $wasteType, $location);

// Execute the statement
if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>