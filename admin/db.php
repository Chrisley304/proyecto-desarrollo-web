<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "siafi_website";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Set character set
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    $error_message = "Connection failed: " . $e->getMessage();

    // Output JavaScript to display error in the console
    echo "<script>console.error('$error_message');</script>";

    // Terminate script execution
    die($error_message);
}
?>
