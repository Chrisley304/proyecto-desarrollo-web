<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: admin/dashboard.php");
    exit;
} else {
    header("Location: login.php");
    exit;
}
