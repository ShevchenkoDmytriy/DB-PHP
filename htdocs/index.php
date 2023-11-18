<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1, h2 {
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input {
            margin-bottom: 10px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php
    include 'Book.php';
    include 'Library.php';
    $library = new Library();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['add'])) {
            $title = $_POST['title'];
            $author = $_POST['author'];
            $year = $_POST['year'];

            $book = new Book($title, $author, $year);
            $library->addBook($book);
        } elseif (isset($_POST['remove'])) {
            $titleToRemove = $_POST['titleToRemove'];
            $library->removeBook($titleToRemove);
        }
    }
    ?>
    <h2>Add a Book</h2>
    <form method="post" action="">
        <label for="title">Title:</label>
        <input type="text" name="title" required><br>
        <label for="author">Author:</label>
        <input type="text" name="author" required><br>
        <label for="year">Year:</label>
        <input type="number" name="year" required><br>
        <input type="submit" name="add" value="Add Book">
    </form>
    <h2>Book List</h2>
    <?php
    $bookList = $library->getBookList();
    if (empty($bookList)) {
        echo "<p>No books in the library.</p>";
    } else {
        echo "<ul>";
        foreach ($bookList as $book) {
            echo "<li>{$book['title']} by {$book['author']} ({$book['year']})</li>";
        }
        echo "</ul>";
    }
    ?>
    <h2>Remove a Book</h2>
    <form method="post" action="">
        <label for="titleToRemove">Title:</label>
        <input type="text" name="titleToRemove" required><br>

        <input type="submit" name="remove" value="Remove Book">
    </form>
</body>
</html>
