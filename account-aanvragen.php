<?php
if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $postal = $_POST['postal'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $description = $_POST['description'];
    $password = $_POST['password'];

    // Controleer of het wachtwoord aan de vereisten voldoet met behulp van de regex
    $password_regex = '/^(?=.*\d)(?=.*[!@#$%^&*])\S{8,}/';
    if (!preg_match($password_regex, $password)) {
        echo "<h1>Registratie mislukt</h1>";
        echo "<p>Ongeldig wachtwoord. Zorg ervoor dat je wachtwoord minimaal 8 tekens bevat, minimaal 1 cijfer en 1 speciaal teken.</p>";
        return;
    }

    $postcode_regex = '/^[1-9][0-9]{3}\s?[a-zA-Z]{2}$/';
    if (preg_match($postcode_regex, $postal)) {
        echo "De postcode voldoet aan de eisen.";
    } else {
        echo "De postcode voldoet niet aan de eisen.";
    }

    $host = 'db-mysql-ams3-46626-do-user-8155278-0.b.db.ondigitalocean.com';
    $user = 'Knv-ehbo-tilburg';
    $pass = '3HBO!';
    $dbname = 'Knv-ehbo-tilburg';
    $port = 25060;

    $conn = mysqli_init();
    mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 10);
    mysqli_real_connect($conn, $host, $user, $pass, $dbname, $port);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO user (firstname, lastname, email, postal, city, address, description, password) VALUES ('$firstname', '$lastname', '$email', '$postal', '$city', '$address', '$description', '$hashedPassword')";

    if (mysqli_query($conn, $sql)) {
        echo "Account is aangemaakt.";
    } else {
        echo "Fout bij het aanmaken van het account: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>