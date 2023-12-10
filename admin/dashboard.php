<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

include("db.php");

// Fetch blogs and projects from the database
$sqlBlogs = "SELECT * FROM blogs";
$resultBlogs = $conn->query($sqlBlogs);

$sqlProjects = "SELECT * FROM projects";
$resultProjects = $conn->query($sqlProjects);

$sqlContactFormEntries = "SELECT * FROM contact_form_entries";
$resultContactFormEntries = $conn->query($sqlContactFormEntries);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de contenido - SIAFI</title>
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

        img {
            max-width: 100px;
            max-height: 100px;
            display: block;
            margin: 10px 0;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .add-button {
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
        }

        .edit-button,
        .delete-button {
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
        }

        h2 {
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Bienvenido al Panel de Administración</h1>
        <a href="logout.php" class="logout">Cerrar sesión</a>

        <h2>Blogs</h2>
        <a href="add_blog.php" class="add-button">Agregar Nuevo Blog</a>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Categoría</th>
                    <th>Imagen de Portada</th>
                    <th>Descripción</th>
                    <th>Autor</th>
                    <th>Foto del Autor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $resultBlogs->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><img src="data:image/jpeg;base64,<?php echo base64_encode($row['cover_image']); ?>" alt="Cover Image"></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['author_name']; ?></td>
                        <td><img src="data:image/jpeg;base64,<?php echo base64_encode($row['author_photo']); ?>" alt="Author Photo"></td>
                        <td class="action-buttons">
                            <a href="edit_blog.php?id=<?php echo $row['id']; ?>" class="edit-button">Editar</a>
                            <a href="delete_blog.php?id=<?php echo $row['id']; ?>" class="delete-button">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h2>Proyectos</h2>
        <a href="add_project.php" class="add-button">Agregar Nuevo Proyecto</a>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Imagen de Portada</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $resultProjects->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['title']; ?></td>
                        <td><img src="data:image/jpeg;base64,<?php echo base64_encode($row['cover_image']); ?>" alt="Cover Image"></td>
                        <td><?php echo $row['description']; ?></td>
                        <td class="action-buttons">
                            <a href="edit_project.php?id=<?php echo $row['id']; ?>" class="edit-button">Editar</a>
                            <a href="delete_project.php?id=<?php echo $row['id']; ?>" class="delete-button">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h2>Entradas de Formulario de Contacto</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Género</th>
                    <th>Correo Electrónico</th>
                    <th>Notificaciones</th>
                    <th>Carrera</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $resultContactFormEntries->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['genero']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['notificaciones']; ?></td>
                        <td><?php echo $row['carrera']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td class="action-buttons">
                            <a href="delete_contact.php?id=<?php echo $row['id']; ?>" class="delete-button">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>