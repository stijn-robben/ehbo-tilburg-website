<?php
session_start();

// Gegevens voor de databaseverbinding
$host = 'db-mysql-ams3-46626-do-user-8155278-0.b.db.ondigitalocean.com';
$port = 25060;
$user = 'Knv-ehbo-tilburg';
$pass = '3HBO!';
$dbname = 'Knv-ehbo-tilburg';

// Verbinding maken met de database
$conn = new mysqli($host, $user, $pass, $dbname, $port);

// Controleren op fouten bij de verbinding
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Controleren of het formulier is verzonden
if (isset($_POST["submit"])) {
    // Gegevens uit het formulier halen
    $id_team = $_POST["id_team"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $text = $_POST["text"];
    $img_url = $_POST["img_url"];

    // Query om de gegevens in de database in te veranderen
    $sql = "UPDATE team
    SET name = '$name', email = '$email', text = '$text', img_url = '$img_url'
    WHERE id_team = '$id_team'";


    // Controleren of de query succesvol is uitgevoerd
    if ($conn->query($sql) === TRUE) {
        echo "Verandering is voltooid";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Verbinding met de database sluiten
$conn->close();