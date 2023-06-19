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
    $name = $_POST["name"];
    $location = $_POST["location"];
    $date = $_POST["date"];
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];

    // Query om de gegevens in de database in te voegen
    $sql = "INSERT INTO event (name, location, date, start_time, end_time) VALUES ('$name', '$location', '$date', '$start_time', '$end_time')";

    // Controleren of de query succesvol is uitgevoerd
    if ($conn->query($sql) === TRUE) {
        echo "Evenement is toegevoegd.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Verbinding met de database sluiten
$conn->close();
?>
