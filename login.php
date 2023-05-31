<?php
if(isset($_POST['submit'])){
    $lidnummer = $_POST['lidnummer'];
    $wachtwoord = $_POST['wachtwoord'];
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'ehbo-test';
    $conn = mysqli_connect($host, $user, $pass, $dbname);
  
    $query = "SELECT * FROM gebruiker WHERE lidnummer = '$lidnummer' AND wachtwoord = '$wachtwoord'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0) {
        // Gebruiker gevonden, toon gegevens op nieuwe pagina
        $row = mysqli_fetch_assoc($result);
        $wachtwoord = $row['wachtwoord'];
        $voornaam = $row['voornaam'];
        $achternaam = $row['achternaam'];
        $email = $row['email'];
        // Nieuwe pagina met gegevens weergeven
        echo "<h1>Welcome, $voornaam!</h1>";
        echo "<p>Email: $email</p>";
        echo "<p>Voornaam: $voornaam</p>";
        echo "<p>Achternaam: $achternaam</p>";
    } else {
        // Gebruiker niet gevonden, toon foutmelding
        echo "<h1>Login Failed</h1>";
        echo "<p>Invalid name or email. Please try again.</p>";
    }
}
?>