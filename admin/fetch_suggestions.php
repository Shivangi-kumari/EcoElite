<?php
include("../connection.php");
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