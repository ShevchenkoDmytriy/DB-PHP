<?php
require_once('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input from the form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Generate a random salt
    $salt = bin2hex(random_bytes(16));

    // Hash the password with the salt
    $hashed_password = hash('sha256', $password . $salt);

    // Prepare and execute a SQL statement to insert the user into the 'users' table
    $stmt = $conn->prepare("INSERT INTO users (users, email, password, salt) VALUES (?, ?, ?, ?)");

    // Check for errors in the prepared statement
    if (!$stmt) {
        die("Error in the prepared statement: " . $conn->error);
    }

    // Bind parameters and execute the statement
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $salt);
    $stmt->execute();

    // Check if the registration was successful
    if ($stmt->affected_rows > 0) {
        echo "Registration successful!";
    } else {
        echo "Registration failed. Please try again.";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Registration</h2>
    <form action="register.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Register">
    </form>
</body>
</html>
