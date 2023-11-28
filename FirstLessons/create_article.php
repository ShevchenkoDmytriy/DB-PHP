<?php
session_start(); // Start a session to retrieve user information

require_once('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is authenticated (logged in)
    if (isset($_SESSION['user_id'])) {
        // Retrieve user input from the form
        $title = $_POST['title'];
        $content = $_POST['content'];
        $user_id = $_SESSION['user_id']; // Get the user ID from the session

        // Prepare and execute a SQL statement to insert the article into the 'articles' table
        $stmt = $conn->prepare("INSERT INTO articles (title, content, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $title, $content, $user_id);
        $stmt->execute();

        // Check if the article creation was successful
        if ($stmt->affected_rows > 0) {
            echo "Article created successfully!";
        } else {
            echo "Article creation failed. Please try again.";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Authentication required. Please log in to create articles.";
    }
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Article</title>
</head>
<body>
    <h2>Create Article</h2>
    <form action="create_article.php" method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="content">Content:</label>
        <textarea id="content" name="content" required></textarea>

        <input type="submit" value="Create Article">
    </form>
</body>
</html>
