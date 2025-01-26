<?php
include("../connection.php");

// Accept a request (change status to 'Accepted')
function acceptRequest($r_id) {
    global $connect;
    $query = "UPDATE requests SET status = 'Accepted' WHERE id = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("i", $r_id); // 'i' means integer type
    if ($stmt->execute()) {
        echo "Request has been accepted successfully.";
    } else {
        echo "Error updating request status.";
    }
    $stmt->close();
}

// Delete a request (remove from database)
function deleteRequest($r_id) {
    global $connect;
    $query = "DELETE FROM requests WHERE id = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("i", $r_id); // 'i' means integer type
    if ($stmt->execute()) {
        echo "Request has been deleted successfully.";
    } else {
        echo "Error deleting request.";
    }
    $stmt->close();
}

// Example of handling AJAX requests
if (isset($_GET['action']) && isset($_GET['id'])) {
    $r_id = $_GET['id'];
    $action = $_GET['action'];

    if ($action == 'accept') {
        acceptRequest($r_id);
    } elseif ($action == 'delete') {
        deleteRequest($r_id);
    }
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Provider Dashboard</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>

<nav class="navbar">
    <div class="logo">EcoElite</div>
    <ul class="nav-links">
        <li><a href="homePage.php">Home</a></li>
        <li><a href="../index.php">Logout</a></li>
    </ul>
</nav>
<div class="container">
    <h2 class="text-center" style="color:white; margin-bottom: 30px; font-weight:700;">Welcome to Admin Dashboard</h2>

    <div class="card-container">
        <!-- Pending Requests Card -->
        <div class="card">
            <div class="card-header">Pending Requests</div>
            <div id="requests-container">
                <?php
                // Fetch requests with status "Pending"
                $query = "SELECT * FROM requests WHERE status = 'Pending'";
                $result = $connect->query($query);
                
                if ($result && $result->num_rows > 0) {
                    // Iterate through the results and display them
                    while ($request = $result->fetch_assoc()) {
                        $r_id = $request['id'];
                        
                        echo "<div class='request-card'>";
                        echo "<h4><strong>Name:</strong> " . htmlspecialchars($request['name']) . "</h4>";
                        echo "<p><strong>Email:</strong> " . htmlspecialchars($request['email']) . "</p>";
                        echo "<p><strong>Phone:</strong> " . htmlspecialchars($request['phone']) . "</p>";
                        echo "<p><strong>Waste Type:</strong> " . htmlspecialchars($request['waste_type']) . "</p>";
                        echo "<p><strong>Location:</strong> " . htmlspecialchars($request['location']) . "</p>";
                        echo "<button class='btn-accept' onclick=\"handleAction('accept', '".$request['id']."')\">Accept</button>";
                        echo "<button class='btn-delete' onclick=\"handleAction('delete', '".$request['id']."')\">Delete</button>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No pending requests found.</p>";
                }
                ?>
            </div>
        </div>

        <!-- Suggestions Card -->
        <div class="card">
            <div class="card-header">Suggestions</div>
            <div id="messages-container" class="message-container">
                <?php
                // Fetch all messages from the messages table
                $messageQuery = "SELECT * FROM messages";
                $messageResult = $connect->query($messageQuery);
                
                if ($messageResult && $messageResult->num_rows > 0) {
                    // Iterate through the results and display them
                    while ($message = $messageResult->fetch_assoc()) {
                        echo "<div class='message-card'>";
                        echo "<p><strong>From:</strong> " . htmlspecialchars($message['name']) . "</p>";
                        echo "<p><strong>Email:</strong> " . htmlspecialchars($message['email']) . "</p>";
                        echo "<p><strong>Message:</strong> " . nl2br(htmlspecialchars($message['message'])) . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No suggestions found.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<footer>
    <p>&copy; 2025 Waste Management Platform</p>
</footer>
<script src="actions.js"></script>
    </html>