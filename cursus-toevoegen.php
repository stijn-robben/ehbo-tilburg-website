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
    $date = $_POST["date"];
    $subject = $_POST["subject"];
    $max_enrollments = $_POST["max_enrollments"];
    $keywords = $_POST["keywords"];

    // Query om de gegevens in de database in te voegen
    $sql = "INSERT INTO course (date, subject, max_enrollments, keywords) VALUES ('$date', '$subject', '$max_enrollments', '$keywords')";

    // Controleren of de query succesvol is uitgevoerd
    if ($conn->query($sql) === TRUE) {
        echo "Cursus is toegevoegd.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Verbinding met de database sluiten
$conn->close();
?>