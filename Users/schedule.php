<?php
include("../connection.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if the user is not logged in
    header("Location: userLogin.php");
    exit();
}

// Retrieve session variables
$user_id = $_SESSION['user_id'];

$success_message = $error_message = ""; // Initialize success and error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize user input
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $phone = mysqli_real_escape_string($connect, $_POST['phone']);
    $wasteType = mysqli_real_escape_string($connect, $_POST['waste-type']); // Note: match the form field name
    $location = mysqli_real_escape_string($connect, $_POST['location']); // Match the form field name

    // Check if all required fields are filled
    if (!empty($name) && !empty($email) && !empty($phone) && !empty($wasteType) && !empty($location)) {
        // Prepare and bind the query
        $query = "INSERT INTO requests (name, email, phone, waste_type, location, user_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $connect->prepare($query);
        $stmt->bind_param("sssssi", $name, $email, $phone, $wasteType, $location, $user_id);

        if ($stmt->execute()) {
            // Success message
            $success_message = "Thank you for scheduling your waste collection! Your request has been received.";
        } else {
            // Error message
            $error_message = "Error: Could not save your request. Please try again later.";
        }

        // Close the statement
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Waste Collection</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   
</head>
<body>
    <nav class="navbar">
        <div class="logo">EcoElite</div>
        <ul class="nav-links">
            <li><a href="homePage.php">Home</a></li>
            <li><a href="schedule.php">Schedule</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="../index.php">Logout</a></li>
        </ul>
    </nav>

    <header class="text-center" style="color:white; font-weight:700;">
        <h1 class="display-4">Schedule Request</h1>
        
    </header>

    <div class="container">
    <?php if (!empty($success_message)) { ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php } elseif (!empty($error_message)) { ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php } ?>

        <form method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="waste-type">Waste Type</label>
                <select id="waste-type" name="waste-type" required>
                    <option value="recycling">Recycling</option>
                    <option value="organic">Organic</option>
                    <option value="general">General</option>
                </select>
            </div>
            <div class="form-group">
            <label for="location">Location</label>
            <input type="text" id="location" name="location" required>
                <label for="location">Location</label>
            </div>
            <button type="submit">Submit</button>
        </form>
        </div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</body>
</html>