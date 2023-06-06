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
    $postcode = "1234AB";
    if (preg_match($postcode_regex, $postcode)) {
        echo "De postcode voldoet aan de eisen.";
    } else {
        echo "De postcode voldoet niet aan de eisen.";
    }

    $host = 'localhost';
    $user = 'id19625723_root';
    $pass = 'ehboAvans23!';
    $dbname = 'id19625723_ehbo';
    $conn = mysqli_connect($host, $user, $pass, $dbname);
    $hashedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);
    $sql = "INSERT INTO user (firstname, lastname, email, postal, city, address, description, password) VALUES ('$firstname', '$lastname', '$email', '$postal', '$city', '$address', '$description', '$password')";
    mysqli_query($conn, $sql);
}
?>
