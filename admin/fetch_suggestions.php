<?php
$host = 'localhost'; // Database host
$db = 'waste_management'; // The name of your database
$user = 'root'; // Your database username
$pass = ''; // Your database password

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all contact submissions
$sql = "SELECT name, email, message FROM contacts"; // Fetch only the necessary fields
$result = $conn->query($sql);

$suggestions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = $row;
    }
}

// Return the suggestions as JSON
header('Content-Type: application/json');
echo json_encode($suggestions);

$conn->close();
?>