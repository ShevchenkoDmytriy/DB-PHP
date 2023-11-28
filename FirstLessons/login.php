<?php
require_once('db.php');

session_start(); // Start a session to store user information

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute a SQL statement to retrieve the user's information
    $stmt = $conn->prepare("SELECT id, users, password, salt FROM users WHERE email = ?");

    // Check for errors in the prepared statement
    if (!$stmt) {
        die("Error in the prepared statement: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_password = $row['password'];
        $stored_salt = $row['salt'];

        // Hash the input password with the stored salt
        $input_hash = hash('sha256', $password . $stored_salt);

        // Check if the hashed input password matches the stored password
        if ($input_hash == $stored_password) {
            // Login successful, store user information in the session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['users'] = $row['users'];

            echo "Login successful! Welcome, " . $row['users'];
        } else {
            echo "Incorrect password. Please try again.";
        }
    } else {
        echo "User not found. Please check your email or register.";
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
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Login">
    </form>
</body>
</html>
