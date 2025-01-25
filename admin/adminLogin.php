

<?php
// Include database connection
include("../connection.php");

// Initialize error message variable
$error = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input and sanitize
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);

    // Query the database to check if the email exists
    $query = "SELECT * FROM e_admin WHERE username = '$username'";
    $result = mysqli_query($connect, $query);

    // If the email exists, verify the password
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($password === $row['a_pass']) {
            // Start session and store user data
            session_start();
            $_SESSION['admin_name'] = $row['username'];
         

            // Redirect to user dashboard
            header("Location: ./homePage.php");
            exit();
        } else {
            $error = "Incorrect password. Please try again.";
        }
    } else {
        $error = "No admin exists.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - EcoElite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../login.css">
    <style>
        body {
            background: linear-gradient(to bottom right, white, white);
            font-family: 'Poppins', sans-serif;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>

        <!-- Display error message -->
        <?php if (!empty($error)) { ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control"  name="username" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control"name="password" placeholder="Enter password" required>
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
        
    </div>
</body>
</html>