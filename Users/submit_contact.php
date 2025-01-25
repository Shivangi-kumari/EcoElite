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
// }else {
//     // Uncomment this line for debugging
//     // echo "Connected successfully"; 
// }
// // }else {
// //     echo "Connected successfully"; // For debugging purposes
// // }

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);
// // Debugging: Log the received data
// if ($data) {
//     // Uncomment this line for debugging
//     // echo "Data received: " . json_encode($data); 
// } else {
//     echo json_encode(['success' => false, 'error' => 'No data received']);
//     exit; // Stop execution if no data is received
// }

// Check if the required fields are set
if (isset($data['name'], $data['email'], $data['message'])) {
    $name = $data['name'];
    $email = $data['email'];
    $message = $data['message'];

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message); // "sss" means all three parameters are strings

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    // Close the statement
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
}

// Close the connection
$conn->close();
?>