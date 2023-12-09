<?php
include("db.php");

$stmt = $conn->prepare("SELECT * FROM projects ORDER BY id DESC");
$stmt->execute();
$result = $stmt->get_result();
$projects = $result->fetch_all(MYSQLI_ASSOC);

// Close the database connection
$stmt->close();
$conn->close();

// Function to convert each field to UTF-8
function convertFieldsToUTF8($value)
{
    return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
}

// Apply mb_convert_encoding to each field in the result
$projects = array_map(function ($blog) {
    $blog['title'] = convertFieldsToUTF8($blog['title']);
    $blog['description'] = convertFieldsToUTF8($blog['description']);
    $blog['cover_image'] = base64_encode($blog['cover_image']);
    return $blog;
}, $projects);
// Send JSON response to the frontend
header('Content-Type: application/json');
echo json_encode($projects);
