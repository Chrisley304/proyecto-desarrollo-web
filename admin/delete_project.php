<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

include("db.php");

// Get the project ID from the URL
$project_id = $_GET['id'];

// Fetch the existing project data
$stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->bind_param("i", $project_id);
$stmt->execute();
$result = $stmt->get_result();
$project = $result->fetch_assoc();

// Process project deletion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Delete the project entry
    $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->bind_param("i", $project_id);

    if ($stmt->execute()) {
        echo "Project entry deleted successfully!";
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
    <title>Eliminar Proyecto</title>
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">
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
    <h1>Delete Project</h1>

    <p>Are you sure you want to delete the project entry "<?php echo $project['title']; ?>"?</p>

    <form action="delete_project.php?id=<?php echo $project_id; ?>" method="post">
        <button type="submit">Delete Project</button>
        <a href="dashboard.php" id="return-btn" class="button">Return to Dashboard</a>
    </form>
</body>

</html>