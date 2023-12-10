<?php
include("db.php"); // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    $gender = $_POST["genero"];
    $notifications = isset($_POST["notificaciones"]) ? $_POST["notificaciones"] : "No";
    $carrera = $_POST["carrera"];

    // Insert data into the contact form table
    $stmt = $conn->prepare("INSERT INTO contact_form_entries (name, email, description, genero, notificaciones, carrera) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $message, $gender, $notifications, $carrera);

    if ($stmt->execute()) {
        echo "Mensaje enviado correctamente.";
    } else {
        echo "Error al enviar el mensaje. Por favor, inténtalo de nuevo.";
    }

    $stmt->close();
    $conn->close();
}
