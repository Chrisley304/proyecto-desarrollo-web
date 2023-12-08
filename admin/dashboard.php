<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

include("db.php"); // Include your database connection file

// Fetch blogs and projects from the database
// $sqlBlogs = "SELECT * FROM blogs";
// $resultBlogs = $conn->query($sqlBlogs);

// $sqlProjects = "SELECT * FROM projects";
// $resultProjects = $conn->query($sqlProjects);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
        }

        .logout {
            float: right;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome to the Admin Dashboard</h1>
        <a href="logout.php" class="logout">Logout</a>

        <h2>Blogs</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Author</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $resultBlogs->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['author_name']; ?></td>
                        <!-- Add more columns as needed -->
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h2>Projects</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $resultProjects->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <!-- Add more columns as needed -->
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>