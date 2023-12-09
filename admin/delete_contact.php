<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

include("db.php");

// Get the contact ID from the URL
$contact_id = $_GET['id'];

// Fetch the existing contact form data
$stmt = $conn->prepare("SELECT * FROM contact_form_entries WHERE id = ?");
$stmt->bind_param("i", $contact_id);
$stmt->execute();
$result = $stmt->get_result();
$contact = $result->fetch_assoc();

// Process contact form deletion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Delete the contact form entry
    $stmt = $conn->prepare("DELETE FROM contact_form_entries WHERE id = ?");
    $stmt->bind_param("i", $contact_id);

    if ($stmt->execute()) {
        echo "Contact form entry deleted successfully!";
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
    <title>Delete Contact Form Entry</title>
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
    <h1>Delete Contact Form Entry</h1>

    <p>Are you sure you want to delete the contact form entry from "<?php echo $contact['Name']; ?>"?</p>

    <form action="delete_contact.php?id=<?php echo $contact_id; ?>" method="post">
        <button type="submit">Delete Contact Form Entry</button>
        <a href="dashboard.php" id="return-btn" class="button">Return to Dashboard</a>
    </form>
</body>

</html>