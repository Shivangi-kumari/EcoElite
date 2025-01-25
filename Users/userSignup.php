<?php
include("../connection.php"); // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Hashing password for security

    // Check if email already exists
    $checkQuery = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($connect, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Email already exists. Please use another email.');</script>";
    } else {
        // Insert user data into the database
        $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";
        if (mysqli_query($connect, $query)) {
            echo "<script>alert('Signup successful! You can now log in.');</script>";
            header('Location: userLogin.php');
            exit;
        } else {
            die("Signup failed: " . mysqli_error($connect));
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Signup - EcoElite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../login.css">
    <style>
        body {
            background: linear-gradient(to bottom right, #1abc9c, #1abc9c);
            font-family: 'Poppins', sans-serif;
            color: #333;
        }
       
    </style>
</head>
<body>
<div class="signup-container">
    <h1>Create Account</h1>
    <form method="POST">
        <label for="name" class="form-label">Name</label>
        <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" required>
        
        <label for="email" class="form-label mt-3">Email</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
        
        <label for="password" class="form-label mt-3">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Create a password" required>
        
        <button type="submit" class="signup-btn mt-4">Sign Up</button>
    </form>
    <p>Already have an account? <a href="userLogin.php">Log in here</a></p>
</div>
</body>
</html>