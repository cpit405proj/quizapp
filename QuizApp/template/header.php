<?php
require_once 'config/app.php';
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $config["app_name"]; ?></title>
    <link rel="stylesheet" type="text/css" href="template/style.css">
</head>
<body>
    <header>
        <h1><?php echo $config["app_name"]; ?></h1>
        <nav>
           

            <?php
            if (isset($_SESSION['user_id'])) {
                // User is logged in
                echo '<a href="logout.php">Logout</a>';
            } else {
                // User is not logged in
                echo '<a href="login.php">Login</a>';
                echo '<a href="register.php">Register</a>';
            }
            ?>
        </nav>
    </header>
