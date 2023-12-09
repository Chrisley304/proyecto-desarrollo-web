<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

include("db.php");

// Process project form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $title = utf8_encode($_POST['title']);
        $description = utf8_encode($_POST['description']);

        // Handle image uploads
        $cover_image = file_get_contents($_FILES['cover_image']['tmp_name']);

        // Insert data into the projects table
        $stmt = $conn->prepare("INSERT INTO projects (title, cover_image, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $cover_image, $description);

        if ($stmt->execute()) {
            echo "Project entry added successfully!";
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
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">
    <title>Añadir nuevo proyecto - SIAFI</title>
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
    <h1>Add New Project</h1>

    <form action="add_project.php" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" name="title" required>

        <label for="cover_image">Cover Image:</label>
        <input type="file" name="cover_image" accept="image/*" required>

        <label for="description">Description:</label>
        <textarea name="description" rows="5" required></textarea>

        <button type="submit">Add Project</button>
        <a href="dashboard.php" id="return-btn" class="button">Return to Dashboard</a>
    </form>
</body>

</html>