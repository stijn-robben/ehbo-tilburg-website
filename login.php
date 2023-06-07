<?php
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $password = $_POST['password'];
    $host = 'db-mysql-ams3-46626-do-user-8155278-0.b.db.ondigitalocean.com';
    $port = 25060;
    $user = 'Knv-ehbo-tilburg';
    $pass = '3HBO!';
    $dbname = 'Knv-ehbo-tilburg';

    // Create connection
    $conn = new mysqli($host, $user, $pass, $dbname, $port);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM user WHERE id = '$id' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Gebruiker gevonden, toon gegevens op nieuwe pagina
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        if (password_verify($password, $hashedPassword)) {

            $voornaam = $row['firstname'];
            $achternaam = $row['lastname'];
            $email = $row['email'];
            $postcode = $row['postal'];
            $woonplaats = $row['city'];
            $adres = $row['address'];
            $beschrijving = $row['description'];
            $approved = $row['approved'];
            $role = $row['role'];


            // Controleren of de gebruiker een admin is of niet
            if ($role == 'admin') {
                // Nieuwe pagina voor admin weergeven
                header("Location: beheer.html");
                exit(); // Zorg ervoor dat de verdere code niet wordt uitgevoerd na de doorverwijzing
            } else {
                // Nieuwe pagina voor leden weergeven
                echo "<h1>Welcome, $voornaam!</h1>";
                // Voeg hier de inhoud toe die je aan leden wilt tonen
            }

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
    } else {
        // Gebruiker niet gevonden, toon foutmelding
        echo "<h1>Login Failed</h1>";
        echo "<p>Invalid lidnummer or wachtwoord. Please try again.</p>";
    }

    $conn->close();
}
?>