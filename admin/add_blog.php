<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

include("db.php");

// Process blog form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $author_name = $_POST['author_name'];

    // Handle image uploads
    $cover_image = file_get_contents($_FILES['cover_image']['tmp_name']);
    $author_photo = file_get_contents($_FILES['author_photo']['tmp_name']);

    // Insert data into the blogs table
    $stmt = $conn->prepare("INSERT INTO blogs (title, category, cover_image, description, author_name, author_photo) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssbsss", $title, $category, $cover_image, $description, $author_name, $author_photo);

    if ($stmt->execute()) {
        echo "Blog entry added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Blog</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
        }

        button {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
            margin-right: 10px;
        }

        #return-btn {
            background-color: #2196F3;
        }
    </style>
</head>

<body>
    <h1>Add New Blog</h1>

    <form action="add_blog.php" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" name="title" required>

        <label for="category">Category:</label>
        <input type="text" name="category" required>

        <label for="cover_image">Cover Image:</label>
        <input type="file" name="cover_image" accept="image/*" required>

        <label for="description">Description:</label>
        <textarea name="description" rows="5" required></textarea>

        <label for="author_name">Author Name:</label>
        <input type="text" name="author_name" required>

        <label for="author_photo">Author Photo:</label>
        <input type="file" name="author_photo" accept="image/*" required>

        <button type="submit">Add Blog</button>
        <a href="dashboard.php" id="return-btn" class="button">Return to Dashboard</a>
    </form>
</body>

</html>