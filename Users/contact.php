<?php
session_start();
// Retrieve session variables
$user_id = $_SESSION['user_id'];

// Include the database connection
include("../connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize user input
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $message = mysqli_real_escape_string($connect, $_POST['message']);

    // Prepare and execute SQL query
    $query = "INSERT INTO messages (name, email, message) VALUES (?, ?, ?)";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        // Success message
        $success_message = "Thank you for contacting us! Your message has been received.";
    } else {
        // Error message
        $error_message = "Error: Could not save your message. Please try again later.";
    }

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css"> 
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
    <header  class="text-center" style="color:white; margin-bottom: 30px; font-weight:700;">
        <h1 class="display-4">Contact Us</h1>
        <p class="lead">Get in touch with us for any queries or support.</p>
    </header>

    <div class="container">
        <!-- Success or error messages -->
        <?php if (!empty($success_message)) { ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php } elseif (!empty($error_message)) { ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php } ?>

        <!-- Contact form -->
        <form  method="POST" class="mt-4">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        </div>

</body>
</html>