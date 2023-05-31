<?php
if(isset($_POST['submit'])){
    $wachtwoord = $_POST['wachtwoord'];
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $email = $_POST['email'];
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'ehbotest'; // Naam van de local test database
    $conn = mysqli_connect($host, $user, $pass, $dbname);
    $sql = "INSERT INTO gebruiker(wachtwoord,voornaam,achternaam,email) values ('$wachtwoord', '$voornaam', '$achternaam', '$email')";
    mysqli_query($conn, $sql);
}
?>
