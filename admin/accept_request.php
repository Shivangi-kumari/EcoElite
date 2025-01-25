<?php
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

// Get the email from the POST request
$email = $_POST['email'];

// Update the request status (you may want to add a status column in your table)
$sql = "UPDATE schedule_requests SET status='accepted' WHERE email='$email'"; // Assuming you have a status column
if ($conn->query($sql) === TRUE) {
    echo "Request accepted successfully.";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>