<?php
if (isset($_POST['submit'])) {
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

<?php
if (isset($_POST['submit'])) {
    $wachtwoord = $_POST['wachtwoord'];
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $email = $_POST['email'];

    // Controleer of het wachtwoord aan de vereisten voldoet met behulp van de regex
    $password_regex = '/^(?=.*\d)(?=.*[!@#$%^&*])\S{8,}/';
    if (!preg_match($password_regex, $wachtwoord)) {
        echo "<h1>Registratie mislukt</h1>";
        echo "<p>Ongeldig wachtwoord. Zorg ervoor dat je wachtwoord minimaal 8 tekens bevat, inclusief minimaal 1 cijfer en 1 speciaal teken.</p>";
        return;
    }

    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'ehbotest'; // Naam van de lokale testdatabase
    $conn = mysqli_connect($host, $user, $pass, $dbname);
    $sql = "INSERT INTO gebruiker(wachtwoord,voornaam,achternaam,email) values ('$wachtwoord', '$voornaam', '$achternaam', '$email')";
    mysqli_query($conn, $sql);
}
?>

