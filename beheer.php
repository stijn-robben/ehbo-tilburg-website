<?php
session_start();

// Controleer of de gebruiker is ingelogd en een admin is
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beheer</title>
</head>
<body>
    <h1>Beheerpagina</h1>
    <p>Dit is de beheerpagina waar alleen admins toegang toe hebben.</p>
</body>
</html>
