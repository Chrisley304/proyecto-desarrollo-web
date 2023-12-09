<?php
include("db.php");

// Fetch the latest 3 blog entries
$stmt = $conn->prepare("SELECT id, title, category, cover_image, description, author_name, author_photo FROM blogs ORDER BY id DESC LIMIT 3");
$stmt->execute();
$result = $stmt->get_result();
$latestBlogs = $result->fetch_all(MYSQLI_ASSOC);

// Close the database connection
$stmt->close();
$conn->close();

// Function to convert each field to UTF-8
function convertFieldsToUTF8($value)
{
    return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
}

// Apply mb_convert_encoding to each field in the result
$latestBlogs = array_map(function ($blog) {
    $blog['title'] = convertFieldsToUTF8($blog['title']);
    $blog['category'] = convertFieldsToUTF8($blog['category']);
    $blog['description'] = convertFieldsToUTF8($blog['description']);
    $blog['author_name'] = convertFieldsToUTF8($blog['author_name']);
    $blog['cover_image'] = base64_encode($blog['cover_image']);
    $blog['author_photo'] = base64_encode($blog['author_photo']);
    return $blog;
}, $latestBlogs);
// Send JSON response to the frontend
header('Content-Type: application/json');
echo json_encode($latestBlogs);
