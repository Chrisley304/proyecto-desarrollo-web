<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./login.php");
    exit;
}

include("./db.php"); // Include your database connection file

// Get the blog ID from the URL
$blog_id = $_GET['id'];

// Fetch the existing blog data
$stmt = $conn->prepare("SELECT * FROM blogs WHERE id = ?");
$stmt->bind_param("i", $blog_id);
$stmt->execute();
$result = $stmt->get_result();
$blog = $result->fetch_assoc();

// Process blog deletion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Delete the blog entry
    $stmt = $conn->prepare("DELETE FROM blogs WHERE id = ?");
    $stmt->bind_param("i", $blog_id);

    if ($stmt->execute()) {
        echo "Blog entry deleted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Blog</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
        }

        p {
            margin-bottom: 20px;
        }

        button {
            background-color: #f44336;
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
    <h1>Delete Blog</h1>

    <p>Are you sure you want to delete the blog entry "<?php echo $blog['title']; ?>"?</p>

    <form action="delete_blog.php?id=<?php echo $blog_id; ?>" method="post">
        <button type="submit">Delete Blog</button>
        <a href="dashboard.php" id="return-btn" class="button">Return to Dashboard</a>
    </form>
</body>

</html>