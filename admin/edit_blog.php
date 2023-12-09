<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

include("db.php"); // Include your database connection file

// Get the blog ID from the URL
$blog_id = $_GET['id'];

// Fetch the existing blog data
$stmt = $conn->prepare("SELECT * FROM blogs WHERE id = ?");
$stmt->bind_param("i", $blog_id);
$stmt->execute();
$result = $stmt->get_result();
$blog = $result->fetch_assoc();

// Process blog form submission for editing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $title = $_POST['title'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $author_name = $_POST['author_name'];

        // Handle image uploads (optional, update only if a new image is provided)
        if ($_FILES['cover_image']['size'] > 0) {
            $cover_image = file_get_contents($_FILES['cover_image']['tmp_name']);
        } else {
            $cover_image = $blog['cover_image'];
        }

        if ($_FILES['author_photo']['size'] > 0) {
            $author_photo = file_get_contents($_FILES['author_photo']['tmp_name']);
        } else {
            $author_photo = $blog['author_photo'];
        }

        // Update data in the blogs table
        $stmt = $conn->prepare("UPDATE blogs SET title=?, category=?, cover_image=?, description=?, author_name=?, author_photo=? WHERE id=?");
        $stmt->bind_param("ssssssi", $title, $category, $cover_image, $description, $author_name, $author_photo, $blog_id);

        if ($stmt->execute()) {
            echo "Blog entry updated successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog</title>
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
    <h1>Edit Blog</h1>

    <form action="edit_blog.php?id=<?php echo $blog_id; ?>" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo $blog['title']; ?>" required>

        <label for="category">Category:</label>
        <input type="text" name="category" value="<?php echo $blog['category']; ?>" required>

        <label for="cover_image">Cover Image:</label>
        <input type="file" name="cover_image" accept="image/*">

        <label for="description">Description:</label>
        <textarea name="description" rows="5" required><?php echo $blog['description']; ?></textarea>

        <label for="author_name">Author Name:</label>
        <input type="text" name="author_name" value="<?php echo $blog['author_name']; ?>" required>

        <label for="author_photo">Author Photo:</label>
        <input type="file" name="author_photo" accept="image/*">

        <button type="submit">Update Blog</button>
        <a href="dashboard.php" id="return-btn" class="button">Return to Dashboard</a>
    </form>
</body>

</html>