<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

include("db.php"); // Include your database connection file

// Get the project ID from the URL
$project_id = $_GET['id'];

// Fetch the existing project data
$stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->bind_param("i", $project_id);
$stmt->execute();
$result = $stmt->get_result();
$project = $result->fetch_assoc();

// Process project form submission for editing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $title = $_POST['title'];
        $description = $_POST['description'];

        // Handle image uploads (optional, update only if a new image is provided)
        if ($_FILES['cover_image']['size'] > 0) {
            $cover_image = file_get_contents($_FILES['cover_image']['tmp_name']);
        } else {
            $cover_image = $project['cover_image'];
        }

        // Update data in the projects table
        $stmt = $conn->prepare("UPDATE projects SET title=?, cover_image=?, description=? WHERE id=?");
        $stmt->bind_param("sssi", $title, $cover_image, $description, $project_id);

        if ($stmt->execute()) {
            echo "Project entry updated successfully!";
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
    <title>Edit Project</title>
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
    <h1>Edit Project</h1>

    <form action="edit_project.php?id=<?php echo $project_id; ?>" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo $project['title']; ?>" required>

        <label for="cover_image">Cover Image:</label>
        <input type="file" name="cover_image" accept="image/*">

        <label for="description">Description:</label>
        <textarea name="description" rows="5" required><?php echo $project['description']; ?></textarea>

        <button type="submit">Update Project</button>
        <a href="dashboard.php" id="return-btn" class="button">Return to Dashboard</a>
    </form>
</body>

</html>