<?php
// Include database connection
include("connection.php");

// Initialize error message variable
$error = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input and sanitize
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $password = $_POST['password'];

    // Query the database to check if the email exists
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($connect, $query);

    // If the email exists, verify the password
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            // Start session and store user data
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];

            // Redirect to user dashboard
            header("Location: home_page.php");
            exit();
        } else {
            $error = "Incorrect password. Please try again.";
        }
    } else {
        $error = "No user found with this email address.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login - EcoElite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom right, #4caf50, #8bc34a);
            font-family: 'Poppins', sans-serif;
            color: #333;
        }
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #4caf50;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control {
            border: 2px solid #4caf50;
            border-radius: 10px;
            transition: 0.3s;
        }
        .form-control:focus {
            border-color: #388e3c;
            box-shadow: 0 0 5px rgba(0, 255, 0, 0.5);
        }
        .login-btn {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }
        .login-btn:hover {
            background-color: #388e3c;
            box-shadow: 0 5px 10px rgba(0, 255, 0, 0.3);
        }
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
        .link {
            text-align: center;
            margin-top: 10px;
        }
        .link a {
            text-decoration: none;
            color: #4caf50;
            font-weight: bold;
            transition: 0.3s;
        }
        .link a:hover {
            color: #388e3c;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>User Login</h2>

        <!-- Display error message -->
        <?php if (!empty($error)) { ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
        <div class="link">
            <p>Don't have an account? <a href="user_signup.php">Signup here</a></p>
        </div>
    </div>
</body>
</html>