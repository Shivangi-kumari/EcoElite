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

// Fetch requests from the database, including the status
$sql = "SELECT name, email, phone, wasteType, location, status FROM schedule_requests WHERE status = 'pending'"; // Fetch only pending requests
$result = $conn->query($sql);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . $conn->error);
}

$requests = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }
}

// Return the requests as JSON
header('Content-Type: application/json');
echo json_encode($requests);

$conn->close();
?>