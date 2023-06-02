<?php
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $password = $_POST['password'];
    $host = 'localhost';
    $user = 'id19625723_root';
    $pass = 'ehboAvans23!';
    $dbname = 'id19625723_ehbo';
    $conn = mysqli_connect($host, $user, $pass, $dbname);
    $query = "SELECT * FROM user WHERE id = '$id' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    var_dump($query);
    var_dump(mysqli_num_rows($result));
    var_dump($id);
    var_dump($password);
    if (mysqli_num_rows($result) > 0) {
        
        // Gebruiker gevonden, toon gegevens op nieuwe pagina
        $row = mysqli_fetch_assoc($result);
        $voornaam = $row['firstname'];
        $achternaam = $row['lastname'];
        $email = $row['email'];
        $postcode = $row['postal'];
        $woonplaats = $row['city'];
        $adres = $row['address'];
        $beschrijving = $row['description'];
        $approved = $row['approved'];
        $role = $row['role'];

        // Nieuwe pagina met gegevens weergeven
        echo "<h1>Welcome, $voornaam!</h1>";
        echo "<p>Email: $email</p>";
        echo "<p>First Name: $voornaam</p>";
        echo "<p>Last Name: $achternaam</p>";
        echo "<p>Postal Code: $postcode</p>";
        echo "<p>City: $woonplaats</p>";
        echo "<p>Address: $adres</p>";
        echo "<p>Description: $beschrijving</p>";
        echo "<p>Approved: $approved</p>";
        echo "<p>Role: $role</p>";
    } else {
        // Gebruiker niet gevonden, toon foutmelding
        echo "<h1>Login Failed</h1>";
        echo "<p>Invalid lidnummer or wachtwoord. Please try again.</p>";
    }
}
?>
