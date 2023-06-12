<?php
session_start();

if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $postal = $_POST['postal'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $description = $_POST['description'];
    $password = $_POST['password'];

    $recaptcha_secret = '6Lfe7Y0mAAAAAALHCbs8FHqgfsHoFUKuT0Mc8EEF
    ';
    $response = $_POST['g-recaptcha-response'];

    // Make a POST request to verify the reCAPTCHA response
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'secret' => $recaptcha_secret,
        'response' => $response
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $recaptcha_result = curl_exec($ch);
    curl_close($ch);

    $recaptcha_result = json_decode($recaptcha_result);

    if (!$recaptcha_result->success) {
        echo '<script>alert("reCAPTCHA verification failed. Please try again.");</script>';
    } else {



        $password_hash = password_hash($password, PASSWORD_DEFAULT);

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

        $sql = "INSERT INTO user (firstname, lastname, email, postal, city, address, description, password) 
            VALUES ('$firstname', '$lastname', '$email', '$postal', '$city', '$address', '$description', '$password_hash')";

        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Uw nieuwe account is aangevraagd!");</script>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        mysqli_close($conn);
    }
}
