<?php
session_start();
include("db.php");

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin_users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['loggedin'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $login_error = "Login failed. Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">
    <title>Iniciar sesión - Administrador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .login-container {
            width: 300px;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="post" action="">
            <label for="username">Usuario:</label>
            <input type="text" name="username" required><br>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" required><br>

            <input type="submit" value="Entrar">
        </form>
        <?php if (isset($login_error)) { ?>
            <p class="error"><?php echo $login_error; ?></p>
        <?php } ?>
    </div>
</body>

</html>