<?php
// Start session and check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location:user_login.php'); // Redirect to login if not logged in
    exit;
}

// Include the database connection
include("../connection.php"); 

// Fetch data for the logged-in user
$user_id = $_SESSION['user_id'];

// Query to fetch counts of accepted and pending requests
$query_accepted = "SELECT COUNT(*) AS count FROM requests WHERE user_id = '$user_id' AND status = 'Accepted'";
$query_pending = "SELECT COUNT(*) AS count FROM requests WHERE user_id = '$user_id' AND status = 'Pending'";

$result_accepted = mysqli_query($connect, $query_accepted);
$result_pending = mysqli_query($connect, $query_pending);

// Fetch the counts
$accepted_count = ($result_accepted && mysqli_num_rows($result_accepted) > 0) ? mysqli_fetch_assoc($result_accepted)['count'] : 0;
$pending_count = ($result_pending && mysqli_num_rows($result_pending) > 0) ? mysqli_fetch_assoc($result_pending)['count'] : 0;

// Logout logic
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - EcoElite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar">
    <div class="navbar-brand">EcoElite</div>
    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="schedule.php">Schedule</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="?logout=true">Logout</a></li>
    </ul>
</nav>
    <div class="container">
        <h2 class="text-center" style="color:white; margin-bottom: 30px; font-weight:700;">Welcome to User Dashboard</h2>

        <div class="card-container">
            <!-- Accepted Card -->
            <div class="card">
                <div class="card-header">
                    Accepted
                </div>
                <div class="card-body">
                    <p><?php echo $accepted_count; ?></p> <!-- Dynamic count -->
                </div>
                <div class="card-footer">
                    <p class="card-label">Total Accepted Requests</p>
                </div>
            </div>

            <!-- Pending Card -->
            <div class="card">
                <div class="card-header">
                    Pending
                </div>
                <div class="card-body">
                    <p><?php echo $pending_count; ?></p> <!-- Dynamic count -->
                </div>
                <div class="card-footer">
                    <p class="card-label">Total Pending Requests</p>
                </div>
            </div>
        </div>

    </div>
</body>
</html>
