<?php
include("db.php"); // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // Insert data into the contact form table
    $stmt = $conn->prepare("INSERT INTO contact_form_entries (name, email, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo "Mensaje enviado correctamente.";
    } else {
        echo "Error al enviar el mensaje. Por favor, inténtalo de nuevo.";
    }

    $stmt->close();
    $conn->close();
}
